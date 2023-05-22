@extends('layouts.app')
@section('content')
    <div class="row mb-none-30">
        <div class="col-lg-12 col-md-12 mb-30">
            <form action="" method="POST" enctype="multipart/form-data" id="generalSettings">
                @csrf
                <input type="hidden" name="update_server" id="update_server">
                <input type="hidden" name="NETWORK" id="NETWORK" value="{{ getenv('NETWORK') }}">
                <div class="card">
                    <h4 class="card-header">{{ __('Settings') }}</h4>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="col ">
                                    <label class="form-control-label h6"> {{ __('Site Title') }} </label>
                                    <input class="form-control" type="text" name="sitename"
                                        value="{{ $general->sitename }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="col ">
                                    <label class="form-control-label h6">{{ __('TinyMCE API') }} </label>
                                    <input class="form-control" type="text" name="tinymce"
                                        value="{{ $general->tinymce }}">
                                    <small>{{ __('You can create api key from ') }} <a
                                            href="https://www.tiny.cloud/my-account/dashboard/">Tiny Cloud</a></small>
                                </div>
                            </div>

                            <div class="col-md-3 mb-1">
                                <div class="col ">
                                    <label class="form-control-label h6">{{ __('User Default Language') }}</label>
                                    <select class="form-select" id="VUE_APP_I18N_LOCALE" name="VUE_APP_I18N_LOCALE">
                                        <option value="" @if (getenv('VUE_APP_I18N_LOCALE') == null || getenv('VUE_APP_I18N_LOCALE') == '') selected @endif
                                            disabled="">
                                            {{ __('Choose an option') }}
                                        </option>
                                        <option value="ar" @if (getenv('VUE_APP_I18N_LOCALE') == 'ar') selected @endif>
                                            Arabic
                                        </option>
                                        <option value="bn" @if (getenv('VUE_APP_I18N_LOCALE') == 'bn') selected @endif>
                                            Bengali
                                        </option>
                                        <option value="de" @if (getenv('VUE_APP_I18N_LOCALE') == 'de') selected @endif>
                                            German
                                        </option>
                                        <option value="en" @if (getenv('VUE_APP_I18N_LOCALE') == 'en') selected @endif>
                                            English
                                        </option>
                                        <option value="es" @if (getenv('VUE_APP_I18N_LOCALE') == 'es') selected @endif>
                                            Spanish
                                        </option>
                                        <option value="fa" @if (getenv('VUE_APP_I18N_LOCALE') == 'fa') selected @endif>
                                            Farsi
                                        </option>
                                        <option value="fr" @if (getenv('VUE_APP_I18N_LOCALE') == 'fr') selected @endif>
                                            French
                                        </option>
                                        <option value="id" @if (getenv('VUE_APP_I18N_LOCALE') == 'id') selected @endif>
                                            Indonesian
                                        </option>
                                        <option value="it" @if (getenv('VUE_APP_I18N_LOCALE') == 'it') selected @endif>
                                            Italian
                                        </option>
                                        <option value="ja" @if (getenv('VUE_APP_I18N_LOCALE') == 'ja') selected @endif>
                                            Japanese
                                        </option>
                                        <option value="ko" @if (getenv('VUE_APP_I18N_LOCALE') == 'ko') selected @endif>
                                            Korean
                                        </option>
                                        <option value="nb" @if (getenv('VUE_APP_I18N_LOCALE') == 'nb') selected @endif>
                                            Norwegian
                                        </option>
                                        <option value="nl" @if (getenv('VUE_APP_I18N_LOCALE') == 'nl') selected @endif>
                                            Netherlands
                                        </option>
                                        <option value="pt" @if (getenv('VUE_APP_I18N_LOCALE') == 'pt') selected @endif>
                                            Portuguese
                                        </option>
                                        <option value="ru" @if (getenv('VUE_APP_I18N_LOCALE') == 'ru') selected @endif>
                                            Russain
                                        </option>
                                        <option value="th" @if (getenv('VUE_APP_I18N_LOCALE') == 'th') selected @endif>
                                            Thai
                                        </option>
                                        <option value="tr" @if (getenv('VUE_APP_I18N_LOCALE') == 'tr') selected @endif>
                                            Turkish
                                        </option>
                                        <option value="vi" @if (getenv('VUE_APP_I18N_LOCALE') == 'vi') selected @endif>
                                            Vietnamese
                                        </option>
                                        <option value="zh" @if (getenv('VUE_APP_I18N_LOCALE') == 'zh') selected @endif>
                                            Chinese
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 mb-1">
                                <div class="col ">
                                    <label class="form-control-label h6">{{ __('User Fallback Language') }}</label>
                                    <select class="form-select" id="VUE_APP_I18N_FALLBACK_LOCALE"
                                        name="VUE_APP_I18N_FALLBACK_LOCALE">
                                        <option value="" @if (getenv('VUE_APP_I18N_FALLBACK_LOCALE') == null || getenv('VUE_APP_I18N_FALLBACK_LOCALE') == '') selected @endif
                                            disabled="">
                                            {{ __('Choose an option') }}
                                        </option>
                                        <option value="ar" @if (getenv('VUE_APP_I18N_FALLBACK_LOCALE') == 'ar') selected @endif>
                                            Arabic
                                        </option>
                                        <option value="bn" @if (getenv('VUE_APP_I18N_FALLBACK_LOCALE') == 'bn') selected @endif>
                                            Bengali
                                        </option>
                                        <option value="de" @if (getenv('VUE_APP_I18N_FALLBACK_LOCALE') == 'de') selected @endif>
                                            German
                                        </option>
                                        <option value="en" @if (getenv('VUE_APP_I18N_FALLBACK_LOCALE') == 'en') selected @endif>
                                            English
                                        </option>
                                        <option value="es" @if (getenv('VUE_APP_I18N_FALLBACK_LOCALE') == 'es') selected @endif>
                                            Spanish
                                        </option>
                                        <option value="fa" @if (getenv('VUE_APP_I18N_FALLBACK_LOCALE') == 'fa') selected @endif>
                                            Farsi
                                        </option>
                                        <option value="fr" @if (getenv('VUE_APP_I18N_FALLBACK_LOCALE') == 'fr') selected @endif>
                                            French
                                        </option>
                                        <option value="id" @if (getenv('VUE_APP_I18N_FALLBACK_LOCALE') == 'id') selected @endif>
                                            Indonesian
                                        </option>
                                        <option value="it" @if (getenv('VUE_APP_I18N_FALLBACK_LOCALE') == 'it') selected @endif>
                                            Italian
                                        </option>
                                        <option value="ja" @if (getenv('VUE_APP_I18N_FALLBACK_LOCALE') == 'ja') selected @endif>
                                            Japanese
                                        </option>
                                        <option value="ko" @if (getenv('VUE_APP_I18N_FALLBACK_LOCALE') == 'ko') selected @endif>
                                            Korean
                                        </option>
                                        <option value="nb" @if (getenv('VUE_APP_I18N_FALLBACK_LOCALE') == 'nb') selected @endif>
                                            Norwegian
                                        </option>
                                        <option value="nl" @if (getenv('VUE_APP_I18N_FALLBACK_LOCALE') == 'nl') selected @endif>
                                            Netherlands
                                        </option>
                                        <option value="pt" @if (getenv('VUE_APP_I18N_FALLBACK_LOCALE') == 'pt') selected @endif>
                                            Portuguese
                                        </option>
                                        <option value="ru" @if (getenv('VUE_APP_I18N_FALLBACK_LOCALE') == 'ru') selected @endif>
                                            Russain
                                        </option>
                                        <option value="th" @if (getenv('VUE_APP_I18N_FALLBACK_LOCALE') == 'th') selected @endif>
                                            Thai
                                        </option>
                                        <option value="tr" @if (getenv('VUE_APP_I18N_FALLBACK_LOCALE') == 'tr') selected @endif>
                                            Turkish
                                        </option>
                                        <option value="vi" @if (getenv('VUE_APP_I18N_FALLBACK_LOCALE') == 'vi') selected @endif>
                                            Vietnamese
                                        </option>
                                        <option value="zh" @if (getenv('VUE_APP_I18N_FALLBACK_LOCALE') == 'zh') selected @endif>
                                            Chinese
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="col ">
                                    <label class="form-control-label h6">{{ __('Cors Link') }} </label>
                                    <input class="form-control" type="text" name="cors" value="{{ $general->cors }}">
                                    <small>{{ __('Follow cors guide on our documentation') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if ($general->staging != 1 && getExt(10)->status == 1)
                    <div class="card">
                        <h4 class="card-header">{{ __('Native Trading') }}</h4>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 mb-1">
                                    <div class="col ">
                                        <label class="form-control-label h6">{{ __('TATUM API URL') }}</label>
                                        <input class="form-control" type="text" name="TATUM_API_URL"
                                            value="{{ getenv('TATUM_API_URL') }}">
                                    </div>
                                </div>

                                <div class="col-md-3 mb-1">
                                    <div class="col ">
                                        <label class="form-control-label h6">{{ __('TATUM API KEY') }}</label>
                                        <input class="form-control" type="text" name="TATUM_API_KEY"
                                            value="{{ getenv('TATUM_API_KEY') }}">
                                    </div>
                                </div>

                                <div class="col-md-3 mb-1">
                                    <div class="col ">
                                        <label class="form-control-label h6">{{ __('TATUM TESTNET API KEY') }} </label>
                                        <input class="form-control" type="text" name="TATUM_TESTNET_API_KEY"
                                            value="{{ getenv('TATUM_TESTNET_API_KEY') }}">
                                    </div>
                                </div>

                                <div class="col-md-3 mb-1">
                                    <div class="col ">
                                        <label class="form-control-label h6">{{ __('NETWORK') }} </label>
                                        <div class="dropdown">
                                            <button class="btn btn-outline-warning dropdown-toggle w-100" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false" id="NETWORK_text"
                                                name="NETWORK_text">
                                                {{ getenv('NETWORK') }}
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item"
                                                        onclick="$('#NETWORK_text').text($(this).text());$('#generalSettings').find('input[name=NETWORK]').val($(this).data('type'));"
                                                        data-type="testnet">{{ __('testnet') }}</a></li>
                                                <li><a class="dropdown-item"
                                                        onclick="$('#NETWORK_text').text($(this).text());$('#generalSettings').find('input[name=NETWORK]').val($(this).data('type'));"
                                                        data-type="mainnet">{{ __('mainnet') }}</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 mb-1">
                                    <div class="col ">
                                        <label class="form-control-label h6">{{ __('TESTNET_TYPE') }} </label>
                                        <input class="form-control" type="text" name="TESTNET_TYPE" id="TESTNET_TYPE"
                                            value="{{ getenv('TESTNET_TYPE') ?? 'ethereum-sepolia' }}">
                                    </div>
                                </div>

                                <div class="col-md-3 mb-1">
                                    <div class="col ">
                                        <label class="form-control-label h6">{{ __('TATUM_RETRIES') }} </label>
                                        <input class="form-control" type="text" name="TATUM_RETRIES"
                                            id="TATUM_RETRIES" value="{{ getenv('TATUM_RETRIES') ?? '5' }}">
                                    </div>
                                </div>

                                <div class="col-md-3 mb-1">
                                    <div class="col ">
                                        <label class="form-control-label h6">{{ __('TATUM_RETRY_DELAY') }} </label>
                                        <input class="form-control" type="text" name="TATUM_RETRY_DELAY"
                                            id="TATUM_RETRY_DELAY" value="{{ getenv('TATUM_RETRY_DELAY') ?? '1000' }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if ($general->staging != 1 && getExt(12)->status == 1)
                    <div class="card">
                        <h4 class="card-header">{{ __('PUSHER') }}</h4>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 mb-1">
                                    <div class="col ">
                                        <label class="form-control-label h6">{{ __('PUSHER APP ID') }}</label>
                                        <input class="form-control" type="text" name="PUSHER_APP_ID"
                                            value="{{ getenv('PUSHER_APP_ID') }}">
                                    </div>
                                    <small>{{ __('Create an app in') }} <a href="https://dashboard.pusher.com/apps"
                                            target="__blank">{{ __('Pusher') }}</a></small>
                                </div>

                                <div class="col-md-3 mb-1">
                                    <div class="col ">
                                        <label class="form-control-label h6">{{ __('PUSHER APP KEY') }}</label>
                                        <input class="form-control" type="text" name="PUSHER_APP_KEY"
                                            value="{{ getenv('PUSHER_APP_KEY') }}">
                                    </div>
                                </div>

                                <div class="col-md-3 mb-1">
                                    <div class="col ">
                                        <label class="form-control-label h6">{{ __('PUSHER APP SECRET') }}</label>
                                        <input class="form-control" type="text" name="PUSHER_APP_SECRET"
                                            value="{{ getenv('PUSHER_APP_SECRET') }}">
                                    </div>
                                </div>

                                <div class="col-md-3 mb-1">
                                    <div class="col ">
                                        <label class="form-control-label h6">{{ __('PUSHER APP CLUSTER') }} </label>
                                        <select class="form-select" id="PUSHER_APP_CLUSTER" name="PUSHER_APP_CLUSTER">
                                            <option value="" @if (getenv('PUSHER_APP_CLUSTER') == '') selected @endif
                                                disabled="">
                                                {{ __('Choose an option') }}
                                            </option>
                                            <option value="mt1" @if (getenv('PUSHER_APP_CLUSTER') == 'mt1') selected @endif>
                                                mt1 (US East (N. Virginia))
                                            </option>
                                            <option value="ap1" @if (getenv('PUSHER_APP_CLUSTER') == 'ap1') selected @endif>
                                                ap1 (Asia Pacific (Singapore))
                                            </option>
                                            <option value="ap2" @if (getenv('PUSHER_APP_CLUSTER') == 'ap2') selected @endif>
                                                ap2 (Asia Pacific (Mumbai))
                                            </option>
                                            <option value="us2" @if (getenv('PUSHER_APP_CLUSTER') == 'us2') selected @endif>
                                                us2 (US East (Ohio))
                                            </option>
                                            <option value="ap3" @if (getenv('PUSHER_APP_CLUSTER') == 'ap3') selected @endif>
                                                ap3 (Asia Pacific (Tokyo))
                                            </option>
                                            <option value="us3" @if (getenv('PUSHER_APP_CLUSTER') == 'us3') selected @endif>
                                                us3 (US West (Oregon))
                                            </option>
                                            <option value="ap4" @if (getenv('PUSHER_APP_CLUSTER') == 'ap4') selected @endif>
                                                ap4 (Asia Pacific (Sydney))
                                            </option>
                                            <option value="eu" @if (getenv('PUSHER_APP_CLUSTER') == 'eu') selected @endif>
                                                eu (EU (Ireland))
                                            </option>
                                            <option value="sa1" @if (getenv('PUSHER_APP_CLUSTER') == 'sa1') selected @endif>
                                                sa1 (South America (São Paulo))
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="card">
                    <h4 class="card-header">{{ __('Rates Settings') }}</h4>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="col ">
                                    <label class="form-control-label h6">{{ __('Currency') }}</label>
                                    <input class="form-control" type="text" name="cur_text"
                                        value="{{ $general->cur_text }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="col ">
                                    <label class="form-control-label h6">{{ __('Currency Symbol') }} </label>
                                    <input class="form-control" type="text" name="cur_sym"
                                        value="{{ $general->cur_sym }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-control-label h6">{{ __('Practice Balance') }}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="practice_balance"
                                        placeholder="{{ __('Enter Amount') }}"
                                        value="{{ getAmount($general->practice_balance) }}"
                                        aria-describedby="basic-addon2">
                                    <span class="input-group-text"
                                        id="basic-addon2">{{ $general->practice_wallet }}</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="col ">
                                    <label class="form-control-label h6">{{ __('Practice Wallet') }} </label>
                                    <input class="form-control" type="text" name="practice_wallet"
                                        value="{{ $general->practice_wallet }}">
                                </div>
                            </div>
                            <div class="col-md-3 mt-1">
                                <label class="form-control-label h6">{{ __('Trade Profit') }}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="profit"
                                        placeholder="{{ __('Enter Amount') }}" value="{{ getAmount($general->profit) }}"
                                        aria-describedby="basic-addon2">
                                    <span class="input-group-text" id="basic-addon2">%</span>
                                </div>
                            </div>
                            <div class="col-md-3 mt-1">
                                <label class="form-control-label h6">{{ __('Exchange Fee') }}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="exchange_fee"
                                        placeholder="{{ __('Enter Percentage') }}"
                                        value="{{ getAmount($general->exchange_fee) }}" aria-describedby="basic-addon2">
                                    <span class="input-group-text" id="basic-addon2">%</span>
                                </div>
                            </div>
                            <div class="col-md-3 mt-1">
                                <label class="form-control-label h6">{{ __('Transaction Fee') }}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="trx_fee"
                                        placeholder="{{ __('Enter Percentage') }}"
                                        value="{{ getAmount($general->trx_fee) }}" aria-describedby="basic-addon2">
                                    <span class="input-group-text" id="basic-addon2">%</span>
                                </div>
                            </div>
                            <div class="col-md-3 mt-1">
                                <label class="form-control-label h6">{{ __('Thirdparty Withdraw Fees') }}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="provider_withdraw_fee"
                                        placeholder="{{ __('Enter Amount') }}"
                                        value="{{ getAmount($general->provider_withdraw_fee) }}"
                                        aria-describedby="basic-addon2">
                                    <span class="input-group-text" id="basic-addon2">%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <h4 class="card-header">{{ __('Trade Limits Settings') }}</h4>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 mt-1">
                                <div class="col ">
                                    <label class="form-control-label h6">{{ __('Trades Minimum Amount') }}
                                    </label>
                                    <input class="form-control" type="number" name="min_amount" step="0.00000001"
                                        value="{{ $limits->min_amount ?? 0 }}">
                                </div>
                            </div>
                            <div class="col-md-3 mt-1">
                                <div class="col ">
                                    <label class="form-control-label h6">{{ __('Trades Maximum Amount') }}
                                    </label>
                                    <input class="form-control" type="number" name="max_amount"
                                        value="{{ $limits->max_amount ?? 0 }}">
                                </div>
                            </div>
                            <div class="col-md-3 mt-1">
                                <div class="col ">
                                    <label class="form-control-label h6">{{ __('Trades Minimum Seconds') }}
                                    </label>
                                    <input class="form-control" type="number" name="min_time_sec"
                                        value="{{ $limits->min_time_sec ?? 0 }}">
                                </div>
                            </div>
                            <div class="col-md-3 mt-1">
                                <div class="col ">
                                    <label class="form-control-label h6">{{ __('Trades Maximum Seconds') }}
                                    </label>
                                    <input class="form-control" type="number" name="max_time_sec"
                                        value="{{ $limits->max_time_sec ?? 0 }}">
                                </div>
                            </div>
                            <div class="col-md-3 mt-1">
                                <div class="col ">
                                    <label class="form-control-label h6">{{ __('Trades Minimum Minutes') }}
                                    </label>
                                    <input class="form-control" type="number" name="min_time_min"
                                        value="{{ $limits->min_time_min ?? 0 }}">
                                </div>
                            </div>
                            <div class="col-md-3 mt-1">
                                <div class="col ">
                                    <label class="form-control-label h6">{{ __('Trades Maximum Minutes') }}
                                    </label>
                                    <input class="form-control" type="number" name="max_time_min"
                                        value="{{ $limits->max_time_min ?? 0 }}">
                                </div>
                            </div>
                            <div class="col-md-3 mt-1">
                                <div class="col ">
                                    <label class="form-control-label h6">{{ __('Trades Minimum Hours') }}
                                    </label>
                                    <input class="form-control" type="number" name="min_time_hour"
                                        value="{{ $limits->min_time_hour ?? 0 }}">
                                </div>
                            </div>
                            <div class="col-md-3 mt-1">
                                <div class="col ">
                                    <label class="form-control-label h6">{{ __('Trades Maximum Hours') }}
                                    </label>
                                    <input class="form-control" type="number" name="max_time_hour"
                                        value="{{ $limits->max_time_hour ?? 0 }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <h4 class="card-header">{{ __('Extra Settings') }}</h4>
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-start">

                            <div class="border-primary rounded p-1 ms-1">
                                <div class="d-flex align-items-center justify-content-between">
                                    <label class="me-1" for="registration">{{ __('User Registration') }}</label>
                                    <input class="form-check-input" type="checkbox" data-bs-toggle="toggle"
                                        data-onstyle="success" data-offstyle="danger" data-on="{{ __('Enable') }}"
                                        data-off="{{ __('Disabled') }}" name="registration"
                                        @if ($general->registration) checked @endif>
                                </div>
                            </div>
                            <div class="border-primary rounded p-1 ms-1">
                                <div class="d-flex align-items-center justify-content-between">
                                    <label class="me-1" for="force_ssl">{{ __('Force SSL') }}</label>
                                    <input class="form-check-input" type="checkbox" data-bs-toggle="toggle"
                                        data-onstyle="success" data-offstyle="danger" data-on="{{ __('Enable') }}"
                                        data-off="{{ __('Disabled') }}" name="force_ssl"
                                        @if ($general->force_ssl) checked @endif>
                                </div>
                            </div>
                            <div class="border-primary rounded p-1 ms-1">
                                <div class="d-flex align-items-center justify-content-between">
                                    <label class="me-1" for="APP_DEBUG">{{ __('App Debug') }}</label>
                                    <input class="form-check-input" type="checkbox" data-bs-toggle="toggle"
                                        data-onstyle="success" data-offstyle="danger" data-on="{{ __('Enable') }}"
                                        data-off="{{ __('Disabled') }}" name="APP_DEBUG"
                                        @if (getenv('APP_DEBUG') == 'true') checked @endif>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <div class="col">
                            <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                        </div>
                    </div>
            </form>
        </div>
    </div>
@endsection
