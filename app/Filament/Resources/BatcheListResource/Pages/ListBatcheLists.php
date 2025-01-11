<?php

namespace App\Filament\Resources\BatcheListResource\Pages;

use App\Filament\Resources\BatcheListResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBatcheLists extends ListRecords
{
    protected static string $resource = BatcheListResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
