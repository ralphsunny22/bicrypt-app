@extends('layouts.app')

@section('content')
    <div class="row" id="table-hover-row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">{{ __('Providers') }}</h4>
                    <div class="card-search"></div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover custom-data-bs-table">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">{{ __('Provider') }}</th>
                                <th scope="col">{{ __('API Connection') }}</th>
                                <th scope="col">{{ __('Status') }}</th>
                                <th scope="col">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($providers as $provider)
                                <tr>
                                    <td data-label="{{ __('Provider') }}">
                                        <img class="avatar-content me-1" style="width:110px;height:35px"
                                            src="{{ getImage('assets/images/providers/' . strtolower($provider->title) . '.jpg') }}" />
                                        {{ $provider->name }}
                                    </td>
                                    <td data-label="{{ __('API Connection') }}">
                                        @if ($provider->status == 1)
                                            @if ($connection == 1)
                                                <span class="badge bg-success">{{ __('Connected Successfully') }}</span>
                                            @elseif($connection == 0)
                                                <span class="badge bg-danger">{{ __('Connection Failed') }}</span>
                                            @else
                                            @endif
                                        @else
                                        @endif
                                    </td>
                                    <td data-label="{{ __('Status') }}">
                                        @if ($provider->development != 1)
                                            @if ($provider->status == 1)
                                                <span class="badge bg-success">{{ __('Active') }}</span>
                                            @else
                                                <span class="badge bg-warning">{{ __('Disabled') }}</span>
                                            @endif
                                        @else
                                            <span class="badge bg-secondary">{{ __('In Development') }}</span>
                                        @endif
                                    </td>
                                    <td data-label="{{ __('Action') }}">
                                        @if ($provider->development == 1)
                                        @else
                                            @if ($provider->installed == 1)
                                                @if ($provider->status == 1)
                                                    @php
                                                        $res = $api->check_update($provider->product_id);
                                                    @endphp
                                                    @if ($res['status'])
                                                        <a type="button" class="btn btn-warning btn-sm" style="top:80%"
                                                            href="{{ route('admin.provider.install', [$provider->product_id]) }}">
                                                            <i class="bi bi-download"></i> {{ __('Update') }}
                                                            V{{ $res['version'] }}
                                                            {{ __('Available') }}</a>
                                                    @endif
                                                    <a href="{{ route('admin.provider.currencies.index', $provider->id) }}"
                                                        class="btn btn-info btn-sm" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Enable/Disable Currencies">
                                                        {{ __('Currencies') }}
                                                    </a>
                                                    <a href="{{ route('admin.provider.markets.index', $provider->id) }}"
                                                        class="btn btn-info btn-sm" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Enable/Disable Market Pairs">
                                                        {{ __('Markets') }}
                                                    </a>
                                                    <a href="{{ route('admin.provider.balances', $provider->id) }}"
                                                        class="btn btn-info btn-sm" data-bs-toggle="tooltip"
                                                        data-bs-placement="top"
                                                        title="CHeck balances and debug errors in provider api connection">
                                                        {{ __('Debug') }}
                                                    </a>
                                                    <a href="{{ route('admin.provider.refresh') }}"
                                                        class="btn btn-icon btn-primary btn-sm" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Refresh">
                                                        <i class="bi bi-arrow-repeat"></i>
                                                    </a>
                                                @endif
                                                <a href="{{ route('admin.provider.edit', $provider->id) }}"
                                                    class="btn btn-icon btn-warning btn-sm" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="{{ __('Edit') }}">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                @if ($provider->status == 0)
                                                    <button type="button"
                                                        class="btn btn-icon btn-success btn-sm activateBtn"
                                                        data-bs-toggle="modal" data-bs-target="#activateModal"
                                                        data-id="{{ $provider->id }}"
                                                        data-name="{{ __($provider->name) }}" title="{{ __('Enable') }}">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                @else
                                                    <span data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="{{ __('Disable') }}">
                                                        <button type="button"
                                                            class="btn btn-icon btn-danger btn-sm deactivateBtn"
                                                            data-bs-toggle="modal" data-bs-target="#deactivateModal"
                                                            data-id="{{ $provider->id }}"
                                                            data-name="{{ __($provider->name) }}">
                                                            <i class="bi bi-eye-slash"></i>
                                                        </button>
                                                    </span>
                                                @endif
                                                @if ($provider->title != 'coinbasepro')
                                                    <a href="{{ route('admin.provider.activater', [$provider->product_id]) }}"
                                                        class="btn btn-success btn-sm ms-1" data-bs-toggle="tooltip"
                                                        data-bs-placement="top"
                                                        title="Reverify if you license show invalid error">
                                                        {{ __('Re-Verify License') }}
                                                    </a>
                                                @endif
                                            @else
                                                @if ($provider->activated == 0)
                                                    <a href="{{ route('admin.provider.activater', [$provider->product_id]) }}"
                                                        class="btn btn-icon btn-success btn-sm ms-1"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="{{ __('Verify License') }}">
                                                        <i class="bi bi-check-lg"></i>
                                                    </a>
                                                @else
                                                    <a href="{{ route('admin.provider.install', [$provider->product_id]) }}"
                                                        class="btn btn-icon btn-dark btn-sm ms-1" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="{{ __('Install') }}">
                                                        <i class="bi bi-download"></i>
                                                    </a>
                                                    @if ($provider->title != 'coinbasepro')
                                                        <a href="{{ route('admin.provider.activater', [$provider->product_id]) }}"
                                                            class="btn btn-icon btn-success btn-sm ms-1"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="{{ __('Re-Verify License') }}">
                                                            <i class="bi bi-check-lg"></i>
                                                        </a>
                                                    @endif
                                                @endif
                                            @endif
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
        </div>
    </div>
    {{-- ACTIVATE METHOD MODAL --}}
    <div id="activateModal" class="modal fade text-start" tabindex="-1" aria-hidden="true" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Provider Activation Confirmation') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.provider.activate') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <p>{{ __('Are you sure to activate') }} <span class="fw-bold provider-name"></span>
                            {{ __('provider') }}?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="btn btn-success">{{ __('Activate') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- DEACTIVATE METHOD MODAL --}}
    <div id="deactivateModal" class="modal fade text-start" tabindex="-1" aria-hidden="true" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Provider Deactivation Confirmation') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.provider.deactivate') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <p>{{ __('Are you sure to deactivate') }} <span class="fw-bold provider-name"></span>
                            {{ __('provider') }}?</p>
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
                modal.find('.provider-name').text($(this).data('name'));
                modal.find('input[name=id]').val($(this).data('id'));
            });
            $('.deactivateBtn').on('click', function() {
                var modal = $('#deactivateModal');
                modal.find('.provider-name').text($(this).data('name'));
                modal.find('input[name=id]').val($(this).data('id'));
            });

        });
    </script>
@endpush
