@extends('layouts.app')

@section('content')
    <div class="row" id="table-hover-row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">{{ __('Locales') }}</h4>
                    <div class="card-search"></div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover custom-data-bs-table">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">{{ __('Locale') }}</th>
                                <th scope="col">{{ __('Code') }}</th>
                                <th scope="col">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($locales as $locale)
                                <tr>
                                    <td data-label="{{ __('Locale') }}">{{ $locale->title }}
                                    </td>
                                    <td data-label="{{ __('Code') }}">
                                        {{ strtoupper($locale->code) }}
                                    </td>
                                    <td data-label="{{ __('Action') }}">
                                        <a href="{{ route('admin.locale.edit', $locale->id) }}"
                                            class="btn btn-primary btn-sm">
                                            {{ __('Edit') }}
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($empty_message) }}</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table><!-- table end -->
                </div>
            </div><!-- card end -->
        </div>
    </div>
@endsection
