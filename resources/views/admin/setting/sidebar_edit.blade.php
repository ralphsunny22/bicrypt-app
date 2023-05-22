@extends('layouts.app')
@section('vendor-style')
    <!-- vendor css files -->
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
    <style>
        .iconpicker-dropdown {
            visibility: hidden;
            opacity: 0;
        }

        .iconpicker-dropdown.show {
            visibility: visible;
            opacity: 1;
        }

        .iconpicker-dropdown ul {
            position: absolute;
            width: 250px;
            height: 200px;
            background: #fff;
            overflow: scroll;
            box-shadow: 0 0 28px rgba(0, 0, 0, 0.1);
            padding: 1rem;
            z-index: 999;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            left: 0;
            list-style: none;
        }

        .iconpicker-dropdown ul li {
            width: 40px;
            height: 40px;
            line-height: 40px;
            text-align: center;
            border: 1px solid #b2b2b2 73;
            cursor: pointer;
            margin: 0.1rem;
        }

        .iconpicker-dropdown ul li.selected {
            background-color: #007eff;
            color: #fff;
        }

        .iconpicker-dropdown ul li.hidden {
            display: none;
        }
    </style>
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            Edit {{ $sidebar->name }}
        </div>

        <form action="{{ route('admin.sidebar.update', [$type, $id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="form-group">
                            <label for="name">Title*</label>
                            <input type="text" id="name" name="name" class="form-control"
                                value="{{ old('name', isset($sidebar) ? $sidebar->name : '') }}" required>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <label>Icon*</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text selected-icon"></span>
                            <input type="text" id="icon" name="icon" class="form-control iconpicker"
                                value="{{ old('icon', isset($sidebar) ? $sidebar->icon : '') }}" required>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="form-group">
                            <label for="permission">{{ trans('cruds.role.fields.permissions') }}*
                                <select name="permission" id="permission" class="form-control" required>
                                    @foreach ($permissions as $permission)
                                        <option value="{{ $permission->code }}"
                                            @if (isset($sidebar) && isset($sidebar->permission) && $permission->code == $sidebar->permission) selected @endif>
                                            {{ $permission->title }}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <label class="form-control-label">{{ __('Status') }} </label>
                        <input type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle"
                            data-on="{{ __('Active') }}" data-off="{{ __('Disabled') }}" data-width="100%" name="status"
                            @if ($sidebar->status == 1) checked @endif>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <input class="btn btn-success" type="submit" value="Save">
            </div>
        </form>
    </div>

    @if (isset($sidebar->submenu) && $sidebar->submenu != null)
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
                        @forelse($sidebar->submenu as $key => $submenu)
                            <tr>
                                <td data-label="{{ __('Title') }}">{{ $submenu->name }}</td>
                                <td data-label="{{ __('Icon') }}"><i class="bi bi-{{ $submenu->icon }}"></i></td>
                                <td data-label="{{ __('Status') }}">
                                    @if ($submenu->status == 1)
                                        <span class="badge bg-success">{{ __('Active') }}</span>
                                    @else
                                        <span class="badge bg-warning">{{ __('Disabled') }}</span>
                                    @endif
                                </td>
                                <td data-label="{{ __('Action') }}">
                                    <a href="{{ route('admin.sidebar.submenu.edit', [$type, $id, $key]) }}"
                                        class="btn btn-icon btn-warning btn-sm" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="{{ __('Edit') }}">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    @if ($submenu->status == 0)
                                        <button type="button" class="btn btn-icon btn-success rounded activateBtn btn-sm"
                                            data-bs-toggle="modal" data-bs-target="#activateModal"
                                            data-id="{{ $key }}" data-name="{{ __($submenu->name) }}"
                                            title="{{ __('Enable') }}">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-icon btn-danger deactivateBtn btn-sm"
                                            data-bs-toggle="modal" data-bs-target="#deactivateModal"
                                            data-id="{{ $key }}" data-name="{{ __($submenu->name) }}"
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
                    <form action="{{ route('admin.sidebar.submenu.activate', [$type, $id]) }}" method="POST">
                        @csrf
                        <input type="hidden" name="submenu_id">
                        <div class="modal-body">
                            <p>{{ __('Are you sure to activate') }} <span class="fw-bold sidebar-name"></span>
                                {{ __('this sidebar item') }}?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-dark"
                                data-bs-dismiss="modal">{{ __('Close') }}</button>
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
                    <form action="{{ route('admin.sidebar.submenu.deactivate', [$type, $id]) }}" method="POST">
                        @csrf
                        <input type="hidden" name="submenu_id">
                        <div class="modal-body">
                            <p>{{ __('Are you sure to disable') }} <span class="fw-bold sidebar-name"></span>
                                {{ __('this sidebar item') }}?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-dark"
                                data-bs-dismiss="modal">{{ __('Close') }}</button>
                            <button type="submit" class="btn btn-danger">{{ __('Disable') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('vendor-script')
    <!-- vendor files -->
    <script src="{{ asset(mix('vendors/js/bootstrap/iconpicker.js')) }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap4-toggle/3.6.1/bootstrap4-toggle.min.js"></script>
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('admin.sidebar.' . $type) }}" class="btn btn-primary btn-sm"><i class="bi bi-chevron-left"></i>
        {{ __('Back') }}</a>
@endpush

@push('script')
    <script>
        (async () => {
            const response = await fetch("/public/data/bootstrap5.json")
            const result = await response.json()


            const iconpicker = new Iconpicker(document.querySelector(".iconpicker"), {
                icons: result,
                showSelectedIn: document.querySelector(".selected-icon"),
                searchable: true,
                selectedClass: "selected",
                containerClass: "my-picker",
                hideOnSelect: true,
                fade: true,
                defaultValue: "{{ isset($sidebar) ? 'bi-' . $sidebar->icon : '' }}",
                valueFormat: val => `bi ${val}`
            });
        })()

        $(function() {
            "use strict";

            $('.activateBtn').on('click', function() {
                var modal = $('#activateModal');
                modal.find('.sidebar-name').text($(this).data('name'));
                modal.find('input[name=submenu_id]').val($(this).data('id'));
            });

            $('.deactivateBtn').on('click', function() {
                var modal = $('#deactivateModal');
                modal.find('.sidebar-name').text($(this).data('name'));
                modal.find('input[name=submenu_id]').val($(this).data('id'));
            });

        });
    </script>
@endpush
