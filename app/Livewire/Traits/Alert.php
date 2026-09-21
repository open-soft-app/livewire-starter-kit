<?php

declare(strict_types=1);

namespace App\Livewire\Traits;

use TallStackUi\Interactions\Dialog;
use TallStackUi\Traits\Interactions;

trait Alert
{
    use Interactions;

    public function success(?string $description = null, ?string $title = null): void
    {
        $this->dialog()
            ->success($title ?? __('dialog.success.title'), $description ?? __('dialog.success.description'))
            ->send();
    }

    public function error(?string $description = null, ?string $title = null): void
    {
        $this->dialog()
            ->error($title ?? __('dialog.error.title'), $description ?? __('dialog.error.description'))
            ->send();
    }

    public function warning(?string $description = null, ?string $title = null): void
    {
        $this->dialog()
            ->warning($title ?? __('dialog.warning.title'), $description ?? __('dialog.warning.description'))
            ->send();
    }

    public function info(?string $description = null, ?string $title = null): void
    {
        $this->dialog()
            ->info($title ?? __('dialog.info.title'), $description ?? __('dialog.info.description'))
            ->send();
    }

    public function question(?string $description = null, ?string $title = null): Dialog
    {
        return $this->dialog()->question($title ?? __('dialog.question.title'), $description ?? __('dialog.question.description'));
    }
}
