<?php

declare(strict_types=1);

use App\Models\Role;
use Livewire\Livewire;
use App\Livewire\Roles\Delete;

use function Pest\Laravel\assertModelExists;
use function Pest\Laravel\assertModelMissing;

beforeEach(fn () => $this->role = Role::create(['name' => 'dispatcher', 'guard_name' => 'web']));

it('renders the delete component', function () {
    Livewire::test(Delete::class, ['role' => $this->role])
        ->assertOk()
        ->assertSeeHtml('wire:click="confirm"');
});

it('asks for confirmation before deletion', function () {
    Livewire::test(Delete::class, ['role' => $this->role])
        ->call('confirm')
        ->assertDispatched('ts-ui:dialog');

    assertModelExists($this->role);
});

it('deletes the role', function () {
    Livewire::test(Delete::class, ['role' => $this->role])
        ->call('delete')
        ->assertDispatched('deleted');

    assertModelMissing($this->role);
});
