<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="tallstackui_darkTheme()"
    data-theme="{{ auth()->user()->theme ?? config('app.theme') }}"
    data-font="{{ auth()->user()->font ?? config('app.font') }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600|poppins:400,500,600|roboto:400,500,600&display=swap" rel="stylesheet" />

        <tallstackui:script />
        @livewireStyles
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased"
        x-cloak
        {{-- x-data="{ name: @js(auth()->user()->name) }" --}}
        x-on:name-updated.window="name = $event.detail.name; document.documentElement.dataset.theme = $event.detail.theme; document.documentElement.dataset.font = $event.detail.font"
        x-bind:class="{ 'dark bg-dark-800': darkTheme, 'bg-white': !darkTheme }">
    <x-layout>
        <x-slot:top>
            <x-dialog />
            <x-toast />
        </x-slot:top>
        <x-slot:header>
            <x-layout.header>
                <x-slot:right>
                    {{-- <x-dropdown icon="ellipsis-vertical" text="ffff"> --}}
                    <x-dropdown>
                        <x-slot:action>
                            <x-button x-on:click="show = !show" round='full' sm outline>{{ auth()->user()->name }}</x-button>
                            {{-- <div>
                                <button class="cursor-pointer" x-on:click="show = !show">
                                    <span class="text-base font-semibold text-primary-500" x-text="`${name}`"></span>
                                </button>
                            </div> --}}
                        </x-slot:action>
                        <x-slot:header>
                            <div class="space-y-3">
                                <x-theme-switch block />
                                <x-language-switch />
                            </div>
                        </x-slot:header>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown.items :text="__('Profile')" :href="route('user.profile')" />
                            <x-dropdown.items :text="__('Logout')" onclick="event.preventDefault(); this.closest('form').submit();" separator />
                        </form>
                    </x-dropdown>
                </x-slot:right>
            </x-layout.header>
        </x-slot:header>
        <x-slot:menu>
            <x-side-bar smart collapsible>
                <x-slot:brand>
                    <div class="my-4 flex items-center justify-center">
                        {{-- <img src="{{ asset('/assets/images/tsui.png') }}" width="40" height="40" /> --}}
                        <x-button.circle lg icon="globe-europe-africa" :href="route('welcome')" color="primary" light />
                    </div>
                </x-slot:brand>
                <x-slot:brand-collapsed>
                    <div class="my-4 flex items-center justify-center">
                        {{-- <img src="{{ asset('/assets/images/tsui.png') }}" width="20" height="20" /> --}}
                        <x-button.circle lg icon="globe-europe-africa" :href="route('welcome')" color="secondary" light />
                    </div>
                </x-slot:brand-collapsed>
                <x-side-bar.item :text="__('app.sidebar.dashboard')" icon="home" :route="route('dashboard')" />
                @role('Admin')
                    <x-side-bar.item :text="__('app.sidebar.users_management')" icon="users">
                        <x-side-bar.item :text="__('app.sidebar.users')" icon="user" :route="route('users.index')" />
                        <x-side-bar.item :text="__('app.sidebar.roles')" icon="shield-check" :route="route('roles.index')" />
                        <x-side-bar.item :text="__('app.sidebar.permissions')" icon="key" :route="route('permissions.index')" />
                    </x-side-bar.item>
                @endrole
            </x-side-bar>
        </x-slot:menu>
        {{ $slot }}
    </x-layout>
    @livewireScripts
    </body>
</html>
