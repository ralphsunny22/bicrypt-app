@extends('layouts.app')

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/kyc/style.css')) }}">
@endsection
@section('content')
    @include('admin.notification.header')

    <div class="row">
        <div class="col-lg-9 col-md-12 col-sm-12">
            <div class="card">
                <form action="{{ route('admin.settings.mail.update') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-1">
                                <div class="form-group">
                                    <label>@lang('Email Sent From') </label>
                                    <input type="text" class="form-control " placeholder="@lang('Email address')"
                                        name="email_from" value="{{ $notification->email_from }}" required />
                                </div>
                            </div>
                            <div class="col-md-12 mb-1">
                                <div class="form-group">
                                    <label>@lang('Email Body') </label>
                                    <textarea id="email_template" name="email_template" rows="10" class="form-control" placeholder="@lang('Your email template')">{{ $notification->email_template }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12 mb-1">
                                <div class="form-group">
                                    <label>@lang('SMS Sent From') </label>
                                    <input class="form-control" placeholder="@lang('SMS Sent From')" name="sms_from"
                                        value="{{ $notification->sms_from }}" required>
                                </div>
                            </div>

                            <div class="col-md-12 mb-1">
                                <div class="form-group">
                                    <label>@lang('SMS Body') </label>
                                    <textarea class="form-control" rows="4" placeholder="@lang('SMS Body')" name="sms_body" required>{{ $notification->sms_body }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn w-100 btn-primary">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-3 col-md-12 col-sm-12">
            <div class="card overflow-hidden">
                <div class="card-body p-0">
                    <div class="table-responsive table-responsive-sm">
                        <table class="table align-items-center">
                            <thead class="table-dark">
                                <tr>
                                    <th>@lang('Short Code') </th>
                                    <th>@lang('Description')</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                <tr>
                                    <td><span class="short-codes">@{{ fullname }}</span></td>
                                    <td>@lang('Full Name of User')</td>
                                </tr>
                                <tr>
                                    <td><span class="short-codes">@{{ username }}</span></td>
                                    <td>@lang('Username of User')</td>
                                </tr>
                                <tr>
                                    <td><span class="short-codes">@{{ message }}</span></td>
                                    <td>@lang('Message')</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <h6 class="my-2">@lang('Global Short Codes')</h6>
            <div class="card overflow-hidden">
                <div class="card-body p-0">
                    <div class="table-responsive table-responsive-sm">
                        <table class=" table align-items-center-">
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
@endsection

@section('page-script')
    <script src="https://cdn.tiny.cloud/1/{{ getGen()->tinymce }}/tinymce/6/tinymce.min.js" referrerpolicy="origin">
    </script>
    <script>
        $(function() {
            tinymce.init({
                selector: 'textarea#email_template',
                plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
                toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
            });
        });
    </script>
@endsection
