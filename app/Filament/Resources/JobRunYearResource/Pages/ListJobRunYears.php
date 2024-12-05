<?php

namespace App\Filament\Resources\JobRunYearResource\Pages;

use App\Filament\Resources\JobRunYearResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJobRunYears extends ListRecords
{
    protected static string $resource = JobRunYearResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
