<?php

declare(strict_types=1);

namespace App\Livewire\Roles;

use App\Models\Role;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Livewire\Traits\Notify;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\View\View;

class Update extends Component
{
    use Notify;

    public ?Role $role;

    public bool $modal = false;

    public function render(): View
    {
        return view('livewire.roles.update');
    }

    #[On('load::role')]
    public function load(Role $role): void
    {
        $this->role  = $role;
        $this->modal = true;
    }

    public function rules(): array
    {
        return [
            'role.name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles', 'name')->where('guard_name', 'web')->ignore($this->role->id),
            ],
        ];
    }

    public function save(): void
    {
        $this->validate();

        $this->role->save();

        $this->dispatch('updated');

        $this->reset();

        $this->success();
    }
}
