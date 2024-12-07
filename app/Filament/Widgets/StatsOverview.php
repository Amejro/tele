<?php

namespace App\Filament\Widgets;

use App\Models\School;
use App\Models\Student;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;



    protected function getStats(): array
    {


        return [
            Stat::make('Students', Student::query()->count())
                ->description('All students')
                ->icon('heroicon-o-user-group'),



        ];
    }
}
