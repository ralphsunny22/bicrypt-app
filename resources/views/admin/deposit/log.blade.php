@extends('layouts.app')
@section('vendor-style')
    {{-- vendor css files --}}
    <!-- datepicker css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.css">
@endsection
@section('content')
    <div class="row" id="table-hover-row">
        @if (request()->routeIs('admin.deposit.list') ||
            request()->routeIs('admin.deposit.method') ||
            request()->routeIs('admin.users.deposits') ||
            request()->routeIs('admin.deposit.dateSearch') ||
            request()->routeIs('admin.users.deposits.method'))
            <div class="col-md-4 col-sm-6 mb-30">
                <div class="widget-two shadow rounded px-2 py-1 mb-1 bg-success">
                    <div class="widget-two__content">
                        <h2 class="text-white">{{ __($general->cur_sym) }}{{ $deposits->where('status', 1)->sum('amount') }}
                        </h2>
                        <p class="text-white">{{ __('Successful Deposit') }}</p>
                    </div>
                </div><!-- widget-two end -->
            </div>
            <div class="col-md-4 col-sm-6 mb-30">
                <div class="widget-two shadow rounded px-2 py-1 mb-1 bg-6">
                    <div class="widget-two__content">
                        <h2 class="text-white">{{ __($general->cur_sym) }}{{ $deposits->where('status', 2)->sum('amount') }}
                        </h2>
                        <p class="text-white">{{ __('Pending Deposit') }}</p>
                    </div>
                </div><!-- widget-two end -->
            </div>
            <div class="col-md-4 col-sm-6 mb-30">
                <div class="widget-two shadow rounded px-2 py-1 mb-1 bg-pink">
                    <div class="widget-two__content">
                        <h2 class="text-white">{{ __($general->cur_sym) }}{{ $deposits->where('status', 3)->sum('amount') }}
                        </h2>
                        <p class="text-white">{{ __('Rejected Deposit') }}</p>
                    </div>
                </div><!-- widget-two end -->
            </div>
        @endif

        {{-- <livewire:funding-deposit-log-table /> --}}
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">{{ __('Deposits Log') }}</h4>
                    <div class="card-search"></div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">{{ __('Date') }}</th>
                                <th scope="col">{{ __('Trx Number') }}</th>
                                @if (!request()->routeIs('admin.users.deposits') && !request()->routeIs('admin.users.deposits.method'))
                                    <th scope="col">{{ __('Username') }}</th>
                                @endif
                                <th scope="col">{{ __('Method') }}</th>
                                <th scope="col">{{ __('Amount') }}</th>
                                <th scope="col">{{ __('Charge') }}</th>
                                <th scope="col">{{ __('After Charge') }}</th>
                                <th scope="col">{{ __('Rate') }}</th>
                                <th scope="col">{{ __('Payable') }}</th>
                                @if (request()->routeIs('admin.deposit.pending') || request()->routeIs('admin.deposit.approved'))
                                    <th scope="col">{{ __('Action') }}</th>
                                @elseif(request()->routeIs('admin.deposit.list') ||
                                    request()->routeIs('admin.deposit.search') ||
                                    request()->routeIs('admin.users.deposits') ||
                                    request()->routeIs('admin.deposit.method') ||
                                    request()->routeIs('admin.deposit.dateSearch') ||
                                    request()->routeIs('admin.users.deposits.method'))
                                    <th scope="col">{{ __('Status') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($deposits as $deposit)
                                @php
                                    $details = $deposit->detail != null ? json_encode($deposit->detail) : null;
                                @endphp
                                <tr>
                                    <td data-label="{{ __('Date') }}"> {{ showDateTime($deposit->created_at) }}</td>
                                    <td data-label="{{ __('Trx Number') }}" class="fw-bold text-uppercase">
                                        {{ $deposit->trx }}</td>
                                    @if (!request()->routeIs('admin.users.deposits') && !request()->routeIs('admin.users.deposits.method'))
                                        <td data-label="{{ __('Username') }}"><a
                                                href="{{ route('admin.users.detail', $deposit->user_id) }}">{{ $deposit->user->username }}</a>
                                        </td>
                                    @endif
                                    <td data-label="{{ __('Method') }}">
                                        @if (request()->routeIs('admin.users.deposits') || request()->routeIs('admin.users.deposits.method'))
                                            <a
                                                href="{{ route('admin.users.deposits.method', [$deposit->gateway->alias, @$type ? $type : 'all', $userId]) }}">{{ __($deposit->gateway->name) }}</a>
                                        @else
                                            <a
                                                href="{{ route('admin.deposit.method', [$deposit->gateway->alias, @$type ? $type : 'all']) }}">{{ __($deposit->gateway->name) }}</a>
                                        @endif

                                    </td>
                                    <td data-label="{{ __('Amount') }}" class="fw-bold">
                                        {{ getAmount($deposit->amount) }} {{ __($general->cur_text) }}</td>
                                    <td data-label="{{ __('Charge') }}" class="text-success">
                                        {{ getAmount($deposit->charge) }} {{ __($general->cur_text) }}</td>
                                    <td data-label="{{ __('After Charge') }}">
                                        @if (getPlatform('wallet')->deposit_fees_method == 'subtracted')
                                            {{ getAmount($deposit->amount - $deposit->charge) }}
                                        @else
                                            {{ getAmount($deposit->amount + $deposit->charge) }}
                                        @endif {{ __($general->cur_text) }}
                                    </td>
                                    <td data-label="{{ __('Rate') }}"> {{ getAmount($deposit->rate) }}
                                        {{ __($deposit->method_currency) }}</td>
                                    <td data-label="{{ __('Payable') }}" class="fw-bold">
                                        {{ getAmount($deposit->final_amo) }} {{ __($deposit->method_currency) }}
                                    </td>

                                    @if (request()->routeIs('admin.deposit.approved') || request()->routeIs('admin.deposit.pending'))
                                        <td data-label="{{ __('Action') }}">
                                            <a href="{{ route('admin.deposit.details', $deposit->id) }}"
                                                class="btn-icon ms-1 " data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="{{ __('Detail') }}">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    @elseif(request()->routeIs('admin.deposit.list') ||
                                        request()->routeIs('admin.deposit.search') ||
                                        request()->routeIs('admin.users.deposits') ||
                                        request()->routeIs('admin.deposit.method') ||
                                        request()->routeIs('admin.deposit.dateSearch') ||
                                        request()->routeIs('admin.users.deposits.method'))
                                        <td data-label="{{ __('Status') }}">
                                            @if ($deposit->status == 2)
                                                <span class="badge bg-warning">{{ __('Pending') }}</span>
                                            @elseif($deposit->status == 1)
                                                <span class="badge bg-success">{{ __('Approved') }}</span>
                                            @elseif($deposit->status == 3)
                                                <span class="badge bg-danger">{{ __('Rejected') }}</span>
                                            @endif
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($empty_message) }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table><!-- table end -->
                </div>
            </div><!-- card end -->
            <div class="mb-1">{{ paginateLinks($deposits) }}</div>

        </div>
    </div>


@endsection
@section('vendor-script')
    {{-- vendor files --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/i18n/datepicker.en-US.min.js"></script>
@endsection

@push('breadcrumb-plugins')
    @if (!request()->routeIs('admin.users.deposits') && !request()->routeIs('admin.users.deposits.method'))
        <div class="row">
            <div class="col"></div>
            <div class="col">
                <form
                    action="{{ route('admin.deposit.dateSearch',$scope ??str_replace('admin.deposit.','',request()->route()->getName())) }}"
                    method="GET" class="bg-white">
                    <div class="input-group">
                        <input name="date" type="text" data-range="true" data-multiple-dates-separator=" - "
                            data-language="en" class="datepicker-here form-control" data-position='bottom right'
                            placeholder="{{ __('Min Date - Max date') }}" autocomplete="off" value="{{ @$dateSearch }}">
                        <input type="hidden" name="method" value="{{ @$methodAlias }}">
                        <button class="btn btn-outline-primary" type="submit"><i class="bi bi-search"></i></button>
                    </div>
            </div>
            </form>
        </div>
        </div>
    @endif
@endpush


@push('script')
    <script>
        "use strict";
        // date picker
        $('.datepicker-here').datepicker();
        $('.datepicker-here').val(new Date()) selectDate(new Date($('.datepicker-here').val()));
    </script>
@endpush
