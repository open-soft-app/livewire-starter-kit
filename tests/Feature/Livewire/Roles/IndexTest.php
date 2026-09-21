<?php

declare(strict_types=1);

use App\Models\Role;
use Livewire\Livewire;
use App\Livewire\Roles\Index;
use Illuminate\Pagination\LengthAwarePaginator;

beforeEach(function () {
    Role::query()->delete();

    foreach (range(1, 15) as $number) {
        Role::create(['name' => "role-{$number}", 'guard_name' => 'web']);
    }
});

it('renders the roles index component', function () {
    Livewire::test(Index::class)
        ->assertOk()
        ->assertViewIs('livewire.roles.index');
});

it('initializes with default settings', function () {
    Livewire::test(Index::class)
        ->assertSet('quantity', 6)
        ->assertSet('search', null)
        ->assertSet('sort', [
            'column'    => 'id',
            'direction' => 'asc',
        ]);
});

it('fetches paginated roles', function () {
    $rows = Livewire::test(Index::class)->get('rows');

    expect($rows)
        ->toBeInstanceOf(LengthAwarePaginator::class)
        ->and($rows->total())->toBe(15)
        ->and($rows->perPage())->toBe(6);
});

it('filters roles by search term', function () {
    $role = Role::create(['name' => 'unique-searchable', 'guard_name' => 'web']);

    $rows = Livewire::test(Index::class)
        ->set('search', 'unique-searchable')
        ->get('rows');

    expect($rows->total())->toBe(1)
        ->and($rows->first()->id)->toBe($role->id);
});

it('supports sorting by name', function () {
    $names = Livewire::test(Index::class)
        ->set('sort', ['column' => 'name', 'direction' => 'asc'])
        ->get('rows')
        ->pluck('name')
        ->all();

    $sorted = $names;
    sort($sorted);

    expect($names)->toBe($sorted);
});

it('handles empty search results', function () {
    $rows = Livewire::test(Index::class)->set('search', 'non-existent-role')->get('rows');

    expect($rows->total())->toBe(0);
});
