<div>
    <x-card shadowless bordered>
        <div class="mb-4">
            <livewire:roles.create @created="$refresh" />
        </div>

        <div class="mb-4 grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-4">
            <div class="lg:col-span-2">
                <x-input wire:model.live.debounce.300ms="search" :placeholder="__('app.roles.search')" icon="magnifying-glass" clearable />
            </div>
            <x-select.native wire:model.live="sort.column" :options="[
                ['label' => __('app.roles.created'), 'value' => 'created_at'],
                ['label' => '#', 'value' => 'id'],
                ['label' => __('app.roles.name'), 'value' => 'name'],
            ]" select="label:label|value:value" />
            <x-select.native wire:model.live="sort.direction" :options="[
                ['label' => __('app.descending'), 'value' => 'desc'],
                ['label' => __('app.ascending'), 'value' => 'asc'],
            ]" select="label:label|value:value" />
        </div>

        <div wire:loading.class="opacity-50" class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">
            @forelse ($this->rows as $row)
                <x-card wire:key="role-{{ $row->id }}" bordered color="primary" light>
                    <x-slot:header>
                        <div class="flex w-full items-center justify-between gap-2">
                            <span class="font-semibold">#{{ $row->id }} &middot; {{ $row->name }}</span>
                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ $row->created_at->diffForHumans() }}</span>
                        </div>
                    </x-slot:header>

                    <dl class="space-y-2 text-sm">
                        <div>
                            <dt class="mb-1 flex items-center justify-between gap-2 text-xs uppercase text-gray-500 dark:text-gray-400">
                                <span>{{ __('app.roles.permissions') }} ({{ $row->permissions->count() }})</span>
                                <x-button.circle icon="pencil-square" sm wire:click="$dispatch('load::role-permissions', { 'role' : '{{ $row->id }}'})" />
                            </dt>
                            <dd class="flex max-h-32 flex-wrap gap-1 overflow-y-auto">
                                @forelse ($row->permissions as $permission)
                                    <x-badge :text="$permission->name" xs round color="secondary" />
                                @empty
                                    <span class="text-gray-500 dark:text-gray-400">{{ __('app.roles.no_permissions') }}</span>
                                @endforelse
                            </dd>
                        </div>
                    </dl>

                    <x-slot:footer>
                        <div class="flex gap-1">
                            <x-button.circle icon="pencil" wire:click="$dispatch('load::role', { 'role' : '{{ $row->id }}'})" />
                            <livewire:roles.delete :role="$row" :key="uniqid('', true)" @deleted="$refresh" />
                        </div>
                    </x-slot:footer>
                </x-card>
            @empty
                <p class="col-span-full py-8 text-center text-gray-500 dark:text-gray-400">{{ __('app.roles.no_records') }}</p>
            @endforelse
        </div>

        <div class="mt-4 flex flex-col items-center justify-between gap-3 sm:flex-row">
            <x-select.native wire:model.live="quantity" :options="[6, 15, 25]" />
            <div class="w-full sm:w-auto">
                {{ $this->rows->links() }}
            </div>
        </div>
    </x-card>

    <livewire:roles.update @updated="$refresh" />
    <livewire:roles.manage-permissions @updated="$refresh" />
</div>
