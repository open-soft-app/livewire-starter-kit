<?php

declare(strict_types=1);

namespace App\Livewire\Traits;

use App\Models\Role;
use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Illuminate\Database\Eloquent\Collection;

trait UserRolesForm
{
    /**
     * @var array<int, int|string>
     */
    public array $selectedRoles = [];

    /**
     * @return Collection<int, Role>
     */
    #[Computed]
    public function availableRoles(): Collection
    {
        return Role::query()->orderBy('name')->get(['id', 'name']);
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    protected function roleRules(): array
    {
        return [
            'selectedRoles'   => ['required', 'array', 'min:1'],
            'selectedRoles.*' => [
                'integer',
                Rule::exists('roles', 'id')->where('guard_name', 'web'),
            ],
        ];
    }

    protected function syncSelectedRoles(User $user): void
    {
        $user->syncRoles(
            Role::query()->whereIn('id', $this->selectedRoles)->pluck('name')->all()
        );
    }
}
