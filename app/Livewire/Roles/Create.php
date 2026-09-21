<?php

declare(strict_types=1);

namespace App\Livewire\Roles;

use App\Models\Role;
use Livewire\Component;
use App\Livewire\Traits\Notify;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\View\View;

class Create extends Component
{
    use Notify;

    public Role $role;

    public bool $modal = false;

    public function mount(): void
    {
        $this->role = new Role();
    }

    public function render(): View
    {
        return view('livewire.roles.create');
    }

    public function rules(): array
    {
        return [
            'role.name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles', 'name')->where('guard_name', 'web'),
            ],
        ];
    }

    public function save(): void
    {
        $this->validate();

        $this->role->guard_name = 'web';
        $this->role->save();

        $this->dispatch('created');

        $this->reset();
        $this->role = new Role();

        $this->success();
    }
}
