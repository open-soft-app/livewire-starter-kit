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
    }

    /**
     * In dark mode the sidebar text and icons follow the theme color instead of white.
     */
    private function customizeSideBarDarkText(): void
    {
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
