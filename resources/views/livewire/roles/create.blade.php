<div>
    <x-button :text="__('app.roles.create_new')" wire:click="$toggle('modal')" round />

    <x-modal :title="__('app.roles.create_new')" wire x-on:open="$tsui.focus('name')">
        <form id="role-create" wire:submit="save" class="space-y-4">
            <div>
                <x-input label="{{ __('app.roles.name') }} *"
                         x-ref="name"
                         wire:model="role.name"
                         required />
            </div>
        </form>
        <x-slot:footer>
            <x-button submit form="role-create" :text="__('app.roles.save')" loading="save" round />
        </x-slot:footer>
    </x-modal>
</div>
