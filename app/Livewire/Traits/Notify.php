<?php

declare(strict_types=1);

namespace App\Livewire\Traits;

use TallStackUi\Interactions\Toast;
use TallStackUi\Interactions\Dialog;
use TallStackUi\Traits\Interactions;

trait Notify
{
    use Interactions;

    public function success(?string $description = null, ?string $title = null): void
    {
        $this->notification()
            ->success($title ?? __('toast.success.title'), $description ?? __('toast.success.description'))
            ->send();
    }

    public function error(?string $description = null, ?string $title = null): void
    {
        $this->notification()
            ->error($title ?? __('toast.error.title'), $description ?? __('toast.error.description'))
            ->send();
    }

    public function warning(?string $description = null, ?string $title = null): void
    {
        $this->notification()
            ->warning($title ?? __('toast.warning.title'), $description ?? __('toast.warning.description'))
            ->send();
    }

    public function info(?string $description = null, ?string $title = null): void
    {
        $this->notification()
            ->info($title ?? __('toast.info.title'), $description ?? __('toast.info.description'))
            ->send();
    }

    public function question(?string $description = null, ?string $title = null): Dialog
    {
        return $this->dialog()->question($title ?? __('dialog.question.title'), $description ?? __('dialog.question.description'));
    }

    protected function notification(): Toast
    {
        return $this->toast()
            ->position('bottom-right')
            ->timeout(3);
    }
}
