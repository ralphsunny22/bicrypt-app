@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="table-responsive">
            <table class="table">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">{{ __('Title') }}</th>
                        <th scope="col">{{ __('Icon') }}</th>
                        <th scope="col">{{ __('Status') }}</th>
                        <th scope="col">{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sidebars as $key => $sidebar)
                        <tr>
                            <td data-label="{{ __('Title') }}">{{ $sidebar->name }}</td>
                            <td data-label="{{ __('Icon') }}"><i class="bi bi-{{ $sidebar->icon }}"></i></td>
                            <td data-label="{{ __('Status') }}">
                                @if ($sidebar->status == 1)
                                    <span class="badge bg-success">{{ __('Active') }}</span>
                                @else
                                    <span class="badge bg-warning">{{ __('Disabled') }}</span>
                                @endif
                            </td>
                            <td data-label="{{ __('Action') }}">
                                <a href="{{ route('admin.sidebar.edit', [$type, $key]) }}"
                                    class="btn btn-icon btn-warning btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="{{ __('Edit') }}">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                @if ($sidebar->status == 0)
                                    <button type="button" class="btn btn-icon btn-success rounded activateBtn btn-sm"
                                        data-bs-toggle="modal" data-bs-target="#activateModal"
                                        data-id="{{ $key }}" data-name="{{ __($sidebar->name) }}"
                                        title="{{ __('Enable') }}">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                @else
                                    <button type="button" class="btn btn-icon btn-danger deactivateBtn btn-sm"
                                        data-bs-toggle="modal" data-bs-target="#deactivateModal"
                                        data-id="{{ $key }}" data-name="{{ __($sidebar->name) }}"
                                        title="{{ __('Disable') }}">
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

    {{-- ACTIVATE METHOD MODAL --}}
    <div id="activateModal" class="modal fade text-start" tabindex="-1" aria-hidden="true" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Sidebar Item Activation Confirmation') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.sidebar.activate', $type) }}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <p>{{ __('Are you sure to activate') }} <span class="fw-bold sidebar-name"></span>
                            {{ __('this sidebar item') }}?</p>
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
                    <h5 class="modal-title">{{ __('Sidebar Item Disable Confirmation') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.sidebar.deactivate', $type) }}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <p>{{ __('Are you sure to disable') }} <span class="fw-bold sidebar-name"></span>
                            {{ __('this sidebar item') }}?</p>
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
        $(function() {
            "use strict";

            $('.activateBtn').on('click', function() {
                var modal = $('#activateModal');
                modal.find('.sidebar-name').text($(this).data('name'));
                modal.find('input[name=id]').val($(this).data('id'));
            });

            $('.deactivateBtn').on('click', function() {
                var modal = $('#deactivateModal');
                modal.find('.sidebar-name').text($(this).data('name'));
                modal.find('input[name=id]').val($(this).data('id'));
            });

        });
    </script>
@endpush
