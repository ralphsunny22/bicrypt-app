@extends('layouts.app')
@section('vendor-style')
    <!-- vendor css files -->
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
@endsection
@section('content')
    <form action="{{ route('admin.platform.update') }}" method="POST" enctype="multipart/form-data" id="settings">
        @csrf
        <input type="hidden" name="mlm_type" id="mlm_type" value="{{ $platform->mlm->type ?? 'binary' }}">
        <input type="hidden" name="deposit_fees_method" id="deposit_fees_method"
            value="{{ $platform->wallet->deposit_fees_method ?? 'added' }}">
        <input type="hidden" name="mlm_commission_type" id="mlm_commission_type"
            value="{{ $platform->mlm->commission_type ?? 'direct' }}">

        <div class="card">
            <ul class="nav nav-tabs nav-fill" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="system-tab" data-bs-toggle="tab" href="#system" aria-controls="system"
                        role="tab" aria-selected="true">{{ __('System') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="dashboard-tab" data-bs-toggle="tab" href="#dashboard" aria-controls="dashboard"
                        role="tab" aria-selected="true">{{ __('Dashboard') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="trading-tab" data-bs-toggle="tab" href="#trading" aria-controls="trading"
                        role="tab" aria-selected="false">{{ __('Trading') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="wallet-tab" data-bs-toggle="tab" href="#wallet" aria-controls="wallet"
                        role="tab" aria-selected="false">{{ __('Wallet') }}</a>
                </li>
                @if (getExt(3)->status == 1)
                    <li class="nav-item">
                        <a class="nav-link" id="mlm-tab" data-bs-toggle="tab" href="#mlm" aria-controls="mlm"
                            role="tab" aria-selected="false">{{ __('MLM') }}</a>
                    </li>
                @endif
                @if (getExt(6)->status == 1)
                    <li class="nav-item">
                        <a class="nav-link" id="staking-tab" data-bs-toggle="tab" href="#staking" aria-controls="staking"
                            role="tab" aria-selected="false">{{ __('Staking') }}</a>
                    </li>
                @endif
                @if (getExt(10)->status == 1)
                    <li class="nav-item">
                        <a class="nav-link" id="eco-tab" data-bs-toggle="tab" href="#eco" aria-controls="eco"
                            role="tab" aria-selected="false">{{ __('Ecosystem') }}</a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link" id="mobile-tab" data-bs-toggle="tab" href="#mobile" aria-controls="mobile"
                        role="tab" aria-selected="false">{{ __('Mobile') }}</a>
                </li>
            </ul>
            <div class="mx-1">
                <div class="tab-content">
                    <div class="tab-pane active" id="system" aria-labelledby="system-tab" role="tabpanel">
                        <div class="shadow rounded p-1 mb-1">
                            <div class="d-flex align-items-center justify-content-between">
                                <label class="me-1" for="sw">{{ __('Service Worker') }}</label>
                                <input class="form-check-input" type="checkbox" data-toggle="toggle" data-size="small"
                                    data-width="25%" data-onstyle="success" data-offstyle="danger"
                                    data-on="{{ __('Active') }}" data-off="{{ __('Inactive') }}" name="sw"
                                    id="sw" @if ($platform->system->sw ?? '') checked @endif>
                            </div>
                            <small
                                class="text-warning">{{ __('Enhance performance by caching all (js,css) files into the client PC') }}</small>
                        </div>
                        <hr>
                        <div class="shadow rounded p-1 mb-1">
                            <div class="d-flex align-items-center justify-content-between">
                                <label class="me-1" for="kyc_status">{{ __('KYC') }}</label>
                                <input class="form-check-input" type="checkbox" data-toggle="toggle" data-size="small"
                                    data-width="25%" data-onstyle="success" data-offstyle="danger"
                                    data-on="{{ __('Active') }}" data-off="{{ __('Inactive') }}" name="kyc_status"
                                    id="kyc_status" @if ($platform->kyc->kyc_status ?? '') checked @endif>
                            </div>
                            <small
                                class="text-danger">{{ __('Disabled = Client directly start trading without any verifications') }}</small>
                        </div>
                        <hr>
                        <div class="shadow rounded p-1 mb-1">
                            <div class="d-flex align-items-center justify-content-between">
                                <label class="me-1" for="maintenance">{{ __('Maintenance') }}</label>
                                <input class="form-check-input" type="checkbox" data-toggle="toggle" data-size="small"
                                    data-width="25%" data-onstyle="success" data-offstyle="danger"
                                    data-on="{{ __('Active') }}" data-off="{{ __('Inactive') }}" name="maintenance"
                                    id="maintenance" @if ($platform->system->maintenance ?? 0) checked @endif>
                            </div>
                            <small
                                class="text-warning">{{ __('Set your frontend in maintenance state for users') }}</small>
                        </div>
                        <hr>
                        <div class="shadow rounded p-1 mb-1">
                            <div class="d-flex align-items-center justify-content-between">
                                <label class="me-1" for="phone">{{ __('Phone Number') }}</label>
                                <input class="form-check-input" type="checkbox" data-toggle="toggle" data-size="small"
                                    data-width="25%" data-onstyle="success" data-offstyle="danger"
                                    data-on="{{ __('Active') }}" data-off="{{ __('Inactive') }}" name="phone"
                                    id="phone" @if ($platform->system->phone ?? 0) checked @endif>
                            </div>
                            <small class="text-warning">{{ __('Enable phone number in registeration page') }}</small>
                        </div>
                        <hr>
                        <div class="shadow rounded p-1 mb-1">
                            <div class="d-flex align-items-center justify-content-between">
                                <label class="me-1" for="frontend_status">{{ __('Frontend') }}</label>
                                <input class="form-check-input" type="checkbox" data-toggle="toggle" data-size="small"
                                    data-width="25%" data-onstyle="success" data-offstyle="danger"
                                    data-on="{{ __('Active') }}" data-off="{{ __('Inactive') }}"
                                    name="frontend_status" id="frontend_status"
                                    @if ($platform->frontend->frontend_status ?? '') checked @endif>
                            </div>
                            <small class="text-danger">{{ __('Disabled = Login page becomes the homepage') }}</small>
                        </div>
                        <hr>
                        <div class="shadow rounded p-1 mb-1">
                            <div class="d-flex align-items-center justify-content-between">
                                <label class="me-1" for="preloader">{{ __('Frontend Preloader') }}</label>
                                <input class="form-check-input" type="checkbox" data-toggle="toggle" data-size="small"
                                    data-width="25%" data-onstyle="success" data-offstyle="danger"
                                    data-on="{{ __('Active') }}" data-off="{{ __('Inactive') }}" name="preloader"
                                    id="preloader" @if ($platform->frontend->preloader ?? '') checked @endif>
                            </div>
                            <small
                                class="text-danger">{{ __('Disabled = directly show frontend without waiting') }}</small>
                        </div>
                        <hr>
                        <div class="shadow rounded p-1 mb-1">
                            <div class="d-flex align-items-center justify-content-between">
                                <label class="me-1" for="auth_design">{{ __('Auth Pages Design') }}</label>
                                <input class="form-check-input" type="checkbox" data-toggle="toggle" data-size="small"
                                    data-width="25%" data-onstyle="success" data-offstyle="warning" data-on="Cover"
                                    data-off="Minimal" name="auth_design" id="auth_design"
                                    @if ($platform->frontend->auth_design ?? '') checked @endif>
                            </div>
                            <small class="text-danger">{{ __('Minimal: Compact Card, Cover: Full Page') }}</small>
                        </div>
                    </div>
                    <div class="tab-pane" id="dashboard" aria-labelledby="dashboard-tab" role="tabpanel">
                        <div class="shadow rounded p-1 mb-1">
                            <div class="d-flex align-items-center justify-content-between">
                                <label class="me-1" for="default_page">{{ __('Default Dashboard Page') }}</label>
                                <select class="form-select w-25" id="default_page" name="default_page">
                                    <option value="" @if (!isset($platform->dashboard->default_page) ||
                                        $platform->dashboard->default_page == null ||
                                        $platform->dashboard->default_page == '') selected @endif
                                        disabled="">
                                        {{ __('Choose an option') }}
                                    </option>
                                    <option value="trading" @if (isset($platform->dashboard->default_page) && $platform->dashboard->default_page == 'trading') selected @endif>
                                        Trading Page
                                    </option>
                                    <option value="binary" @if (isset($platform->dashboard->default_page) && $platform->dashboard->default_page == 'binary') selected @endif>
                                        Binary Dashboard
                                    </option>
                                    <option value="bot" @if (isset($platform->dashboard->default_page) && $platform->dashboard->default_page == 'bot') selected @endif>
                                        Bot Dashboard
                                    </option>
                                    <option value="ico" @if (isset($platform->dashboard->default_page) && $platform->dashboard->default_page == 'ico') selected @endif>
                                        Token Offers Page
                                    </option>
                                    <option value="mlm" @if (isset($platform->dashboard->default_page) && $platform->dashboard->default_page == 'mlm') selected @endif>
                                        Referrals Page
                                    </option>
                                    <option value="forex" @if (isset($platform->dashboard->default_page) && $platform->dashboard->default_page == 'forex') selected @endif>
                                        Forex Dashboard
                                    </option>
                                    <option value="staking" @if (isset($platform->dashboard->default_page) && $platform->dashboard->default_page == 'staking') selected @endif>
                                        Staking Dashboard
                                    </option>
                                    <option value="knowledge" @if (isset($platform->dashboard->default_page) && $platform->dashboard->default_page == 'knowledge') selected @endif>
                                        Knowledge Base Page
                                    </option>
                                </select>
                            </div>
                            <small class="text-warning">{{ __('Set default page to load after user login') }}</small>
                        </div>
                        <hr>
                        <div class="shadow rounded p-1 mb-1">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="col">
                                    <label class="me-1" for="first_trade_page">{{ __('First Trading Page') }}</label>
                                </div>
                                <div class="col">
                                    <input class="form-control" type="text" name="first_trade_page"
                                        value="{{ $platform->trading->first_trade_page ?? 'BTC/USDT' }}">
                                </div>
                            </div>
                            <small
                                class="text-warning">{{ __('Set first pair to show when you click start trading') }}</small>
                        </div>
                    </div>
                    <div class="tab-pane" id="trading" aria-labelledby="trading-tab" role="tabpanel">
                        <div class="shadow rounded p-1 mb-1">
                            <div class="d-flex align-items-center justify-content-between">
                                <label class="me-1" for="binary_status">{{ __('Binary Trading') }}</label>
                                <input class="form-check-input" type="checkbox" data-toggle="toggle" data-size="small"
                                    data-width="25%" data-onstyle="success" data-offstyle="danger"
                                    data-on="{{ __('Active') }}" data-off="{{ __('Inactive') }}" name="binary_status"
                                    id="binary_status" @if ($platform->trading->binary_status ?? '') checked @endif>
                            </div>
                            <small class="text-warning">{{ __('Completely Enable/Disable Binary System') }}</small>
                        </div>
                        <hr>
                        <div class="shadow rounded p-1 mb-1">
                            <div class="d-flex align-items-center justify-content-between">
                                <label class="me-1" for="trading_cards">{{ __('Trading Dynamic Cards') }}</label>
                                <input class="form-check-input" type="checkbox" data-toggle="toggle" data-size="small"
                                    data-width="25%" data-onstyle="success" data-offstyle="danger"
                                    data-on="{{ __('Active') }}" data-off="{{ __('Inactive') }}" name="trading_cards"
                                    id="trading_cards" @if ($platform->trading->trading_cards ?? '') checked @endif>
                            </div>
                            <small
                                class="text-success">{{ __('Enabled = (Resizable, Draggable, Arrangable) cards') }}</small>
                            ,
                            <small class="text-danger">{{ __('Disabled = static cards') }}</small>
                        </div>
                        <hr>
                        <div class="shadow rounded p-1 mb-1">
                            <div class="d-flex align-items-center justify-content-between">
                                <label class="me-1" for="pair_prices">{{ __('Trading Page Pair Prices') }}</label>
                                <input class="form-check-input" type="checkbox" data-toggle="toggle" data-size="small"
                                    data-width="25%" data-onstyle="success" data-offstyle="danger"
                                    data-on="{{ __('Active') }}" data-off="{{ __('Inactive') }}" name="pair_prices"
                                    id="pair_prices" @if ($platform->trading->pair_prices ?? '') checked @endif>
                            </div>
                            <small
                                class="text-danger">{{ __('Disabled = No pairs live price updates, faster loading') }}</small>
                        </div>
                        <hr>
                        <div class="shadow rounded p-1 mb-1">
                            <div class="d-flex align-items-center justify-content-between">
                                <label class="me-1" for="practice">{{ __('Practice Trading Only') }}</label>
                                <input class="form-check-input" type="checkbox" data-toggle="toggle" data-size="small"
                                    data-width="25%" data-onstyle="success" data-offstyle="danger"
                                    data-on="{{ __('Active') }}" data-off="{{ __('Inactive') }}" name="practice"
                                    id="practice" @if ($platform->trading->practice ?? '') checked @endif>
                            </div>
                            <small
                                class="text-success">{{ __('Enabled = No deposits or withdrawals, Admin manually add balance to clients, Trading become practice only') }}</small>
                        </div>
                    </div>
                    <div class="tab-pane" id="wallet" aria-labelledby="wallet-tab" role="tabpanel">
                        <div class="shadow rounded p-1 mb-1">
                            <div class="d-flex align-items-center justify-content-between">
                                <label class="form-control-label me-1">{{ __('Deposit Fees') }}</label>
                                <div class="dropdown">
                                    <button class="btn btn-outline-warning dropdown-toggle w-100" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false" id="deposit_fees_methodd"
                                        name="mlm_commission_typed">
                                        {{ $platform->wallet->deposit_fees_method ?? 'added' }}
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item"
                                                onclick="$('#deposit_fees_methodd').text($(this).text());$('#settings').find('input[name=deposit_fees_method]').val($(this).data('type'));"
                                                data-type="added">{{ __('added') }}</a></li>
                                        <li><a class="dropdown-item"
                                                onclick="$('#deposit_fees_methodd').text($(this).text());$('#settings').find('input[name=deposit_fees_method]').val($(this).data('type'));"
                                                data-type="subtracted">{{ __('subtracted') }}</a></li>
                                    </ul>
                                </div>
                            </div>
                            <small
                                class="text-warning">{{ __('added: deposit fees added to total deposit amount, subtracted: deposit fees subtracted from total deposit amount') }}</small>
                        </div>
                    </div>
                    @if (getExt(3)->status == 1)
                        <div class="tab-pane" id="mlm" aria-labelledby="mlm-tab" role="tabpanel">
                            <ul class="nav nav-tabs nav-fill border-primary shadow" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="mlm_general-tab" data-bs-toggle="tab"
                                        href="#mlm_general" aria-controls="mlm_general" role="tab"
                                        aria-selected="true">{{ __('General Settings') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="mlm_membership-tab" data-bs-toggle="tab"
                                        href="#mlm_membership" aria-controls="mlm_membership" role="tab"
                                        aria-selected="true">{{ __('Membership') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="mlm_community_line-tab" data-bs-toggle="tab"
                                        href="#mlm_community_line" aria-controls="mlm_community_line" role="tab"
                                        aria-selected="false">{{ __('Community Line') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="mlm_earning_methods-tab" data-bs-toggle="tab"
                                        href="#mlm_earning_methods" aria-controls="mlm_earning_methods" role="tab"
                                        aria-selected="false">{{ __('Earning Methods') }}</a>
                                </li>
                                @if ($platform->mlm->type == 'unilevel')
                                    <li class="nav-item">
                                        <a class="nav-link" id="mlm_rewards-tab" data-bs-toggle="tab"
                                            href="#mlm_rewards" aria-controls="mlm_rewards" role="tab"
                                            aria-selected="false">{{ __('Unilevel Reward Percentage') }}</a>
                                    </li>
                                @endif
                            </ul>
                            <div class="mx-1">
                                <div class="tab-content">
                                    <div class="tab-pane mb-1 active" id="mlm_general" aria-labelledby="mlm_general-tab"
                                        role="tabpanel">
                                        <div class="shadow rounded p-1 mb-1">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <label class="form-control-label me-1">{{ __('MLM System Type') }}</label>
                                                <div class="dropdown">
                                                    <button class="btn btn-outline-warning dropdown-toggle w-100"
                                                        type="button" data-bs-toggle="dropdown" aria-expanded="false"
                                                        id="mlm_typed" name="mlm_typed">
                                                        {{ $platform->mlm->type ?? 'binary' }}
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li><a class="dropdown-item"
                                                                onclick="$('#mlm_typed').text($(this).text());$('#settings').find('input[name=mlm_type]').val($(this).data('type'));"
                                                                data-type="binary">{{ __('binary') }}</a></li>
                                                        <li><a class="dropdown-item"
                                                                onclick="$('#mlm_typed').text($(this).text());$('#settings').find('input[name=mlm_type]').val($(this).data('type'));"
                                                                data-type="unilevel">{{ __('unilevel') }}</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <small
                                                class="text-warning">{{ __('Binary system allow users to rank and earn higher commission, Unilevel allow clients up to 5 levels to earn commission defined by percentage') }}</small>
                                        </div>
                                        <hr>
                                        <div class="shadow rounded p-1 mb-1">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <label
                                                    class="form-control-label me-1">{{ __('MLM Commission Type') }}</label>
                                                <div class="dropdown">
                                                    <button class="btn btn-outline-warning dropdown-toggle w-100"
                                                        type="button" data-bs-toggle="dropdown" aria-expanded="false"
                                                        id="mlm_commission_typed" name="mlm_commission_typed">
                                                        {{ $platform->mlm->commission_type ?? 'direct' }}
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li><a class="dropdown-item"
                                                                onclick="$('#mlm_commission_typed').text($(this).text());$('#settings').find('input[name=mlm_commission_type]').val($(this).data('type'));"
                                                                data-type="direct">{{ __('direct') }}</a></li>
                                                        <li><a class="dropdown-item"
                                                                onclick="$('#mlm_commission_typed').text($(this).text());$('#settings').find('input[name=mlm_commission_type]').val($(this).data('type'));"
                                                                data-type="daily">{{ __('daily') }}</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <small
                                                class="text-warning">{{ __('Daily will make investments and plans earn commission on daily bases for referrers') }}</small>
                                        </div>
                                        <hr>
                                        <div class="shadow rounded p-1 mb-1">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="col">
                                                    <label class="me-1"
                                                        for="mlm_min_withdraw">{{ __('Minimum Bv to unlock withdrawal') }}</label>
                                                </div>
                                                <div class="col">
                                                    <div class="input-group">
                                                        <input class="form-control" type="text"
                                                            name="mlm_min_withdraw"
                                                            value="{{ $platform->mlm->min_withdraw ?? 100 }}">
                                                        <span class="input-group-text">BV</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <small
                                                class="text-warning">{{ __('Minimum business value earned to unlock withdrawal button') }}</small>
                                        </div>
                                    </div>
                                    <div class="tab-pane mb-1" id="mlm_membership" aria-labelledby="mlm_membership-tab"
                                        role="tabpanel">
                                        <div class="shadow rounded p-1 mb-1">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <label class="me-1" for="membership_status">{{ __('Membership') }}
                                                </label>
                                                <input class="form-check-input" type="checkbox" data-toggle="toggle"
                                                    data-size="small" data-onstyle="success" data-offstyle="danger"
                                                    data-width="25%" data-on="{{ __('Active') }}"
                                                    data-off="{{ __('Inactive') }}" name="membership_status"
                                                    id="membership_status"
                                                    @if ($platform->mlm->membership_status ?? '') checked @endif>
                                            </div>
                                            <small
                                                class="text-warning">{{ __('Enable membership system where only those who deposit can earn from commission methods') }}
                                            </small>
                                        </div>
                                        <hr>
                                        <div class="shadow rounded p-1 mb-1">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <label class="me-1"
                                                    for="membership_can_earn">{{ __('Only Membership Can Earn') }}
                                                </label>
                                                <input class="form-check-input" type="checkbox" data-toggle="toggle"
                                                    data-size="small" data-onstyle="success" data-offstyle="danger"
                                                    data-width="25%" data-on="{{ __('Active') }}"
                                                    data-off="{{ __('Inactive') }}" name="membership_can_earn"
                                                    id="membership_can_earn"
                                                    @if ($platform->mlm->membership_can_earn ?? '') checked @endif>
                                            </div>
                                            <small
                                                class="text-warning">{{ __('Only clients with active membership can earn BV or reward his uplines') }}
                                            </small>
                                        </div>
                                        <hr>
                                        <div class="shadow rounded p-1 mb-1">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="col">
                                                    <label class="me-1"
                                                        for="membership_fees">{{ __('Membership deposit/withadraw fees') }}
                                                    </label>
                                                </div>
                                                <div class="col">
                                                    <div class="input-group mt-1">
                                                        <input class="form-control" type="text" name="membership_fees"
                                                            value="{{ $platform->mlm->membership_fees ?? '1' }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <small
                                                class="text-warning">{{ __('Fees for the site from all deposits or withdrawals of clients with active membership') }}
                                            </small>
                                        </div>
                                        <hr>
                                        <div class="shadow rounded p-1 mb-1">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="col">
                                                    <label class="me-1"
                                                        for="membership_duration">{{ __('Membership Duration') }}
                                                    </label>
                                                </div>
                                                <div class="col">
                                                    <div class="input-group mt-1">
                                                        <input class="form-control" type="text"
                                                            name="membership_duration"
                                                            value="{{ $platform->mlm->membership_duration ?? '25' }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <small
                                                class="text-warning">{{ __('Duration of no BV earning until membership is cancelled') }}
                                            </small>
                                        </div>
                                        <hr>
                                        <div class="shadow rounded p-1 mb-1">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="col">
                                                    <label class="me-1"
                                                        for="membership_grace_duration">{{ __('Membership Grace Duration') }}
                                                    </label>
                                                </div>
                                                <div class="col">
                                                    <div class="input-group mt-1">
                                                        <input class="form-control" type="text"
                                                            name="membership_grace_duration"
                                                            value="{{ $platform->mlm->membership_grace_duration ?? '5' }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <small
                                                class="text-warning">{{ __('Grace duration to notify client to earn bv before final cancellation of membership') }}
                                            </small>
                                        </div>
                                        <hr>
                                        <div class="shadow rounded p-1 mb-1">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <label class="me-1"
                                                    for="membership_custom_deposit">{{ __('Membership Custom Deposit Token') }}
                                                </label>
                                                <input class="form-check-input" type="checkbox" data-toggle="toggle"
                                                    data-size="small" data-onstyle="success" data-offstyle="danger"
                                                    data-width="25%" data-on="{{ __('Active') }}"
                                                    data-off="{{ __('Inactive') }}" name="membership_custom_deposit"
                                                    id="membership_custom_deposit"
                                                    @if ($platform->mlm->membership_custom_deposit ?? '') checked @endif>
                                            </div>
                                            <small
                                                class="text-warning">{{ __('Show deposit card with custom token and wallet address to send to in order to join membership plan') }}
                                            </small>
                                        </div>
                                        <hr>
                                        <div class="shadow rounded p-1 mb-1">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="col">
                                                    <label class="me-1"
                                                        for="membership_deposit_currency">{{ __('Membership Custom Deposit Currency') }}
                                                    </label>
                                                </div>
                                                <div class="col">
                                                    <div class="input-group mt-1">
                                                        <input class="form-control" type="text"
                                                            name="membership_deposit_currency"
                                                            value="{{ $platform->mlm->membership_deposit_currency ?? 'USDT' }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <small
                                                class="text-warning">{{ __('Deposit token to show in the deposit card') }}
                                            </small>
                                        </div>
                                        <hr>
                                        <div class="shadow rounded p-1 mb-1">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="col">
                                                    <label class="me-1"
                                                        for="membership_deposit_currency_network">{{ __('Membership Custom Deposit Currency Network') }}
                                                    </label>
                                                </div>
                                                <div class="col">
                                                    <div class="input-group mt-1">
                                                        <input class="form-control" type="text"
                                                            name="membership_deposit_currency_network"
                                                            value="{{ $platform->mlm->membership_deposit_currency_network ?? 'ETH' }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <small
                                                class="text-warning">{{ __('Deposit token to show in the deposit card') }}
                                            </small>
                                        </div>
                                        <hr>
                                        <div class="shadow rounded p-1 mb-1">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="col">
                                                    <label class="me-1"
                                                        for="membership_deposit_wallet">{{ __('Membership Custom Deposit Wallet') }}
                                                    </label>
                                                </div>
                                                <div class="col">
                                                    <div class="input-group mt-1">
                                                        <input class="form-control" type="text"
                                                            name="membership_deposit_wallet"
                                                            value="{{ $platform->mlm->membership_deposit_wallet ?? '' }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <small
                                                class="text-warning">{{ __('Wallet address to show to client when he want to subscribe to membership plan') }}
                                            </small>
                                        </div>
                                        <hr>
                                        <div class="shadow rounded p-1 mb-1">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <label class="me-1"
                                                    for="membership_custom_withdraw">{{ __('Membership Custom Withdraw') }}
                                                </label>
                                                <input class="form-check-input" type="checkbox" data-toggle="toggle"
                                                    data-size="small" data-onstyle="success" data-offstyle="danger"
                                                    data-width="25%" data-on="{{ __('Active') }}"
                                                    data-off="{{ __('Inactive') }}" name="membership_custom_withdraw"
                                                    id="membership_custom_withdraw"
                                                    @if ($platform->mlm->membership_custom_withdraw ?? '') checked @endif>
                                            </div>
                                            <small
                                                class="text-warning">{{ __('Show withdraw card ability to set client own wallet to withdraw to') }}
                                            </small>
                                        </div>
                                        <hr>
                                        <div class="shadow rounded p-1">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="col">
                                                    <label class="me-1"
                                                        for="membership_withdraw_currency">{{ __('Membership Custom Withdraw Currency') }}
                                                    </label>
                                                </div>
                                                <div class="col">
                                                    <div class="input-group mt-1">
                                                        <input class="form-control" type="text"
                                                            name="membership_withdraw_currency"
                                                            value="{{ $platform->mlm->membership_withdraw_currency ?? 'USDT' }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <small class="text-warning">{{ __('Withdraw currency to collect earnings') }}
                                            </small>
                                        </div>
                                        <hr>
                                        <div class="shadow rounded p-1">
                                            <label class="form-label"
                                                for="membership_terms">{{ __('Membership Upgrade Terms') }}</label>
                                            <textarea id="membership_terms" name="membership_terms" style="width: calc(90vw);" rows="10" cols="40">{!! $platform->mlm->membership_terms ?? '' !!}
                                        </textarea>
                                        </div>
                                    </div>
                                    <div class="tab-pane mb-1" id="mlm_community_line"
                                        aria-labelledby="mlm_community_line-tab" role="tabpanel">
                                        <div class="shadow rounded p-1 mb-1">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <label class="me-1"
                                                    for="community_line_status">{{ __('Community Line') }}
                                                </label>
                                                <input class="form-check-input" type="checkbox" data-toggle="toggle"
                                                    data-size="small" data-onstyle="success" data-offstyle="danger"
                                                    data-width="25%" data-on="{{ __('Active') }}"
                                                    data-off="{{ __('Inactive') }}" name="community_line_status"
                                                    id="community_line_status"
                                                    @if ($platform->mlm->community_line_status ?? '') checked @endif>
                                            </div>
                                            <small
                                                class="text-warning">{{ __('When client deposit, latest clients in the community will get 1% as BV') }}
                                            </small>
                                        </div>
                                        <div class="shadow rounded p-1">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="col">
                                                    <label class="me-1"
                                                        for="community_line_clients">{{ __('Community Line Clients') }}
                                                    </label>
                                                </div>
                                                <div class="col">
                                                    <div class="input-group mt-1">
                                                        <input class="form-control" type="text"
                                                            name="community_line_clients"
                                                            value="{{ $platform->mlm->community_line_clients ?? '' }}">
                                                        <span class="input-group-text">{{ __('Client') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <small
                                                class="text-warning">{{ __('Number of clients that will recieve the 1% BV in the community line') }}
                                            </small>
                                        </div>
                                    </div>
                                    <div class="tab-pane mb-1" id="mlm_earning_methods"
                                        aria-labelledby="mlm_earning_methods" role="tabpanel">
                                        <div class="shadow rounded p-1 mb-1">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <label class="me-1"
                                                    for="mlm_deposits">{{ __('BV from Deposits') }}</label>
                                                <input class="form-check-input" type="checkbox" data-toggle="toggle"
                                                    data-size="small" data-width="25%" data-onstyle="success"
                                                    data-offstyle="danger" data-on="{{ __('Active') }}"
                                                    data-off="{{ __('Inactive') }}" name="mlm_deposits"
                                                    id="mlm_deposits" @if ($platform->mlm->deposits ?? 1) checked @endif>
                                            </div>
                                            <small
                                                class="text-warning">{{ __('Referrar earn BV percentage set by admin for each of his downlines deposits') }}</small>
                                        </div>
                                        @if ($platform->mlm->type == 'binary')
                                            <hr>
                                            <div class="shadow rounded p-1 mb-1">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <label class="me-1"
                                                        for="mlm_first_deposit">{{ __('BV from First Deposits') }}</label>
                                                    <input class="form-check-input" type="checkbox" data-toggle="toggle"
                                                        data-size="small" data-width="25%" data-onstyle="success"
                                                        data-offstyle="danger" data-on="{{ __('Active') }}"
                                                        data-off="{{ __('Inactive') }}" name="mlm_first_deposit"
                                                        id="mlm_first_deposit"
                                                        @if ($platform->mlm->first_deposit ?? 1) checked @endif>
                                                </div>
                                                <small
                                                    class="text-warning">{{ __('Referrar earn BV percentage set by admin for each of his downlines first deposit') }}</small>
                                            </div>
                                            <hr>
                                            <div class="shadow rounded p-1 mb-1">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <label class="me-1"
                                                        for="mlm_active_first_deposit">{{ __('BV from Active First Deposits') }}</label>
                                                    <input class="form-check-input" type="checkbox" data-toggle="toggle"
                                                        data-size="small" data-width="25%" data-onstyle="success"
                                                        data-offstyle="danger" data-on="{{ __('Active') }}"
                                                        data-off="{{ __('Inactive') }}" name="mlm_active_first_deposit"
                                                        id="mlm_active_first_deposit"
                                                        @if ($platform->mlm->active_first_deposit ?? 1) checked @endif>
                                                </div>
                                                <small
                                                    class="text-warning">{{ __('Referrar earn BV percentage set by admin for each of his active downlines first deposits') }}</small>
                                            </div>
                                        @endif
                                        <hr>
                                        <div class="shadow rounded p-1 mb-1">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <label class="me-1"
                                                    for="mlm_trades">{{ __('BV from Trades') }}</label>
                                                <input class="form-check-input" type="checkbox" data-toggle="toggle"
                                                    data-size="small" data-width="25%" data-onstyle="success"
                                                    data-offstyle="danger" data-on="{{ __('Active') }}"
                                                    data-off="{{ __('Inactive') }}" name="mlm_trades" id="mlm_trades"
                                                    @if ($platform->mlm->trades ?? 1) checked @endif>
                                            </div>
                                            <small
                                                class="text-warning">{{ __('Referrar earn BV percentage set by admin for each of his downlines trades') }}</small>
                                        </div>
                                        <hr>
                                        <div class="shadow rounded p-1 mb-1">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <label class="me-1"
                                                    for="mlm_bot_investment">{{ __('BV from Bot Investments') }}</label>
                                                <input class="form-check-input" type="checkbox" data-toggle="toggle"
                                                    data-size="small" data-width="25%" data-onstyle="success"
                                                    data-offstyle="danger" data-on="{{ __('Active') }}"
                                                    data-off="{{ __('Inactive') }}" name="mlm_bot_investment"
                                                    id="mlm_bot_investment"
                                                    @if ($platform->mlm->bot_investment ?? 1) checked @endif>
                                            </div>
                                            <small
                                                class="text-warning">{{ __('Referrar earn BV percentage set by admin for each of his downlines bot investments') }}</small>
                                        </div>
                                        <hr>
                                        <div class="shadow rounded p-1 mb-1">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <label class="me-1"
                                                    for="mlm_ico_purchase">{{ __('BV from Token Ico Purchases') }}</label>
                                                <input class="form-check-input" type="checkbox" data-toggle="toggle"
                                                    data-size="small" data-width="25%" data-onstyle="success"
                                                    data-offstyle="danger" data-on="{{ __('Active') }}"
                                                    data-off="{{ __('Inactive') }}" name="mlm_ico_purchase"
                                                    id="mlm_ico_purchase"
                                                    @if ($platform->mlm->ico_purchase ?? 1) checked @endif>
                                            </div>
                                            <small
                                                class="text-warning">{{ __('Referrar earn BV percentage set by admin for each of his downlines token ico purchases') }}</small>
                                        </div>
                                        <hr>
                                        <div class="shadow rounded p-1 mb-1">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <label class="me-1"
                                                    for="mlm_forex_deposit">{{ __('BV from Forex Deposits') }}</label>
                                                <input class="form-check-input" type="checkbox" data-toggle="toggle"
                                                    data-size="small" data-width="25%" data-onstyle="success"
                                                    data-offstyle="danger" data-on="{{ __('Active') }}"
                                                    data-off="{{ __('Inactive') }}" name="mlm_forex_deposit"
                                                    id="mlm_forex_deposit"
                                                    @if ($platform->mlm->forex_deposit ?? 1) checked @endif>
                                            </div>
                                            <small
                                                class="text-warning">{{ __('Referrar earn BV percentage set by admin for each of his downlines forex deposits') }}</small>
                                        </div>
                                        <hr>
                                        <div class="shadow rounded p-1 mb-1">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <label class="me-1"
                                                    for="mlm_forex_investment">{{ __('BV from Forex Investments') }}</label>
                                                <input class="form-check-input" type="checkbox" data-toggle="toggle"
                                                    data-size="small" data-width="25%" data-onstyle="success"
                                                    data-offstyle="danger" data-on="{{ __('Active') }}"
                                                    data-off="{{ __('Inactive') }}" name="mlm_forex_investment"
                                                    id="mlm_forex_investment"
                                                    @if ($platform->mlm->forex_investment ?? 1) checked @endif>
                                            </div>
                                            <small
                                                class="text-warning">{{ __('Referrar earn BV percentage set by admin for each of his downlines forex investments') }}</small>
                                        </div>
                                        @if (getExt('6')->status == 1)
                                            <div class="shadow rounded p-1">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <label class="me-1"
                                                        for="mlm_staking">{{ __('BV from Staking') }}</label>
                                                    <input class="form-check-input" type="checkbox" data-toggle="toggle"
                                                        data-size="small" data-width="25%" data-onstyle="success"
                                                        data-offstyle="danger" data-on="{{ __('Active') }}"
                                                        data-off="{{ __('Inactive') }}" name="mlm_staking"
                                                        id="mlm_staking"
                                                        @if ($platform->mlm->staking ?? 1) checked @endif>
                                                </div>
                                                <small
                                                    class="text-warning">{{ __('Referrar earn BV percentage set by admin for each of his downlines staking') }}</small>
                                            </div>
                                        @endif
                                    </div>
                                    @if ($platform->mlm->type == 'unilevel')
                                        <div class="tab-pane mb-1" id="mlm_rewards" aria-labelledby="mlm_rewards-tab"
                                            role="tabpanel">
                                            <div class="shadow rounded p-1 mb-1">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="col">
                                                        <label class="me-1"
                                                            for="unilevel_upline1_percentage">{{ __('1st Upline') }}
                                                        </label>
                                                        <span class="badge bg-success">{{ __('Active') }}</span>
                                                    </div>
                                                    <div class="col">
                                                        <div class="input-group mt-1">
                                                            <input class="form-control" type="text"
                                                                name="unilevel_upline1_percentage"
                                                                value="{{ $platform->mlm->unilevel_upline1_percentage ?? '' }}">
                                                            <span class="input-group-text">%</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <small
                                                    class="text-warning">{{ __('Direct Referrer Commission Percentage') }}</small>
                                            </div>
                                            <hr>
                                            <div class="shadow rounded p-1 mb-1">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="col">
                                                        <label class="me-1"
                                                            for="unilevel_upline2_percentage">{{ __('2nd Upline') }}
                                                        </label>
                                                        <input class="form-check-input" type="checkbox"
                                                            data-toggle="toggle" data-size="small" data-onstyle="success"
                                                            data-offstyle="danger" data-width="25%"
                                                            data-on="{{ __('Active') }}"
                                                            data-off="{{ __('Inactive') }}"
                                                            name="unilevel_upline2_status" id="unilevel_upline2_status"
                                                            @if ($platform->mlm->unilevel_upline2_status ?? '') checked @endif>
                                                    </div>
                                                    <div class="col">
                                                        <div class="input-group mt-1">
                                                            <input class="form-control" type="text"
                                                                name="unilevel_upline2_percentage"
                                                                value="{{ $platform->mlm->unilevel_upline2_percentage ?? '' }}">
                                                            <span class="input-group-text">%</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <small
                                                    class="text-warning">{{ __('Second Upline Commission Percentage') }}</small>
                                            </div>
                                            <hr>
                                            <div class="shadow rounded p-1 mb-1">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="col">
                                                        <label class="me-1"
                                                            for="unilevel_upline3_percentage">{{ __('3rd Upline') }}
                                                        </label>
                                                        <input class="form-check-input" type="checkbox"
                                                            data-toggle="toggle" data-size="small" data-onstyle="success"
                                                            data-offstyle="danger" data-width="25%"
                                                            data-on="{{ __('Active') }}"
                                                            data-off="{{ __('Inactive') }}"
                                                            name="unilevel_upline3_status" id="unilevel_upline3_status"
                                                            @if ($platform->mlm->unilevel_upline3_status ?? '') checked @endif>
                                                    </div>
                                                    <div class="col">
                                                        <div class="input-group mt-1">
                                                            <input class="form-control" type="text"
                                                                name="unilevel_upline3_percentage"
                                                                value="{{ $platform->mlm->unilevel_upline3_percentage ?? '' }}">
                                                            <span class="input-group-text">%</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <small
                                                    class="text-warning">{{ __('Third Upline Commission Percentage') }}</small>
                                            </div>
                                            <hr>
                                            <div class="shadow rounded p-1 mb-1">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="col">
                                                        <label class="me-1"
                                                            for="unilevel_upline4_percentage">{{ __('4th Upline') }}
                                                        </label>
                                                        <input class="form-check-input" type="checkbox"
                                                            data-toggle="toggle" data-size="small" data-onstyle="success"
                                                            data-offstyle="danger" data-width="25%"
                                                            data-on="{{ __('Active') }}"
                                                            data-off="{{ __('Inactive') }}"
                                                            name="unilevel_upline4_status" id="unilevel_upline4_status"
                                                            @if ($platform->mlm->unilevel_upline4_status ?? '') checked @endif>
                                                    </div>
                                                    <div class="col">
                                                        <div class="input-group mt-1">
                                                            <input class="form-control" type="text"
                                                                name="unilevel_upline4_percentage"
                                                                value="{{ $platform->mlm->unilevel_upline4_percentage ?? '' }}">
                                                            <span class="input-group-text">%</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <small
                                                    class="text-warning">{{ __('Fourth Upline Commission Percentage') }}</small>
                                            </div>
                                            <hr>
                                            <div class="shadow rounded p-1 mb-1">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="col">
                                                        <label class="me-1"
                                                            for="unilevel_upline5_percentage">{{ __('5th Upline') }}
                                                        </label>
                                                        <input class="form-check-input" type="checkbox"
                                                            data-toggle="toggle" data-size="small" data-onstyle="success"
                                                            data-offstyle="danger" data-width="25%"
                                                            data-on="{{ __('Active') }}"
                                                            data-off="{{ __('Inactive') }}"
                                                            name="unilevel_upline5_status" id="unilevel_upline5_status"
                                                            @if ($platform->mlm->unilevel_upline5_status ?? '') checked @endif>
                                                    </div>
                                                    <div class="col">
                                                        <div class="input-group mt-1">
                                                            <input class="form-control" type="text"
                                                                name="unilevel_upline5_percentage"
                                                                value="{{ $platform->mlm->unilevel_upline5_percentage ?? '' }}">
                                                            <span class="input-group-text">%</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <small
                                                    class="text-warning">{{ __('Fifth Upline Commission Percentage') }}</small>
                                            </div>
                                            <hr>
                                            <div class="shadow rounded p-1 mb-1">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="col">
                                                        <label class="me-1"
                                                            for="unilevel_upline6_percentage">{{ __('6th Upline') }}
                                                        </label>
                                                        <input class="form-check-input" type="checkbox"
                                                            data-toggle="toggle" data-size="small" data-onstyle="success"
                                                            data-offstyle="danger" data-width="25%"
                                                            data-on="{{ __('Active') }}"
                                                            data-off="{{ __('Inactive') }}"
                                                            name="unilevel_upline6_status" id="unilevel_upline6_status"
                                                            @if ($platform->mlm->unilevel_upline6_status ?? '') checked @endif>
                                                    </div>
                                                    <div class="col">
                                                        <div class="input-group mt-1">
                                                            <input class="form-control" type="text"
                                                                name="unilevel_upline6_percentage"
                                                                value="{{ $platform->mlm->unilevel_upline6_percentage ?? '' }}">
                                                            <span class="input-group-text">%</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <small
                                                    class="text-warning">{{ __('Sixth Upline Commission Percentage') }}</small>
                                            </div>
                                            <div class="shadow rounded p-1 mb-1">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="col">
                                                        <label class="me-1"
                                                            for="unilevel_upline7_percentage">{{ __('7th Upline') }}
                                                        </label>
                                                        <input class="form-check-input" type="checkbox"
                                                            data-toggle="toggle" data-size="small" data-width="25%"
                                                            data-onstyle="success" data-offstyle="danger"
                                                            data-on="{{ __('Active') }}"
                                                            data-off="{{ __('Inactive') }}"
                                                            name="unilevel_upline7_status" id="unilevel_upline7_status"
                                                            @if ($platform->mlm->unilevel_upline7_status ?? '') checked @endif>
                                                    </div>
                                                    <div class="col">
                                                        <div class="input-group mt-1">
                                                            <input class="form-control" type="text"
                                                                name="unilevel_upline7_percentage"
                                                                value="{{ $platform->mlm->unilevel_upline7_percentage ?? '' }}">
                                                            <span class="input-group-text">%</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <small
                                                    class="text-warning">{{ __('Seventh Upline Commission Percentage') }}</small>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                    @if (getExt(6)->status == 1)
                        <div class="tab-pane" id="staking" aria-labelledby="staking-tab" role="tabpanel">
                            <div class="shadow rounded p-1 mb-1">
                                <div class="d-flex align-items-center justify-content-between">
                                    <label class="me-1" for="cancel_stake">Cancel Claim Option</label>
                                    <input class="form-check-input" type="checkbox" data-toggle="toggle"
                                        data-size="small" data-width="25%" data-onstyle="success" data-offstyle="danger"
                                        data-on="Enabled" data-off="Disabled" name="cancel_stake" id="cancel_stake"
                                        @if ($platform->staking->cancel_stake ?? '') checked @endif>
                                </div>
                                <small
                                    class="text-danger">{{ __('Enabled: allow client to cancel his staking and claim his original amount without profit before the end of staking duration') }}</small>
                            </div>
                        </div>
                    @endif
                    @if (getExt(10)->status == 1)
                        <div class="tab-pane" id="eco" aria-labelledby="eco-tab" role="tabpanel">
                            <div class="shadow rounded p-1 mb-1">
                                <div class="d-flex align-items-center justify-content-between">
                                    <label class="me-1"
                                        for="ecosystem_trading_only">{{ __('Show only ecosystem pairs') }}</label>
                                    <input class="form-check-input" type="checkbox" data-toggle="toggle"
                                        data-size="small" data-width="25%" data-onstyle="success" data-offstyle="danger"
                                        data-on="Enabled" data-off="Disabled" name="ecosystem_trading_only"
                                        id="ecosystem_trading_only" @if ($platform->eco->ecosystem_trading_only ?? '') checked @endif>
                                </div>
                                <small
                                    class="text-danger">{{ __('Enabled: only show eco system pairs while hiding all providers trading pairs and make tabs from the ecosystem pairing') }}</small>
                            </div>
                        </div>
                    @endif
                    <div class="tab-pane" id="mobile" aria-labelledby="mobile-tab" role="tabpanel">
                        <div class="shadow rounded p-1 mb-1">
                            <div class="d-flex align-items-center justify-content-between">
                                <label class="me-1"
                                    for="mobile_market_info">{{ __('Market Info Card In Phones') }}</label>
                                <input class="form-check-input" type="checkbox" data-toggle="toggle" data-size="small"
                                    data-width="25%" data-onstyle="success" data-offstyle="danger"
                                    data-on="{{ __('Enabled') }}" data-off="{{ __('Disabled') }}"
                                    name="mobile_market_info" id="mobile_market_info"
                                    @if ($platform->mobile->market_info ?? '') checked @endif>
                            </div>
                        </div>
                        <hr>
                        <div class="shadow rounded p-1 mb-1">
                            <div class="d-flex align-items-center justify-content-between">
                                <label class="me-1" for="mobile_trades">{{ __('Trades Card In Phones') }}</label>
                                <input class="form-check-input" type="checkbox" data-toggle="toggle" data-size="small"
                                    data-width="25%" data-onstyle="success" data-offstyle="danger"
                                    data-on="{{ __('Enabled') }}" data-off="{{ __('Disabled') }}"
                                    name="mobile_trades" id="mobile_trades"
                                    @if ($platform->mobile->trades ?? '') checked @endif>
                            </div>
                        </div>
                        <hr>
                        <div class="shadow rounded p-1 mb-1">
                            <div class="d-flex align-items-center justify-content-between">
                                <label class="me-1"
                                    for="mobile_charting">{{ __('Charting Card In Phones') }}</label>
                                <input class="form-check-input" type="checkbox" data-toggle="toggle"
                                    data-size="small" data-width="25%" data-onstyle="success" data-offstyle="danger"
                                    data-on="{{ __('Enabled') }}" data-off="{{ __('Disabled') }}"
                                    name="mobile_charting" id="mobile_charting"
                                    @if ($platform->mobile->charting ?? '') checked @endif>
                            </div>
                        </div>
                        <hr>
                        <div class="shadow rounded p-1 mb-1">
                            <div class="d-flex align-items-center justify-content-between">
                                <label class="me-1" for="mobile_orders">{{ __('Orders Card In Phones') }}</label>
                                <input class="form-check-input" type="checkbox" data-toggle="toggle"
                                    data-size="small" data-width="25%" data-onstyle="success" data-offstyle="danger"
                                    data-on="{{ __('Enabled') }}" data-off="{{ __('Disabled') }}"
                                    name="mobile_orders" id="mobile_orders"
                                    @if ($platform->mobile->orders ?? '') checked @endif>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
            </div>
        </div>
    </form>
@endsection

@section('vendor-script')
    <!-- vendor files -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap4-toggle/3.6.1/bootstrap4-toggle.min.js"></script>
    <script src="//js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
    <script type="text/javascript">
        bkLib.onDomLoaded(nicEditors.allTextAreas);
    </script>
@endsection
