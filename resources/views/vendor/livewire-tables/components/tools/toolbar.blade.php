@aware(['component'])

@if ($component->hasConfigurableAreaFor('before-toolbar'))
    @include($component->getConfigurableAreaFor('before-toolbar'),
        $component->getParametersForConfigurableArea('before-toolbar'))
@endif

<div class="d-md-flex justify-content-between mb-1">
    <div class="d-md-flex">
        @if ($component->hasConfigurableAreaFor('toolbar-left-start'))
            @include($component->getConfigurableAreaFor('toolbar-left-start'),
                $component->getParametersForConfigurableArea('toolbar-left-start'))
        @endif

        @if ($component->reorderIsEnabled())
            <div class="me-0 me-md-2 mb-1 mb-md-0">
                <button
                    wire:click="{{ $component->currentlyReorderingIsEnabled() ? 'disableReordering' : 'enableReordering' }}"
                    type="button" class="btn btn-default d-block w-100 d-md-inline">
                    @if ($component->currentlyReorderingIsEnabled())
                        @lang('Done Reordering')
                    @else
                        @lang('Reorder')
                    @endif
                </button>
            </div>
        @endif

        @if ($component->searchIsEnabled() && $component->searchVisibilityIsEnabled())
            <div class="mb-1 mb-md-0 input-group">
                <input wire:model{{ $component->getSearchOptions() }}="{{ $component->getTableName() }}.search"
                    placeholder="{{ __('Search') }}" type="text" class="form-control">
                <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
                @if ($component->hasSearch())
                    <button wire:click.prevent="clearSearch" class="btn btn-outline-secondary" type="button">
                        <svg style="width:.75em;height:.75em" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                @endif
            </div>
        @endif

        @if ($component->filtersAreEnabled() &&
            $component->filtersVisibilityIsEnabled() &&
            $component->hasVisibleFilters())
            <div class="{{ $component->searchIsEnabled() ? 'ms-0 ms-md-2' : '' }} mb-1 mb-md-0">
                <div @if ($component->isFilterLayoutPopover()) x-data="{ open: false }"
                            x-on:keydown.escape.stop="open = false"
                            x-on:mousedown.away="open = false" @endif
                    class="btn-group d-block d-md-inline">
                    <div>
                        <button type="button" class="btn btn-outline-primary dropdown-toggle d-block w-100 d-md-inline"
                            @if ($component->isFilterLayoutPopover()) x-on:click="open = !open"
                                    aria-haspopup="true"
                                    x-bind:aria-expanded="open"
                                    aria-expanded="true" @endif
                            @if ($component->isFilterLayoutSlideDown()) x-on:click="filtersOpen = !filtersOpen" @endif>
                            @lang('Filters')

                            @if ($count = $component->getFilterBadgeCount())
                                <span class="badge bg-info">
                                    {{ $count }}
                                </span>
                            @endif

                            <span class="caret"></span>
                        </button>
                    </div>

                    @if ($component->isFilterLayoutPopover())
                        <ul x-cloak class="dropdown-menu w-100" x-bind:class="{ 'show': open }" role="menu">
                            @foreach ($component->getFilters() as $filter)
                                @if ($filter->isVisibleInMenus())
                                    <div wire:key="{{ $component->getTableName() }}-filter-{{ $filter->getKey() }}"
                                        class="p-2">
                                        <label for="{{ $component->getTableName() }}-filter-{{ $filter->getKey() }}"
                                            class="mb-2">
                                            {{ $filter->getName() }}
                                        </label>

                                        {{ $filter->render($component) }}
                                    </div>
                                @endif
                            @endforeach

                            @if ($component->hasAppliedVisibleFiltersWithValuesThatCanBeCleared())
                                <div class="dropdown-divider"></div>

                                <button wire:click.prevent="setFilterDefaults" x-on:click="open = false"
                                    class="dropdown-item text-center">
                                    @lang('Clear')
                                </button>
                            @endif
                        </ul>
                    @endif
                </div>
            </div>
        @endif

        @if ($component->hasConfigurableAreaFor('toolbar-left-end'))
            @include($component->getConfigurableAreaFor('toolbar-left-end'),
                $component->getParametersForConfigurableArea('toolbar-left-end'))
        @endif
    </div>

    <div class="d-md-flex">
        @if ($component->hasConfigurableAreaFor('toolbar-right-start'))
            @include($component->getConfigurableAreaFor('toolbar-right-start'),
                $component->getParametersForConfigurableArea('toolbar-right-start'))
        @endif

        @if ($component->showBulkActionsDropdown())
            <div class="mb-1 mb-md-0">
                <div class="dropdown d-block d-md-inline">
                    <button class="btn btn-outline-secondary  dropdown-toggle d-block w-100 d-md-inline" type="button"
                        id="{{ $component->getTableName() }}-bulkActionsDropdown" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        @lang('Bulk Actions')
                    </button>

                    <div class="dropdown-menu dropdown-menu-end w-100"
                        aria-labelledby="{{ $component->getTableName() }}-bulkActionsDropdown">
                        @foreach ($component->getBulkActions() as $key => $action)
                            <a href="#" wire:click.prevent="{{ $key }}"
                                wire:key="bulk-action-{{ $key }}-{{ $component->getTableName() }}"
                                class="dropdown-item d-flex align-items-center">
                                <i class="bi bi-{{ $action['icon'] }} me-50"></i>{{ $action['title'] }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        @if ($component->columnSelectIsEnabled())
            <div class="mb-1 mb-md-0 md-0 ms-md-2">
                <div x-data="{ open: false }" x-on:keydown.escape.stop="open = false" x-on:mousedown.away="open = false"
                    class="dropdown d-block d-md-inline"
                    wire:key="column-select-button-{{ $component->getTableName() }}">
                    <button x-on:click="open = !open"
                        class="btn btn-outline-primary dropdown-toggle d-block w-100 d-md-inline" type="button"
                        id="columnSelect-{{ $component->getTableName() }}" aria-haspopup="true"
                        x-bind:aria-expanded="open">
                        @lang('Columns')
                    </button>

                    <div class="dropdown-menu dropdown-menu-end w-100" x-bind:class="{ 'show': open }"
                        aria-labelledby="columnSelect-{{ $component->getTableName() }}">
                        <div>
                            <label wire:loading.attr="disabled" class="px-2 mb-1">
                                <input
                                    @if ($component->allDefaultVisibleColumnsAreSelected()) checked
                                            wire:click="deselectAllColumns"
                                        @else
                                            unchecked
                                            wire:click="selectAllColumns" @endif
                                    wire:loading.attr="disabled" type="checkbox" />
                                <span class="ml-2">{{ __('All Columns') }}</span>
                            </label>
                        </div>
                        @foreach ($component->getColumns() as $column)
                            @if ($column->isVisible() && $column->isSelectable())
                                <div wire:key="columnSelect-{{ $loop->index }}-{{ $component->getTableName() }}">
                                    <label wire:loading.attr="disabled" wire:target="selectedColumns"
                                        class="px-2 {{ $loop->last ? 'mb-0' : 'mb-1' }}">
                                        <input wire:model="selectedColumns" wire:target="selectedColumns"
                                            wire:loading.attr="disabled" type="checkbox"
                                            value="{{ $column->getSlug() }}" />
                                        <span class="ml-2">{{ $column->getTitle() }}</span>
                                    </label>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        @if ($component->paginationIsEnabled() && $component->perPageVisibilityIsEnabled())
            <div class="ms-0 ms-md-2">
                <select wire:model="perPage" id="perPage" class="form-control">
                    @foreach ($component->getPerPageAccepted() as $item)
                        <option value="{{ $item }}"
                            wire:key="per-page-{{ $item }}-{{ $component->getTableName() }}">
                            {{ $item === -1 ? __('All') : $item }}</option>
                    @endforeach
                </select>
            </div>
        @endif

        @if ($component->hasConfigurableAreaFor('toolbar-right-end'))
            @include($component->getConfigurableAreaFor('toolbar-right-end'),
                $component->getParametersForConfigurableArea('toolbar-righ-end'))
        @endif
    </div>
</div>

@if ($component->filtersAreEnabled() &&
    $component->filtersVisibilityIsEnabled() &&
    $component->hasVisibleFilters() &&
    $component->isFilterLayoutSlideDown())
    <div x-cloak x-show="filtersOpen">
        <div class="container">
            <div class="row">
                @foreach ($component->getFilters() as $filter)
                    @if ($filter->isVisibleInMenus())
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-1">
                            <label for="{{ $component->getTableName() }}-filter-{{ $filter->getKey() }}"
                                class="d-block">
                                {{ $filter->getName() }}
                            </label>

                            {{ $filter->render($component) }}
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endif

@if ($component->hasConfigurableAreaFor('after-toolbar'))
    @include($component->getConfigurableAreaFor('after-toolbar'),
        $component->getParametersForConfigurableArea('after-toolbar'))
@endif
