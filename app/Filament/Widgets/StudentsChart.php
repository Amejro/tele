<?php

namespace App\Filament\Widgets;

use App\Models\Student;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;

class StudentsChart extends ChartWidget
{
    protected static ?string $heading = 'Students by Level';
    protected static ?int $sort = 2;
    protected static string $color = 'info';

    protected function getData(): array
    {
        $data = Student::selectRaw('level, COUNT(*) as total')
            ->groupBy('level')
            ->orderBy('level', 'asc') // Ensure levels are sorted in ascending order
            ->get();

        return [
            'datasets' => [
                [
                    'label' => "Students by Level ",
                    'data' => $data->pluck('total'), // Extract the counts
                    'backgroundColor' => [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(201, 203, 207, 0.2)'
                    ],
                    'borderColor' => [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                        'rgb(153, 102, 255)',
                        'rgb(201, 203, 207)'
                    ],
                    'borderWidth' => 1,

                    'maxBarThickness' => 25,
                ],
            ],
            'labels' => $data->pluck('level'), // Extract the levels
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
