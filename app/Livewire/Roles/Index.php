<?php

declare(strict_types=1);

namespace App\Livewire\Roles;

use App\Models\Role;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class Index extends Component
{
    use WithPagination;

    private const array SORTABLE_COLUMNS = [
        'id',
        'name',
        'created_at',
    ];

    public ?int $quantity = 6;

    public ?string $search = null;

    public array $sort = [
        'column'    => 'id',
        'direction' => 'asc',
    ];

    public function render(): View
    {
        return view('livewire.roles.index');
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedQuantity(): void
    {
        $this->resetPage();
    }

    #[Computed]
    public function rows(): LengthAwarePaginator
    {
        return Role::query()
            ->with(['permissions' => fn ($query) => $query->orderBy('name')])
            ->when(filled($this->search), fn (Builder $query) => $query->where('name', 'like', '%'.mb_trim($this->search).'%'))
            ->orderBy(
                in_array($this->sort['column'], self::SORTABLE_COLUMNS, true) ? $this->sort['column'] : 'id',
                $this->sort['direction'] === 'asc' ? 'asc' : 'desc',
            )
            ->paginate($this->quantity)
            ->withQueryString();
    }
}
