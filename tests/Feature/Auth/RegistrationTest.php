<?php

declare(strict_types=1);

use App\Models\User;

it('renders the register page', function () {
    app()->setLocale('en');

    $this->get(route('register'))
        ->assertOk()
        ->assertSee('Create your account');
});

it('registers a new user', function () {
    $this->post(route('register.store'), [
        'name'                  => 'newuser',
        'first_name'            => 'New',
        'last_name'             => 'User',
        'email'                 => 'new@example.com',
        'password'              => 'password',
        'password_confirmation' => 'password',
    ])->assertRedirect('/dashboard');

    $this->assertAuthenticated();

    expect(User::query()->where('email', 'new@example.com')->first())
        ->first_name->toBe('New')
        ->last_name->toBe('User')
        ->name->toBe('newuser')
        ->hasRole('Operatore')->toBeTrue();
});

it('requires a unique email', function () {
    User::factory()->create(['email' => 'taken@example.com']);

    $this->post(route('register.store'), [
        'name'                  => 'newuser',
        'first_name'            => 'New',
        'last_name'             => 'User',
        'email'                 => 'taken@example.com',
        'password'              => 'password',
        'password_confirmation' => 'password',
    ])->assertSessionHasErrors('email');

    $this->assertGuest();
});

it('requires a unique name', function () {
    User::factory()->create(['name' => 'taken']);

    $this->post(route('register.store'), [
        'name'                  => 'taken',
        'first_name'            => 'New',
        'last_name'             => 'User',
        'email'                 => 'new@example.com',
        'password'              => 'password',
        'password_confirmation' => 'password',
    ])->assertSessionHasErrors('name');

    $this->assertGuest();
});
