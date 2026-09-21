<?php

declare(strict_types=1);

use App\Models\Role;
use Livewire\Livewire;
use App\Livewire\Roles\Create;

use function Pest\Laravel\assertDatabaseHas;

beforeEach(fn () => Role::query()->delete());

it('renders the create role component', function () {
    Livewire::test(Create::class)
        ->assertOk()
        ->assertViewIs('livewire.roles.create');
});

it('creates a role with the web guard', function () {
    Livewire::test(Create::class)
        ->set('role.name', 'dispatcher')
        ->call('save')
        ->assertHasNoErrors()
        ->assertDispatched('created');

    assertDatabaseHas('roles', ['name' => 'dispatcher', 'guard_name' => 'web']);
});

it('requires name', function () {
    Livewire::test(Create::class)
        ->set('role.name', '')
        ->call('save')
        ->assertHasErrors(['role.name' => 'required']);
});

it('requires unique name', function () {
    Role::create(['name' => 'dispatcher', 'guard_name' => 'web']);

    Livewire::test(Create::class)
        ->set('role.name', 'dispatcher')
        ->call('save')
        ->assertHasErrors(['role.name' => 'unique']);
});

it('resets form after successful creation', function () {
    Livewire::test(Create::class)
        ->set('role.name', 'dispatcher')
        ->call('save')
        ->assertSet('role', fn ($role) => $role instanceof Role && $role->name === null);
});
