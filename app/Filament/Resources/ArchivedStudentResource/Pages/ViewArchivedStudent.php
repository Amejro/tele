<?php

namespace App\Filament\Resources\ArchivedStudentResource\Pages;

use App\Filament\Resources\ArchivedStudentResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewArchivedStudent extends ViewRecord
{
    protected static string $resource = ArchivedStudentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
