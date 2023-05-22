@extends('layouts.app')

@section('content')
    @include('admin.notification.header')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form action="" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label class="mb-2">@lang('Email Send Method')</label>
                            <select name="email_method" class="form-control">
                                <option value="php" @if (@$notification->mail_config->name == 'php') selected @endif>@lang('PHP Mail')
                                </option>
                                <option value="smtp" @if (@$notification->mail_config->name == 'smtp') selected @endif>@lang('SMTP')
                                </option>
                                <option value="sendgrid" @if (@$notification->mail_config->name == 'sendgrid') selected @endif>@lang('SendGrid API')
                                </option>
                                <option value="mailjet" @if (@$notification->mail_config->name == 'mailjet') selected @endif>@lang('Mailjet API')
                                </option>
                            </select>
                        </div>
                        <div class="row mt-2 d-none configForm" id="smtp">
                            <div class="col-md-12">
                                <h6 class="mb-2">@lang('SMTP Configuration')</h6>
                            </div>
                            <div class="col-md-4 mb-1">
                                <div class="form-group">
                                    <label>@lang('Host') </label>
                                    <input type="text" class="form-control" placeholder="e.g. @lang('smtp.googlcom')"
                                        name="host" value="{{ @$notification->mail_config->host ?? '' }}" />
                                </div>
                            </div>
                            <div class="col-md-4 mb-1">
                                <div class="form-group">
                                    <label>@lang('Port') </label>
                                    <input type="text" class="form-control" placeholder="@lang('Available port')"
                                        name="port" value="{{ @$notification->mail_config->port ?? '' }}" />
                                </div>
                            </div>
                            <div class="col-md-4 mb-1">
                                <div class="form-group">
                                    <label>@lang('Encryption')</label>
                                    <select class="form-control" name="enc">
                                        <option value="ssl" @if (@$notification->mail_config->enc == 'ssl') selected @endif>
                                            @lang('SSL')
                                        </option>
                                        <option value="tls" @if (@$notification->mail_config->enc == 'tls') selected @endif>
                                            @lang('TLS')</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Username') </label>
                                    <input type="text" class="form-control" placeholder="@lang('Normally your email') address"
                                        name="username" value="{{ @$notification->mail_config->username ?? '' }}" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Password') </label>
                                    <input type="text" class="form-control" placeholder="@lang('Normally your email password')"
                                        name="password" value="{{ @$notification->mail_config->password ?? '' }}" />
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2 d-none configForm" id="sendgrid">
                            <div class="col-md-12">
                                <h6 class="mb-2">@lang('SendGrid API Configuration')</h6>
                            </div>
                            <div class="form-group col-md-12">
                                <label>@lang('App Key') </label>
                                <input type="text" class="form-control" placeholder="@lang('SendGrid App key')" name="appkey"
                                    value="{{ @$notification->mail_config->appkey ?? '' }}" />
                            </div>
                        </div>
                        <div class="row mt-2 d-none configForm" id="mailjet">
                            <div class="col-md-12">
                                <h6 class="mb-2">@lang('Mailjet API Configuration')</h6>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Api Public Key') </label>
                                    <input type="text" class="form-control" placeholder="@lang('Mailjet Api Public Key')"
                                        name="public_key" value="{{ @$notification->mail_config->public_key ?? '' }}" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Api Secret Key') </label>
                                    <input type="text" class="form-control" placeholder="@lang('Mailjet Api Secret Key')"
                                        name="secret_key" value="{{ @$notification->mail_config->secret_key ?? '' }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary w-100 h-45">@lang('Submit')</button>
                    </div>
                </form>
            </div><!-- card end -->
        </div>


    </div>


    {{-- TEST MAIL MODAL --}}
    <div id="testMailModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Test Mail Setup')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                <form action="{{ route('admin.settings.mail.test') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>@lang('Sent to') </label>
                                    <input type="text" name="email" class="form-control"
                                        placeholder="@lang('Email Address')">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary w-100 h-45">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('breadcrumb-plugins')
    <button type="button" data-bs-target="#testMailModal" data-bs-toggle="modal"
        class="btn btn-sm btn-outline-primary"><i class="bi bi-paper-plane"></i> @lang('Send Test Mail')</button>
@endpush
@push('script')
    <script>
        (function($) {
            "use strict";

            var method = '{{ @$notification->mail_config->name }}';
            emailMethod(method);
            $('select[name=email_method]').on('change', function() {
                var method = $(this).val();
                emailMethod(method);
            });

            function emailMethod(method) {
                $('.configForm').addClass('d-none');
                if (method != 'php') {
                    $(`#${method}`).removeClass('d-none');
                }
            }

        })(jQuery);
    </script>
@endpush
