<?php

namespace App\Http\Controllers;

use App\Models\AdminNotification;
use App\Models\GeneralSetting;
use App\Models\Transaction;
use App\Models\Commission;
use App\Models\User;
use App\Models\Tokens;
use App\Models\WithdrawMethod;
use App\Models\Withdrawal;
use App\Models\TradeLog;
use App\Models\KYC;
use App\Models\PracticeLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\EmailToUser;
use App\Models\Platform;
use App\Models\Popups;
use App\Models\PopupsStatus;
use App\Models\ThirdpartyProvider;
use App\Models\Wallet;
use App\Models\WalletsTransactions;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\RegisterViewResponse;
use Throwable;

class UserController extends Controller
{
    public function __construct()
    {
        if (ThirdpartyProvider::where('status', 1)->exists()) {
            $thirdparty = ThirdpartyProvider::where('status', 1)->first();
            $exchange_class = "\\ccxt\\$thirdparty->title";
            $this->api = new $exchange_class(array(
                'apiKey' => $thirdparty->api,
                'secret' => $thirdparty->secret,
                'password' => $thirdparty->password,
            ));
            $this->provider = $thirdparty->title;
        } else {
            $this->provider = null;
        }
    }

    public function index()
    {
        $page_title = 'Dashboard';
        if ($this->provider != null) {
            $provider = $this->provider;
            $trading_wallet = 1;
        } else {
            $provider = 'kucoin';
            $trading_wallet = 0;
        }
        $gnl_cur = GetCurrency();
        return view('user.index', compact('page_title', 'provider', 'trading_wallet', 'gnl_cur'));
    }

    public function authenticate(Request $request)
    {
        if (Tokens::where('token', $request->token)->where('abilities', 'like', "%\"{$request->ability}\"%")->exists()) {
            if (User::where('email', $request->email)->exists()) {
                $user = User::where('email', $request->email)->first();
                try {
                    auth()->login($user);
                    return response()->json(
                        [
                            'success' => true,
                            'type' => 'success',
                            'message' => 'User Authenticated Successfully',
                            'token' => $request->session()->get('_token')
                        ]
                    );
                } catch (\Throwable $th) {
                    return response()->json(
                        [
                            'success' => false,
                            'type' => 'error',
                            'message' => $th
                        ]
                    );
                }
            } else {
                $user = new User();
                try {
                    User::create([
                        'email' => $request->email,
                        'password' => Hash::make('12345678'),
                        'name' => 'No Name',
                        'firstname' => 'No Name',
                        'lastname' => 'No Name',
                        'username' => $request->email,
                        'email_verified_at' => Carbon::now(),
                        'status' => 1,
                        'role_id' => 2,
                    ]);
                } catch (\Throwable $th) {
                    throw $th;
                }
                return response()->json(
                    [
                        'success' => true,
                        'type' => 'success',
                        'message' => 'User Created Successfully',
                        'password' => '12345678',
                        'token' => $request->session()->get('_token')
                    ]
                );
            }
        } else {
            return response()->json(
                [
                    'success' => false,
                    'type' => 'error',
                    'message' => "API don't have authentication permission"
                ]
            );
        }
    }

    public function home()
    {
        $platform['trading'] = json_decode(Platform::where('option', 'trading')->first()->settings);
        $platform = arrayToObject($platform);
        return redirect()->route('user.home');
    }

    public function data()
    {
        $user = Auth::user();
        if ($user->frozen_wallets() != null) {
            $user->frozen_wallet = $user->frozen_wallets();
        }
        if (Popups::where('status', 1)->exists()) {
            $popups = [];
            $data = Popups::where('status', 1)->get();
            foreach ($data as $item) {
                if (!PopupsStatus::where('popup_id', $item->id)->where('user_id', $user->id)->where('status', 0)->exists()) {
                    $popup[] = $item;
                }
            }
            $popups = $popup ?? null;
        }
        return response()->json([
            'user' => $user,
            'popups' => $popups ?? null,
            'kyc' => checkKYC($user->id),
        ]);
    }

