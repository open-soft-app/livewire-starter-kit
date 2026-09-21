<?php

declare(strict_types=1);

use App\Models\User;
use Livewire\Livewire;
use App\Livewire\User\Profile\Information;

beforeEach(function () {
    $this->user = User::factory()->create();

    $this->actingAs($this->user);
});

it('renders successfully', function () {
    Livewire::test(Information::class)
        ->assertOk()
        ->assertViewIs('livewire.user.profile.information');
});

it('mounts with authenticated user data', function () {
    Livewire::test(Information::class)
        ->assertSet('user.id', $this->user->id)
        ->assertSet('user.name', $this->user->name)
        ->assertSet('user.first_name', $this->user->first_name)
        ->assertSet('user.last_name', $this->user->last_name);
});

it('validates required name, firstname and lastname', function () {
    Livewire::test(Information::class)
        ->set('user.name', '')
        ->set('user.first_name', '')
        ->set('user.last_name', '')
        ->call('save')
        ->assertHasErrors(['user.name' => 'required', 'user.first_name' => 'required', 'user.last_name' => 'required']);
});

it('validates unique name', function () {
    User::factory()->create(['name' => 'taken']);

    Livewire::test(Information::class)
        ->set('user.name', 'taken')
        ->call('save')
        ->assertHasErrors(['user.name' => 'unique']);
});

it('validates maximum length of firstname and lastname', function () {
    Livewire::test(Information::class)
        ->set('user.first_name', str_repeat('a', 256))
        ->set('user.last_name', str_repeat('a', 256))
        ->call('save')
        ->assertHasErrors(['user.first_name' => 'max', 'user.last_name' => 'max']);
});

it('updates the name without changing the email', function () {
    $email = $this->user->email;

    Livewire::test(Information::class)
        ->set('user.name', 'updated')
        ->set('user.first_name', 'Updated')
        ->set('user.last_name', 'Name')
        ->call('save')
        ->assertHasNoErrors()
        ->assertDispatched('updated');

    expect($this->user->refresh())
        ->first_name->toBe('Updated')
        ->last_name->toBe('Name')
        ->name->toBe('updated')
        ->email->toBe($email);
});

it('dispatches success alert after saving', function () {
    Livewire::test(Information::class)
        ->set('user.name', 'updated.again')
        ->set('user.first_name', 'Updated')
        ->set('user.last_name', 'Again')
        ->call('save')
        ->assertDispatched('updated')
        ->assertDispatched('ts-ui:dialog', function (string $event, array $params) {
            return $event === 'ts-ui:dialog' &&
                $params['type'] === 'success' &&
                $params['title'] === __('dialog.success.title');
        });
});

it('defaults the theme to the configured one', function () {
    Livewire::test(Information::class)
        ->assertSet('user.theme', config('app.theme'));
});

it('persists the selected theme', function () {
    Livewire::test(Information::class)
        ->set('user.theme', 'emerald')
        ->call('save')
        ->assertHasNoErrors()
        ->assertDispatched('updated', name: $this->user->name, theme: 'emerald', font: config('app.font'));

    expect($this->user->refresh()->theme)->toBe('emerald');
});

it('rejects a theme that is not available', function () {
    Livewire::test(Information::class)
        ->set('user.theme', 'purple')
        ->call('save')
        ->assertHasErrors(['user.theme' => 'in']);
});

it('defaults the font to the configured one', function () {
    Livewire::test(Information::class)
        ->assertSet('user.font', config('app.font'));
});

it('persists the selected font', function () {
    Livewire::test(Information::class)
        ->set('user.font', 'poppins')
        ->call('save')
        ->assertHasNoErrors()
        ->assertDispatched('updated', font: 'poppins');

    expect($this->user->refresh()->font)->toBe('poppins');
});

it('rejects a font that is not available', function () {
    Livewire::test(Information::class)
        ->set('user.font', 'comic-sans')
        ->call('save')
        ->assertHasErrors(['user.font' => 'in']);
});

it('renders the layout with the theme of the user', function () {
    $this->user->update(['theme' => 'teal', 'font' => 'roboto']);

    $this->get(route('user.profile'))
        ->assertOk()
        ->assertSee('data-theme="teal"', false)
        ->assertSee('data-font="roboto"', false);
});
