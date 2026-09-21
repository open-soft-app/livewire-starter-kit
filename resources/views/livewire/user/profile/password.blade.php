<div>
    <form id="update-password" wire:submit="save" class="space-y-2">
        <div class="grid gap-4 sm:grid-cols-3">
            <x-password label="{{ __('profile.password.current_password') }} *"
                        wire:model="current_password"
                        autocomplete="current-password"
                        required />

            <x-password label="{{ __('profile.password.new_password') }} *"
                        wire:model="password"
                        rules
                        generator="password_confirmation"
                        autocomplete="new-password"
                        required />

            <x-password label="{{ __('profile.password.confirm_password') }} *"
                        wire:model="password_confirmation"
                        autocomplete="new-password"
                        required />
        </div>
    </form>

    <div class="mt-6 flex justify-end">
        <x-button submit form="update-password" :text="__('profile.password.save')" loading="save" round />
    </div>
</div>
