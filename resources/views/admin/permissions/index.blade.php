@extends('layouts.app')

@section('content')
    <div class="row" id="table-hover-row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">{{ __('Permissions List') }}</h4>
                    <div class="card-search"></div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover custom-data-bs-table">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">{{ __('Title') }}</th>
                                <th scope="col">{{ __('Code') }}</th>
                                <th scope="col">{{ __('Type') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permissions as $permission)
                                <tr>
                                    <td data-label="{{ __('Title') }}">{{ $permission->title }}</td>
                                    <td data-label="{{ __('Code') }}">{{ $permission->code }}</td>
                                    <td data-label="{{ __('Type') }}">
                                        @if ($permission->tab == 'system')
                                            <span class="badge rounded-pill badge-light-danger">{{ __('System') }}</span>
                                        @elseif($permission->tab == 'addons')
                                            <span class="badge rounded-pill badge-light-warning">{{ __('Addons') }}</span>
                                        @elseif($permission->tab == 'users')
                                            <span class="badge rounded-pill badge-light-success">{{ __('Users') }}</span>
                                        @elseif($permission->tab == 'logs')
                                            <span class="badge rounded-pill badge-light-info">{{ __('Logs') }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table><!-- table end -->
                </div>
            </div><!-- card end -->

        </div>


    </div>
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('admin.roles.index') }}" class="btn btn-primary btn-sm"><i class="bi bi-chevron-left"></i>
        {{ __('Back') }}</a>
@endpush
