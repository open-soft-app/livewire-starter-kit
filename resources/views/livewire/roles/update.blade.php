<div>
    <x-modal :title="__('app.roles.update_title', ['id' => $role?->id])" wire>
        <form id="role-update-{{ $role?->id }}" wire:submit="save" class="space-y-4">
            <div>
                <x-input label="{{ __('app.roles.name') }} *"
                         x-ref="name"
                         wire:model="role.name"
                         required />
            </div>
        </form>
        <x-slot:footer>
            <x-button submit form="role-update-{{ $role?->id }}" :text="__('app.roles.save')" loading="save" round />
        </x-slot:footer>
    </x-modal>
</div>
