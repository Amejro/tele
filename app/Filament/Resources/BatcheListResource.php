<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BatcheListResource\Pages;
use App\Filament\Resources\BatcheListResource\RelationManagers;
use App\Models\BatcheList;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BatcheListResource extends Resource
{
    protected static ?string $model = BatcheList::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('serial_number')
                    ->required(),
                Forms\Components\TextInput::make('caller_number')
                    ->required(),
                Forms\Components\Select::make('batche_id')
                    ->relationship('batche', 'name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('serial_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('caller_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('batche.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBatcheLists::route('/'),
            'create' => Pages\CreateBatcheList::route('/create'),
            'view' => Pages\ViewBatcheList::route('/{record}'),
            'edit' => Pages\EditBatcheList::route('/{record}/edit'),
        ];
    }
}
