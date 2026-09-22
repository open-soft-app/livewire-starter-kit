<x-guest-layout>
    <x-card shadowless bordered :header="__('Create your account')">
        <form id="register" method="POST" action="{{ route('register.store') }}" class="space-y-4">
            @csrf

            <x-input label="{{ __('Name') }} *"
                     name="name"
                     :value="old('name')"
                     required
                     autofocus
                     autocomplete="username" />

            <div class="grid gap-4 sm:grid-cols-2">
                <x-input label="{{ __('First Name') }} *"
                         name="first_name"
                         :value="old('first_name')"
                         required
                         autocomplete="given-name" />

                <x-input label="{{ __('Last Name') }} *"
                         name="last_name"
                         :value="old('last_name')"
                         required
                         autocomplete="family-name" />
            </div>

            <x-input label="{{ __('Email') }} *"
                     type="email"
                     name="email"
                     :value="old('email')"
                     required
                     autocomplete="username" />

            <x-password label="{{ __('Password') }} *"
                        name="password"
                        required
                        rules
                        generator="password_confirmation"
                        autocomplete="new-password" />

            <x-password label="{{ __('Confirm Password') }} *"
                        name="password_confirmation"
                        required
                        autocomplete="new-password" />
        </form>

        <x-slot:footer>
            <div class="flex w-full flex-col gap-y-2">
                <x-button submit form="register" :text="__('Register')" block round />

                <span class="text-center text-sm text-gray-600">
                    {{ __('Already have an account?') }}
                    <x-link :href="route('login')" :text="__('Log in!')" sm bold />
                </span>
            </div>
        </x-slot:footer>
    </x-card>
</x-guest-layout>
