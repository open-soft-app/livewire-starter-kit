<?php

declare(strict_types=1);

namespace App\Actions\Fortify;

use App\Models\Role;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    public function create(array $input): User
    {
        Validator::make($input, [
            'name'       => ['required', 'string', 'max:255', Rule::unique(User::class)],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name'  => ['required', 'string', 'max:255'],
            'email'      => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => ['required', 'string', Password::default(), 'confirmed'],
        ])->validate();

        $user = User::create([
            'name'       => $input['name'],
            'first_name' => $input['first_name'],
            'last_name'  => $input['last_name'],
            'email'      => $input['email'],
            'password'   => Hash::make($input['password']),
        ]);

        $user->assignRole(Role::findOrCreate('Operatore', 'web'));

        return $user;
    }
}
