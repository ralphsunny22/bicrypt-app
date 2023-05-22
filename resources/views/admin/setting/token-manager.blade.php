@extends('layouts.app')

@section('content')
    <form action="{{ route('admin.tokens.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ __('Create API Token') }}</h4>
                <h6 class="card-subtitle text-muted">
                    {{ __('API tokens allow third-party services to authenticate with our application on your behalf.') }}
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-1">
                    <x-jet-label for="name" class="form-label" value="{{ __('Token Name') }}" />
                    <input class="form-control" type="text" name="name" value="{{ old('name') }}" autofocus>
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
                                                name="abilities[]">
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
                <button type="submit" class="btn btn-success">{{ __('Create') }}</button>
            </div>
        </div>
    </form>

    <!-- Manage API Tokens -->
    <div>
        <x-jet-action-section>
            <x-slot name="title">
                {{ __('Manage API Tokens') }}
            </x-slot>

            <x-slot name="description">
                {{ __('You may delete any of your existing tokens if they are no longer needed.') }}
            </x-slot>

            <!-- API Token List -->
            <x-slot name="content">
                <div>
                    @foreach ($tokens->sortBy('name') as $token)
                        <div class="d-flex justify-content-between">
                            <div class="fw-bolder">
                                {{ $token->name }}
                            </div>

                            <div class="fw-bolder">
                                {{ $token->token }}
                            </div>

                            <div class="d-flex">
                                <a href="{{ route('admin.tokens.edit', $token->id) }}">
                                    <button class="btn btn-warning ">
                                        {{ __('Edit') }}
                                    </button>
                                </a>

                                <form action="{{ route('admin.tokens.destroy', $token->id) }}" method="POST">
                                    @csrf

                                    @method('DELETE')

                                    <button type="submit"
                                        class="btn btn-danger btn-block ms-1">{{ __('Delete') }}</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </x-slot>
        </x-jet-action-section>
    </div>
@endsection
