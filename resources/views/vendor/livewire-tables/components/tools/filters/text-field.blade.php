<div class="mb-1 mb-md-0 input-group">
    <input wire:model.stop="{{ $component->getTableName() }}.filters.{{ $filter->getKey() }}"
        wire:key="{{ $component->getTableName() }}-filter-{{ $filter->getKey() }}"
        id="{{ $component->getTableName() }}-filter-{{ $filter->getKey() }}" type="text"
        @if ($filter->hasConfig('placeholder')) placeholder="{{ $filter->getConfig('placeholder') }}" @endif
        @if ($filter->hasConfig('maxlength')) maxlength="{{ $filter->getConfig('maxlength') }}" @endif
        class="form-control" />
</div>
