@extends('layouts.app')

@section('content')
    <div class="card">
        <h6 class="card-header">
            <div class="col-sm-8 col-md-6">
                @if ($ticket->status == 0)
                    <span class="badge bg-success">{{ __('Open') }}</span>
                @elseif($ticket->status == 1)
                    <span class="badge bg-primary">{{ __('Answered') }}</span>
                @elseif($ticket->status == 2)
                    <span class="badge bg-warning">{{ __('Customer Reply') }}</span>
                @elseif($ticket->status == 3)
                    <span class="badge bg-dark">{{ __('Closed') }}</span>
                @endif
                [{{ __('Ticket#') }}{{ $ticket->ticket }}] {{ $ticket->subject }}
            </div>
            <div class="col-sm-4 col-md-6 text-sm-end mt-sm-0 mt-3">
                <button class="btn btn-danger btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#DelModal">
                    <i class="bi bi-x-circle"></i> {{ __('Close Ticket') }}
                </button>
            </div>
        </h6>

        <form action="{{ route('admin.ticket.reply', $ticket->id) }}" enctype="multipart/form-data" method="post"
            class="form-horizontal">
            @csrf
            <div class="row mx-1">
                <div class="col-md-12">
                    <div class="col">
                        <textarea class="form-control" name="message" rows="3" id="inputMessage" placeholder="{{ __('Your Message') }}"></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row mt-1">
                        <div class="col-md-12">
                            <label for="inputAttachments">{{ __('Attachments') }}</label>
                        </div>
                        <div class="col-9">
                            <div class="file-upload-wrapper" data-text="{{ __('Select your file!') }}">
                                <input type="file" name="attachments[]" id="inputAttachments" class="form-control" />
                            </div>
                            <div id="fileUploadsContainer"></div>
                        </div>
                        <div class="col-3">
                            <button type="button" class="btn btn-dark" onclick="extraTicketAttachment()"><i
                                    class="bi bi-plus-lg"></i></button>
                        </div>
                        <div class="col-md-12 ticket-attachments-message text-muted mt-1">
                            {{ __('Allowed File Extensions') }}: .jpg, .jpeg, .png, .pdf, .doc, .docx
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <button class="btn btn-primary btn-sm" type="submit" name="replayTicket" value="1"><i
                        class="bi bi-reply"></i> {{ __('Reply') }}
                </button>
            </div>

        </form>
    </div>

    @foreach ($messages as $message)
        @if ($message->admin_id == 0)
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-3 border-end text-end">
                            <h5 class="my-1">{{ $ticket->name }}</h5>
                            @if ($ticket->user_id != null)
                                <p><a
                                        href="{{ route('admin.users.detail', $ticket->user_id) }}">&#64;{{ $ticket->name }}</a>
                                </p>
                            @else
                                <p>@<span>{{ $ticket->name }}</span></p>
                            @endif

                        </div>

                        <div class="col-md-9">
                            <p class="text-muted fw-bold my-1">
                                {{ __('Posted on') }}
                                {{ showDateTime($message->created_at, 'l, dS F Y @ H:i') }}</p>
                            <p>{{ $message->message }}</p>
                            @if ($message->attachments()->count() > 0)
                                <div class="my-1">
                                    @foreach ($message->attachments as $k => $image)
                                        <a href="{{ route('admin.ticket.download', encrypt($image->id)) }}"
                                            class="mr-3"><i class="bi bi-file-earmark"></i>{{ __('Attachment') }}
                                            {{ ++$k }}</a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button data-id="{{ $message->id }}" type="button" data-bs-toggle="modal"
                        data-bs-target="#DelMessage" class="btn btn-danger btn-sm delete-message"><i
                            class="bi bi-trash"></i> {{ __('Delete') }}</button>
                </div>

            </div>
        @else
            <div class="card">
                <div class="card-body">
                    <div class="row admin-bg-reply">

                        <div class="col-md-3 border-end text-end">
                            <h5 class="my-1">{{ @$message->admin->name }}</h5>
                            <p class="lead text-muted">{{ __('Staff') }}</p>

                        </div>

                        <div class="col-md-9">
                            <p class="text-muted fw-bold my-1">
                                {{ __('Posted on') }}
                                {{ showDateTime($message->created_at, 'l, dS F Y @ H:i') }}</p>
                            <p>{{ $message->message }}</p>
                            @if ($message->attachments()->count() > 0)
                                <div class="my-1">
                                    @foreach ($message->attachments as $k => $image)
                                        <a href="{{ route('admin.ticket.download', encrypt($image->id)) }}"
                                            class="mr-3"><i class="bi bi-file-earmark"></i>
                                            {{ __('Attachment') }} {{ ++$k }} </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button data-id="{{ $message->id }}" type="button" data-bs-toggle="modal"
                        data-bs-target="#DelMessage" class="btn btn-danger btn-sm delete-message"><i
                            class="bi bi-trash"></i> {{ __('Delete') }}</button>
                </div>
            </div>
        @endif
    @endforeach





    <div class="modal fade text-start" id="DelModal" tabindex="-1" aria-hidden="true" role="dialog"
        aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> {{ __('Close Support Ticket!') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <strong>{{ __('Are you  want to Close This Support Ticket?') }}</strong>
                </div>
                <div class="modal-footer">
                    <form method="post" action="{{ route('admin.ticket.reply', $ticket->id) }}">
                        @csrf

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('No') }}
                        </button>
                        <button type="submit" class="btn btn-success" name="replayTicket" value="2">
                            {{ __('Close Ticket') }} </button>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade text-start" id="DelMessage" tabindex="-1" aria-hidden="true" role="dialog"
        aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('Delete Reply!') }}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <strong>{{ __('Are you sure to delete this?') }}</strong>
                </div>
                <div class="modal-footer">
                    <form method="post" action="{{ route('admin.ticket.delete') }}">
                        @csrf
                        <input type="hidden" name="message_id" class="message_id">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{ __('No') }}
                        </button>
                        <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i> {{ __('Delete') }}
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection




@push('breadcrumb-plugins')
    <a href="{{ route('admin.ticket') }}" class="btn btn-primary btn-sm"><i class="bi bi-chevron-left"></i>
        {{ __('Go Back') }} </a>
@endpush
@push('script')
    <script>
        "use strict";
        $(document).ready(function() {
            $('.delete-message').on('click', function(e) {
                $('.message_id').val($(this).data('id'));
            })
        });

        function extraTicketAttachment() {
            $("#fileUploadsContainer").append(
                `
            <div class="mt-1 file-upload-wrapper" data-text="Select your file!"><input type="file" name="attachments[]" id="inputAttachments" class="form-control"/></div>`
            )
        }
    </script>
@endpush
