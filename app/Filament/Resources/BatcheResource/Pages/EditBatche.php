<?php

namespace App\Filament\Resources\BatcheResource\Pages;

use App\Filament\Resources\BatcheResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBatche extends EditRecord
{
    protected static string $resource = BatcheResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
