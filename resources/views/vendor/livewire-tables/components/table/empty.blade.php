@aware(['component'])

@php
    $attributes = $attributes->merge(['wire:key' => 'empty-message-' . $component->id]);
@endphp

<tr {{ $attributes }}>
    <td colspan="{{ $component->getColspanCount() }}">
        {{ $component->getEmptyMessage() }}
    </td>
</tr>
