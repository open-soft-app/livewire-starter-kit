<?php

declare(strict_types=1);

use App\Models\Role;
use App\Models\User;
use Livewire\Livewire;
use App\Livewire\Users\Update;

beforeEach(function () {
    $this->original = User::factory()->create([
        'name'       => 'original',
        'first_name' => 'Original',
        'last_name'  => 'Name',
        'email'      => 'original@example.com',
    ]);

    $this->role = Role::create(['name' => 'operator', 'guard_name' => 'web']);
});

it('renders the update user component', function () {
    Livewire::test(Update::class, ['user' => $this->original])
        ->assertOk()
        ->assertViewIs('livewire.users.update');
});

it('initializes with existing user data', function () {
    Livewire::test(Update::class, ['user' => $this->original])
        ->assertSet('user.name', 'original')
        ->assertSet('user.first_name', 'Original')
        ->assertSet('user.last_name', 'Name')
        ->assertSet('user.email', 'original@example.com')
        ->assertSet('password', null)
        ->assertSet('password_confirmation', null);
});

it('load the correct use', function () {
    Livewire::test(Update::class)
        ->call('load', $this->original)
        ->assertSet('user.name', 'original')
        ->assertSet('user.first_name', 'Original')
        ->assertSet('user.last_name', 'Name')
        ->assertSet('user.email', 'original@example.com')
        ->assertSet('password', null)
        ->assertSet('password_confirmation', null);
});

it('updates user name and email', function () {
    Livewire::test(Update::class, ['user' => $this->original])
        ->set('selectedRoles', [$this->role->id])
        ->set('user.name', 'updated')
        ->set('user.first_name', 'Updated')
        ->set('user.last_name', 'Name')
        ->set('user.email', 'updated@example.com')
        ->call('save')
        ->assertHasNoErrors();

    $updated = User::find($this->original->id);

    expect($updated)
        ->first_name->toBe('Updated')
        ->last_name->toBe('Name')
        ->name->toBe('updated')
        ->and($updated->email)
        ->toBe('updated@example.com');
});

it('requires name, firstname and lastname', function () {
    Livewire::test(Update::class, ['user' => $this->original])
        ->set('user.name', '')
        ->set('user.first_name', '')
        ->set('user.last_name', '')
        ->set('user.email', 'updated@example.com')
        ->call('save')
        ->assertHasErrors(['user.name' => 'required', 'user.first_name' => 'required', 'user.last_name' => 'required']);
});

it('validates unique name with ignore', function () {
    User::factory()->create(['name' => 'taken']);

    Livewire::test(Update::class, ['user' => $this->original])
        ->set('user.name', 'taken')
        ->call('save')
        ->assertHasErrors(['user.name' => 'unique']);

    Livewire::test(Update::class, ['user' => $this->original])
        ->set('selectedRoles', [$this->role->id])
        ->set('user.name', 'original')
        ->call('save')
        ->assertHasNoErrors();
});

it('validates unique email with ignore', function () {
    User::factory()->create([
        'email' => 'existing@example.com',
    ]);

    Livewire::test(Update::class, ['user' => $this->original])
        ->set('user.email', 'existing@example.com')
        ->call('save')
        ->assertHasErrors(['user.email' => 'unique']);
});

it('updates password when provided', function () {
    $old = $this->original->password;

    Livewire::test(Update::class, ['user' => $this->original])
        ->set('selectedRoles', [$this->role->id])
        ->set('password', 'new-password-123')
        ->set('password_confirmation', 'new-password-123')
        ->call('save')
        ->assertHasNoErrors();

    $updated = User::find($this->original->id);

    expect($updated->password)->not()->toBe($old);
});

it('does not update password when not provided', function () {
    $old = $this->original->password;

    Livewire::test(Update::class, ['user' => $this->original])
        ->set('selectedRoles', [$this->role->id])
        ->set('user.name', 'updated')
        ->set('user.first_name', 'Updated')
        ->set('user.last_name', 'Name')
        ->call('save')
        ->assertHasNoErrors();

    $updated = User::find($this->original->id);

    expect($updated->password)->toBe($old);
});

it('requires password confirmation', function () {
    Livewire::test(Update::class, ['user' => $this->original])
        ->set('password', 'new-password-123')
        ->set('password_confirmation', 'different-password')
        ->call('save')
        ->assertHasErrors(['password' => 'confirmed']);
});

it('requires minimum password length', function () {
    Livewire::test(Update::class, ['user' => $this->original])
        ->set('password', 'short')
        ->set('password_confirmation', 'short')
        ->call('save')
        ->assertHasErrors(['password' => 'min']);
});

it('dispatches updated event', function () {
    Livewire::test(Update::class, ['user' => $this->original])
        ->set('selectedRoles', [$this->role->id])
        ->set('user.name', 'updated')
        ->set('user.first_name', 'Updated')
        ->set('user.last_name', 'Name')
        ->call('save')
        ->assertDispatched('updated');
});

it('resets form after successful update', function () {
    Livewire::test(Update::class, ['user' => $this->original])
        ->set('selectedRoles', [$this->role->id])
        ->set('user.name', 'updated')
        ->set('user.first_name', 'Updated')
        ->set('user.last_name', 'Name')
        ->set('password', 'new-password-123')
        ->set('password_confirmation', 'new-password-123')
        ->call('save')
        ->assertSet('password', null)
        ->assertSet('password_confirmation', null);
});

it('validates email format', function () {
    Livewire::test(Update::class, ['user' => $this->original])
        ->set('user.email', 'invalid-email')
        ->call('save')
        ->assertHasErrors(['user.email' => 'email']);
});

it('loads the roles already assigned to the user', function () {
    $admin = Role::create(['name' => 'admin', 'guard_name' => 'web']);
    $this->original->assignRole($admin);

    Livewire::test(Update::class)
        ->call('load', $this->original)
        ->assertSet('selectedRoles', [$admin->id]);
});

it('syncs the selected roles adding and removing', function () {
    $admin  = Role::create(['name' => 'admin', 'guard_name' => 'web']);
    $editor = Role::create(['name' => 'editor', 'guard_name' => 'web']);
    $this->original->assignRole($admin);

    Livewire::test(Update::class)
        ->call('load', $this->original)
        ->set('selectedRoles', [$editor->id])
        ->call('save')
        ->assertHasNoErrors();

    expect($this->original->fresh()->getRoleNames()->all())->toBe(['editor']);
});

it('requires at least one role', function () {
    Livewire::test(Update::class)
        ->call('load', $this->original)
        ->set('selectedRoles', [])
        ->call('save')
        ->assertHasErrors(['selectedRoles' => 'required']);
});

it('rejects roles that do not exist', function () {
    Livewire::test(Update::class)
        ->call('load', $this->original)
        ->set('selectedRoles', [999999])
        ->call('save')
        ->assertHasErrors(['selectedRoles.0' => 'exists']);
});
