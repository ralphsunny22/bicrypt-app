@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Payment Providers</h4>
                    <div class="card-search"></div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover custom-data-bs-table">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">{{ __('Provider') }}</th>
                                <th scope="col">{{ __('Status') }}</th>
                                <th scope="col">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($gateways as $k=>$gateway)
                                <tr>
                                    <td data-label="{{ __('Provider') }}">
                                        <div class="row centerize">
                                            <div class="col-md-3">
                                                <img src="{{ getImage(imagePath()['gateway']['path'] . '/' . $gateway->image, imagePath()['gateway']['size']) }}"
                                                    alt="{{ __('image') }}" width="128px">
                                            </div>
                                            <span class="col-md-9 name">{{ __($gateway->name) }}</span>
                                        </div>
                                    </td>
                                    <td data-label="{{ __('Status') }}">
                                        @if ($gateway->status == 1)
                                            <span class="badge bg-success">{{ __('Active') }}</span>
                                        @else
                                            <span class="badge bg-warning">{{ __('Disabled') }}</span>
                                        @endif

                                    </td>
                                    <td data-label="{{ __('Action') }}">
                                        <a href="{{ route('admin.payment.provider.edit', $gateway->alias) }}">
                                            <button class="btn btn-sm btn-icon btn-warning editGatewayBtn"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="{{ __('Edit') }}">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                        </a>


                                        @if ($gateway->status == 0)
                                            <button data-bs-toggle="modal" data-bs-target="#activateModal"
                                                class="btn btn-sm btn-icon btn-success activateBtn"
                                                data-code="{{ $gateway->code }}" data-name="{{ __($gateway->name) }}"
                                                data-original-title="{{ __('Enable') }}">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        @else
                                            <button data-bs-toggle="modal" data-bs-target="#deactivateModal"
                                                class="btn btn-sm btn-icon btn-danger deactivateBtn"
                                                data-code="{{ $gateway->code }}" data-name="{{ __($gateway->name) }}"
                                                data-original-title="{{ __('Disable') }}">
                                                <i class="bi bi-eye-slash"></i>
                                            </button>
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
            <div class="mb-1">
                {{ paginateLinks($gateways) }}
            </div>
        </div>


    </div>



    {{-- ACTIVATE METHOD MODAL --}}
    <div id="activateModal" class="modal fade text-start" tabindex="-1" aria-hidden="true" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Payment Method Activation Confirmation') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.payment.provider.activate') }}" method="POST">
                    @csrf
                    <input type="hidden" name="code">
                    <div class="modal-body">
                        <p>{{ __('Are you sure to activate') }} <span class="fw-bold method-name"></span>
                            {{ __('method') }}?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{ __('Close') }}</button>

                        <button type="submit" class="btn btn-primary">{{ __('Activate') }}</button>
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
                    <h5 class="modal-title">{{ __('Payment Method Disable Confirmation') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.payment.provider.deactivate') }}" method="POST">
                    @csrf
                    <input type="hidden" name="code">
                    <div class="modal-body">
                        <p>{{ __('Are you sure to disable') }} <span class="fw-bold method-name"></span>
                            {{ __('method') }}?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="btn btn-danger">{{ __('Disable') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        "use strict"
        $(document).on('click', '.activateBtn', function() {
            var modal = $('#activateModal');
            modal.find('.method-name').text($(this).data('name'));
            modal.find('input[name=code]').val($(this).data('code'));
        });

        $(document).on('click', '.deactivateBtn', function() {
            var modal = $('#deactivateModal');
            modal.find('.method-name').text($(this).data('name'));
            modal.find('input[name=code]').val($(this).data('code'));
        });
    </script>
@endpush
