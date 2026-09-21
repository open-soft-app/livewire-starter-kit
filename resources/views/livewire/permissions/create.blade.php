<div>
    <x-button :text="__('app.permissions.create_new')" wire:click="$toggle('modal')" round />

    <x-modal :title="__('app.permissions.create_new')" wire x-on:open="$tsui.focus('name')">
        <form id="permission-create" wire:submit="save" class="space-y-4">
            <div>
                <x-input label="{{ __('app.permissions.name') }} *"
                         x-ref="name"
                         wire:model="permission.name"
                         required />
            </div>
        </form>
        <x-slot:footer>
            <x-button submit form="permission-create" :text="__('app.permissions.save')" loading="save" round />
        </x-slot:footer>
    </x-modal>
</div>
