<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\School;
use App\Models\Student;
use Filament\Forms\Form;
use Filament\Tables\Table;

use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Support\Contracts\HasLabel;
use App\Filament\Exports\StudentExporter;
use App\Filament\Imports\StudentImporter;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ImportAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Tables\Actions\ExportBulkAction;
use App\Filament\Resources\StudentResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\StudentResource\RelationManagers;


class StudentResource extends Resource
{
    protected static ?string $model = Student::class;
    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->email()
                    ->required(),
                TextInput::make('index_number')
                    ->required(),
                Select::make('program_id')
                    ->relationship('program', 'name')
                    ->required(),
                TextInput::make('telephone')
                    ->tel()
                    ->required(),

                Select::make('name')
                    ->model(School::class)
                    ->label('School')
                    ->required(),

                Select::make('level')->options(Level::class)
                    ->required(),
                Radio::make('program_type')
                    ->options(ProgramType::class)->columns(2),
                TextInput::make('telcos_number')->tel()->required(),
                TextInput::make('expected_completion_year')->required()->numeric(),
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
                    ->searchable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('level')
                    ->searchable(),
                Tables\Columns\TextColumn::make('program_type')
                    ->searchable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('telcos_number')
                    ->label('Telcel Number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('expected_completion_year')

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
                SelectFilter::make('program')
                    ->relationship('program', 'name')
                    ->searchable()
                    ->preload()
                ,

                Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from'),
                        DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->headerActions([
                ExportAction::make()->exporter(StudentExporter::class),
                ImportAction::make()->importer(StudentImporter::class),


            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
                ExportBulkAction::make()->exporter(StudentExporter::class),

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
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'view' => Pages\ViewStudent::route('/{record}'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}


enum ProgramType: string implements HasLabel
{
    case Regular = 'regular';
    case Top_up = 'top_up';

    public function getLabel(): ?string
    {
        return $this->name;

    }
}

// 100,200,300,400,500,600
enum Level: string implements HasLabel
{
    case Level_100 = '100';
    case Level_200 = '200';
    case Level_300 = '300';
    case Level_400 = '400';
    case Level_500 = '500';
    case Level_600 = '600';


    public function getLabel(): ?string
    {
        return $this->name;

    }
}