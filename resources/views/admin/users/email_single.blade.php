@extends('layouts.app')

@section('content')
    <div class="row mb-none-30">
        <div class="col-xl-12">
            <div class="card">
                <form action="{{ route('admin.users.email.single', $user->id) }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col col-md-12 mb-2">
                                <label class="fw-bold">{{ __('Subject') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="{{ __('Email subject') }}"
                                    name="subject" required />
                            </div>
                            <div class="col col-md-12">
                                <label class="fw-bold">{{ __('Message') }} <span class="text-danger">*</span></label>
                                <textarea name="message" rows="10" class="form-control" placeholder="{{ __('Your message') }}"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col col-md-12 text-center">
                                <button type="submit" class="btn mt-2 btn-primary me-2">{{ __('Send Email') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('page-script')
    <script src="//js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
    <script type="text/javascript">
        bkLib.onDomLoaded(nicEditors.allTextAreas);
    </script>
@endsection
