<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\UserLogin;
use App\Models\Commission;
use App\Models\MLM\MLMBV;
use App\Models\ThirdpartyProvider;
use App\Models\ThirdpartyTransactions;
use App\Models\Wallet;
use App\Models\WalletsTransactions;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;

class ReportController extends Controller
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
            $this->provider = 'funding';
        }
        #$this->api->set_sandbox_mode('enable');
    }

    public function transaction()
    {
        abort_if(Gate::denies('transaction_log'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $page_title = 'Transaction Logs';
        $transactions = Transaction::with('user')->orderBy('id', 'desc')->paginate(getPaginate());
        $empty_message = 'No transactions.';
        return view('admin.reports.transactions', compact('page_title', 'transactions', 'empty_message'));
    }

    public function transactionSearch(Request $request)
    {
        $request->validate(['search' => 'required']);
        $search = $request->search;
        $page_title = 'Transactions Search - ' . $search;
        $empty_message = 'No transactions.';

        $transactions = Transaction::with('user')->whereHas('user', function ($user) use ($search) {
            $user->where('username', 'like', "%$search%");
        })->orWhere('trx', $search)->orderBy('id', 'desc')->paginate(getPaginate());
        return view('admin.reports.transactions', compact('page_title', 'transactions', 'empty_message'));
    }

    public function wallet()
    {
        abort_if(Gate::denies('transaction_log'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $page_title = 'Wallet Transaction Logs';
        $page = 'wallet';
        $wallet_trx = WalletsTransactions::paginate(getPaginate());
        $empty_message = 'No transactions.';
        return view('admin.reports.wallet', compact('page_title', 'wallet_trx', 'empty_message', 'page'));
    }

    public function wallet_trx_cancel(Request $request)
    {
        $wallet_trx = WalletsTransactions::where('trx', $request->trx)->first();
        if ($wallet_trx->wallet_type == 'trading' && $wallet_trx->trx != null) {
            $provider_trx = ThirdpartyTransactions::where('trx_id', $wallet_trx->trx)->first();
            $provider_trx->delete();
        }
        if (Transaction::where('trx', $request->trx)->exists()) {
            $trx = Transaction::where('trx', $request->trx)->first();
            $trx->delete();
        }
        $wallet_trx->delete();
        $notify[] = ['success', 'Transaction Canceled Successfully'];
        return back()->withNotify($notify);
    }

    public function wallet_search(Request $request)
    {
        $request->validate(['search' => 'required']);
        $search = $request->search;
        $page_title = 'Wallet Transaction Search - ' . $search;
        $page = 'wallet';
        $empty_message = 'No transactions.';

        $wallet_trx = WalletsTransactions::with('user')->whereHas('user', function ($user) use ($search) {
            $user->where('username', 'like', "%$search%");
        })->orWhere('trx', $search)->orderBy('id', 'desc')->paginate(getPaginate());
        return view('admin.reports.wallet', compact('page_title', 'wallet_trx', 'empty_message', 'page'));
    }

    public function wallet_deposit()
    {
        abort_if(Gate::denies('deposit_log'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $page_title = 'Deposits Logs';
        $page = 'wallet.deposit';
        $wallet_trx = WalletsTransactions::where('type', 1)->paginate(getPaginate());
        $empty_message = 'No transactions.';
        return view('admin.reports.wallet', compact('page_title', 'wallet_trx', 'empty_message', 'page'));
    }

    public function wallet_deposit_search(Request $request)
    {
        $request->validate(['search' => 'required']);
        $search = $request->search;
        $page_title = 'Deposits Search - ' . $search;
        $page = 'wallet.deposit';
        $empty_message = 'No transactions.';

        $wallet_trx = WalletsTransactions::where('type', 1)->with('user')->whereHas('user', function ($user) use ($search) {
            $user->where('username', 'like', "%$search%");
        })->orWhere('trx', $search)->orderBy('id', 'desc')->paginate(getPaginate());
        return view('admin.reports.wallet', compact('page_title', 'wallet_trx', 'empty_message', 'page'));
    }

    public function wallet_withdraw()
    {
        abort_if(Gate::denies('withdraw_log'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $page_title = 'Withdraw Logs';
        $page = 'wallet.withdraw';
        $wallet_trx = WalletsTransactions::where('type', 2)->paginate(getPaginate());
        $empty_message = 'No transactions.';
        return view('admin.reports.wallet', compact('page_title', 'wallet_trx', 'empty_message', 'page'));
    }

    public function wallet_withdraw_search(Request $request)
    {
        $request->validate(['search' => 'required']);
        $search = $request->search;
        $page_title = 'Withdraw Search - ' . $search;
        $page = 'wallet.withdraw';
        $empty_message = 'No transactions.';

        $wallet_trx = WalletsTransactions::where('type', 2)->with('user')->whereHas('user', function ($user) use ($search) {
            $user->where('username', 'like', "%$search%");
        })->orWhere('trx', $search)->orderBy('id', 'desc')->paginate(getPaginate());
        return view('admin.reports.wallet', compact('page_title', 'wallet_trx', 'empty_message', 'page'));
    }

    public function wallet_transfer_trading()
    {
        abort_if(Gate::denies('transaction_log'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $page_title = 'Trading Transfer Logs';
        $page = 'wallet.transfer.trading';
        $wallet_trx = WalletsTransactions::where('type', 3)->paginate(getPaginate());
        $empty_message = 'No transactions.';
        return view('admin.reports.wallet', compact('page_title', 'wallet_trx', 'empty_message', 'page'));
    }

    public function wallet_transfer_trading_search(Request $request)
    {
        $request->validate(['search' => 'required']);
        $search = $request->search;
        $page_title = 'Withdraw Search - ' . $search;
        $page = 'wallet.transfer.trading';
        $empty_message = 'No transactions.';

        $wallet_trx = WalletsTransactions::where('type', 3)->with('user')->whereHas('user', function ($user) use ($search) {
            $user->where('username', 'like', "%$search%");
        })->orWhere('trx', $search)->orderBy('id', 'desc')->paginate(getPaginate());
        return view('admin.reports.wallet', compact('page_title', 'wallet_trx', 'empty_message', 'page'));
    }

    public function wallet_transfer_funding()
    {
        abort_if(Gate::denies('transaction_log'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $page_title = 'Funding Transfer Logs';
        $page = 'wallet.transfer.funding';
        $wallet_trx = WalletsTransactions::where('type', 4)->paginate(getPaginate());
        $empty_message = 'No transactions.';
        return view('admin.reports.wallet', compact('page_title', 'wallet_trx', 'empty_message', 'page'));
    }

    public function wallet_transfer_funding_search(Request $request)
    {
        $request->validate(['search' => 'required']);
        $search = $request->search;
        $page_title = 'Withdraw Search - ' . $search;
        $page = 'wallet.transfer.funding';
        $empty_message = 'No transactions.';

        $wallet_trx = WalletsTransactions::where('type', 4)->with('user')->whereHas('user', function ($user) use ($search) {
            $user->where('username', 'like', "%$search%");
        })->orWhere('trx', $search)->orderBy('id', 'desc')->paginate(getPaginate());
        return view('admin.reports.wallet', compact('page_title', 'wallet_trx', 'empty_message', 'page'));
    }

    public function wallet_transfer_funding_approve(Request $request)
    {
        $trx = WalletsTransactions::where('trx', $request->trx)->first();
        $trx->status = '1';
        $trx->save();
        $to = Wallet::where('user_id', $trx->user_id)->where('provider', $this->provider)->where('symbol', $trx->symbol)->first();
        $to->balance += $trx->amount;
        $to->save();

        $notify[] = ['success', 'Balance Transfer Approved'];
        return back()->withNotify($notify);
    }
    public function wallet_transfer_funding_reject(Request $request)
    {
        $transfer = WalletsTransactions::where('trx', $request->trx)->first();
        $transfer->status = 3;
        //$withdraw->admin_feedback = $request->details;
        $transfer->save();

        $wallet = Wallet::where('user_id', $transfer->user_id)->where('provider', 'funding')->where('symbol', $transfer->symbol)->first();
        $wallet->balance += getAmount($transfer->amount);
        $wallet->save();

        $notify[] = ['success', 'Transfer has been rejected.'];
        return back()->withNotify($notify);
    }

    public function loginHistory(Request $request)
    {
        abort_if(Gate::denies('user_login_log'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if ($request->search) {
            $search = $request->search;
            $page_title = 'User Login History Search - ' . $search;
            $empty_message = 'No search result found.';
            $login_logs = UserLogin::whereHas('user', function ($query) use ($search) {
                $query->where('username', $search);
            })->orderBy('id', 'desc')->paginate(getPaginate());
            return view('admin.reports.logins', compact('page_title', 'empty_message', 'search', 'login_logs'));
        }
        $page_title = 'User Login History';
        $empty_message = 'No users login found.';
        $login_logs = UserLogin::orderBy('id', 'desc')->paginate(getPaginate());
        return view('admin.reports.logins', compact('page_title', 'empty_message', 'login_logs'));
    }

    public function loginIpHistory($ip)
    {
        abort_if(Gate::denies('user_login_log'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $page_title = 'Login By - ' . $ip;
        $login_logs = UserLogin::where('user_ip', $ip)->orderBy('id', 'desc')->paginate(getPaginate());
        $empty_message = 'No users login found.';
        return view('admin.reports.logins', compact('page_title', 'empty_message', 'login_logs'));
    }

    public function commission()
    {
        abort_if(Gate::denies('commission_log'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $page_title = 'Commission Logs';
        $commissions = MLMBV::paginate(getPaginate());
        $empty_message = 'No Commission.';
        return view('admin.reports.commission', compact('page_title', 'commissions', 'empty_message'));
    }

    public function commissionSearch(Request $request)
    {
        $request->validate(['search' => 'required']);
        $search = $request->search;
        $page_title = 'Commission Search - ' . $search;
        $empty_message = 'No Commission.';

        $commissions = Commission::with('user')->whereHas('user', function ($user) use ($search) {
            $user->where('username', 'like', "%$search%");
        })->orWhereHas('fromUser', function ($q) use ($search) {
            $q->where('username', 'like', "%$search%");
        })->orWhere('trx', $search)->orderBy('id', 'desc')->paginate(getPaginate());
        return view('admin.reports.commission', compact('page_title', 'commissions', 'empty_message', 'search'));
    }
}