<div @updated="$dispatch('name-updated', { name: $event.detail.name, theme: $event.detail.theme, font: $event.detail.font })">
    <x-tab selected="profile" shadowless bordered scroll-on-mobile>
        <x-tab.items tab="profile" :title="__('profile.tabs.profile')">
            <livewire:user.profile.information />
        </x-tab.items>

        <x-tab.items tab="password" :title="__('profile.tabs.password')">
            <livewire:user.profile.password />
        </x-tab.items>

        <x-tab.items tab="two-factor" :title="__('profile.tabs.two_factor')">
            <livewire:user.profile.two-factor-authentication />
        </x-tab.items>
    </x-tab>
</div>
