<?php

declare(strict_types=1);

use App\Models\User;
use Livewire\Livewire;
use Illuminate\Support\Arr;
use App\Livewire\Users\Index;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;

beforeEach(function () {
    $this->auth = User::factory()->create();

    Auth::login($this->auth);

    User::factory()->count(15)->create();
});

it('renders the users index component', function () {
    Livewire::test(Index::class)
        ->assertOk()
        ->assertViewIs('livewire.users.index');
});

it('initializes with default settings', function () {
    Livewire::test(Index::class)
        ->assertSet('quantity', 15)
        ->assertSet('search', null)
        ->assertSet('sort', [
            'column'    => 'id',
            'direction' => 'asc',
        ]);
});

it('verifies component headers', function () {
    $component = Livewire::test(Index::class);

    $headers = [
        ['index' => 'id', 'label' => __('app.users.id')],
        ['index' => 'name', 'label' => __('app.users.name')],
        ['index' => 'first_name', 'label' => __('app.users.first_name')],
        ['index' => 'last_name', 'label' => __('app.users.last_name')],
        ['index' => 'email', 'label' => __('app.users.email')],
        ['index' => 'roles', 'label' => __('app.users.roles'), 'sortable' => false],
        ['index' => 'created_at', 'label' => __('app.users.created')],
        ['index' => 'action', 'sortable' => false],
    ];

    $component->assertSet('headers', $headers);
});

it('fetches paginated users excluding authenticated user', function () {
    $rows = Livewire::test(Index::class)->get('rows');

    expect($rows)
        ->toBeInstanceOf(LengthAwarePaginator::class)
        ->and($rows->total())
        ->toBe(15)
        ->and($rows->pluck('id'))->not()->toContain($this->auth->id);

});

it('filters users by search term', function () {
    $user = User::factory()->create([
        'first_name' => 'John Unique',
        'last_name'  => 'Searchable',
        'email'      => 'john.unique@example.com',
    ]);

    $component = Livewire::test(Index::class)
        ->set('search', 'John Unique');

    $rows = $component->get('rows');

    expect($rows->total())
        ->toBe(1)
        ->and($rows->first()->id)
        ->toBe($user->id);
});

it('supports searching by email', function () {
    $user = User::factory()->create([
        'first_name' => 'Unique Search',
        'last_name'  => 'User',
        'email'      => 'unique.searchable@example.com',
    ]);

    $component = Livewire::test(Index::class)->set('search', 'unique.searchable');

    $rows = $component->get('rows');

    expect($rows->total())
        ->toBe(1)
        ->and($rows->first()->id)
        ->toBe($user->id);
});

it('supports changing pagination quantity', function () {
    $component = Livewire::test(Index::class)->set('quantity', 5);

    $rows = $component->get('rows');

    expect($rows->perPage())
        ->toBe(5)
        ->and($rows->total())
        ->toBe(15);
});

it('supports sorting by different columns', function () {
    $component = Livewire::test(Index::class)
        ->set('sort', [
            'column'    => 'last_name',
            'direction' => 'asc',
        ]);

    $sort = $component->get('rows')->pluck('last_name')->toArray();

    expect($sort === array_values(Arr::sort($sort)))->toBeTrue();
});

it('handles empty search results', function () {
    $component = Livewire::test(Index::class)->set('search', 'non-existent-user');

    expect($component->get('rows')->total())->toBe(0);
});
