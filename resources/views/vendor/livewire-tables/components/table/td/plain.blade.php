@aware(['component'])
@props(['column' => null, 'customAttributes' => []])


<td
    {{ $attributes->merge($customAttributes)->class(['' => $customAttributes['default'] ?? true])->class(['none d-sm-table-cell' => $column && $column->shouldCollapseOnMobile()])->class(['none d-md-table-cell' => $column && $column->shouldCollapseOnTablet()])->except('default') }}>
    {{ $slot }}</td>
