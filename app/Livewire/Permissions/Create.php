<?php

declare(strict_types=1);

namespace App\Livewire\Permissions;

use Livewire\Component;
use App\Models\Permission;
use App\Livewire\Traits\Notify;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\View\View;

class Create extends Component
{
    use Notify;

    public Permission $permission;

    public bool $modal = false;

    public function mount(): void
    {
        $this->initialize();
    }

    public function render(): View
    {
        return view('livewire.permissions.create');
    }

    public function rules(): array
    {
        return [
            'permission.name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('permissions', 'name')->where('guard_name', $this->permission->guard_name),
            ],
        ];
    }

    public function save(): void
    {
        $this->validate();

        $this->permission->save();

        $this->dispatch('created');

        $this->reset();
        $this->initialize();

        $this->success();
    }

    private function initialize(): void
    {
        $this->permission             = new Permission();
        $this->permission->guard_name = 'web';
    }
}
