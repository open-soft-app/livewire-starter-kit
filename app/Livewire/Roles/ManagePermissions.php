<?php

declare(strict_types=1);

namespace App\Livewire\Roles;

use App\Models\Role;
use Livewire\Component;
use App\Models\Permission;
use Livewire\Attributes\On;
use App\Livewire\Traits\Notify;
use Illuminate\Contracts\View\View;

class ManagePermissions extends Component
{
    use Notify;

    public ?Role $role = null;

    public array $selectedPermissions = [];

    public bool $modal = false;

    public function render(): View
    {
        return view('livewire.roles.manage-permissions', [
            'allPermissions' => Permission::query()
                ->orderBy('name')
                ->get(),
        ]);
    }

    #[On('load::role-permissions')]
    public function load(Role $role): void
    {
        $this->role                = $role;
        $this->selectedPermissions = $role->permissions()
            ->pluck('id')
            ->toArray();
        $this->modal = true;
    }

    public function selectAllPermissions(): void
    {
        $this->selectedPermissions = Permission::query()
            ->pluck('id')
            ->toArray();
    }

    public function save(): void
    {
        if ($this->role === null) {
            return;
        }

        $permissionNames = Permission::whereIn('id', $this->selectedPermissions)
            ->pluck('name')
            ->toArray();

        $this->role->syncPermissions($permissionNames);

        $this->dispatch('updated');
        $this->success(__('app.roles.permissions_updated'));
        $this->closeModal();
    }

    public function closeModal(): void
    {
        $this->modal = false;
        $this->reset();
    }
}
