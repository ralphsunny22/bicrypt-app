<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Platform;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;

class PlatformController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('platform_manager_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $page_title = 'Platform Settings';
        $plats = Platform::get();
        foreach ($plats as $plat) {
            $platform[$plat->option] = json_decode($plat->settings);
        }
        $platform = arrayToObject($platform);
        return view('admin.setting.platform', compact('page_title', 'platform'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'unilevel_upline1_percentage' => 'numeric',
            'unilevel_upline2_percentage' => 'numeric',
            'unilevel_upline3_percentage' => 'numeric',
            'unilevel_upline4_percentage' => 'numeric',
            'unilevel_upline5_percentage' => 'numeric',
            'unilevel_upline6_percentage' => 'numeric',
            'unilevel_upline7_percentage' => 'numeric',
            'community_line_percentage' => 'numeric'
        ]);

        $json = file_get_contents(resource_path('data/sidebar.json'));
        $datas = json_decode($json, true);

        $request->merge(['preloader' => isset($request->preloader) ? 1 : 0]);
        $request->merge(['maintenance' => isset($request->maintenance) ? 1 : 0]);
        $request->merge(['sw' => isset($request->sw) ? 1 : 0]);
        $request->merge(['frontend_status' => isset($request->frontend_status) ? 1 : 0]);
        $request->merge(['binary_status' => isset($request->binary_status) ? 1 : 0]);
        $request->merge(['pair_prices' => isset($request->pair_prices) ? 1 : 0]);
        $request->merge(['practice' => isset($request->practice) ? 1 : 0]);
        $request->merge(['kyc_status' => isset($request->kyc_status) ? 1 : 0]);


        $request->merge(['trading_cards' => isset($request->trading_cards) ? 1 : 0]);
        $request->merge(['auth_design' => isset($request->auth_design) ? 1 : 0]);


        $request->merge(['mobile_market_info' => isset($request->mobile_market_info) ? 1 : 0]);
        $request->merge(['mobile_trades' => isset($request->mobile_trades) ? 1 : 0]);
        $request->merge(['mobile_charting' => isset($request->mobile_charting) ? 1 : 0]);
        $request->merge(['mobile_orders' => isset($request->mobile_orders) ? 1 : 0]);

        $platform['dashboard'] = Platform::where('option', 'dashboard')->first();
        $platform['dashboard']->settings = json_encode([
            'default_page' => $request->default_page,
        ]);
        $platform['dashboard']->save();

        $platform['frontend'] = Platform::where('option', 'frontend')->first();
        $platform['frontend']->settings = json_encode([
            'preloader' => $request->preloader,
            'frontend_status' => $request->frontend_status,
            'auth_design' => $request->auth_design,
        ]);
        $platform['frontend']->save();
        $platform['trading'] = Platform::where('option', 'trading')->first();
        $platform['trading']->settings = json_encode([
            'binary_status' => $request->binary_status,
            'pair_prices' => $request->pair_prices,
            'practice' => $request->practice,
            'trading_cards' => $request->trading_cards,
            'first_trade_page' => $request->first_trade_page,
        ]);
        $platform['trading']->save();

        $binary_id = searchForId('Binary', $datas['user'], 'name');
        if ($binary_id != null) {
            $datas['user'][$binary_id]['status'] = $request->binary_status;
        }

        $platform['kyc'] = Platform::where('option', 'kyc')->first();
        $platform['kyc']->settings = json_encode([
            'kyc_status' => $request->kyc_status,
        ]);
        $platform['kyc']->save();

        $platform['mobile'] = Platform::where('option', 'mobile')->first();
        $platform['mobile']->settings = json_encode([
            'market_info' => $request->mobile_market_info,
            'trades' => $request->mobile_trades,
            'charting' => $request->mobile_charting,
            'orders' => $request->mobile_orders,
        ]);
        $platform['mobile']->save();

        $platform['system'] = Platform::where('option', 'system')->first();
        $platform['system']->settings = json_encode([
            'sw' => $request->sw,
            'maintenance' => $request->maintenance,
            'phone' => $request->phone,
        ]);
        $platform['system']->save();

        $kyc_id = searchForId('kyc_manager_show', $datas['admin'], 'permission');
        if ($kyc_id != null) {
            $datas['admin'][$kyc_id]['status'] = $request->kyc_status;
        }

        if (getExt(1)->status == 1) {
            $request->merge(['data' => isset($request->data) ? 1 : 0]);
            $platform['bot'] = Platform::where('option', 'bot')->first();
            $platform['bot']->settings = json_encode([
                'data' => $request->data,
            ]);
            $platform['bot']->save();
        }

        $platform['wallet'] = Platform::where('option', 'wallet')->first();
        $platform['wallet']->settings = json_encode([
            'deposit_fees_method' => $request->deposit_fees_method,
        ]);
        $platform['wallet']->save();

        if (getExt(3)->status == 1) {
            $request->merge(['mlm_deposits' => isset($request->mlm_deposits) ? 1 : 0]);
            $request->merge(['mlm_first_deposit' => isset($request->mlm_first_deposit) ? 1 : 0]);
            $request->merge(['mlm_active_first_deposit' => isset($request->mlm_active_first_deposit) ? 1 : 0]);
            $request->merge(['mlm_trades' => isset($request->mlm_trades) ? 1 : 0]);
            $request->merge(['mlm_bot_investment' => isset($request->mlm_bot_investment) ? 1 : 0]);
            $request->merge(['mlm_ico_purchase' => isset($request->mlm_ico_purchase) ? 1 : 0]);
            $request->merge(['mlm_forex_deposit' => isset($request->mlm_forex_deposit) ? 1 : 0]);
            $request->merge(['mlm_forex_investment' => isset($request->mlm_forex_investment) ? 1 : 0]);
            $request->merge(['mlm_staking' => isset($request->mlm_staking) ? 1 : 0]);
            $request->merge(['unilevel_upline2_status' => isset($request->unilevel_upline2_status) ? 1 : 0]);
            $request->merge(['unilevel_upline3_status' => isset($request->unilevel_upline3_status) ? 1 : 0]);
            $request->merge(['unilevel_upline4_status' => isset($request->unilevel_upline4_status) ? 1 : 0]);
            $request->merge(['unilevel_upline5_status' => isset($request->unilevel_upline5_status) ? 1 : 0]);
            $request->merge(['unilevel_upline6_status' => isset($request->unilevel_upline6_status) ? 1 : 0]);
            $request->merge(['unilevel_upline7_status' => isset($request->unilevel_upline7_status) ? 1 : 0]);
            $request->merge(['community_line_status' => isset($request->community_line_status) ? 1 : 0]);
            $request->merge(['membership_status' => isset($request->membership_status) ? 1 : 0]);
            $request->merge(['membership_can_earn' => isset($request->membership_can_earn) ? 1 : 0]);
            $request->merge(['membership_custom_deposit' => isset($request->membership_custom_deposit) ? 1 : 0]);
            $request->merge(['membership_custom_withdraw' => isset($request->membership_custom_withdraw) ? 1 : 0]);

            $platform['mlm'] = Platform::where('option', 'mlm')->first();
            $platform['mlm']->settings = json_encode([
                'type' => $request->mlm_type,
                'commission_type' => $request->mlm_commission_type,
                'min_withdraw' => $request->mlm_min_withdraw,
                'deposits' => $request->mlm_deposits,
                'first_deposit' => $request->mlm_first_deposit,
                'active_first_deposit' => $request->mlm_active_first_deposit,
                'trades' => $request->mlm_trades,
                'bot_investment' => $request->mlm_bot_investment,
                'ico_purchase' => $request->mlm_ico_purchase,
                'forex_deposit' => $request->mlm_forex_deposit,
                'forex_investment' => $request->mlm_forex_investment,
                'staking' => $request->mlm_staking,
                'unilevel_upline1_percentage' => $request->unilevel_upline1_percentage,
                'unilevel_upline2_percentage' => $request->unilevel_upline2_percentage,
                'unilevel_upline3_percentage' => $request->unilevel_upline3_percentage,
                'unilevel_upline4_percentage' => $request->unilevel_upline4_percentage,
                'unilevel_upline5_percentage' => $request->unilevel_upline5_percentage,
                'unilevel_upline6_percentage' => $request->unilevel_upline6_percentage,
                'unilevel_upline7_percentage' => $request->unilevel_upline7_percentage,
                'unilevel_upline2_status' => $request->unilevel_upline2_status,
                'unilevel_upline3_status' => $request->unilevel_upline3_status,
                'unilevel_upline4_status' => $request->unilevel_upline4_status,
                'unilevel_upline5_status' => $request->unilevel_upline5_status,
                'unilevel_upline6_status' => $request->unilevel_upline6_status,
                'unilevel_upline7_status' => $request->unilevel_upline7_status,
                'community_line_status' => $request->community_line_status,
                'community_line_clients' => $request->community_line_clients,
                'membership_status' => $request->membership_status,
                'membership_fees' => $request->membership_fees,
                'membership_can_earn' => $request->membership_can_earn,
                'membership_duration' => $request->membership_duration,
                'membership_grace_duration' => $request->membership_grace_duration,
                'membership_custom_deposit' => $request->membership_custom_deposit,
                'membership_deposit_currency' => $request->membership_deposit_currency,
                'membership_deposit_wallet' => $request->membership_deposit_wallet,
                'membership_custom_withdraw' => $request->membership_custom_withdraw,
                'membership_withdraw_currency' => $request->membership_withdraw_currency,
                'membership_deposit_currency_network' => $request->membership_deposit_currency_network,
                'membership_terms' => $request->membership_terms
            ]);
            $platform['mlm']->save();
        }


        if (getExt(6)->status == 1) {
            $request->merge(['cancel_stake' => isset($request->cancel_stake) ? 1 : 0]);
            $platform['staking'] = Platform::where('option', 'staking')->first();
            $platform['staking']->settings = json_encode([
                'cancel_stake' => $request->cancel_stake,
            ]);
            $platform['staking']->save();
        }

        if (getExt(10)->status == 1) {
            $request->merge(['ecosystem_trading_only' => isset($request->ecosystem_trading_only) ? 1 : 0]);
            $platform['eco'] = Platform::where('option', 'eco')->first();
            $platform['eco']->settings = json_encode([
                'ecosystem_trading_only' => $request->ecosystem_trading_only,
            ]);
            $platform['eco']->save();
        }

        $newJsonString = json_encode($datas, JSON_PRETTY_PRINT);
        file_put_contents(resource_path('data/sidebar.json'), stripslashes($newJsonString));

        \Illuminate\Support\Facades\Artisan::call('optimize:clear');
        $notify[] = ['success', 'Platform Setting has been updated.'];
        return back()->withNotify($notify);
    }
}