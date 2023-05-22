@extends('layouts.app')
@section('content')
    <div class="dashboard-section ">
        <div>
            <div class="pb-3">
                <div class="row g-4">
                    @forelse ($withdrawMethod as $data)
                        <div class="col-xl-3 col-lg-4 col-sm-6">
                            <div class="card deposit-card">
                                <div class="card-header">
                                    <h5 class="card-title">{{ __($data->name) }}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="deposit__thumb">
                                        <img style="height: 100px;width: 100%;"
                                            src="{{ getImage(imagePath()['withdraw']['method']['path'] . '/' . $data->image, imagePath()['withdraw']['method']['size']) }}"
                                            alt="{{ __($data->name) }}">
                                    </div>
                                    <ul class="list-group text-center list-group">
                                        <li class="list-group-item">@lang('Limit')
                                            : {{ getAmount($data->min_limit) }}
                                            - {{ getAmount($data->max_limit) }} {{ __($data->currency) }}</li>

                                        <li class="list-group-item"> {{ __('Charge') }}
                                            - {{ getAmount($data->fixed_charge) }} {{ __($data->currency) }}
                                            + {{ getAmount($data->percent_charge) }}%
                                        </li>
                                        <li class="list-group-item"> {{ __('Rate') }}
                                            <span class="text-info">1 {{ __($general->cur_text) }} =
                                                {{ getAmount($data->rate) }} {{ $data->currency }}</span>
                                        </li>
                                        <li class="list-group-item">@lang('Processing Time')
                                            - {{ $data->delay }}
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-footer text-center">
                                    <a href="javascript:void(0)" data-id="{{ $data->id }}"
                                        data-resource="{{ $data }}"
                                        data-min_amount="{{ getAmount($data->min_limit) }}"
                                        data-max_amount="{{ getAmount($data->max_limit) }}"
                                        data-fix_charge="{{ getAmount($data->fixed_charge) }}"
                                        data-percent_charge="{{ getAmount($data->percent_charge) }}"
                                        data-base_symbol="{{ __($data->currency) }}" class="btn mt-2 btn-success deposit"
                                        data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        @lang('Withdraw Now')</a>
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
            </div>
        </div>
    </div>

    @if ($withdrawMethod != null)
        <div class="modal fade custom-modal" id="exampleModal">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title method-name"></h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('user.withdraw.money') }}" method="POST">
                        @csrf
                        <input type="hidden" id="symbol" name="symbol" value="{{ $symbol }}">
                        <input type="hidden" name="currency" class="edit-currency form-control" value="">
                        <input type="hidden" name="method_code" class="edit-method-code  form-control" value="">

                        <div class="modal-body">
                            <p class="text-danger depositLimit"></p>
                            <p class="text-danger depositCharge"></p>

                            <div class="col">
                                <label>@lang('Enter Amount'):</label>
                                <div class="input-group">
                                    <input class="form-control" type="number" id="amount"
                                        onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')" name="amount"
                                        placeholder="0.00" required="" value="{{ old('amount') }}">
                                    <span class="input-group-text">{{ getGen()->cur_text }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary btn-sm text-white btn-danger"
                                data-bs-dismiss="modal">{{ __('Close') }}</button>
                            <button type="submit"
                                class="btn btn-primary btn-sm text-white btn-success">{{ __('Confirm') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
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
                var fixCharge = $(this).data('fix_charge');
                var percentCharge = $(this).data('percent_charge');

                var depositLimit =
                    `@lang('Withdraw Limit'): ${minAmount} - ${maxAmount}  {{ getGen()->cur_text }}`;
                $('.depositLimit').text(depositLimit);
                var depositCharge =
                    `{{ __('Charge') }}: ${fixCharge} {{ getGen()->cur_text }} ${(0 < percentCharge) ? ' + ' + percentCharge + ' %' : ''}`
                $('.depositCharge').text(depositCharge);
                $('.method-name').text(`@lang('Withdraw Via') ${result.name}`);
                $('.edit-currency').val(result.currency);
                $('.edit-method-code').val(result.id);
            });


        });
    </script>
@endpush
