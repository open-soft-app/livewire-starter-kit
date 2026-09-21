<?php

declare(strict_types=1);

use App\Models\Role;
use App\Models\User;

beforeEach(function () {
    Role::findOrCreate('Admin', 'web');
});

it('allows admins to access users, roles and permissions', function (string $routeName) {
    $admin = User::factory()->create();
    $admin->assignRole('Admin');

    $this->actingAs($admin)
        ->get(route($routeName))
        ->assertOk();
})->with(['users.index', 'roles.index', 'permissions.index']);

it('shows the users management menu to admins', function () {
    $admin = User::factory()->create();
    $admin->assignRole('Admin');

    $this->actingAs($admin)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertSee(route('users.index'));
});
