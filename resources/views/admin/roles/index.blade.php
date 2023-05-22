@extends('layouts.app')

@section('page-style')
    <!-- Page css files -->
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
@endsection

@section('content')
    <h3>{{ __('Roles List') }}</h3>
    <p class="mb-2">
        {{ __('A role provided access to predefined menus and features so that depending') }} <br />
        {{ __('on assigned role an administrator can have access to what he need') }}
    </p>

    <!-- Role cards -->
    <div class="row">
        @foreach ($roles as $role)
            <div class="col-xl-4 col-lg-6 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <span>{{ __('Total') }} {{ $role->users->count() }} {{ __('users') }}</span>
                            @if ($role->users->count() > 0)
                                <ul class="list-unstyled d-flex align-items-center avatar-group mb-0">
                                    @foreach ($role->users as $user)
                                        <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                            title="{{ $user->username }}" class="avatar avatar-sm pull-up">
                                            <img class="rounded-circle"
                                                src="{{ getImage(imagePath()['profileImage']['path'] . '/' . $user->profile_photo_path, imagePath()['profileImage']['size']) }}"
                                                alt="Avatar" />
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                        <div class="d-flex justify-content-between align-items-end mt-1 pt-25">
                            <div class="role-heading">
                                <h4 class="fw-bolder">{{ $role->title }}</h4>
                                <a href="{{ route('admin.roles.edit', $role->id) }}" class="role-edit-modal">
                                    <small class="fw-bolder">{{ __('Edit Role') }}</small>
                                </a>
                            </div>
                            <a href="javascript:void(0);" class="text-body"><i data-feather="copy"
                                    class="font-medium-5"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="col-xl-4 col-lg-6 col-md-6">
            <div class="card">
                <div class="row">
                    <div class="col-sm-5">
                        <div class="d-flex align-items-end justify-content-center h-100">
                            <img src="{{ asset('images/illustration/faq-illustrations.svg') }}" class="img-fluid mt-2"
                                alt="Image" width="85" />
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <div class="card-body text-sm-end text-center ps-sm-0">
                            <a href="{{ route('admin.roles.create') }}" class="stretched-link text-nowrap add-new-role">
                                <span class="btn btn-primary mb-1">{{ __('Add New Role') }}</span>
                            </a>
                            <p class="mb-0">{{ __('Add role, if it does not exist') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Role cards -->

    <h3 class="mt-50">{{ __('Total users with their roles') }}</h3>
    <p class="mb-2">{{ __('Find all of your company’s administrator accounts and their associate roles.') }}</p>

    <livewire:user-role-table />

    <div class="modal fade" id="assignRole" tabindex="-1" aria-labelledby="newWallet" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <h5 class="modal-title">{{ __('Create New Wallet') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="add-new-record modal-content pt-0" autocomplete="off" method="POST"
                    action="{{ route('admin.roles.assign') }}">
                    @csrf
                    <div class="modal-body pb-3 px-sm-3">
                        <input type="hidden" name="id">

                        <label class="form-control-label h6">{{ __('Role') }}</label>
                        <select class="form-select" id="role_id" name="role_id">
                            <option value="" disabled="" selected>
                                {{ __('Choose an option') }}
                            </option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">
                                    {{ $role->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer text-end">
                        <button type="submit" class="btn btn-primary me-1">{{ __('Assign') }}</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                            {{ __('Discard') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--/ Add Role Modal -->
@endsection
@push('breadcrumb-plugins')
    <a href="{{ route('admin.permissions.index') }}" class="btn btn-primary btn-sm"><i class="bi bi-chevron-right"></i>
        {{ __('Permissions') }}</a>
@endpush
@push('script')
    <script>
        $(".assign").click(function() {
            $('#assignRole').find('input[name=id]').val($(this).data('id'));
        });
    </script>
@endpush
