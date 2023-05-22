@aware(['component'])
@props(['customAttributes' => []])

<tr
    {{ $attributes->merge($customAttributes)->class(['' => $customAttributes['default'] ?? true])->except('default') }}>
    {{ $slot }}
</tr>
