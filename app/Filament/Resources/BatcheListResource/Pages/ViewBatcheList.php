<?php

namespace App\Filament\Resources\BatcheListResource\Pages;

use App\Filament\Resources\BatcheListResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewBatcheList extends ViewRecord
{
    protected static string $resource = BatcheListResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
