@extends('layouts.app')

@section('content')
    <div class="row" id="table-hover-row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">{{ $locale->title }} {{ __('Editor') }}</h4>
                    <div class="card-search"></div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover custom-data-bs-table">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">{{ __('String') }}</th>
                                <th scope="col">{{ __('Translation') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($strings as $key => $item)
                                <tr>
                                    <td class="w-50" data-label="{{ __('String') }}">{{ $key }}
                                    </td>
                                    <td class="w-50" data-label="{{ __('Translation') }}">
                                        <div class="input-group">
                                            <input type="text" class="form-control form-control-sm"
                                                name="{{ $key }}" id="{{ $key }}"
                                                aria-describedby="{{ $key }}" value="{{ $item }}">
                                            <button data-bs-toggle="tooltip" data-bs-placement="top" title="Update"
                                                class="btn btn-success" onclick="updateString('{{ $key }}')"><i
                                                    class="bi bi-arrow-repeat"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table><!-- table end -->
                </div>
            </div><!-- card end -->
        </div>
    </div>
    <div id="new" class="modal fade text-start" tabindex="-1" aria-hidden="true" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('New String') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.locale.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $locale->id }}">
                    <div class="modal-body">
                        <div class="mb-1">
                            <label for="">{{ __('String') }}</label>
                            <input type="text" class="form-control form-control-sm" name="string">
                        </div>
                        <div>
                            <label for="">{{ __('Translation') }}</label>
                            <input type="text" class="form-control form-control-sm" name="translation">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="btn btn-success" data-bs-dismiss="modal">{{ __('Create') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#new" aria-pressed="false"
        autocomplete="off"><i class="bi bi-plus-lg"></i> {{ __('New') }}</button>
    <a href="{{ route('admin.locale.index') }}" class="btn btn-primary"><i class="bi bi-chevron-left"></i>
        {{ __('Back') }}</a>
@endpush

@push('script')
    <script>
        "use strict";

        function updateString(key) {
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                },
                url: "{{ route('admin.locale.update', $locale->id) }}",
                method: "PUT",
                data: {
                    key: key,
                    value: $('#' + key).val()
                },
                success: function(response) {
                    notify(response.type, response.message)
                },
                error: function(response) {
                    notify(response.type, response.message)
                }
            });
        }
    </script>
@endpush
