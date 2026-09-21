<?php

declare(strict_types=1);

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use App\Livewire\Traits\Notify;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\View\View;
use App\Livewire\Traits\UserRolesForm;

class Create extends Component
{
    use Notify;
    use UserRolesForm;

    public User $user;

    public ?string $password = null;

    public ?string $password_confirmation = null;

    public bool $modal = false;

    public function mount(): void
    {
        $this->user = new User();
    }

    public function render(): View
    {
        return view('livewire.users.create');
    }

    public function rules(): array
    {
        return [
            'user.name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'name'),
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
                Rule::unique('users', 'email'),
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

        $this->user->password          = bcrypt($this->password);
        $this->user->email_verified_at = now();
        $this->user->save();

        $this->syncSelectedRoles($this->user);

        $this->dispatch('created');

        $this->reset();
        $this->user = new User();

        $this->success();
    }
}
