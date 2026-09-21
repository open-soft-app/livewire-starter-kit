<?php

declare(strict_types=1);

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class Index extends Component
{
    use WithPagination;

    public ?int $quantity = 15;

    public ?string $search = null;

    public array $sort = [
        'column'    => 'id',
        'direction' => 'asc',
    ];

    public array $headers = [];

    public function mount(): void
    {
        $this->headers = [
            ['index' => 'id', 'label' => __('app.users.id')],
            ['index' => 'name', 'label' => __('app.users.name')],
            ['index' => 'first_name', 'label' => __('app.users.first_name')],
            ['index' => 'last_name', 'label' => __('app.users.last_name')],
            ['index' => 'email', 'label' => __('app.users.email')],
            ['index' => 'roles', 'label' => __('app.users.roles'), 'sortable' => false],
            ['index' => 'created_at', 'label' => __('app.users.created')],
            ['index' => 'action', 'sortable' => false],
        ];
    }

    public function render(): View
    {
        return view('livewire.users.index');
    }

    #[Computed]
    public function rows(): LengthAwarePaginator
    {
        return User::query()
            ->with(['roles'])
            ->whereNotIn('id', [Auth::id()])
            ->when($this->search !== null, function (Builder $query) {
                $term = '%'.mb_trim($this->search).'%';

                $query->where(function (Builder $query) use ($term) {
                    $query->whereAny(['name', 'first_name', 'last_name', 'email'], 'like', $term);
                });
            })
            ->orderBy(...array_values($this->sort))
            ->paginate($this->quantity)
            ->withQueryString();
    }
}
