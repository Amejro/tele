<?php

namespace App\Filament\Widgets;

use App\Models\Program;
use Filament\Widgets\ChartWidget;

class ProgramStudentChart extends ChartWidget
{
    protected static ?string $heading = 'Students by Program';
    protected static ?int $sort = 2;
    protected function getData(): array
    {
        $programs = Program::with('students')->get();

        // Prepare the data for the chart
        $labels = $programs->pluck('name'); // Program names for the x-axis
        $data = $programs->map(fn($program) => $program->students->count()); // Student counts for the y-axis

        return [
            'datasets' => [
                [
                    'label' => 'Number of Students',
                    'data' => $data, // Y-axis data
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)', // Customize colors
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'borderWidth' => 1,


                    'maxBarThickness' => 25,
                ],
            ],
            'labels' => $labels, // X-axis labels
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
