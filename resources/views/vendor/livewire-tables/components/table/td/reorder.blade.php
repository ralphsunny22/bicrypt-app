@aware(['component'])

@if ($this->currentlyReorderingIsEnabled())
    <x-livewire-tables::table.td.plain wire:sortable.handle>
        <svg xmlns="http://www.w3.org/2000/svg" class="d-inline" style="width:1em;height:1em;" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </x-livewire-tables::table.td.plain>
@endif
