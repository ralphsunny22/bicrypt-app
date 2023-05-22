@extends('layouts.app')
@section('content')
    <div class="row justify-content-start">
        <div class="card col-lg-4 col-md-4">
            <div class="card-body">
                <img class="img-thumbnail mb-1" src="{{ $data->gateway_currency()->methodImage() }}"
                    alt="{{ __('Payment Image') }}">
                <div class="deposit-content">
                    <ul>
                        <li>
                            {{ __('Amount') }}: <span class="text-success">{{ ttz($data->amount) }}
                                {{ __($general->cur_text) }}</span>
                        </li>
                        <li>
                            {{ __('Charge') }}: <span class="text-danger">{{ ttz($data->charge) }}
                                {{ __($general->cur_text) }}</span>
                        </li>
                        @if (getPlatform('wallet')->deposit_fees_method == 'added')
                            <li>
                                {{ __('Payable') }}: <span class="text-warning">{{ ttz($data->amount + $data->charge) }}
                                    {{ __($general->cur_text) }}</span>
                            </li>
                        @else
                            <li>
                                {{ __('Payable') }}: <span class="text-warning">{{ ttz($data->amount) }}
                                    {{ __($general->cur_text) }}</span>
                            </li>
                        @endif
                        <li>
                            {{ __('Conversion Rate') }}: <span class="text-info">1 {{ __($general->cur_text) }} =
                                {{ ttz($data->rate) }} {{ __($data->baseCurrency()) }}</span>
                        </li>
                        <li>
                            {{ __('In') }} {{ $data->baseCurrency() }}: <span
                                class="text-primary">{{ ttz($data->final_amo) }}</span>
                        </li>
                        @if ($plat->wallet_address == 1)
                            <li>
                                {{ __('To Wallet') }}: <span class="text-primary">{{ $address }}</span>
                            </li>
                        @endif
                        @if ($data->gateway->crypto == 1)
                            <li>
                                {{ __('Conversion with') }}
                                <b> {{ __($data->method_currency) }}</b>
                                {{ __('and final value will Show on next step') }}
                            </li>
                        @endif
                    </ul>
                    @if (1000 > $data->method_code)
                        <a href="{{ route('user.deposit.confirm') }}" class="btn btn-primary">{{ __('Pay Now') }}</a>
                    @else
                        <a href="{{ route('user.deposit.manual.confirm') }}"
                            class="btn btn-primary">{{ __('Pay Now') }}</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
