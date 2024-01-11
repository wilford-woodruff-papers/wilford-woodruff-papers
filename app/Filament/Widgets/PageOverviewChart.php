<?php

namespace App\Filament\Widgets;

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
                    'data' => collect($this->statuses)->sortBy('page_count')->pluck('page_count')->toArray(),
                    'backgroundColor' => [
                        '#84CC16',
                        '#EAB308',
                        '#D97706',
                        '#DC2626',
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
