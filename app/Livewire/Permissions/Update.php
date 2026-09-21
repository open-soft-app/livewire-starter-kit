<?php

declare(strict_types=1);

namespace App\Livewire\Permissions;

use Livewire\Component;
use App\Models\Permission;
use Livewire\Attributes\On;
use App\Livewire\Traits\Notify;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\View\View;

class Update extends Component
{
    use Notify;

    public ?Permission $permission = null;

    public bool $modal = false;

    public function render(): View
    {
        return view('livewire.permissions.update');
    }

    #[On('load::permission')]
    public function load(Permission $permission): void
    {
        $this->permission = $permission;
        $this->modal      = true;
    }

    public function rules(): array
    {
        return [
            'permission.name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('permissions', 'name')
                    ->where('guard_name', $this->permission->guard_name)
                    ->ignore($this->permission->id),
            ],
        ];
    }

    public function save(): void
    {
        $this->validate();

        $this->permission->save();

        $this->dispatch('updated');

        $this->reset();

        $this->success();
    }
}
