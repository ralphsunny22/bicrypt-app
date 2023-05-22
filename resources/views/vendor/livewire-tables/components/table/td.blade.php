@aware(['component', 'row', 'rowIndex'])
@props(['column', 'colIndex'])

@php
    $attributes = $attributes->merge(['wire:key' => 'cell-' . $rowIndex . '-' . $colIndex . '-' . $component->id]);
    $customAttributes = $component->getTdAttributes($column, $row, $colIndex, $rowIndex);
@endphp

<td @if ($column->isClickable()) onclick="window.open('{{ $component->getTableRowUrl($row) }}', '{{ $component->getTableRowUrlTarget($row) ?? '_self' }}')"
            style="cursor:pointer" @endif
    {{ $attributes->merge($customAttributes)->class(['' => $customAttributes['default'] ?? true])->class(['d-none d-sm-table-cell' => $column && $column->shouldCollapseOnMobile()])->class(['d-none d-md-table-cell' => $column && $column->shouldCollapseOnTablet()])->except('default') }}>
    {{ $slot }}
</td>
