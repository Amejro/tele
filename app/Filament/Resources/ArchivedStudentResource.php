<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArchivedStudentResource\Pages;
use App\Filament\Resources\ArchivedStudentResource\RelationManagers;
use App\Models\ArchivedStudent;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ArchivedStudentResource extends Resource
{
    protected static ?string $model = ArchivedStudent::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required(),
                Forms\Components\TextInput::make('index_number')
                    ->required(),
                Forms\Components\Select::make('program_id')
                    ->relationship('program', 'name')
                    ->required(),
                Forms\Components\TextInput::make('telephone')
                    ->tel()
                    ->required(),
                Forms\Components\TextInput::make('level')
                    ->required(),
                Forms\Components\TextInput::make('program_type')
                    ->required(),
                Forms\Components\TextInput::make('telcos_number')
                    ->tel()
                    ->required(),
                Forms\Components\TextInput::make('serial_number')
                    ->required(),
                Forms\Components\TextInput::make('expected_completion_year')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('index_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('program.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('telephone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('level')
                    ->searchable(),
                Tables\Columns\TextColumn::make('program_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('telcos_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('serial_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('expected_completion_year')
                    ->numeric()
                    ->sortable(),

                // Tables\Columns\TextColumn::make('registered_at')
                //     ->dateTime(),
                // Tables\Columns\TextColumn::make('last_updated_at')
                //     ->dateTime(),


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
            'index' => Pages\ListArchivedStudents::route('/'),
            'create' => Pages\CreateArchivedStudent::route('/create'),
            'view' => Pages\ViewArchivedStudent::route('/{record}'),
            'edit' => Pages\EditArchivedStudent::route('/{record}/edit'),
        ];
    }
}
