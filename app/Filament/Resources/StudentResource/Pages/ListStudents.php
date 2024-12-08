<?php

namespace App\Filament\Resources\StudentResource\Pages;

use Filament\Actions;
use App\Models\Student;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\StudentResource;
use Filament\Resources\Pages\ListRecords\Tab;

class ListStudents extends ListRecords
{
    protected static string $resource = StudentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }


    public function getTabs(): array
    {
        return [
            'All' => Tab::make(),
            'Active' => Tab::make()->modifyQueryUsing(fn(Builder $query) => $query->where('status', '=', 'active'))->badge(Student::query()->where('status', '=', 'active')->count()),

            'Graduating' => Tab::make()->modifyQueryUsing(fn(Builder $query) => $query->where('status', '=', 'graduating'))->badge(Student::query()->where('status', '=', 'graduating')->count()),

            // 'Graduated' => Tab::make()->modifyQueryUsing(fn(Builder $query) => $query->where('status', '=', 'graduated'))->badge(Student::query()->where('status', '=', 'graduated')->count()),

        ];

    }

}
