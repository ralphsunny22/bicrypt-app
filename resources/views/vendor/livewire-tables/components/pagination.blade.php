@aware(['component'])
@props(['rows'])

@if ($component->hasConfigurableAreaFor('before-pagination'))
    @include($component->getConfigurableAreaFor('before-pagination'),
        $component->getParametersForConfigurableArea('before-pagination'))
@endif

<div>
    @if ($component->paginationVisibilityIsEnabled())
        @if ($component->paginationIsEnabled() && $rows->lastPage() > 1)
            <div class="row mt-2">
                <div class="col-12 col-md-6 overflow-auto">
                    {{ $rows->links('livewire-tables::specific.bootstrap-4.pagination') }}
                </div>

                <div class="col-12 col-md-6 text-center text-md-end text-muted">
                    <span>@lang('Showing')</span>
                    <strong>{{ $rows->count() ? $rows->firstItem() : 0 }}</strong>
                    <span>@lang('to')</span>
                    <strong>{{ $rows->count() ? $rows->lastItem() : 0 }}</strong>
                    <span>@lang('of')</span>
                    <strong>{{ $rows->total() }}</strong>
                    <span>@lang('results')</span>
                </div>
            </div>
        @else
            <div class="row mt-3">
                <div class="col-12 text-muted">
                    @lang('Showing')
                    <strong>{{ $rows->count() }}</strong>
                    @lang('results')
                </div>
            </div>
        @endif
    @endif
</div>

@if ($component->hasConfigurableAreaFor('after-pagination'))
    @include($component->getConfigurableAreaFor('after-pagination'),
        $component->getParametersForConfigurableArea('after-pagination'))
@endif
