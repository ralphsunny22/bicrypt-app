@extends('layouts.app')
@section('vendor-style')
    <!-- vendor css files -->
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            Edit {{ $sidebar->name }}
        </div>

        <form action="{{ route('admin.sidebar.submenu.update', [$type, $id, $submenu_id]) }}" method="POST"
            enctype="multipart/form-data">
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
@endsection

@section('vendor-script')
    <!-- vendor files -->
    <script src="{{ asset(mix('vendors/js/bootstrap/iconpicker.js')) }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap4-toggle/3.6.1/bootstrap4-toggle.min.js"></script>
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('admin.sidebar.edit', [$type, $id]) }}" class="btn btn-primary btn-sm"><i
            class="bi bi-chevron-left"></i>
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
