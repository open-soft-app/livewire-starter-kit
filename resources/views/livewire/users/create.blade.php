<div>
    <x-button :text="__('app.users.create_new')" wire:click="$toggle('modal')" round />

    <x-modal :title="__('app.users.create_new')" wire x-on:open="$tsui.focus('name')">
        <form id="user-create" wire:submit="save" class="space-y-4">
            <div>
                <x-input label="{{ __('app.users.name') }} *"
                        x-ref="name"
                        wire:model="user.name"
                        required />
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <x-input label="{{ __('app.users.first_name') }} *"
                        wire:model="user.first_name"
                        required />

                <x-input label="{{ __('app.users.last_name') }} *"
                        wire:model="user.last_name"
                        required />
            </div>

            <div>
                <x-input label="{{ __('app.users.email') }} *"
                        wire:model="user.email"
                        required />
            </div>

            <div>
                <x-password label="{{ __('app.users.password') }} *"
                            wire:model="password"
                            rules
                            generator="password_confirmation"
                            required />
            </div>

            <div>
                <x-password label="{{ __('app.users.confirm_password') }} *"
                            wire:model="password_confirmation"
                            rules
                            required />
            </div>

            <div>
                <x-select.styled label="{{ __('app.users.roles') }}"
                                wire:model="selectedRoles"
                                :options="$this->availableRoles"
                                select="label:name|value:id"
                                multiple
                                searchable />
            </div>
        </form>
        <x-slot:footer>
            <x-button submit form="user-create" :text="__('app.users.save')" loading="save" round />
        </x-slot:footer>
    </x-modal>
</div>
