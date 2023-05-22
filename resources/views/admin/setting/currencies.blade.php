@extends('layouts.app')

@section('content')
    <div class="row" id="table-hover-row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">{{ __('Ranks') }}</h4>
                    <div class="card-search"></div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover custom-data-bs-table">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">{{ __('Name') }}</th>
                                <th scope="col">{{ __('Code') }}</th>
                                <th scope="col">{{ __('Symbol') }}</th>
                                <th scope="col">{{ __('Rate') }}</th>
                                <th scope="col">{{ __('Status') }}</th>
                                <th scope="col">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($currencies as $currency)
                                <tr>
                                    <td data-label="{{ __('Name') }}">{{ $currency->name }}</td>
                                    <td data-label="{{ __('Code') }}">{{ $currency->code }}</td>
                                    <td data-label="{{ __('Symbol') }}">{{ $currency->symbol }}</td>
                                    <td data-label="{{ __('Rate') }}">{{ $currency->rate }}</td>
                                    <td data-label="{{ __('Status') }}">
                                        @if ($currency->status == 1)
                                            <span class="badge bg-success">{{ __('Active') }}</span>
                                        @else
                                            <span class="badge bg-warning">{{ __('Disabled') }}</span>
                                        @endif
                                    </td>
                                    <td data-label="{{ __('Action') }}">
                                        <button type="button" class="btn btn-icon btn-warning btn-sm updateBtn"
                                            data-bs-toggle="modal" data-bs-target="#updateModal"
                                            data-id="{{ $currency->id }}" data-name="{{ __($currency->name) }}"
                                            title="{{ __('Edit') }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        @if ($currency->status == 0)
                                            <button type="button" class="btn btn-icon btn-success btn-sm activateBtn"
                                                data-bs-toggle="modal" data-bs-target="#activateModal"
                                                data-id="{{ $currency->id }}" data-name="{{ __($currency->name) }}"
                                                title="{{ __('Enable') }}">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        @else
                                        @endif
                                    </td>
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
            {{-- <div class="mb-1">{{ paginateLinks($currencies) }}</div> --}}
        </div>
    </div>
    {{-- ACTIVATE METHOD MODAL --}}
    <div id="activateModal" class="modal fade text-start" tabindex="-1" aria-hidden="true" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Currency Activation Confirmation') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.currency.activate') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <p>{{ __('Are you sure to activate') }} <span class="fw-bold currency-name"></span>
                            {{ __('currency') }}?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="btn btn-success">{{ __('Activate') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Update METHOD MODAL --}}
    <div id="updateModal" class="modal fade text-start" tabindex="-1" aria-hidden="true" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Currency Deactivation Confirmation') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.currency.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <label for="cur">Rate in USD</label>
                        <input type="text" class="form-control" name="rate">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="btn btn-danger">{{ __('Deactivate') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(function() {
            "use strict";

            $('.activateBtn').on('click', function() {
                var modal = $('#activateModal');
                modal.find('.currency-name').text($(this).data('name'));
                modal.find('input[name=id]').val($(this).data('id'));
            });
            $('.updateBtn').on('click', function() {
                var modal = $('#updateModal');
                modal.find('.currency-name').text($(this).data('name'));
                modal.find('input[name=id]').val($(this).data('id'));
            });

        });
    </script>
@endpush
