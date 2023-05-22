<?php

namespace App\Http\Controllers\Admin;

use App\Models\Deposit;
use App\Models\Gateway;
use App\Models\GeneralSetting;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Extension;
use App\Models\Wallet;
use App\Models\WalletsTransactions;
use Illuminate\Http\Request;
use Throwable;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;

class DepositController extends Controller
{

    public function pending()
    {
        abort_if(Gate::denies('deposit_log'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $page_title = 'Pending Deposits';
        $empty_message = 'No pending deposits.';
        $type = 'pending';
        $deposits = Deposit::where('method_code', '>=', 1000)->where('status', 2)->with(['user', 'gateway'])->latest()->paginate(getPaginate());
        return view('admin.deposit.log', compact('page_title', 'empty_message', 'deposits', 'type'));
    }


    public function approved()
    {
        abort_if(Gate::denies('deposit_log'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $page_title = 'Approved Deposits';
        $empty_message = 'No approved deposits.';
        $deposits = Deposit::where('method_code', '>=', 1000)->where('status', 1)->with(['user', 'gateway'])->latest()->paginate(getPaginate());
        $type = 'approved';
        return view('admin.deposit.log', compact('page_title', 'empty_message', 'deposits', 'type'));
    }

    public function successful()
    {
        abort_if(Gate::denies('deposit_log'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $page_title = 'Successful Deposits';
        $empty_message = 'No successful deposits.';
        $deposits = Deposit::where('status', 1)->with(['user', 'gateway'])->latest()->paginate(getPaginate());
        $type = 'successful';
        return view('admin.deposit.log', compact('page_title', 'empty_message', 'deposits', 'type'));
    }

    public function rejected()
    {
        abort_if(Gate::denies('deposit_log'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $page_title = 'Rejected Deposits';
        $empty_message = 'No rejected deposits.';
        $type = 'rejected';
        $deposits = Deposit::where('method_code', '>=', 1000)->where('status', 3)->with(['user', 'gateway'])->latest()->paginate(getPaginate());
        return view('admin.deposit.log', compact('page_title', 'empty_message', 'deposits', 'type'));
    }

    public function deposit()
    {
        abort_if(Gate::denies('deposit_log'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $page_title = 'Deposit History';
        $empty_message = 'No deposit history available.';
        $deposits = Deposit::with(['user', 'gateway'])->where('status', '!=', 0)->latest()->paginate(getPaginate());
        return view('admin.deposit.log', compact('page_title', 'empty_message', 'deposits'));
    }

    public function depViaMethod($method, $type = null)
    {
        $method = Gateway::where('alias', $method)->firstOrFail();

        if ($type == 'approved') {
            $page_title = 'Approved Payment Via ' . $method->name;
            $deposits = Deposit::where('method_code', '>=', 1000)->where('method_code', $method->code)->where('status', 1)->latest()->with(['user', 'gateway'])->paginate(getPaginate());
        } elseif ($type == 'rejected') {
            $page_title = 'Rejected Payment Via ' . $method->name;
            $deposits = Deposit::where('method_code', '>=', 1000)->where('method_code', $method->code)->where('status', 3)->latest()->with(['user', 'gateway'])->paginate(getPaginate());
        } elseif ($type == 'successful') {
            $page_title = 'Successful Payment Via ' . $method->name;
            $deposits = Deposit::where('status', 1)->where('method_code', $method->code)->latest()->with(['user', 'gateway'])->paginate(getPaginate());
        } elseif ($type == 'pending') {
            $page_title = 'Pending Payment Via ' . $method->name;
            $deposits = Deposit::where('method_code', '>=', 1000)->where('method_code', $method->code)->where('status', 2)->latest()->with(['user', 'gateway'])->paginate(getPaginate());
        } else {
            $page_title = 'Payment Via ' . $method->name;
            $deposits = Deposit::where('status', '!=', 0)->where('method_code', $method->code)->latest()->with(['user', 'gateway'])->paginate(getPaginate());
        }
        $methodAlias = $method->alias;
        $empty_message = 'Deposit Log';
        return view('admin.deposit.log', compact('page_title', 'empty_message', 'deposits', 'methodAlias'));
    }

    public function search(Request $request, $scope)
    {
        $search = $request->search;
        $page_title = '';
        $empty_message = 'No search result was found.';
        $deposits = Deposit::with(['user', 'gateway'])->where('status', '!=', 0)->where(function ($q) use ($search) {
            $q->where('trx', 'like', "%$search%")->orWhereHas('user', function ($user) use ($search) {
                $user->where('username', 'like', "%$search%");
            });
        });
        switch ($scope) {
            case 'pending':
                $page_title .= 'Pending Deposits Search';
                $deposits = $deposits->where('method_code', '>=', 1000)->where('status', 2);
                break;
            case 'approved':
                $page_title .= 'Approved Deposits Search';
                $deposits = $deposits->where('method_code', '>=', 1000)->where('status', 1);
                break;
            case 'rejected':
                $page_title .= 'Rejected Deposits Search';
                $deposits = $deposits->where('method_code', '>=', 1000)->where('status', 3);
                break;
            case 'list':
                $page_title .= 'Deposits History Search';
                break;
        }

        $deposits = $deposits->paginate(getPaginate());
        $page_title .= ' - ' . $search;

        return view('admin.deposit.log', compact('page_title', 'search', 'scope', 'empty_message', 'deposits'));
    }

    public function dateSearch(Request $request, $scope = null)
    {
        $search = $request->date;
        if (!$search) {
            return back();
        }
        $date = explode('-', $search);
        $start = @$date[0];
        $end = @$date[1];
        // date validation
        $pattern = "/\d{2}\/\d{2}\/\d{4}/";
        if ($start && !preg_match($pattern, $start)) {
            $notify[] = ['error', 'Invalid date format'];
            return redirect()->route('admin.deposit.list')->withNotify($notify);
        }
        if ($end && !preg_match($pattern, $end)) {
            $notify[] = ['error', 'Invalid date format'];
            return redirect()->route('admin.deposit.list')->withNotify($notify);
        }
        if ($start) {
            $deposits = Deposit::where('status', '!=', 0)->whereDate('created_at', Carbon::parse($start));
        }
        if ($end) {
            $deposits = Deposit::where('status', '!=', 0)->whereDate('created_at', '>=', Carbon::parse($start))->whereDate('created_at', '<=', Carbon::parse($end));
        }
        if ($request->method) {
            $method = Gateway::where('alias', $request->method)->firstOrFail();
            $deposits = $deposits->where('method_code', $method->code);
        }
        if ($scope == 'pending') {
            $deposits = $deposits->where('method_code', '>=', 1000)->where('status', 2);
        } elseif ($scope == 'approved') {
            $deposits = $deposits->where('method_code', '>=', 1000)->where('status', 1);
        } elseif ($scope == 'rejected') {
            $deposits = $deposits->where('method_code', '>=', 1000)->where('status', 3);
        }
        $deposits = $deposits->with(['user', 'gateway'])->orderBy('id', 'desc')->paginate(getPaginate());
        $page_title = ' Deposits Log';
        $emptyMessage = 'No Deposit Found';
        $dateSearch = $search;
        return view('admin.deposit.log', compact('page_title', 'emptyMessage', 'deposits', 'dateSearch', 'scope'));
    }

    public function details($id)
    {
        $general = GeneralSetting::first();
        $deposit = Deposit::where('id', $id)->where('method_code', '>=', 1000)->with(['user', 'gateway'])->firstOrFail();
        $page_title = $deposit->user->username . ' requested ' . getAmount($deposit->amount) . ' ' . $general->cur_text;
        $details = ($deposit->detail != null) ? json_encode($deposit->detail) : null;
        return view('admin.deposit.detail', compact('page_title', 'deposit', 'details'));
    }

    public function approve(Request $request)
    {
        $request->validate(['id' => 'required|integer']);
        $deposit = Deposit::where('id', $request->id)->where('status', 2)->firstOrFail();
        $deposit->status = 1;
        $deposit->save();

        $user = User::find($deposit->user_id);
        $wallet = Wallet::where('user_id', $deposit->user_id)->where('type', 'funding')->where('symbol', $deposit->symbol)->first();
        if (getPlatform('wallet')->deposit_fees_method == 'added') {
            $wallet->balance += $deposit->amount / getCoinRate($deposit->symbol);
        } else if (getPlatform('wallet')->deposit_fees_method == 'subtracted') {
            $wallet->balance += ($deposit->amount - $deposit->charge) / getCoinRate($deposit->symbol);
        }
        $wallet->save();

        $transaction = new Transaction();
        $transaction->user_id = $deposit->user_id;
        $transaction->amount = getAmount($deposit->amount);
        $transaction->post_balance = getAmount($wallet->balance);
        $transaction->charge = getAmount($deposit->charge);
        $transaction->trx_type = '+';
        $transaction->details = 'Deposit Via ' . $deposit->gateway_currency()->name;
        $transaction->trx =  $deposit->trx;
        $transaction->save();

        $wal_trx = WalletsTransactions::where('user_id', $deposit->user_id)->where('trx', $deposit->trx)->firstOrFail();
        $wal_trx->status = 1;
        $wal_trx->save();

        $plat_mlm = getPlatform('mlm');
        if (Extension::where('id', 3)->first()->status == 1 && $plat_mlm->deposits == 1 && $user->ref_by != null) {
            BVstore($user, 1, $deposit->amount);
        }

        try {
            notify($user, 'MANUAL_DEPOSIT_ADMIN_APPROVED', [
                'username' => $user->username,
                'site_name' => getNotify()->site_name,
                "amount" => $deposit->amount,
                "currency" => $deposit->symbol,
                "trx" => $transaction->trx,
                "post_balance" => $transaction->post_balance,
                "charge" => $deposit->charge,
                "rate" => $deposit->rate,
                "method_currency" => $deposit->method_currency,
                "method_name" => $deposit->gateway_currency()->name,
                "method_amount" => $deposit->final_amo
            ]);
            $notify[] = ['success', 'Client Notified By Email Successfully'];
        } catch (Throwable $e) {
            $notify[] = ['warning', 'Mail Not Properly Set'];
        }

        $notify[] = ['success', 'Deposit has been approved.'];

        return redirect()->route('admin.deposit.pending')->withNotify($notify);
    }

    public function reject(Request $request)
    {

        $request->validate([
            'id' => 'required|integer',
            'message' => 'required|max:250'
        ]);
        $deposit = Deposit::where('id', $request->id)->where('status', 2)->firstOrFail();
        $user = User::find($deposit->user_id);

        $deposit->admin_feedback = $request->message;
        $deposit->status = 3;
        $deposit->save();

        try {
            notify($user, 'MANUAL_DEPOSIT_ADMIN_REJECTED', [
                'username' => $user->username,
                'site_name' => getNotify()->site_name,
                "amount" => $deposit->amount,
                "currency" => $deposit->symbol,
                "trx" => $deposit->trx,
                "method_name" => $deposit->gateway_currency()->name,
                "rejection_message" => $deposit->admin_feedback
            ]);
            $notify[] = ['success', 'Client Notified By Email Successfully'];
        } catch (Throwable $e) {
            $notify[] = ['warning', 'Mail Not Properly Set'];
        }

        $wal_trx = WalletsTransactions::where('user_id', $deposit->user_id)->where('trx', $deposit->trx)->firstOrFail();
        $wal_trx->status = 3;
        $wal_trx->save();

        $notify[] = ['success', 'Deposit has been rejected.'];
        return  redirect()->route('admin.deposit.pending')->withNotify($notify);
    }
}