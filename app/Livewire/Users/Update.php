<?php

declare(strict_types=1);

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Livewire\Traits\Notify;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\View\View;
use App\Livewire\Traits\UserRolesForm;

class Update extends Component
{
    use Notify;
    use UserRolesForm;

    public ?User $user;

    public ?string $password = null;

    public ?string $password_confirmation = null;

    public bool $modal = false;

    public function render(): View
    {
        return view('livewire.users.update');
    }

    #[On('load::user')]
    public function load(User $user): void
    {
        $this->user          = $user;
        $this->selectedRoles = $user->roles()->pluck('id')->all();
        $this->modal         = true;
    }

    public function rules(): array
    {
        return [
            'user.name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'name')->ignore($this->user->id),
            ],
            'user.first_name' => [
                'required',
                'string',
                'max:255',
            ],
            'user.last_name' => [
                'required',
                'string',
                'max:255',
            ],
            'user.email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->user->id),
            ],
            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],
            ...$this->roleRules(),
        ];
    }

    public function save(): void
    {
        $this->validate();

        $this->user->password = when($this->password !== null, bcrypt($this->password), $this->user->password);
        $this->user->save();

        $this->syncSelectedRoles($this->user);

        $this->dispatch('updated');

        $this->reset();

        $this->success();
    }
}
