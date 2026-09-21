<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Call;
use Livewire\Component;
use App\Models\Incident;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Computed;
use Illuminate\Contracts\View\View;

class Dashboard extends Component
{
    private const MONTHS_SHOWN = 12;

    public function render(): View
    {
        return view('livewire.dashboard');
    }

    #[Computed]
    public function incidentsCount(): int
    {
        return Incident::query()->count();
    }

    #[Computed]
    public function callsCount(): int
    {
        return Call::query()->count();
    }

    /**
     * Incidents per month for the last months, oldest first.
     *
     * @return list<array{label: string, count: int}>
     */
    #[Computed]
    public function incidentsPerMonth(): array
    {
        $start = Carbon::now()->startOfMonth()->subMonths(self::MONTHS_SHOWN - 1);

        $counts = Incident::query()
            ->where('created_at', '>=', $start)
            ->pluck('created_at')
            ->countBy(fn (Carbon $date): string => $date->format('Y-m'));

        return collect(range(0, self::MONTHS_SHOWN - 1))
            ->map(function (int $offset) use ($start, $counts): array {
                $month = $start->copy()->addMonths($offset);

                return [
                    'label' => $month->translatedFormat('M y'),
                    'count' => $counts->get($month->format('Y-m'), 0),
                ];
            })
            ->all();
    }
}
