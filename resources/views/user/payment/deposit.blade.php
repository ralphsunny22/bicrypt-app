@extends('layouts.app')
@section('content')
    <div class="row g-2">
        @forelse ($gatewayCurrency as $data)
            <div class="col-xl-3 col-lg-4 col-sm-6">
                <div class="card custom-card deposit-card">
                    <div class="card-header">
                        <h5 class="card-title">{{ __($data->name) }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="deposit__thumb">
                            <img class="img-thumbnail" src="{{ $data->methodImage() }}" alt="{{ __($data->name) }}">
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="javascript:void(0)" data-id="{{ $data->id }}" data-resource="{{ $data }}"
                            data-min_amount="{{ ttz($data->min_amount) }}" data-max_amount="{{ ttz($data->max_amount) }}"
                            data-base_symbol="{{ $data->baseSymbol() }}" data-currency="{{ $data->currency }}"
                            data-fix_charge="{{ ttz($data->fixed_charge) }}" data-rate="{{ ttz($data->rate) }}"
                            data-percent_charge="{{ ttz($data->percent_charge) }}"
                            class="btn-sm d-block btn btn-primary text-center deposit" data-bs-toggle="modal"
                            data-bs-target="#deposit-modal">
                            {{ __('Deposit Now') }}</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-xl-3 col-lg-4 col-sm-6">
                <div class="card deposit-card">
                    <div class="card-body">
                        No Method Available Yet
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Deposit Modal -->
    <div id="deposit-modal" class="modal fade" tabindex="-1" aria-hidden="true" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Enter Deposit Amount')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="deposite-form" action="{{ route('user.deposit.insert') }}" method="POST">
                    @csrf
                    <input type="hidden" id="symbol" name="symbol" value="{{ $track->symbol }}">
                    <input type="hidden" name="currency" class="edit-currency" value="">
                    <input type="hidden" name="method_code" class="edit-method-code" value="">
                    <div class="modal-body">
                        <ul>
                            <li>
                                <span>{{ __('Deposit Limit') }}</span> <span class="text-success depositLimit"></span>
                            </li>
                            <li>
                                <span>{{ __('Charge') }}</span> <span class="text-danger depositCharge"></span>
                            </li>
                            <li>
                                <span>{{ __('Rate') }}</span> <span class="text-info">1
                                    {{ __($general->cur_text) }} = <span class="rate"></span></span>
                            </li>
                        </ul>
                        <label class="form-control-label h6">{{ __('Enter Amount') }} </label>
                        <div class="input-group">
                            <input class="form-control" type="number" id="amount"
                                onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')" name="amount"
                                placeholder="0.00" required="" value="{{ old('amount') }}">
                            <span class="input-group-text">{{ __($general->cur_text) }}</span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-sm text-white btn-danger"
                            data-bs-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit"
                            class="btn btn-primary btn-sm text-white btn-success">{{ __('Submit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        "use strict";
        $(document).ready(function() {
            $('.deposit').on('click', function() {
                var id = $(this).data('id');
                var result = $(this).data('resource');
                var minAmount = $(this).data('min_amount');
                var maxAmount = $(this).data('max_amount');
                var baseSymbol = "{{ __($general->cur_text) }}";
                var fixCharge = $(this).data('fix_charge');
                var rate = $(this).data('rate');
                var currency = $(this).data('currency');
                var percentCharge = $(this).data('percent_charge');

                var depositLimit = `${minAmount} - ${maxAmount}  ${baseSymbol}`;
                $('.depositLimit').text(depositLimit);
                var depositCharge =
                    `${fixCharge} ${baseSymbol}  ${(0 < percentCharge) ? ' + ' +percentCharge + ' % ' : ''}`;
                $('.depositCharge').text(depositCharge);
                $('.rate').text(rate + ' ' + currency);
                $('.method-name').text(`{{ __('Payment By ') }} ${result.name}`);
                $('.currency-addon').text(baseSymbol);
                $('.edit-currency').val(result.currency);
                $('.edit-method-code').val(result.method_code);
            });
        });
    </script>
@endpush
