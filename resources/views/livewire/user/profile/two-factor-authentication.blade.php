<div class="space-y-6">
    @if ($this->enabled)
        <x-alert :text="__('profile.two_factor.enabled_message')" color="green" icon="shield-check" />

        <form id="disable-two-factor" wire:submit="disable" class="space-y-2">
            <x-password label="{{ __('profile.two_factor.current_password') }} *"
                        wire:model="current_password"
                        autocomplete="current-password"
                        required />
        </form>

        <div class="flex flex-wrap items-center justify-end gap-2">
            <x-button :text="__('profile.two_factor.show_codes')"
                      color="primary"
                      round
                      sm
                      x-on:click="$tsui.open.modal('recovery-codes')" />

            <x-button submit form="disable-two-factor" :text="__('profile.two_factor.disable')" color="red" round loading="disable" />
        </div>
    @elseif ($this->pending)
        <x-alert :text="__('profile.two_factor.pending_message')"
                 color="primary"
                 icon="qr-code" />

        <div class="flex flex-col items-center gap-4 sm:flex-row sm:items-start">
            <x-qr-code :link="$this->qrCodeUrl" size="lg" />

            <div class="w-full space-y-4">
                <x-clipboard :text="$this->setupKey" label="{{ __('profile.two_factor.setup_key') }}" secret />

                <form id="confirm-two-factor" wire:submit="confirm" class="space-y-2">
                    <x-pin wire:model="code" label="{{ __('profile.two_factor.code') }} *" :length="6" numbers />
                </form>
            </div>
        </div>

        <div class="flex justify-end items-center gap-2">
            <x-button :text="__('profile.two_factor.cancel')" color="red" round wire:click="cancel" loading="cancel" sm />

            <x-button submit form="confirm-two-factor" :text="__('profile.two_factor.confirm')" round loading="confirm" />
        </div>
    @else
        <p class="text-sm text-dark-600 dark:text-gray-100">
            {{ __('profile.two_factor.description') }}
        </p>

        <form id="enable-two-factor" wire:submit="enable" class="space-y-2">
            <x-password label="{{ __('profile.two_factor.current_password') }} *"
                        wire:model="current_password"
                        autocomplete="current-password"
                        required />
        </form>

        <div class="flex justify-end">
            <x-button submit form="enable-two-factor" :text="__('profile.two_factor.enable')" loading="enable" round />
        </div>
    @endif

    @if ($this->enabled || $this->pending)
        <livewire:user.profile.recovery-codes />
    @endif
</div>
