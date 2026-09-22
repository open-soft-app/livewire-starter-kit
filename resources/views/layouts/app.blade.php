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
            <x-layout.header />
        </x-slot:header>
        <x-slot:menu>
            <x-side-bar smart collapsible>
                <x-slot:brand>
                    <div class="my-4 flex items-center justify-center">
                        {{-- <img src="{{ asset('/assets/images/tsui.png') }}" width="40" height="40" /> --}}
                        <x-button.circle lg icon="config('app.logo_icon')" :href="route('welcome')" color="primary" light />
                    </div>
                </x-slot:brand>
                <x-slot:brand-collapsed>
                    <div class="my-4 flex items-center justify-center">
                        {{-- <img src="{{ asset('/assets/images/tsui.png') }}" width="20" height="20" /> --}}
                        <x-button.circle lg icon="config('app.logo_icon')" :href="route('welcome')" color="primary" light />
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
                <x-slot:footer>
                    <div class="bg-primary-500" data-sidebar-footer>
                        <form method="POST" action="{{ route('logout') }}" class="hidden">
                            @csrf
                        </form>
                        <div x-show="railed" x-cloak>
                            <x-dropdown position="right-end" scope="full" hover>
                                <x-slot:action>
                                    <div x-on:click="show = !show"
                                        class="flex w-full cursor-pointer items-center justify-center py-4 text-white hover:bg-primary-600">
                                        <x-icon name="user-circle" class="h-6 w-6" />
                                    </div>
                                </x-slot:action>
                                <x-slot:header>
                                    <div class="space-y-3" x-on:pointerenter="clearTimeout(timeout)" x-on:pointerleave="leave($event)">
                                        <x-theme-switch block />
                                        <x-language-switch />
                                    </div>
                                </x-slot:header>
                                <div x-on:pointerenter="clearTimeout(timeout)" x-on:pointerleave="leave($event)">
                                    <x-dropdown.items :text="__('profile.title')" icon="user" :href="route('user.profile')" />
                                    <x-dropdown.items :text="__('Logout')" icon="arrow-right-start-on-rectangle" separator
                                        onclick="event.preventDefault(); document.querySelector('[data-sidebar-footer] form').submit();" />
                                </div>
                            </x-dropdown>
                        </div>
                        <ul x-show="! railed" class="*:flex *:flex-col-reverse">
                            <x-side-bar.item scope="footer" :text="auth()->user()->name" icon="user-circle">
                                <li class="space-y-3 py-2">
                                    <x-theme-switch block />
                                    <x-language-switch />
                                </li>
                                <x-side-bar.item scope="footer-menu" :text="__('profile.title')" icon="user" :route="route('user.profile')" />
                                <x-side-bar.item scope="footer-menu" :text="__('Logout')" icon="arrow-right-start-on-rectangle" href="#"
                                    onclick="event.preventDefault(); this.closest('[data-sidebar-footer]').querySelector('form').submit();" />
                            </x-side-bar.item>
                        </ul>
                    </div>
                </x-slot:footer>
            </x-side-bar>
        </x-slot:menu>
        {{ $slot }}
    </x-layout>
    @livewireScripts
    </body>
</html>
