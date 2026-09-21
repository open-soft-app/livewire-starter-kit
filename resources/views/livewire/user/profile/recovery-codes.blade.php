<div>
    <x-modal id="recovery-codes" :title="__('profile.recovery_codes.title')">
        <p class="mb-4 text-sm text-gray-600 dark:text-gray-400">
            {{ __('profile.recovery_codes.description') }}
        </p>

        <div class="grid grid-cols-1 gap-2 sm:grid-cols-2">
            @foreach ($this->recoveryCodes as $code)
                <x-kbd shadowless>
                    {{ $code }}
                </x-kbd>
            @endforeach
        </div>

        <x-slot:footer>
            <div class="flex justify-between items-center w-full">
                <div class="flex flex-wrap gap-2">
                    <x-button :text="__('profile.recovery_codes.refresh')"
                              round
                              color="secondary"
                              sm
                              wire:click="regenerate"
                              loading="regenerate"/>

                    <x-button :text="__('profile.recovery_codes.download')"
                              round
                              color="secondary"
                              sm
                              wire:click="download"
                              loading="download"/>
                </div>
                <x-button :text="__('profile.recovery_codes.close')"
                          round
                          x-on:click="$tsui.close.modal('recovery-codes')"/>
            </div>
        </x-slot:footer>
    </x-modal>
</div>
