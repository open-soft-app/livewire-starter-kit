<div>
    <x-card shadowless bordered>
        <div class="mb-4">
            <livewire:users.create @created="$refresh" />
        </div>

        <x-table :$headers :$sort :rows="$this->rows" paginate filter loading :quantity="[10, 15, 25]">
            @interact('column_roles', $row)
            <div class="flex flex-wrap gap-1">
                @forelse ($row->roles as $role)
                    <x-badge :text="$role->name" sm round color="secondary" />
                @empty
                    <span class="text-gray-500 dark:text-gray-400">&mdash;</span>
                @endforelse
            </div>
            @endinteract

            @interact('column_created_at', $row)
            {{ $row->created_at->diffForHumans() }}
            @endinteract

            @interact('column_action', $row)
            <div class="flex gap-1">
                <x-button.circle icon="pencil" wire:click="$dispatch('load::user', { 'user' : '{{ $row->id }}'})" />
                <livewire:users.delete :user="$row" :key="uniqid('', true)" @deleted="$refresh" />
            </div>
            @endinteract
        </x-table>
    </x-card>

    <livewire:users.update @updated="$refresh" />
</div>
