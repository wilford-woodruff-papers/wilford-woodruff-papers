<?php

namespace App\Filament\Widgets;

use App\Models\Action;
use App\Models\ActionType;
use App\Models\Page;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class ActionsCompletedChart extends ChartWidget
{
    protected static ?string $heading = 'Tasks Completed';

    protected int|string|array $columnSpan = 4;

    protected static ?string $maxHeight = '250px';

    protected function getData(): array
    {
        $period = collect(today()->startOfMonth()->subMonths(12)->monthsUntil(today()->startOfMonth()))
            ->mapWithKeys(fn ($month) => [$month->month => $month->shortMonthName])
            ->reverse();
        $types = ActionType::query()->where('type', 'Documents')->get();

        $datasets = [];
        foreach ($types as $key => $type) {
            $datasets[] = [
                'label' => $type->name,
                'data' => Trend::query(Action::query()->where('action_type_id', $type->id)->where('actionable_type', Page::class))
                    ->dateColumn('completed_at')
                    ->between(
                        start: today()->startOfMonth()->subMonths(11),
                        end: today()->endOfMonth()
                    )
                    ->perMonth()
                    ->count()
                    ->map(fn (TrendValue $value) => $value->aggregate),
                'borderColor' => $this->getDataColor($key),
                //                'borderColor' => '#9BD0F5',
            ];
            if ($key === 0) {
                $labels = Trend::query(Action::query()->where('action_type_id', $type->id))
                    ->dateColumn('completed_at')
                    ->between(
                        start: today()->startOfMonth()->subMonths(11),
                        end: today()->endOfMonth()
                    )
                    ->perMonth()
                    ->count()
                    ->map(fn (TrendValue $value) => $value->date);
            }
        }

        //dd($datasets);

        return [
            'datasets' => $datasets,
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getDataColor($key): string
    {
        return match ($key) {
            0 => '#B91C1C',
            1 => '#C2410C',
            2 => '#B45309',
            3 => '#A16207',
            4 => '#4D7C0F',
            5 => '#0E7490',
            6 => '#1D4ED8',
            7 => '#4338CA',
            8 => '#6D28D9',
            9 => '#A21CAF',
            default => '#BE123C',
        };
    }
}
