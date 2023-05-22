@extends('layouts.app')
@section('content')
    {{-- <div class="se-pre-con-admin">
        <div class="se-pre-con2 spinner-border text-primary" role="status">
            <span class="sr-only"></span>
        </div>
    </div> --}}
    @can('system_manager_access')
        @if (file_exists(public_path() . '/install/index.php'))
            <div class="alert alert-danger mb-2">
                <div class="alert-heading"><i class="bi bi-exclamation-triangle"></i> {{ __('Security Alert') }}</div>
                <div class="alert-body">
                    {{ __('Your have not deleted') }}
                    <code>/public/install/index.php</code>
                    {{ __('file, others can invalidate your license if its not deleted, click') }} <a
                        href="{{ route('admin.alerts.remove_install_file') }}"><button
                            class="btn btn-sm btn-success">{{ __('Install Cleaner') }}</button></a>
                    {{ __('to get it removed!') }}
                </div>
            </div>
        @endif
    @endcan
    
    @can('email_manager_show')
        @if (!env('MAIL_PASSWORD'))
            <div class="alert alert-warning mb-2">
                <div class="alert-heading"><i class="bi bi-exclamation-triangle"></i> {{ __('Email Warning') }}</div>
                <div class="alert-body">
                    {{ __('You forgot to add SMTP email in email settings, click') }}
                    {{-- <a href="{{ route('admin.settings.email') }}"><button class="btn btn-sm btn-success">{{ __('Email Settings') }}</button></a> --}}
                    {{ __('to add it, otherwise you will get error 500 on registeration!') }}
                </div>
            </div>
        @endif
    @endcan
    
    @can('general_settings_show')
        @if (!getGen()->cors)
            <div class="alert alert-warning mb-2">
                <div class="alert-heading"><i class="bi bi-exclamation-triangle"></i> {{ __('Cors Warning') }}</div>
                <div class="alert-body">
                    {{ __('You forgot to add cors link in general settings, click') }} <a
                        href="{{ route('admin.setting.index') }}"><button
                            class="btn btn-sm btn-success">{{ __('General Settings') }}</button></a>
                    {{ __('to add it, otherwise you will get empty page on trading!') }}
                </div>
            </div>
        @endif
    @endcan
    <!--/ Users Cards -->
    
    <div class="row">

        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
            <div class="card">
                <div class="card-header align-items-start pb-0">
                    <div>
                        <h2 class="fw-bolder">{{ $widget['total_users'] }}
                            @can('user_show')
                                <a href="{{ route('admin.users.all') }}"
                                    class="btn btn-sm text-small bg-white text-red">{{ __('View All') }}</a>
                            @endcan
                        </h2>
                        <p class="card-text">{{ __('Users') }}</p>
                    </div>
                    <div class="avatar bg-light-success p-50">
                        <div class="avatar-content">
                            <i class="bi bi-people font-medium-5"></i>
                        </div>
                    </div>
                </div>
                <div id="line-area-chart-1"></div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
            <div class="card">
                <div class="card-header align-items-start pb-0">
                    <div>
                        <h2 class="fw-bolder">{{ $widget['verified_users'] }}
                            @can('user_show')
                                <a href="{{ route('admin.users.all') }}"
                                    class="btn btn-sm text-small bg-white text-red">{{ __('View All') }}</a>
                            @endcan
                        </h2>
                        <p class="card-text">{{ __('Verified Users') }}</p>
                    </div>
                    <div class="avatar bg-light-success p-50">
                        <div class="avatar-content">
                            <i class="bi bi-people-fill font-medium-5"></i>
                        </div>
                    </div>
                </div>
                <div id="line-area-chart-2"></div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
            <div class="card">
                <div class="card-header align-items-start pb-0">
                    <div>
                        <h2 class="fw-bolder">{{ $widget['email_unverified_users'] }}
                            @can('user_show')
                                <a href="{{ route('admin.users.all') }}"
                                    class="btn btn-sm text-small bg-white text-red">{{ __('View All') }}</a>
                            @endcan
                        </h2>
                        <p class="card-text">{{ __('Email Unverified Users') }}</p>
                    </div>
                    <div class="avatar bg-light-success p-50">
                        <div class="avatar-content">
                            <i class="bi bi-envelope font-medium-5"></i>
                        </div>
                    </div>
                </div>
                <div id="line-area-chart-3"></div>
            </div>
        </div>
    </div>
    @can('trade_log')
        <div class="row match-height">
            <div class="col-xl-8 col-lg-8 col-md-6 col-sm-12">
                <div class="card card-revenue-budget">
                    <div class="row mx-0">
                        <div class="col-md-6 col-12 revenue-report-wrapper">
                            <div class="d-sm-flex justify-content-between align-items-center mb-3">
                                <h4 class="card-title mb-50 mb-sm-0">{{ __('Trades Log') }}</h4>
                                <div class="d-flex align-items-center">
                                    <div class="d-flex align-items-center me-2">
                                        <span class="bullet bullet-success font-small-3 me-50 cursor-pointer"></span>
                                        <span>{{ __('Buy') }}</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="bullet bullet-danger font-small-3 me-50 cursor-pointer"></span>
                                        <span>{{ __('Sell') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div id="trades-numbers-chart"></div>
                        </div>
                        <div class="col-md-6 col-12 revenue-report-wrapper">
                            <div class="d-sm-flex justify-content-between align-items-center mb-3">
                                <h4 class="card-title mb-50 mb-sm-0">{{ __('Trades Value') }}</h4>
                                <div class="d-flex align-items-center">
                                    <div class="d-flex align-items-center me-2">
                                        <span class="bullet bullet-success font-small-3 me-50 cursor-pointer"></span>
                                        <span>{{ __('Buy') }}</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="bullet bullet-danger font-small-3 me-50 cursor-pointer"></span>
                                        <span>{{ __('Sell') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div id="trades-amount-chart"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                <div class="card card-transaction">
                    <div class="card-title m-1">
                        <div class="d-flex justify-content-between">
                            @if ($notifications->count() > 0)
                                <h4 class="notification-title mb-0 me-auto">{{ __('Notifications') }}</h4>
                                <div class="badge rounded-pill badge-light-primary badge-sm">@lang('You have')
                                    <span class="fw-bolder">{{ $notifications->count() }}</span> @lang('unread notification')
                                </div>
                            @else
                                <h4 class="notification-title mb-0 me-auto">{{ __('Notifications') }}</h4>
                            @endif
                        </div>
                    </div>
                    @if ($notifications->count() > 0)
                        <div style="max-height: calc(38vh); overflow-y: auto">
                            @foreach ($notifications as $notification)
                                <a class="m-1 d-flex" href="{{ route('admin.notification.read', $notification->id) }}">
                                    <div class="list-item d-flex align-items-start">
                                        <div class="me-1">
                                            <div class="avatar">
                                                <img class="round"
                                                    src="{{ getImage(imagePath()['profileImage']['path'] . '/' . @$notification->user->profile_photo_path, imagePath()['profileImage']['size']) }}"
                                                    alt="avatar" height="40" width="40">
                                            </div>
                                        </div>
                                        <div class="text-dark">
                                            <div class="fw-bolder">{{ $notification->title }}
                                            </div>
                                            <div><small class="notification-text"><i class="bi bi-clock"></i>
                                                    {{ $notification->created_at->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <hr>
                            @endforeach
                        </div>
                        <div class="input-group mt-auto mx-auto">
                            <a class="btn btn-primary w-50 btn-sm"
                                href="{{ route('admin.notifications') }}">{{ __('Read all') }}</a>
                            <a class="btn btn-danger w-50 btn-sm"
                                href="{{ route('admin.notifications.clean') }}">{{ __('Remove all') }}</a>
                        </div>
                </div>
            @else
                <div class="text-muted text-center" colspan="100%">
                    <img height="128px" width="128px" src="https://assets.staticimg.com/pro/2.0.4/images/empty.svg"
                        alt="" />
                    <p class="">{{ __('No Unread Notification Found') }}</p>
                </div>
                @endif
            </div>
        </div>
    @endcan
    <!-- Binary Report Card -->
    @can(['binary_practice_log', 'binary_trade_log'])
        @if ($plat->trading->binary_status == 1)
            <div class="row mb-none-30">
                <div class="col-lg-12 col-12">
                    <div class="card card-revenue-budget">
                        <div class="row mx-0">
                            <div class="col-md-8 col-12 revenue-report-wrapper">
                                <div class="d-sm-flex justify-content-between align-items-center mb-3">
                                    <h4 class="card-title mb-50 mb-sm-0">{{ __('Binary Trading') }}</h4>
                                    <div class="d-flex align-items-center">
                                        <div class="d-flex align-items-center me-2">
                                            <span class="bullet bullet-success font-small-3 me-50 cursor-pointer"></span>
                                            <span>{{ __('Wins') }}: {{ $binary_trades_info['wins'] }}$</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="bullet bullet-danger font-small-3 me-50 cursor-pointer"></span>
                                            <span>{{ __('Loses') }}: {{ $binary_trades_info['loses'] }}$</span>
                                        </div>
                                    </div>
                                </div>
                                <div id="binary-report-chart"></div>
                            </div>
                            <div class="col-md-4 col-12 budget-wrapper">
                                <h2 class="mb-25">{{ __('Trades') }}: {{ $binary_trades_info['total_trades'] }} </h2>
                                <div class="fw-bolder me-25">
                                    {{ __('Earning') }}:
                                    <span
                                        class="@if ($binary_trades_info['loses'] - $binary_trades_info['wins'] > 0) text-success 
                                    @elseif($binary_trades_info['loses'] - $binary_trades_info['wins'] < 0) text-danger @else @endif">
                                        {{ $binary_trades_info['loses'] - $binary_trades_info['wins'] }} $</span>
                                </div>
                                <div id="budget-chart"></div>
                                <a href="{{ route('admin.binary.trade.log.list') }}">
                                    <button type="button" class="btn btn-primary">{{ __('View All') }}</button></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endcan

    <div class="row match-height">
        <div class="col-xl-6">
            @can('deposit_log')
                <div class="row">
                    <div class="col-6">
                        <div class="card text-center">
                            <div class="card-body">
                                <div class="avatar bg-light-info p-50 mb-1">
                                    <div class="avatar-content">
                                        <i class="bi bi-wallet2 font-medium-5"></i>
                                    </div>
                                </div>
                                <h2 class="fw-bolder">{{ $payment['total_deposit'] }}</h2>
                                <p class="card-text">{{ __('Deposit') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card text-center">
                            <div class="card-body">
                                <div class="avatar bg-light-warning p-50 mb-1">
                                    <div class="avatar-content">
                                        <i class="bi bi-cash font-medium-5"></i>
                                    </div>
                                </div>
                                <h2 class="fw-bolder">{{ getAmount($payment['total_deposit_amount']) }}
                                    {{ __($general->cur_text) }}</h2>
                                <p class="card-text">{{ __('Deposited Amount') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card text-center">
                            <div class="card-body">
                                <div class="avatar bg-light-danger p-50 mb-1">
                                    <div class="avatar-content">
                                        <i class="bi bi-cash-coin font-medium-5"></i>
                                    </div>
                                </div>
                                <h2 class="fw-bolder">{{ getAmount($payment['total_deposit_charge']) }}
                                    {{ __($general->cur_text) }}</h2>
                                <p class="card-text">{{ __('Deposit Charge') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="card text-center">
                            <div class="card-body">
                                <div class="avatar bg-light-primary p-50 mb-1">
                                    <div class="avatar-content">
                                        <i class="bi bi-cash-stack font-medium-5"></i>
                                    </div>
                                </div>
                                <h2 class="fw-bolder">{{ $payment['total_deposit_pending'] }}</h2>
                                <p class="card-text">{{ __('Pending Deposit') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan
        </div>
        @can(['deposit_log', 'withdraw_log'])
            <div class="col-xl-6">
                <!-- Deposits Line Chart Card -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-25">{{ __('Deposits & Withdraws') }}</h4>
                        </div>
                        <div class="card-body pb-0">
                            <div id="trxs-chart"></div>
                        </div>
                    </div>
                </div>
                <!--/ Deposits Line Chart Card -->
            </div>
        @endcan
    </div>


    @can('withdraw_log')
        <div class="row">

            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-header align-items-start pb-0">
                        <div>
                            <h2 class="fw-bolder mt-1">{{ $paymentWithdraw['total_withdraw'] }} <a
                                    href="{{ route('admin.withdraw.method.index') }}"
                                    class="btn btn-sm text-small bg--white text-red">{{ __('View All') }}</a>
                            </h2>
                            <p class="card-text">{{ __('Withdraw') }}</p>
                        </div>
                        <div class="avatar bg-light-primary p-50 m-0">
                            <div class="avatar-content">
                                <i class="bi bi-wallet font-medium-5"></i>
                            </div>
                        </div>
                    </div>
                    <div id="line-area-chart-9"></div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-header align-items-start pb-0">
                        <div>
                            <h2 class="fw-bolder mt-1">
                                {{ getAmount($paymentWithdraw['total_withdraw_amount']) }}
                                {{ __($general->cur_text) }}
                            </h2>
                            <p class="card-text">{{ __('Withdraw') }}</p>
                        </div>
                        <div class="avatar bg-light-primary p-50 m-0">
                            <div class="avatar-content">
                                <i class="bi bi-coin font-medium-5"></i>
                            </div>
                        </div>
                    </div>
                    <div id="line-area-chart-10"></div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-header align-items-start pb-0">
                        <div>
                            <h2 class="fw-bolder mt-1">{{ getAmount($paymentWithdraw['total_withdraw_charge']) }}
                                {{ __($general->cur_text) }}
                            </h2>
                            <p class="card-text">{{ __('Withdraw Charge') }}</p>
                        </div>
                        <div class="avatar bg-light-primary p-50 m-0">
                            <div class="avatar-content">
                                <i class="bi bi-cash-coin font-medium-5"></i>
                            </div>
                        </div>
                    </div>
                    <div id="line-area-chart-11"></div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-header align-items-start pb-0">
                        <div>
                            <h2 class="fw-bolder mt-1">{{ $paymentWithdraw['total_withdraw_pending'] }} <a
                                    href="{{ route('admin.withdraw.pending') }}"
                                    class="btn btn-sm text-small bg--white text-red">{{ __('View All') }}</a>
                            </h2>
                            <p class="card-text">{{ __('Withdraw Pending') }}</p>
                        </div>
                        <div class="avatar bg-light-primary p-50 m-0">
                            <div class="avatar-content">
                                <i class="bi bi-clock-history font-medium-5"></i>
                            </div>
                        </div>
                    </div>
                    <div id="line-area-chart-12"></div>
                </div>
            </div>
        </div>
    @endcan
@endsection

@push('breadcrumb-plugins')
    @can('update_show')
        @if ($gnl->new_version > $api->get_current_version())
            <a type="button" class="btn btn-warning" href="{{ route('admin.update') }}">{{ __('New Update Released') }}:
                V{{ $gnl->new_version }}</a>
        @endif
        <a type="button" class="btn btn-primary" onclick="check_update()" id="checkUpdate"><i id="checkUpdateIcon"></i>
            {{ __('Check New Update') }}</a>
    @endcan
@endpush

@section('vendor-script')
    {{-- vendor files --}}
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
@endsection

@section('page-script')
    @include('admin.partials.apexcharts')
    <script>
        function check_update() {
            $('#checkUpdate').addClass('disabled');
            $('#checkUpdateIcon').addClass('spinner-border spinner-border-sm');
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                },
                url: "{{ route('admin.update.check') }}",
                method: "get",
                success: function(response) {
                    notify(response.type, response.message)
                    $('#checkUpdate').removeClass('disabled');
                    $('#checkUpdateIcon').removeClass('spinner-border spinner-border-sm');
                    if (response.type == 'success') {
                        location.reload();
                    }
                },
                error: function(response) {
                    notify(response.type, response.message)
                    $('#checkUpdate').removeClass('disabled');
                    $('#checkUpdateIcon').removeClass('spinner-border spinner-border-sm');
                }
            });
        }
    </script>
@endsection
