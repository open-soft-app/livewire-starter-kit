<div>
    <x-card shadowless bordered>
        <div class="mb-4">
            <livewire:permissions.create @created="$refresh" />
        </div>

        <x-table :$headers :$sort :rows="$this->rows" paginate filter loading :quantity="[2, 5, 15, 25]">
            @interact('column_created_at', $row)
            {{ $row->created_at->diffForHumans() }}
            @endinteract

            @interact('column_action', $row)
            <div class="flex gap-1">
                <x-button.circle icon="pencil" wire:click="$dispatch('load::permission', { 'permission' : '{{ $row->id }}'})" />
                <livewire:permissions.delete :permission="$row" :key="uniqid('', true)" @deleted="$refresh" />
            </div>
            @endinteract
        </x-table>
    </x-card>

    <livewire:permissions.update @updated="$refresh" />
</div>
