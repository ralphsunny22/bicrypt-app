<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\Deposit;
use App\Models\User;
use App\Models\UserLogin;
use App\Models\Withdrawal;
use App\Models\TradeLog;
use App\Models\KYC;
use App\Models\Permission;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Composer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use App\Models\ThirdpartyOrders;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{


    public function __construct(Composer $composer)
    {
        $this->composer = $composer;
        $this->gnl = getGen();
    }

    public function dashboard()
    {
        $page_title = 'Dashboard';
        $gnl = $this->gnl;
        $api = new UpdateController();
        $plat = arrayToObject(getPlatforms());
        $widget['total_users'] = User::count();
        if (getPlatform('kyc')->kyc_status == 1) {
            $widget['verified_users'] = KYC::where('status', 'approved')->count();
        } else {
            $widget['verified_users'] = User::emailVerified()->count();
        }
        $widget['email_unverified_users'] = User::where('email_verified_at', NULL)->count();
        // Build an array of the dates we want to show, oldest first
        $dates['total_users'] = collect();
        $dates['verified_users'] = collect();
        $dates['email_unverified_users'] = collect();
        //$dates['sms_unverified_users'] = collect();
        foreach (range(-30, 0) as $i) {
            $date = Carbon::now()->addDays($i)->format('Y-m-d');
            $dates['total_users']->put($date, 0);
        }
        foreach (range(-30, 0) as $i) {
            $date = Carbon::now()->addDays($i)->format('Y-m-d');
            $dates['verified_users']->put($date, 0);
        }
        foreach (range(-30, 0) as $i) {
            $date = Carbon::now()->addDays($i)->format('Y-m-d');
            $dates['email_unverified_users']->put($date, 0);
        }
        $widgets['total_usersdate'] = User::where('created_at', '>=',  $dates['total_users']->keys()->first())
            ->groupBy('date')
            ->orderBy('date')
            ->get([
                DB::raw('DATE( created_at ) as date'),
                DB::raw('COUNT( * ) as "count"')
            ])
            ->pluck('count', 'date');
        $widgets['verified_usersdate'] = User::where('email_verified_at', '!=', NULL)->where('created_at', '>=', $dates['verified_users']->keys()->first())
            ->groupBy('date')
            ->orderBy('date')
            ->get([
                DB::raw('DATE( created_at ) as date'),
                DB::raw('COUNT( * ) as "count"')
            ])
            ->pluck('count', 'date');
        $widgets['email_unverified_usersdate'] = User::where('email_verified_at', NULL)->where('created_at', '>=', $dates['email_unverified_users']->keys()->first())
            ->groupBy('date')
            ->orderBy('date')
            ->get([
                DB::raw('DATE( created_at ) as date'),
                DB::raw('COUNT( * ) as "count"')
            ])
            ->pluck('count', 'date');

        $dates['total_users'] = $dates['total_users']->merge($widgets['total_usersdate']);
        $dates['verified_users'] = $dates['verified_users']->merge($widgets['verified_usersdate']);
        $dates['email_unverified_users'] = $dates['email_unverified_users']->merge($widgets['email_unverified_usersdate']);

        // Trades

        $trades = array(
            "Jan" => [
                "buy" => ["count" => 0, "amount" => 0],
                "sell" => ["count" => 0, "amount" => 0]
            ],
            "Feb" => [
                "buy" => ["count" => 0, "amount" => 0],
                "sell" => ["count" => 0, "amount" => 0]
            ],
            "Mar" => [
                "buy" => ["count" => 0, "amount" => 0],
                "sell" => ["count" => 0, "amount" => 0]
            ],
            "Apr" => [
                "buy" => ["count" => 0, "amount" => 0],
                "sell" => ["count" => 0, "amount" => 0]
            ],
            "May" => [
                "buy" => ["count" => 0, "amount" => 0],
                "sell" => ["count" => 0, "amount" => 0]
            ],
            "Jun" => [
                "buy" => ["count" => 0, "amount" => 0],
                "sell" => ["count" => 0, "amount" => 0]
            ],
            "Jul" => [
                "buy" => ["count" => 0, "amount" => 0],
                "sell" => ["count" => 0, "amount" => 0]
            ],
            "Aug" => [
                "buy" => ["count" => 0, "amount" => 0],
                "sell" => ["count" => 0, "amount" => 0]
            ],
            "Sep" => [
                "buy" => ["count" => 0, "amount" => 0],
                "sell" => ["count" => 0, "amount" => 0]
            ],
            "Oct" => [
                "buy" => ["count" => 0, "amount" => 0],
                "sell" => ["count" => 0, "amount" => 0]
            ],
            "Nov" => [
                "buy" => ["count" => 0, "amount" => 0],
                "sell" => ["count" => 0, "amount" => 0]
            ],
            "Dec" => [
                "buy" => ["count" => 0, "amount" => 0],
                "sell" => ["count" => 0, "amount" => 0]
            ]
        );

        $tradesMonths = ThirdpartyOrders::select(
            DB::raw('side as type'),
            DB::raw('count(*) as count'),
            DB::raw('sum(amount) as amount'),
            DB::raw("DATE_FORMAT(created_at,'%M') as month")
        )->groupBy('month')->get();
        foreach ($tradesMonths as $item) {
            if (array_key_exists(substr($item->month, 0, 3), $trades)) {
                $trades[substr($item->month, 0, 3)][$item->type]['count'] = $item->count;
                $trades[substr($item->month, 0, 3)][$item->type]['amount'] = getAmount($item->amount);
            } else {
                $trades[substr($item->month, 0, 3)][$item->type]['count'] = 0;
                $trades[substr($item->month, 0, 3)][$item->type]['amount'] = 0;
            }
        }

        // Binary

        if ($plat->trading->binary_status == 1) {
            $binary_trades_logs = TradeLog::get();
            $binary_trades_info = array(
                "total_trades" => $binary_trades_logs->count(),
                "wins" => $binary_trades_logs->where('result', 1)->where('status', 1)->sum('amount'),
                "loses" => $binary_trades_logs->where('result', 2)->where('status', 1)->sum('amount')
            );
            $binary_trades = array(
                "Jan" => ["wins" => 0, "loses" => 0, "total" => 0],
                "Feb" => ["wins" => 0, "loses" => 0, "total" => 0],
                "Mar" => ["wins" => 0, "loses" => 0, "total" => 0],
                "Apr" => ["wins" => 0, "loses" => 0, "total" => 0],
                "May" => ["wins" => 0, "loses" => 0, "total" => 0],
                "Jun" => ["wins" => 0, "loses" => 0, "total" => 0],
                "Jul" => ["wins" => 0, "loses" => 0, "total" => 0],
                "Aug" => ["wins" => 0, "loses" => 0, "total" => 0],
                "Sep" => ["wins" => 0, "loses" => 0, "total" => 0],
                "Oct" => ["wins" => 0, "loses" => 0, "total" => 0],
                "Nov" => ["wins" => 0, "loses" => 0, "total" => 0],
                "Dec" => ["wins" => 0, "loses" => 0, "total" => 0]
            );
            $BinaryTotal = TradeLog::where('status', 1)->select(
                DB::raw('COUNT( * ) as count'),
                DB::raw("DATE_FORMAT(created_at,'%M') as month")
            )->groupBy('month')->get();
            foreach ($BinaryTotal as $item) {
                if (array_key_exists(substr($item->month, 0, 3), $binary_trades)) {
                    $binary_trades[substr($item->month, 0, 3)]['total'] = $item->count;
                } else {
                    $binary_trades[substr($item->month, 0, 3)]['total'] = 0;
                }
            }
            $BinaryWinning = TradeLog::where('result', 1)->where('status', 1)->select(
                DB::raw('COUNT( * ) as count'),
                DB::raw("DATE_FORMAT(created_at,'%M') as month")
            )->groupBy('month')->get();
            foreach ($BinaryWinning as $item) {
                if (array_key_exists(substr($item->month, 0, 3), $binary_trades)) {
                    $binary_trades[substr($item->month, 0, 3)]['wins'] = $item->count;
                } else {
                    $binary_trades[substr($item->month, 0, 3)]['wins'] = 0;
                }
            }
            $BinaryLosing = TradeLog::where('result', 2)->where('status', 1)->select(
                DB::raw('COUNT( * ) as count'),
                DB::raw("DATE_FORMAT(created_at,'%M') as month")
            )->groupBy('month')->get();
            foreach ($BinaryLosing as $item) {
                if (array_key_exists(substr($item->month, 0, 3), $binary_trades)) {
                    $binary_trades[substr($item->month, 0, 3)]['loses'] = $item->count;
                } else {
                    $binary_trades[substr($item->month, 0, 3)]['loses'] = 0;
                }
            }
        } else {
            $binary_trades = null;
            $binary_trades_logs = null;
            $binary_trades_info = null;
        }

        // Deposits & Withdrawals

        $trxs = array(
            "Jan" => [],
            "Feb" => [],
            "Mar" => [],
            "Apr" => [],
            "May" => [],
            "Jun" => [],
            "Jul" => [],
            "Aug" => [],
            "Sep" => [],
            "Oct" => [],
            "Nov" => [],
            "Dec" => []
        );

        $depositsMonth = Deposit::where('status', 1)->select(
            DB::raw('sum(amount) as amount'),
            DB::raw("DATE_FORMAT(created_at,'%M') as month")
        )->groupBy('month')->get();
        foreach ($depositsMonth as $item) {
            if (array_key_exists(substr($item->month, 0, 3), $trxs)) {
                $trxs[substr($item->month, 0, 3)]['deposits'] = getAmount($item->amount);
            } else {
                $trxs[substr($item->month, 0, 3)]['deposits'] = 0;
            }
        }
        $withdrawalMonth = Withdrawal::where('status', 1)->select(
            DB::raw('sum(amount) as amount'),
            DB::raw("DATE_FORMAT(created_at,'%M') as month")
        )->groupBy('month')->get();
        foreach ($withdrawalMonth as $item) {
            if (array_key_exists(substr($item->month, 0, 3), $trxs)) {
                $trxs[substr($item->month, 0, 3)]['withdraws'] = getAmount($item->amount);
            } else {
                $trxs[substr($item->month, 0, 3)]['withdraws'] = 0;
            }
        }


        $payment['total_deposit_amount'] = Deposit::where('status', 1)->sum('amount');
        $payment['total_deposit_charge'] = Deposit::where('status', 1)->sum('charge');
        $payment['total_deposit_pending'] = Deposit::where('status', 2)->count();
        $payment['total_deposit'] = Deposit::where('status', 1)->count();
        // Build an array of the dates we want to show, oldest first
        $dates['total_deposit'] = collect();
        foreach (range(-30, 0) as $i) {
            $date = Carbon::now()->addDays($i)->format('Y-m-d');
            $dates['total_deposit']->put($date, 0);
        }

        // Get the post counts
        $payment['total_depositdate'] = Deposit::where('status', 1)->where('created_at', '>=', $dates['total_deposit']->keys()->first())
            ->groupBy('date')
            ->orderBy('date')
            ->get([
                DB::raw('DATE( created_at ) as date'),
                DB::raw('COUNT( * ) as "count"')
            ])
            ->pluck('count', 'date');

        // Merge the two collections; any results in `$posts` will overwrite the zero-value in `$dates`
        $dates['total_deposit'] = $dates['total_deposit']->merge($payment['total_depositdate']);

        // Build an array of the dates we want to show, oldest first
        $dates['total_deposit_pending'] = collect();
        foreach (range(-30, 0) as $i) {
            $date = Carbon::now()->addDays($i)->format('Y-m-d');
            $dates['total_deposit_pending']->put($date, 0);
        }

        // Get the post counts
        $payment['total_deposit_pendingdate'] = Deposit::where('status', 2)->where('created_at', '>=', $dates['total_deposit_pending']->keys()->first())
            ->groupBy('date')
            ->orderBy('date')
            ->get([
                DB::raw('DATE( created_at ) as date'),
                DB::raw('COUNT( * ) as "count"')
            ])
            ->pluck('count', 'date');

        // Merge the two collections; any results in `$posts` will overwrite the zero-value in `$dates`
        $dates['total_deposit_pending'] = $dates['total_deposit_pending']->merge($payment['total_deposit_pendingdate']);

        $paymentWithdraw['total_withdraw_amount'] = Withdrawal::where('status', 1)->sum('amount');
        $paymentWithdraw['total_withdraw'] = Withdrawal::where('status', 1)->count();
        $paymentWithdraw['total_withdraw_charge'] = Withdrawal::where('status', 1)->sum('charge');
        $paymentWithdraw['total_withdraw_pending'] = Withdrawal::where('status', 2)->count();
        // Build an array of the dates we want to show, oldest first
        $dates['total_withdraw'] = collect();
        foreach (range(-30, 0) as $i) {
            $date = Carbon::now()->addDays($i)->format('Y-m-d');
            $dates['total_withdraw']->put($date, 0);
        }

        // Get the post counts
        $paymentWithdraw['total_withdrawdate'] = Withdrawal::where('status', 1)->where('created_at', '>=', $dates['total_withdraw']->keys()->first())
            ->groupBy('date')
            ->orderBy('date')
            ->get([
                DB::raw('DATE( created_at ) as date'),
                DB::raw('COUNT( * ) as "count"')
            ])
            ->pluck('count', 'date');

        // Merge the two collections; any results in `$posts` will overwrite the zero-value in `$dates`
        $dates['total_withdraw'] = $dates['total_withdraw']->merge($paymentWithdraw['total_withdrawdate']);

        // Build an array of the dates we want to show, oldest first
        $dates['total_withdraw_pending'] = collect();
        foreach (range(-30, 0) as $i) {
            $date = Carbon::now()->addDays($i)->format('Y-m-d');
            $dates['total_withdraw_pending']->put($date, 0);
        }

        // Get the post counts
        $paymentWithdraw['total_withdraw_pendingdate'] = Withdrawal::where('status', 2)->where('created_at', '>=', $dates['total_withdraw_pending']->keys()->first())
            ->groupBy('date')
            ->orderBy('date')
            ->get([
                DB::raw('DATE( created_at ) as date'),
                DB::raw('COUNT( * ) as "count"')
            ])
            ->pluck('count', 'date');

        // Merge the two collections; any results in `$posts` will overwrite the zero-value in `$dates`
        $dates['total_withdraw_pending'] = $dates['total_withdraw_pending']->merge($paymentWithdraw['total_withdraw_pendingdate']);


        // user Browsing, Country, Operating Log

        $user_login_data = UserLogin::whereDate('created_at', '>=', \Carbon\Carbon::now()->subDay(30))->get(['browser', 'os', 'country']);

        $chart['user_browser_counter'] = $user_login_data->groupBy('browser')->map(function ($item, $key) {
            return collect($item)->count();
        });
        $chart['user_os_counter'] = $user_login_data->groupBy('os')->map(function ($item, $key) {
            return collect($item)->count();
        });
        $chart['user_country_counter'] = $user_login_data->groupBy('country')->map(function ($item, $key) {
            return collect($item)->count();
        })->sort()->reverse()->take(5);

        $latestUser = User::latest()->limit(5)->get();
        $empty_message = 'User Not Found';
        $notifications = AdminNotification::where('read_status', 0)->with('user')->orderBy('id', 'desc')->get();
        return view('admin.dashboard', compact(
            'page_title',
            'notifications',
            'widget',
            'gnl',
            'api',
            'dates',
            'chart',
            'payment',
            'paymentWithdraw',
            'latestUser',
            'empty_message',
            'depositsMonth',
            'withdrawalMonth',
            'binary_trades',
            'binary_trades_info',
            'trxs',
            'plat',
            'trades'
        ));
    }


    public function frontend()
    {
        $page_title = "Home";
        return view('admin.setting.frontend.index', compact('page_title'));
    }

    public function frontend_save(Request $request)
    {
        $html = "";
        $path = makeDirectory(public_path() . $request->folder);
        if (!$path) throw new Exception('File could not been created.');
        if (isset($request->startTemplateUrl) && !empty($request->startTemplateUrl)) {
            $html = file_get_contents(public_path() . $request->startTemplateUrl);
        } else if (isset($request->html)) {
            $html = substr($request->html, 0, 1024 * 1024 * 2);
        }
        $result = file_put_contents(public_path() . $request->file, $html);
        if ($result) {
            echo "File saved $request->file";
        } else {
            header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
            echo "Error saving file  $request->file\nPossible causes are missing write permission or incorrect file path!";
        }
    }

    public function frontend_set(Request $request)
    {
        $gnl = getGen();
        $gnl->frontend = $request->file;
        $gnl->save();
        if ($gnl->save()) {
            echo "Frontend set to $request->file";
        } else {
            header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
            echo "Error setting file  $request->file\nPossible causes are missing write permission or incorrect file path!";
        }
    }

    public function sanitizeFileName($file)
    {
        //sanitize, remove double dot .. and remove get parameters if any
        $file = __DIR__ . '/' . preg_replace('@\?.*$@', '', preg_replace('@\.{2,}@', '', preg_replace('@[^\/\\a-zA-Z0-9\-\._]@', '', $file)));
        return $file;
    }

    public function api()
    {
        abort_if(Gate::denies('api_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $page_title = "API";
        $user = Auth::user();
        return view('api.index', compact('page_title', 'user'));
    }

    public function clean()
    {
        \Illuminate\Support\Facades\Artisan::call('optimize:clear');
        $notify[] = ['success', 'System Optimized'];
        return  back()->withNotify($notify);
    }

    public function notifications()
    {
        $notifications = AdminNotification::orderBy('id', 'desc')->with('user')->paginate(getPaginate());
        $page_title = 'Notifications';
        return view('admin.notifications', compact('page_title', 'notifications'));
    }

    public function notifications_clean()
    {
        abort_if(Gate::denies('notifications_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $notifications = AdminNotification::get();
        foreach ($notifications as $notification) {
            $notification->delete();
        }
        $notify[] = ['success', 'Notifications removed successfully'];
        return back()->withNotify($notify);
    }

    public function notificationRead($id)
    {
        $notification = AdminNotification::findOrFail($id);
        $notification->read_status = 1;
        $notification->save();
        return redirect($notification->click_url);
    }

    public function sidebar_admin()
    {
        abort_if(Gate::denies('admin_sidebar_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $page_title = "Admin Sidebar Menu Manager";
        $json = file_get_contents(resource_path('data/sidebar.json'));
        $sidebars = arrayToObject(json_decode($json, true)['admin']);
        $type = 'admin';
        return view('admin.setting.sidebar', compact('page_title', 'sidebars', 'type'));
    }

    public function sidebar_user()
    {
        abort_if(Gate::denies('user_sidebar_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $page_title = "User Sidebar Menu Manager";
        $json = file_get_contents(resource_path('data/sidebar.json'));
        $sidebars = arrayToObject(json_decode($json, true)['user']);
        $type = 'user';
        return view('admin.setting.sidebar', compact('page_title', 'sidebars', 'type'));
    }

    public function sidebar_edit($type, $id)
    {
        $json = file_get_contents(resource_path('data/sidebar.json'));
        $sidebar = arrayToObject(json_decode($json, true)[$type][$id]);
        $page_title = "Sidebar Edit";
        $permissions = Permission::select('id', 'title', 'code')->get();
        return view('admin.setting.sidebar_edit', compact('page_title', 'sidebar', 'id', 'permissions', 'type'));
    }

    public function sidebar_update(Request $request, $type)
    {
        $json = file_get_contents(resource_path('data/sidebar.json'));
        $datas = json_decode($json, true);
        $datas[$type][$request->id]['name'] = $request->name;
        $datas[$type][$request->id]['icon'] = str_replace("bi bi-", "", $request->icon);
        $datas[$type][$request->id]['permission'] = $request->permission;
        $request->merge(['status' => isset($request->status) ? 1 : 0]);
        $datas[$type][$request->id]['status'] = $request->status;

        $newJsonString = json_encode($datas, JSON_PRETTY_PRINT);
        file_put_contents(resource_path('data/sidebar.json'), stripslashes($newJsonString));

        $notify[] = ['success', 'Updated Successfully'];
        return back()->withNotify($notify);
    }

    public function sidebar_activate(Request $request, $type)
    {
        $json = file_get_contents(resource_path('data/sidebar.json'));
        $datas = json_decode($json, true);
        $datas[$type][$request->id]['status'] = 1;
        $newJsonString = json_encode($datas, JSON_PRETTY_PRINT);
        file_put_contents(resource_path('data/sidebar.json'), stripslashes($newJsonString));

        $notify[] = ['success', 'Activated Successfully'];
        return back()->withNotify($notify);
    }

    public function sidebar_deactivate(Request $request, $type)
    {
        $json = file_get_contents(resource_path('data/sidebar.json'));
        $datas = json_decode($json, true);
        $datas[$type][$request->id]['status'] = 0;
        $newJsonString = json_encode($datas, JSON_PRETTY_PRINT);
        file_put_contents(resource_path('data/sidebar.json'), stripslashes($newJsonString));

        $notify[] = ['success', 'Deactivated Successfully'];
        return back()->withNotify($notify);
    }


    public function sidebar_submenu_edit($type, $id, $submenu_id)
    {
        $json = file_get_contents(resource_path('data/sidebar.json'));
        $sidebar = arrayToObject(json_decode($json, true)[$type][$id]['submenu'][$submenu_id]);
        $page_title = "Sidebar Edit";
        $permissions = Permission::select('id', 'title', 'code')->get();
        return view('admin.setting.sidebar_submenu_edit', compact('page_title', 'sidebar', 'id', 'submenu_id', 'permissions', 'type'));
    }

    public function sidebar_submenu_update(Request $request, $type,  $id, $submenu_id)
    {
        $json = file_get_contents(resource_path('data/sidebar.json'));
        $datas = json_decode($json, true);
        $datas[$type][$id]['submenu'][$request->id]['name'] = $request->name;
        $datas[$type][$id]['submenu'][$request->id]['icon'] = str_replace("bi bi-", "", $request->icon);
        $datas[$type][$id]['submenu'][$request->id]['permission'] = $request->permission;
        $request->merge(['status' => isset($request->status) ? 1 : 0]);
        $datas[$type][$id]['submenu'][$request->id]['status'] = $request->status;
        $newJsonString = json_encode($datas, JSON_PRETTY_PRINT);
        file_put_contents(resource_path('data/sidebar.json'), stripslashes($newJsonString));

        $notify[] = ['success', 'Updated Successfully'];
        return back()->withNotify($notify);
    }

    public function sidebar_submenu_activate(Request $request, $type,  $id)
    {
        $json = file_get_contents(resource_path('data/sidebar.json'));
        $datas = json_decode($json, true);
        $datas[$type][$id]['submenu'][$request->id]['status'] = 1;
        $newJsonString = json_encode($datas, JSON_PRETTY_PRINT);
        file_put_contents(resource_path('data/sidebar.json'), stripslashes($newJsonString));

        $notify[] = ['success', 'Activated Successfully'];
        return back()->withNotify($notify);
    }

    public function sidebar_submenu_deactivate(Request $request, $type,  $id)
    {
        $json = file_get_contents(resource_path('data/sidebar.json'));
        $datas = json_decode($json, true);
        $datas[$type][$id]['submenu'][$request->id]['status'] = 0;
        $newJsonString = json_encode($datas, JSON_PRETTY_PRINT);
        file_put_contents(resource_path('data/sidebar.json'), stripslashes($newJsonString));

        $notify[] = ['success', 'Deactivated Successfully'];
        return back()->withNotify($notify);
    }

    public function remove_install_file()
    {
        File::delete(public_path() . '/install/index.php');
        $notify[] = ['success', 'File removed successfully'];
        return back()->withNotify($notify);
    }
}