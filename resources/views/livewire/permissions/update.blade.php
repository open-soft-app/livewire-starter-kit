<div>
    <x-modal :title="__('app.permissions.update_title', ['id' => $permission?->id])" wire>
        <form id="permission-update-{{ $permission?->id }}" wire:submit="save" class="space-y-4">
            <div>
                <x-input label="{{ __('app.permissions.name') }} *"
                         x-ref="name"
                         wire:model="permission.name"
                         required />
            </div>
        </form>
        <x-slot:footer>
            <x-button submit form="permission-update-{{ $permission?->id }}" :text="__('app.permissions.save')" loading="save" round />
        </x-slot:footer>
    </x-modal>
</div>
