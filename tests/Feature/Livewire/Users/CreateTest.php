<?php

declare(strict_types=1);

use App\Models\Role;
use App\Models\User;
use Livewire\Livewire;
use App\Livewire\Users\Create;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

beforeEach(function () {
    User::query()->delete();

    $this->role = Role::create(['name' => 'operator', 'guard_name' => 'web']);
});

it('renders the create user component', function () {
    Livewire::test(Create::class)
        ->assertOk()
        ->assertViewIs('livewire.users.create');
});

it('initializes with a new user', function () {
    Livewire::test(Create::class)
        ->assertSet('user', fn ($user) => $user instanceof User)
        ->assertSet('password', null)
        ->assertSet('password_confirmation', null);
});

it('validates user creation with valid data', function () {
    $data = [
        'selectedRoles'         => [$this->role->id],
        'user.name'             => 'johndoe',
        'user.first_name'       => 'John',
        'user.last_name'        => 'Doe',
        'user.email'            => 'john@example.com',
        'password'              => 'password123',
        'password_confirmation' => 'password123',
    ];

    Livewire::test(Create::class)
        ->set($data)
        ->call('save')
        ->assertHasNoErrors();

    assertDatabaseHas('users', [
        'name'       => 'johndoe',
        'first_name' => 'John',
        'last_name'  => 'Doe',
        'email'      => 'john@example.com',
    ]);
});

it('requires name, firstname and lastname', function () {
    Livewire::test(Create::class)
        ->set('user.name', '')
        ->set('user.first_name', '')
        ->set('user.last_name', '')
        ->set('user.email', 'john@example.com')
        ->set('password', 'password123')
        ->set('password_confirmation', 'password123')
        ->call('save')
        ->assertHasErrors(['user.name' => 'required', 'user.first_name' => 'required', 'user.last_name' => 'required']);
});

it('requires unique name', function () {
    User::factory()->create(['name' => 'johndoe']);

    Livewire::test(Create::class)
        ->set('user.name', 'johndoe')
        ->set('user.first_name', 'John')
        ->set('user.last_name', 'Doe')
        ->set('user.email', 'john@example.com')
        ->set('password', 'password123')
        ->set('password_confirmation', 'password123')
        ->set('selectedRoles', [$this->role->id])
        ->call('save')
        ->assertHasErrors(['user.name' => 'unique']);
});

it('requires unique email', function () {
    User::create([
        'name'     => 'Existing User',
        'email'    => 'existing@example.com',
        'password' => bcrypt('password123'),
    ]);

    Livewire::test(Create::class)
        ->set('user.name', 'johndoe')
        ->set('user.first_name', 'John')
        ->set('user.last_name', 'Doe')
        ->set('user.email', 'existing@example.com')
        ->set('password', 'password123')
        ->set('password_confirmation', 'password123')
        ->call('save')
        ->assertHasErrors(['user.email' => 'unique']);
});

it('validates email format', function () {
    Livewire::test(Create::class)
        ->set('user.name', 'johndoe')
        ->set('user.first_name', 'John')
        ->set('user.last_name', 'Doe')
        ->set('user.email', 'invalid-email')
        ->set('password', 'password123')
        ->set('password_confirmation', 'password123')
        ->call('save')
        ->assertHasErrors(['user.email' => 'email']);
});

it('requires password confirmation', function () {
    Livewire::test(Create::class)
        ->set('user.name', 'johndoe')
        ->set('user.first_name', 'John')
        ->set('user.last_name', 'Doe')
        ->set('user.email', 'john@example.com')
        ->set('password', 'password123')
        ->set('password_confirmation', 'different-password')
        ->call('save')
        ->assertHasErrors(['password' => 'confirmed']);
});

it('requires minimum password length', function () {
    Livewire::test(Create::class)
        ->set('user.name', 'johndoe')
        ->set('user.first_name', 'John')
        ->set('user.last_name', 'Doe')
        ->set('user.email', 'john@example.com')
        ->set('password', 'short')
        ->set('password_confirmation', 'short')
        ->call('save')
        ->assertHasErrors(['password' => 'min']);
});

it('sets email verified at when creating user', function () {
    $data = [
        'selectedRoles'         => [$this->role->id],
        'user.name'             => 'johndoe',
        'user.first_name'       => 'John',
        'user.last_name'        => 'Doe',
        'user.email'            => 'john@example.com',
        'password'              => 'password123',
        'password_confirmation' => 'password123',
    ];

    Livewire::test(Create::class)
        ->set($data)
        ->call('save');

    $user = User::where('email', 'john@example.com')->first();

    expect($user->email_verified_at)->not()->toBeNull();
});

it('resets form after successful creation', function () {
    $data = [
        'selectedRoles'         => [$this->role->id],
        'user.name'             => 'johndoe',
        'user.first_name'       => 'John',
        'user.last_name'        => 'Doe',
        'user.email'            => 'john@example.com',
        'password'              => 'password123',
        'password_confirmation' => 'password123',
    ];

    Livewire::test(Create::class)
        ->set($data)
        ->call('save')
        ->assertSet('user', fn ($user) => $user instanceof User && $user->first_name === null && $user->last_name === null)
        ->assertSet('password', null)
        ->assertSet('password_confirmation', null);
});

it('dispatches created event', function () {
    $data = [
        'selectedRoles'         => [$this->role->id],
        'user.name'             => 'johndoe',
        'user.first_name'       => 'John',
        'user.last_name'        => 'Doe',
        'user.email'            => 'john@example.com',
        'password'              => 'password123',
        'password_confirmation' => 'password123',
    ];

    Livewire::test(Create::class)
        ->set($data)
        ->call('save')
        ->assertDispatched('created');
});

it('assigns the selected roles to the new user', function () {
    $admin  = Role::create(['name' => 'admin', 'guard_name' => 'web']);
    $editor = Role::create(['name' => 'editor', 'guard_name' => 'web']);

    Livewire::test(Create::class)
        ->set('user.name', 'johndoe')
        ->set('user.first_name', 'John')
        ->set('user.last_name', 'Doe')
        ->set('user.email', 'john@example.com')
        ->set('password', 'password123')
        ->set('password_confirmation', 'password123')
        ->set('selectedRoles', [$admin->id, $editor->id])
        ->call('save')
        ->assertHasNoErrors()
        ->assertSet('selectedRoles', []);

    $user = User::where('email', 'john@example.com')->first();

    expect($user->getRoleNames()->all())->toEqualCanonicalizing(['admin', 'editor']);
});

it('requires at least one role', function () {
    Livewire::test(Create::class)
        ->set('user.name', 'johndoe')
        ->set('user.first_name', 'John')
        ->set('user.last_name', 'Doe')
        ->set('user.email', 'john@example.com')
        ->set('password', 'password123')
        ->set('password_confirmation', 'password123')
        ->set('selectedRoles', [])
        ->call('save')
        ->assertHasErrors(['selectedRoles' => 'required']);

    assertDatabaseMissing('users', ['email' => 'john@example.com']);
});

it('rejects roles that do not exist', function () {
    Livewire::test(Create::class)
        ->set('user.name', 'johndoe')
        ->set('user.first_name', 'John')
        ->set('user.last_name', 'Doe')
        ->set('user.email', 'john@example.com')
        ->set('password', 'password123')
        ->set('password_confirmation', 'password123')
        ->set('selectedRoles', [999999])
        ->call('save')
        ->assertHasErrors(['selectedRoles.0' => 'exists']);

    assertDatabaseMissing('users', ['email' => 'john@example.com']);
});
