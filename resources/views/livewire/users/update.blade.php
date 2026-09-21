<div>
    <x-modal :title="__('app.users.update_title', ['id' => $user?->id])" wire>
        <form id="user-update-{{ $user?->id }}" wire:submit="save" class="space-y-4">
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
                            :hint="__('app.users.password_hint')"
                            wire:model="password"
                            rules
                            generator="confirm-password-{{ $user?->id }}" />
            </div>

            <div>
                <x-password label="{{ __('app.users.confirm_password') }} *"
                            id="confirm-password-{{ $user?->id }}"
                            wire:model="password_confirmation"
                            rules />
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
            <x-button submit form="user-update-{{ $user?->id }}" :text="__('app.users.save')" loading="save" round />
        </x-slot:footer>
    </x-modal>
</div>
