<?php

namespace App\Filament\Pages\Widgets;

use Filament\Widgets\ChartWidget;

class PageOverviewChart extends ChartWidget
{
    protected static ?string $heading = '# of Tasks Needed For Publication';

    protected static ?string $maxHeight = '250px';

    public $statuses;

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Tasks Needed',
                    'data' => collect($this->statuses)->sortBy('task_count')->pluck('page_count')->toArray(),
                    'backgroundColor' => [
                        '#15803D',
                        '#FDE047',
                        '#F59E0B',
                        '#D946EF',
                        '#EF4444',
                    ],
                ],
            ],
            'labels' => collect($this->statuses)->sortBy('task_count')->pluck('task_count')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'x' => [
                    'display' => false,
                    'grid' => [
                        'display' => false,
                    ],
                    'axis' => [
                        'display' => false,
                    ],
                ],
                'y' => [
                    'display' => false,
                    'grid' => [
                        'display' => false,
                    ],
                    'axis' => [
                        'display' => false,
                    ],
                ],
            ],
        ];
    }
}