    public function binary_dashboard()
    {
        $user = Auth::user();
        Carbon::setWeekStartsAt(Carbon::MONDAY);
        Carbon::setWeekEndsAt(Carbon::SUNDAY);
        $trade['Won'] = TradeLog::where('user_id', $user->id)->where('result', 1)->sum('margin');
        $trade['Log'] = TradeLog::where('user_id', $user->id)->count();
        $trade['Win'] = TradeLog::where('user_id', $user->id)->where('result', 1)->count();
        $trade['Lose'] = TradeLog::where('user_id', $user->id)->where('result', 2)->count();
        $trade['Draw'] = TradeLog::where('user_id', $user->id)->where('result', 3)->count();
        $perc['tradeWon_last_week'] = TradeLog::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('result', 1)->sum('margin');
        if ($trade['Win'] > 0) {
            $perc['tradeWon_last_week_percentage'] = $perc['tradeWon_last_week'] > 0 ? ceil((($perc['tradeWon_last_week']) * 100) / $trade['Win']) : 0;
        } else {
            $perc['tradeWon_last_week_percentage'] = 0;
        }
        $trade['practice_Won'] = PracticeLog::where('user_id', $user->id)->where('result', 1)->sum('margin');
        $trade['practice_Log'] = PracticeLog::where('user_id', $user->id)->count();
        $trade['practice_Win'] = PracticeLog::where('user_id', $user->id)->where('result', 1)->count();
        $trade['practice_Lose'] = PracticeLog::where('user_id', $user->id)->where('result', 2)->count();
        $trade['practice_Draw'] = PracticeLog::where('user_id', $user->id)->where('result', 3)->count();
        $trade['practice_logs'] = PracticeLog::where('user_id', $user->id)->latest()->limit(10)->get();
        $perc['practiceWon_last_week'] = PracticeLog::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('result', 1)->sum('margin');
        if ($trade['practice_Win'] > 0) {
            $perc['practiceWon_last_week_percentage'] = $perc['practiceWon_last_week'] > 0 ? ceil((($perc['practiceWon_last_week']) * 100) / $trade['practice_Win']) : 0;
        } else {
            $perc['practiceWon_last_week_percentage'] = 0;
        }
        return response()->json([
            'user' => $user,
            'funding_wallets' => getWallet($user->id, 'funding', 'USDT', 'funding')->balance ?? null,
            'userkyc' => KYC::where('userId', $user->id)->first(),
            'perc' => $perc,
            'trade' => $trade,
            'tradelogs' => TradeLog::where('user_id', $user->id)->latest()->limit(10)->get(),
            'practicelogs' => PracticeLog::where('user_id', $user->id)->latest()->limit(10)->get(),
            'deposit' => auth()->user()->deposits()->sum('amount'),
            'withdraw' => Withdrawal::where('user_id', $user->id)->where('status', '!=', 0)->sum('amount'),
            'transaction' => auth()->user()->transactions()->count(),
        ]);
    }

