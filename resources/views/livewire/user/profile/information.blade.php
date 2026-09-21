<div>
    <form id="update-profile" wire:submit="save" class="space-y-2">
        <div class="grid gap-4 sm:grid-cols-2">
            <x-input label="{{ __('profile.information.name') }} *" wire:model="user.name" required />
            
            <x-input label="{{ __('profile.information.email') }}" :value="$user->email" disabled />

            <x-input label="{{ __('profile.information.first_name') }} *" wire:model="user.first_name" required />

            <x-input label="{{ __('profile.information.last_name') }} *" wire:model="user.last_name" required />


            <x-select.styled label="{{ __('profile.information.theme') }} *"
                             wire:model="user.theme"
                             :options="$this->themes"
                             required />

            <x-select.styled label="{{ __('profile.information.font') }} *"
                             wire:model="user.font"
                             :options="$this->fonts"
                             required />
        </div>
    </form>

    @if($this->roles->isNotEmpty())
        <div class="mt-6">
            <label class="block text-sm font-medium text-gray-900 dark:text-white mb-2">
                {{ __('profile.information.assigned_roles') }}
            </label>
            <div class="flex flex-wrap gap-2">
                @foreach($this->roles as $role)
                    <x-badge :text="str($role)->headline()->toString()" color="secondary" sm />
                @endforeach
            </div>
        </div>
    @endif

    <div class="mt-6 flex items-center justify-between">
        <livewire:user.profile.delete />

        <x-button submit form="update-profile" :text="__('profile.information.save')" loading="save" round />
    </div>
</div>
