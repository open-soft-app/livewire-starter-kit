<?php

declare(strict_types=1);

use App\Models\Role;
use App\Models\User;
use Livewire\Livewire;
use App\Models\Permission;
use App\Livewire\Permissions\Index;
use App\Livewire\Permissions\Create;
use App\Livewire\Permissions\Delete;
use App\Livewire\Permissions\Update;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

beforeEach(function () {
    $this->actingAs(User::factory()->create());
});

it('lists permissions', function () {
    Permission::create(['name' => 'edit articles']);

    Livewire::test(Index::class)
        ->assertOk()
        ->assertSee('edit articles');
});

it('filters permissions by name', function () {
    Permission::create(['name' => 'edit articles']);

    Livewire::test(Index::class)
        ->set('search', 'does-not-exist')
        ->assertDontSee('edit articles');
});

it('creates a permission with the default guard', function () {
    Livewire::test(Create::class)
        ->set('permission.name', 'edit articles')
        ->call('save')
        ->assertHasNoErrors()
        ->assertDispatched('created');

    assertDatabaseHas('permissions', [
        'name'       => 'edit articles',
        'guard_name' => 'web',
    ]);
});

it('requires a name', function () {
    Livewire::test(Create::class)
        ->call('save')
        ->assertHasErrors(['permission.name' => 'required']);
});

it('does not allow duplicate names for the same guard', function () {
    Permission::create(['name' => 'edit articles']);

    Livewire::test(Create::class)
        ->set('permission.name', 'edit articles')
        ->call('save')
        ->assertHasErrors(['permission.name' => 'unique']);
});

it('updates a permission keeping its own name valid', function () {
    $permission = Permission::create(['name' => 'edit articles']);

    Livewire::test(Update::class)
        ->dispatch('load::permission', permission: $permission->id)
        ->assertSet('modal', true)
        ->call('save')
        ->assertHasNoErrors()
        ->dispatch('load::permission', permission: $permission->id)
        ->set('permission.name', 'publish articles')
        ->call('save')
        ->assertHasNoErrors()
        ->assertDispatched('updated');

    expect($permission->fresh()->name)->toBe('publish articles');
});

it('deletes a permission', function () {
    $permission = Permission::create(['name' => 'edit articles']);

    Livewire::test(Delete::class, ['permission' => $permission])
        ->call('delete')
        ->assertDispatched('deleted');

    assertDatabaseMissing('permissions', ['id' => $permission->id]);
});

it('serves the permissions page to authenticated users', function () {
    Role::findOrCreate('Admin', 'web');

    $admin = User::factory()->create();
    $admin->assignRole('Admin');

    $this->actingAs($admin)
        ->withoutVite()
        ->get(route('permissions.index'))
        ->assertOk();
});
