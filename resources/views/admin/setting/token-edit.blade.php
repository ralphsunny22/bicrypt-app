@extends('layouts.app')

@section('content')
    <form action="{{ route('admin.tokens.update', $token->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="_method" value="PUT">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ __('Update API Token') }}</h4>
                <h6 class="card-subtitle text-muted">
                    {{ __('API tokens allow third-party services to authenticate with our application on your behalf.') }}
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-1">
                    <x-jet-label for="name" class="form-label" value="{{ __('Token Name') }}" />
                    <input class="form-control" type="text" name="name" value="{{ $token->name }}" autofocus>
                </div>

                <!-- Token Permissions -->
                @if (Laravel\Jetstream\Jetstream::hasPermissions())
                    <div>
                        <x-jet-label class="form-label" for="permissions" value="{{ __('Permissions') }}" />

                        <div class="mt-2 row">
                            @foreach (Laravel\Jetstream\Jetstream::$permissions as $permission)
                                <div class="col-6">
                                    <div class="mb-1">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="{{ $permission }}"
                                                name="abilities[]" @if (in_array($permission, json_decode($token->abilities, true))) checked @endif>
                                            <label class="form-check-label" for="{{ 'create-' . $permission }}">
                                                {{ $permission }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
            <div class="card-footer text-end">
                <button type="submit" class="btn btn-success">{{ __('Update') }}</button>
            </div>
        </div>
    </form>
@endsection
@push('breadcrumb-plugins')
    <a href="{{ route('admin.tokens.index') }}" class="btn btn-primary"><i class="bi bi-chevron-left"></i>
        {{ __('Back') }}</a>
@endpush
