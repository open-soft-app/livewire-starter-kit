<?php

declare(strict_types=1);

use App\Models\Role;
use Livewire\Livewire;
use App\Livewire\Roles\Update;

beforeEach(function () {
    Role::query()->delete();

    $this->original = Role::create(['name' => 'original', 'guard_name' => 'web']);
});

it('renders the update role component', function () {
    Livewire::test(Update::class, ['role' => $this->original])
        ->assertOk()
        ->assertViewIs('livewire.roles.update');
});

it('loads the correct role', function () {
    Livewire::test(Update::class)
        ->call('load', $this->original)
        ->assertSet('role.name', 'original')
        ->assertSet('modal', true);
});

it('updates the role name', function () {
    Livewire::test(Update::class, ['role' => $this->original])
        ->set('role.name', 'updated')
        ->call('save')
        ->assertHasNoErrors()
        ->assertDispatched('updated');

    expect($this->original->fresh()->name)->toBe('updated');
});

it('requires name', function () {
    Livewire::test(Update::class, ['role' => $this->original])
        ->set('role.name', '')
        ->call('save')
        ->assertHasErrors(['role.name' => 'required']);
});

it('validates unique name ignoring the current role', function () {
    Role::create(['name' => 'existing', 'guard_name' => 'web']);

    Livewire::test(Update::class, ['role' => $this->original])
        ->set('role.name', 'existing')
        ->call('save')
        ->assertHasErrors(['role.name' => 'unique']);

    Livewire::test(Update::class, ['role' => $this->original])
        ->set('role.name', 'original')
        ->call('save')
        ->assertHasNoErrors();
});
