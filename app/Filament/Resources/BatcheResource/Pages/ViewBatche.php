<?php

namespace App\Filament\Resources\BatcheResource\Pages;

use App\Filament\Resources\BatcheResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewBatche extends ViewRecord
{
    protected static string $resource = BatcheResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
