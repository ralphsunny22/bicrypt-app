@extends('layouts.app')

@section('vendor-style')
    <!-- vendor css files -->
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
@endsection

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title">{{ __('New Popup') }}</h4>
            <div class="card-search"></div>
        </div>
        <form action="{{ route('admin.popups.store') }}" method="POST" enctype="multipart/form-data" id="newpopup">
            @csrf
            <div class="card-body">
                <div class="row">
                    <label for="title">{{ __('Title') }}</label>
                    <div class="input-group mb-1">
                        <input type="text" class="form-control" id="title" name="title" placeholder="Popup Title"
                            aria-describedby="title" value="{{ old('title') }}">
                    </div>
                </div>
                <label for="desc">{{ __('Message') }}</label>
                <div class="mb-1">
                    <textarea class="form-control" name="msg" rows="8" id="msg" placeholder="Popup Message">{!! old('msg') !!}</textarea>
                    <small class="text-warning">{{ __('HTML code allowed') }}</small>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <label for="link">{{ __('Link') }}</label>
                        <div class="mb-1">
                            <input type="text" class="form-control" id="link" name="link"
                                placeholder="Popup Link" aria-describedby="link" value="{{ old('link') }}">
                            <small class="text-warning">{{ __('Adding link will show a button to open new tab in the popup')
                                }}</small>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <label for="duration">{{ __('Duration') }}</label>
                        <div class=" mb-1">
                            <div class="input-group">
                                <input type="number" class="form-control" id="duration" name="duration"
                                    placeholder="Popup Duration" aria-describedby="duration" value="{{ old('duration') }}">
                                <span class="input-group-text" for="duration">Sec</span>
                            </div>
                            <small class="text-warning">{{ __('Duration until popup automatically closed') }}</small>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <label class="form-label" for="end_date">{{ __('End Date') }}</label>
                        <input type="text" id="end_date" name="end_date" class="form-control flatpickr-date-time"
                            value="{{ old('end_date') }}" placeholder="YYYY-MM-DD HH:MM" />
                    </div>
                </div>
                <div class="d-flex justify-content-start align-items-top mb-1">
                    <div>
                        <input class="form-control" name="image" type="file" id="image"
                            accept=".png, .jpg, .jpeg" />
                        <small class="text-warning">600px * 400px</small>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <label class="form-control-label h6 mt-1">{{ __('Status') }} </label>
                    <input type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle"
                        data-on="{{ __('Active') }}" data-off="{{ __('Disabled') }}" data-width="100%" name="status">
                </div>
            </div>
            <div class="card-footer text-end">
                <button class="btn btn-success" type="submit">{{ __('Submit') }}
                </button>
            </div>
        </form>
    </div>
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('admin.popups.index') }}" class="btn btn-primary btn-sm"><i class="bi bi-chevron-left"></i>
        {{ __('Back') }}</a>
@endpush


@section('vendor-script')
    <!-- vendor files -->
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap4-toggle/3.6.1/bootstrap4-toggle.min.js"></script>
@endsection
@section('page-script')
    <!-- Page js files -->
    <script src="{{ asset(mix('js/scripts/forms/pickers/form-pickers.js')) }}"></script>
@endsection

@push('script')
    <script>
        "use strict";
        $('.toggle').bootstrapToggle({
            on: 'Y',
            off: 'N',
            width: '100%',
            size: 'small'
        });
    </script>
@endpush
