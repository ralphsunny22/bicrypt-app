@extends('layouts.app')

@section('vendor-style')
    <!-- vendor css files -->
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
@endsection
@section('content')
    @include('admin.notification.header')

    <form action="{{ route('admin.settings.mail.template.update', $template->id) }}" method="post">
        @csrf
        <div class="row">
            <div class="col-lg-9 col-md-12 col-sm-12">

                <div class="row">
                    <div class="@if ($template->push_notification_status) col-md-12 @else col-md-6 @endif">
                        <div class="card">
                            <div class="card-header bg-primary">
                                <h5 class="card-title text-white">@lang('Email Template')</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8 mt-1">
                                        <div class="form-group">
                                            <label>@lang('Subject')</label>
                                            <input type="text" class="form-control form-control-lg"
                                                placeholder="@lang('Email subject')" name="subject" value="{{ $template->subj }}"
                                                required />
                                        </div>
                                    </div>
                                    <div class="col-md-4 mt-1">
                                        <div class="form-group">
                                            <label>@lang('Status') <span class="text-danger">*</span></label>
                                            <input type="checkbox" class="form-check-input" data-height="46px"
                                                data-width="100%" data-onstyle="success" data-offstyle="danger"
                                                data-toggle="toggle" data-on="@lang('Send Email')"
                                                data-off="@lang("Don't Send")" name="email_status"
                                                @if ($template->email_status) checked @endif>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-1">
                                        <div class="form-group">
                                            <label>@lang('Message') <span class="text-danger">*</span></label>
                                            <textarea id="email_body" name="email_body" rows="10" class="form-control" placeholder="@lang('Your message using short-codes')">{{ $template->email_body }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-primary">
                                <h5 class="card-title text-white">@lang('SMS Template')</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 mt-1">
                                        <div class="form-group">
                                            <label>@lang('Status') <span class="text-danger">*</span></label>
                                            <input type="checkbox" class="form-check-input" data-height="46px"
                                                data-width="100%" data-onstyle="success" data-offstyle="danger"
                                                data-toggle="toggle" data-on="@lang('Send SMS')"
                                                data-off="@lang("Don't Send")" name="sms_status"
                                                @if ($template->sms_status) checked @endif>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-1">
                                        <div class="form-group">
                                            <label>@lang('Message')</label>
                                            <textarea name="sms_body" rows="10" class="form-control" placeholder="@lang('Your message using short-codes')" required>{{ $template->sms_body }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($template->push_notification_status == 1)
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-primary">
                                    <h5 class="card-title text-white">@lang('Push Notification Template')</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 mt-1">
                                            <div class="form-group">
                                                <label>@lang('Status') <span class="text-danger">*</span></label>
                                                <input type="checkbox" class="form-check-input" data-height="46px"
                                                    data-width="100%" data-onstyle="success" data-offstyle="danger"
                                                    data-toggle="toggle" data-on="@lang('Send Push Notification')"
                                                    data-off="@lang("Don't Send")" name="push_notification_status"
                                                    @if ($template->push_notification_status) checked @endif>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mt-1">
                                            <div class="form-group">
                                                <label>@lang('Message')</label>
                                                <textarea name="push_notification_body" rows="10" class="form-control" placeholder="@lang('Your message using short-codes')" required>{{ $template->push_notification_body }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-3 col-md-12 col-sm-12">
                <button type="submit" class="btn btn-primary w-100 mb-1">@lang('Submit')</button>
                <div class="card overflow-hidden">
                    <div class="card-body p-0">
                        <div class="table-responsive table-responsive-sm">
                            <table class="table align-items-center">
                                <thead class="table-dark">
                                    <tr>
                                        <th>@lang('Short Code')</th>
                                        <th>@lang('Description')</th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    @forelse($template->shortcodes as $shortcode => $key)
                                        <tr>
                                            <th><span class="short-codes">@php echo "{{ ". $shortcode ." }}"  @endphp</span></th>
                                            <td>{{ __($key) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="100%" class="text-muted text-center">{{ __($emptyMessage) }}
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><!-- card end -->
                <h6 class="mt-4 mb-2">@lang('Global Short Codes')</h6>
                <div class="card overflow-hidden">
                    <div class="card-body p-0">
                        <div class="table-responsive table-responsive-sm">
                            <table class=" table align-items-center">
                                <thead class="table-dark">
                                    <tr>
                                        <th>@lang('Short Code') </th>
                                        <th>@lang('Description')</th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    @foreach ($notification->global_shortcodes as $shortCode => $codeDetails)
                                        <tr>
                                            <td><span class="short-codes">@{{ @php echo $shortCode @endphp }}</span></td>
                                            <td>{{ __($codeDetails) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection


@push('breadcrumb-plugins')
    <a href="{{ route('admin.settings.mail.templates') }}" class="btn btn-primary"><i class="bi bi-chevron-left"></i>
        {{ __('Back') }}</a>
@endpush

@section('page-script')
    <script src="https://cdn.tiny.cloud/1/{{ getGen()->tinymce }}/tinymce/6/tinymce.min.js" referrerpolicy="origin">
    </script>
    <script>
        $(function() {
            tinymce.init({
                selector: 'textarea#email_body',
                plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
                toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
            });
        });
    </script>
@endsection

@section('vendor-script')
    <!-- vendor files -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap4-toggle/3.6.1/bootstrap4-toggle.min.js"></script>
@endsection
