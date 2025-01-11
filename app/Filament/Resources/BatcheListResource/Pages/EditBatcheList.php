<?php

namespace App\Filament\Resources\BatcheListResource\Pages;

use App\Filament\Resources\BatcheListResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBatcheList extends EditRecord
{
    protected static string $resource = BatcheListResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