    public function send_email(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ], [
            'user_id.required' => __('Select a user first!'),
        ]);

        if ($validator->fails()) {
            if ($validator->errors()->has('name')) {
                $msg = $validator->errors()->first();
            } else {
                $msg = __('messages.somthing_wrong');
            }

            $ret['msg'] = 'warning';
            $ret['message'] = $msg;
        } else {
            $user = User::FindOrFail($request->input('user_id'));

            if ($user) {
                $msg = $request->input('message');
                $msg = replace_with($msg, '[[user_name]]', $user->name);
                $data = (object) [
                    'user' => (object) ['name' => $user->name, 'email' => $user->email],
                    'subject' => $request->input('subject'),
                    'greeting' => $request->input('greeting'),
                    'text' => str_replace("\n", "<br>", $msg),
                ];
                $when = now()->addMinutes(2);

                try {
                    Mail::to($user->email)
                        ->later($when, new EmailToUser($data));
                    $ret['msg'] = 'success';
                    $ret['message'] = __('messages.mail.send');
                } catch (\Exception $e) {
                    $ret['errors'] = $e->getMessage();
                    $ret['msg'] = 'warning';
                    $ret['message'] = __('messages.mail.issues');
                }
            } else {
                $ret['msg'] = 'warning';
                $ret['message'] = __('messages.mail.failed');
            }

            if ($request->ajax()) {
                return response()->json($ret);
            }
            return back()->with([$ret['msg'] => $ret['message']]);
        }
    }


    public function commissions()
    {
        $user = Auth::user();
        $page_title = 'Commission History';
        $empty_message = 'No Commission found.';
        $commissions = Commission::where('user_id', $user->id)->latest()->paginate(getPaginate());
        return view('user.commissions', compact('page_title', 'empty_message', 'commissions'));
    }

    public function referralog()
    {
        $user = Auth::user();
        $page_title = 'Referral Log';
        $empty_message = 'No Referral User';
        $referrals = User::where('ref_by', $user->id)->latest()->paginate(getPaginate());
        return view('user.referral', compact('page_title', 'empty_message', 'referrals'));
    }

    public function withdrawMoney($symbol)
    {
        $data['withdrawMethod'] = WithdrawMethod::where('status', 1)->get();
        $data['page_title'] = "Withdraw Money";
        $data['symbol'] = $symbol;
        return view('user.withdraw.methods', $data);
    }

    public function withdrawStore(Request $request)
    {
        $this->validate($request, [
            'method_code' => 'required',
            'amount' => 'required|numeric'
        ]);
        $method = WithdrawMethod::where('id', $request->method_code)->where('status', 1)->firstOrFail();
        $user = auth()->user();
        $wallet = Wallet::where('provider', 'funding')->where('user_id', $user->id)->where('type', 'funding')->where('symbol', $request->symbol)->first();
        if ($request->amount < $method->min_limit) {
            $notify[] = ['error', 'Your Requested Amount is Smaller Than Minimum Amount.'];
            return back()->withNotify($notify);
        }
        if ($request->amount > $method->max_limit) {
            $notify[] = ['error', 'Your Requested Amount is Larger Than Maximum Amount.'];
            return back()->withNotify($notify);
        }

        if ($request->amount > $wallet->balance) {
            $notify[] = ['error', 'Your do not have Sufficient Balance For Withdraw.'];
            return back()->withNotify($notify);
        }

        $charge = $method->fixed_charge + ($request->amount * $method->percent_charge / 100);
        $afterCharge = $request->amount - $charge;
        $finalAmount = getAmount($afterCharge * $method->rate);

        $withdraw = new Withdrawal();
        $withdraw->method_id = $method->id;
        $withdraw->user_id = $user->id;
        $withdraw->amount = getAmount($request->amount);
        $withdraw->currency = $method->currency;
        $withdraw->rate = $method->rate;
        $withdraw->charge = $charge;
        $withdraw->symbol = $wallet->symbol;
        $withdraw->final_amount = $finalAmount;
        $withdraw->after_charge = $afterCharge;
        $withdraw->trx = getTrx();
        $withdraw->save();
        session()->put('wtrx', $withdraw->trx);
        return redirect()->route('user.withdraw.preview');
    }

    public function withdrawPreview()
    {
        $data['withdraw'] = Withdrawal::with('method', 'user')->where('trx', session()->get('wtrx'))->where('status', 0)->latest()->firstOrFail();
        $data['page_title'] = "Withdraw Preview";
        $user = Auth::user();
        $data['wallet'] = Wallet::where('user_id', $user->id)->where('type', 'funding')->where('symbol', $data['withdraw']->symbol)->first();
        return view('user.withdraw.preview', $data);
    }


    public function withdrawSubmit(Request $request)
    {
        $withdraw = Withdrawal::with('method', 'user')->where('trx', session()->get('wtrx'))->where('status', 0)->latest()->firstOrFail();
        $rules = [];
        $inputField = [];
        if ($withdraw->method->user_data != null) {
            foreach ($withdraw->method->user_data as $key => $cus) {
                $rules[$key] = [$cus->validation];
                if ($cus->type == 'file') {
                    array_push($rules[$key], 'image');
                    array_push($rules[$key], 'mimes:jpeg,jpg,png');
                    array_push($rules[$key], 'max:2048');
                }
                if ($cus->type == 'text') {
                    array_push($rules[$key], 'max:191');
                }
                if ($cus->type == 'textarea') {
                    array_push($rules[$key], 'max:300');
                }
                $inputField[] = $key;
            }
        }
        $this->validate($request, $rules);
        $user = Auth::user();
        $wallet = Wallet::where('user_id', $user->id)->where('type', 'funding')->where('symbol', $withdraw->symbol)->first();

        if (getAmount($withdraw->final_amount) > $wallet->balance) {
            $notify[] = ['error', 'Your Request Amount is Larger Then Your Current Balance.'];
            return back()->withNotify($notify);
        }

        $directory = date("Y") . "/" . date("m") . "/" . date("d");
        $path = imagePath()['verify']['withdraw']['path'] . '/' . $directory;
        $collection = collect($request);
        $reqField = [];
        if ($withdraw->method->user_data != null) {
            foreach ($collection as $k => $v) {
                foreach ($withdraw->method->user_data as $inKey => $inVal) {
                    if ($k != $inKey) {
                        continue;
                    } else {
                        if ($inVal->type == 'file') {
                            if ($request->hasFile($inKey)) {
                                try {
                                    $reqField[$inKey] = [
                                        'field_name' => $directory . '/' . uploadImg($request[$inKey], $path),
                                        'type' => $inVal->type,
                                    ];
                                } catch (\Exception $exp) {
                                    $notify[] = ['error', 'Could not upload your ' . $request[$inKey]];
                                    return back()->withNotify($notify)->withInput();
                                }
                            }
                        } else {
                            $reqField[$inKey] = $v;
                            $reqField[$inKey] = [
                                'field_name' => $v,
                                'type' => $inVal->type,
                            ];
                        }
                    }
                }
            }
            $withdraw['withdraw_information'] = $reqField;
        } else {
            $withdraw['withdraw_information'] = null;
        }

        $withdraw->status = 2;
        $withdraw->save();
        $wallet->balance -= $withdraw->amount * $withdraw->rate;
        $wallet->save();

        if ($wallet->save()) {
            $transaction = new Transaction();
            $transaction->user_id = $withdraw->user_id;
            $transaction->amount = getAmount($withdraw->amount);
            $transaction->post_balance = getAmount($wallet->balance);
            $transaction->charge = getAmount($withdraw->charge);
            $transaction->trx_type = '-';
            $transaction->details = getAmount($withdraw->amount * $withdraw->rate) . ' ' . $withdraw->currency . ' Withdraw Via ' . $withdraw->method->name;
            $transaction->trx =  $withdraw->trx;
            $transaction->save();
            try {
                notify($withdraw->user, 'WITHDRAW_USER_REQUESTED', [
                    'username' => $withdraw->user->username,
                    'site_name' => getNotify()->site_name,
                    "amount" => $withdraw->amount,
                    "currency" => $withdraw->symbol,
                    "trx" => $withdraw->trx,
                    "post_balance" => $withdraw->after_charge,
                    "charge" => $withdraw->charge,
                    "rate" => $withdraw->rate,
                    "delay" => $withdraw->method->delay,
                    "method_currency" => $withdraw->method_currency,
                    "method_name" => $withdraw->method->name,
                    "method_amount" => $withdraw->final_amo
                ]);
            } catch (Throwable $e) {
            }

            if ($transaction->save()) {
                $wallet_new_trx = new WalletsTransactions();
                $wallet_new_trx->user_id = $withdraw->user_id;
                $wallet_new_trx->symbol = $withdraw->symbol;
                $wallet_new_trx->amount = $withdraw->amount;
                $wallet_new_trx->amount_recieved = $withdraw->final_amount / getCoinRate($withdraw->symbol);
                $wallet_new_trx->charge = getAmount($withdraw->charge);
                $wallet_new_trx->to = $withdraw->symbol;
                $wallet_new_trx->type = '2';
                $wallet_new_trx->status = '2';
                $wallet_new_trx->trx = $withdraw->trx;
                $wallet_new_trx->details = getAmount($withdraw->final_amount) . ' ' . $withdraw->currency . ' Withdraw Via ' . $withdraw->method->name;
                $wallet_new_trx->wallet_type = 'funding';
                $wallet_new_trx->save();
            }
        }

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = $user->id;
        $adminNotification->title = 'New withdraw request from ' . $user->username;
        $adminNotification->click_url = route('admin.withdraw.details', $withdraw->id);
        $adminNotification->save();

        $notify[] = ['success', 'Withdraw Request Successfully Send'];
        return redirect()->to('/user#/withdraw/history');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $profile = User::where('id', $user->id)->first();
        $path = imagePath()['profileImage']['path'];
        $size = imagePath()['profileImage']['size'];
        if (isset($request->image)) {
            try {
                $filename = uploadImg($request->image, $path, $size);
            } catch (\Exception $exp) {
                $notify[] = ['errors', 'Image could not be uploaded.'];
                return back()->withNotify($notify);
            }
            $profile->profile_photo_path = $filename;
            $profile->save();
            $notify[] = ['success', 'Profile Image Updated Successfully'];
            return back()->withNotify($notify);
        }
        $this->validate($request, [
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'image' => ['nullable', 'max:4096'],
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'zip' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
        ]);
        if ($request->email != $user->email) {
            $profile->name = $request->firstname . ' ' . $request->lastname;
            $profile->email = $request->email;
            $profile->email_verified_at = null;
            $profile->save();
            $user->sendEmailVerificationNotification();
        } else {
            $profile->name = $request->firstname . ' ' . $request->lastname;
            $profile->email = $request->email;
            $profile->firstname = $request->firstname;
            $profile->lastname = $request->lastname;
            $profile->zip = $request->zip;
            $profile->address = $request->address;
            $profile->state = $request->state;
            $profile->city = $request->city;
            $profile->country = $request->country;
            $profile->save();
        }

        $notify[] = ['success', 'Profile Updated Successfully'];
        return back()->withNotify($notify);
    }

    public function createref(Request $request, $reference): RegisterViewResponse
    {
        session()->put('reference', $reference);
        return app(RegisterViewResponse::class);
    }


    public function addPracticeBalance()
    {
        $gnl = GeneralSetting::first();
        $user = Auth::user();
        $user->practice_balance = $gnl->practice_balance;
        $user->save();
        return response()->json(
            [
                'success' => true,
                'type' => 'success',
                'message' => 'Practice Balance Add Successfully'
            ]
        );
    }

    public function fetch_withdraw_history()
    {
        $logs = Withdrawal::where('user_id', Auth::id())->where('status', '!=', 0)->with('method')->latest()->get();
        return response()->json([
            'logs' => $logs
        ]);
    }
    public function fetch_deposit_history()
    {
        $logs = auth()->user()->deposits()->with(['gateway'])->latest()->get();
        $gnl = GeneralSetting::first();
        return response()->json([
            'logs' => $logs
        ]);
    }
    public function fetch_transaction_history()
    {
        $logs = auth()->user()->transactions()->latest()->get();
        return response()->json([
            'logs' => $logs
        ]);
    }

    public function depositHistory()
    {
        $page_title = 'Deposit History';
        $empty_message = 'No history found.';
        $logs = auth()->user()->deposits()->with(['gateway'])->latest()->paginate(getPaginate());
        $gnl = GeneralSetting::first();
        return view('user.deposit_history', compact('page_title', 'empty_message', 'logs', 'gnl'));
    }
    public function withdrawLog()
    {
        $data['page_title'] = "Withdraw Log";
        $data['withdraws'] = Withdrawal::where('user_id', Auth::id())->where('status', '!=', 0)->with('method')->latest()->paginate(getPaginate());
        $data['empty_message'] = "No Data Found!";
        return view('user.withdraw.log', $data);
    }
}