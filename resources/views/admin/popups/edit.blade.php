@extends('layouts.app')

@section('vendor-style')
    <!-- vendor css files -->
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
@endsection
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title">{{ 'Editing ' . $popup->title . ' popup' }}</h4>
            <div class="card-search"></div>
        </div>
        <form action="{{ route('admin.popups.update', $popup->id) }}" method="POST" enctype="multipart/form-data"
            id="popupUpdate">
            @csrf
            <div class="card-body">
                <div class="row">
                    <label for="title">{{ __('Title') }}</label>
                    <div class="input-group mb-1">
                        <input type="text" class="form-control" id="title" name="title" placeholder="Popup Title"
                            aria-describedby="title" value="{{ $popup->title }}">
                    </div>
                </div>
                <label for="desc">{{ __('Message') }}</label>
                <div class="input-group mb-1">
                    <textarea class="form-control" name="msg" rows="8" id="msg" placeholder="Popup Message">{!! $popup->msg !!}</textarea>

                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <label for="link">{{ __('Link') }}</label>
                        <div class="input-group mb-1">
                            <input type="text" class="form-control" id="link" name="link"
                                placeholder="Popup Link" aria-describedby="link" value="{{ $popup->link }}">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <label for="duration">{{ __('Duration') }}</label>
                        <div class="input-group mb-1">
                            <input type="number" class="form-control" id="duration" name="duration"
                                placeholder="Popup Duration" aria-describedby="duration" value="{{ $popup->duration }}">
                            <span class="input-group-text" for="duration">{{ __('Sec') }}</span>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <label class="form-label" for="end_date">{{ __('End Date') }}</label>
                        <input type="text" id="end_date" name="end_date" class="form-control flatpickr-date-time"
                            value="{{ $popup->end_date }}" placeholder="YYYY-MM-DD HH:MM" />
                    </div>
                </div>
                <div class="d-flex justify-content-start align-items-top mb-1">
                    <div class="me-1">
                        <img class="img-thumbnail mb-1"
                            src="{{ getImage(imagePath()['popup']['path'] . '/' . $popup->image, imagePath()['popup']['size']) }}" />
                    </div>
                    <div>
                        <input class="form-control" name="image" type="file" id="image"
                            accept=".png, .jpg, .jpeg" />
                        <small class="text-warning">600px * 400px</small>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <label class="form-control-label h6 mt-1">{{ __('Status') }} </label>
                    <input type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle"
                        data-on="{{ __('Active') }}" data-off="{{ __('Disabled') }}" data-width="100%" name="status"
                        @if ($popup->status == 1) checked @endif>
                </div>
            </div>
            <div class="card-footer text-end">
                <button class="btn btn-success" type="submit"><i class="bi bi-pencil-square"></i>
                    {{ __('Edit') }}
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap4-toggle/3.6.1/bootstrap4-toggle.min.js"></script>
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
