<?php

declare(strict_types=1);

namespace App\Livewire\Permissions;

use Livewire\Component;
use App\Models\Permission;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class Index extends Component
{
    use WithPagination;

    public ?int $quantity = 5;

    public ?string $search = null;

    public array $sort = [
        'column'    => 'created_at',
        'direction' => 'desc',
    ];

    public array $headers = [];

    public function mount(): void
    {
        $this->headers = [
            ['index' => 'id', 'label' => __('app.permissions.id')],
            ['index' => 'name', 'label' => __('app.permissions.name')],
            ['index' => 'guard_name', 'label' => __('app.permissions.guard')],
            ['index' => 'created_at', 'label' => __('app.permissions.created')],
            ['index' => 'action', 'sortable' => false],
        ];
    }

    public function render(): View
    {
        return view('livewire.permissions.index');
    }

    #[Computed]
    public function rows(): LengthAwarePaginator
    {
        return Permission::query()
            ->when($this->search !== null, fn (Builder $query) => $query->whereAny(['name', 'guard_name'], 'like', '%'.mb_trim($this->search).'%'))
            ->orderBy(...array_values($this->sort))
            ->paginate($this->quantity)
            ->withQueryString();
    }
}
