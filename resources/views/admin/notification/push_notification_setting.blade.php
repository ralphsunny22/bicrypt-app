@extends('layouts.app')

@section('vendor-style')
    <!-- vendor css files -->
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
@endsection
@section('content')
    @include('admin.notification.header')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form action="" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row mb-1">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>@lang('Status') <span class="text-danger">*</span></label>
                                    <input type="checkbox" class="form-check-input" data-height="36px" data-width="100%"
                                        data-onstyle="success" data-offstyle="danger" data-toggle="toggle"
                                        data-on="@lang('Send Push Notification')" data-off="@lang("Don't Send")" name="sms_status"
                                        @if (@$notification->push_status) checked @endif>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>@lang('OneSignal APP ID') </label>
                                    <input type="text" class="form-control" placeholder="@lang('OneSignal APP ID')"
                                        name="ONESIGNAL_APP_ID" value="{{ getenv('ONESIGNAL_APP_ID') ?? '' }}" />
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>@lang('OneSignal Rest API Key') </label>
                                    <input type="text" class="form-control" placeholder="@lang('OneSignal Rest API Key')"
                                        name="ONESIGNAL_REST_API_KEY"
                                        value="{{ getenv('ONESIGNAL_REST_API_KEY') ?? '' }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn w-100 h-45 btn-primary">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="card">
        <h4 class="card-header">Guide</h4>
        <div class="card-body">
            <ul>
                <li class="list-style-circle">Register An Account <a
                        href="https://dashboard.onesignal.com/apps/">Onesignal</a></li>
                <li class="list-style-circle">Create an app</li>
                <li class="list-style-circle">Enter Name of your app or website</li>
                <li class="list-style-circle">Select Web</li>
                <li class="list-style-circle">Select Typical Site</li>
                <li class="list-style-circle">Enter SITE NAME , SITE URL , </li>
                <li class="list-style-circle">If you have ssl and using secure https then select AUTO RESUBSCRIBE (HTTPS
                    ONLY)</li>
                <li class="list-style-circle">upload your icon in DEFAULT ICON URL</li>
                <li class="list-style-circle">if your site not on https then enable My site is not fully HTTPS and write a
                    label</li>
                <li class="list-style-circle">Add Prompt (we suggest using bell and hide if subscribed)</li>
                <li class="list-style-circle">Set a Welcome Notification</li>
                <li class="list-style-circle">if you have safari cert then enable SAFARI CERTIFICATE and add it to have
                    notification for apple devices
                </li>
                <li class="list-style-circle">Click save</li>
                <li class="list-style-circle">Go to app > settings > key and ID</li>
                <li class="list-style-circle">Copy the info from there to these 2 inputs an save</li>
            </ul>
        </div>
    </div>
@endsection

@section('vendor-script')
    <!-- vendor files -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap4-toggle/3.6.1/bootstrap4-toggle.min.js"></script>
@endsection
