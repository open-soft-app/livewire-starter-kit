<?php

declare(strict_types=1);

namespace App\Providers;

use TallStackUi\Facades\TallStackUi;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->customizeSideBarDarkText();
        $this->customizeSideBarFooter();
    }

    /**
     * The sidebar footer loses its padding, and the sidebar its bottom padding, so a full-width
     * child can make the whole area clickable and sit flush with the bottom of the page.
     */
    private function customizeSideBarFooter(): void
    {
        // Elimina bordo sidebar in basso per fare posto al menu profile
        TallStackUi::customize()
            ->sideBar()
            ->block('desktop.footer')->replace('px-2 pt-3', 'p-0')
            ->block('mobile.footer')->replace('px-2 py-4', 'p-0')
            ->block('desktop.wrapper.second')->replace('pb-4', 'pb-0')
            ->block('mobile.wrapper.fourth')->replace('pb-4', 'pb-0');

        TallStackUi::customize()
            ->sideBar('item', scope: 'footer')
            ->block('group.button', 'flex w-full cursor-pointer items-center px-4 py-4 text-left text-sm font-semibold text-white transition-all hover:bg-primary-600')
            ->block('group.button.collapsed', 'relative justify-center')
            ->block('group.icon.base', 'h-6 w-6 shrink-0 text-white')
            ->block('group.icon.collapse.base', 'ml-auto h-4 w-4 shrink-0 text-white transition-all')
            ->block('group.icon.collapse.rotate', 'rotate-180 text-white')
            ->block('group.group', 'bg-primary-50 px-2 py-2 dark:bg-dark-700')
            ->block('item.state.current', 'bg-primary-700 text-white')
            ->block('item.state.normal', 'text-white hover:bg-primary-600')
            ->block('item.icon', 'h-6 w-6 shrink-0 text-white transition-all');

        TallStackUi::customize('dropdown', scope: 'full')
            ->block('wrapper.first')->append('w-full')
            ->block('wrapper.second')->append('w-full');

        TallStackUi::customize()
            ->themeSwitch()
            ->block('segmented.wrapper')->replace('bg-gray-100', 'bg-white');

        TallStackUi::customize()
            ->sideBar('item', scope: 'footer-menu')
            ->block('item.wrapper.border', 'pl-0')
            ->block('item.state.current', 'bg-primary-100 text-primary-700 dark:bg-dark-600 dark:text-primary-100')
            ->block('item.state.normal', 'text-primary-700 hover:bg-primary-100 dark:text-primary-100 dark:hover:bg-dark-600')
            ->block('item.icon', 'h-6 w-6 shrink-0 text-primary-500 transition-all dark:text-primary-300');
    }

    /**
     * In dark mode the sidebar text and icons follow the theme color instead of white.
     */
    private function customizeSideBarDarkText(): void
    {
        // Personalizzazione colore icone e scritte
        TallStackUi::customize()
            ->sideBar('item')
            ->block('item.state.current')->replace('dark:text-white', 'dark:text-primary-100')
            ->block('item.state.normal')->replace('dark:text-white', 'dark:text-primary-100')
            ->block('item.icon')->replace('dark:text-white', 'dark:text-primary-300')
            ->block('group.button')->replace('dark:text-white', 'dark:text-primary-100')
            ->block('group.icon.base')->replace('dark:text-white', 'dark:text-primary-300')
            ->block('group.icon.collapse.base')->replace('dark:text-white', 'dark:text-primary-300')
            ->block('group.icon.collapse.rotate')->replace('dark:text-white', 'dark:text-primary-300');
    }
}
