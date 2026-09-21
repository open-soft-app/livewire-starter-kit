<div>
    @if($modal)
    <x-modal :title="__('app.roles.manage_permissions', ['name' => $role?->name])" wire size="lg">
        <div class="space-y-4">
            @if($allPermissions->isEmpty())
                <x-card shadowless bordered>
                    <p class="text-center text-gray-500">{{ __('app.roles.no_permissions') }}</p>
                </x-card>
            @else
                <div class="flex justify-end">
                    <x-button
                        :text="__('app.roles.select_all_permissions')"
                        icon="check-circle"
                        wire:click="selectAllPermissions"
                        loading="selectAllPermissions"
                        color="primary"
                        outline
                        sm
                        round
                    />
                </div>

                <x-select.styled
                    :label="__('app.roles.permissions')"
                    wire:model="selectedPermissions"
                    :options="$allPermissions->map(fn ($permission) => ['label' => $permission->name, 'value' => $permission->id])->all()"
                    select="label:label|value:value"
                    multiple
                    searchable
                />
            @endif
        </div>

        <x-slot:footer>
            <div class="flex gap-2 justify-end">
                <x-button
                    :text="__('app.roles.cancel')"
                    secondary
                    wire:click="closeModal"
                    round
                />
                <x-button
                    :text="__('app.roles.save')"
                    wire:click="save"
                    loading="save"
                    round
                />
            </div>
        </x-slot:footer>
    </x-modal>
    @endif
</div>
