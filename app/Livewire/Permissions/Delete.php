<?php

declare(strict_types=1);

namespace App\Livewire\Permissions;

use Livewire\Component;
use App\Models\Permission;
use App\Livewire\Traits\Notify;
use Livewire\Attributes\Renderless;

class Delete extends Component
{
    use Notify;

    public Permission $permission;

    public function render(): string
    {
        return <<<'HTML'
        <div>
            <x-button.circle icon="trash" color="red" wire:click="confirm" />
        </div>
        HTML;
    }

    #[Renderless]
    public function confirm(): void
    {
        $this->question()
            ->confirm(method: 'delete')
            ->cancel()
            ->send();
    }

    public function delete(): void
    {
        $this->permission->delete();

        $this->dispatch('deleted');

        $this->success();
    }
}
