<?php

namespace App\Filament\Resources;

use App\Models\BatcheList;
use Filament\Forms;
use Filament\Tables;
use App\Models\School;
use App\Models\Student;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;


use App\Models\ArchivedStudent;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Support\Contracts\HasLabel;
use Filament\Tables\Actions\ActionGroup;
use App\Filament\Exports\StudentExporter;
use App\Filament\Imports\StudentImporter;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ImportAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Wizard\Step;
use Illuminate\Contracts\Support\Htmlable;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Resources\Pages\ListRecords\Tab;
use Filament\Tables\Actions\ExportBulkAction;
use App\Filament\Resources\StudentResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\StudentResource\RelationManagers;


class StudentResource extends Resource
{
    protected static ?string $model = Student::class;
    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    // protected static ?string $recordTitleAttribute = 'index_number';
    //     public static function getGlobalSearchResultDetails(Student $record): array
// {
//     return [
//         'name' => $record->author->name,

    //     ];
// }
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
                TextInput::make('telephone')
                    ->tel()
                    ->required(),

                Select::make('program_id')
                    ->relationship('program', 'name')
                    ->required(),

                Select::make('level')->options(Level::class)
                    ->required(),

                Select::make('batche_list_id')
                    ->label('Caller number')
                    ->relationship('batcheList', 'caller_number')
                    ->live()
                    ->afterStateUpdated(function (Get $get, Set $set) {
                        $SN = BatcheList::find($get('batche_list_id'))->serial_number;

                        return $set('serial_number', $SN);
                    })
                    ->required(),

                Forms\Components\Placeholder::make('serial_number')

                    ->content(function (Get $get, $record) {

                        if ($record || $get('batche_list_id')) {
                            $SN = BatcheList::find($get('batche_list_id'))->serial_number;

                            return $SN;
                        }
                    }),

                Select::make('status')->options(Status::class)->required(),

                TextInput::make('expected_completion_year')->required()->numeric(),
                Toggle::make('is_verified')
                    ->hidden(function ($record) {
                        return !$record;
                    })

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                // ->searchable()
                ,
                Tables\Columns\TextColumn::make('email')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('index_number')
                    ->searchable()
                ,
                Tables\Columns\TextColumn::make('program.name')
                    ->numeric(),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('telephone')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('level')
                ,

                Tables\Columns\TextColumn::make('expected_completion_year')
                    ->label('Completion year')
                ,
                Tables\Columns\TextColumn::make('batcheList.caller_number')
                    ->label('Caller Number'),
                Tables\Columns\IconColumn::make('is_verified')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
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

                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    Action::make('deactivate')
                        ->icon('heroicon-o-user-minus')
                        ->label('Deactivate')
                        ->requiresConfirmation()
                        ->action(function (Student $student) {
                            ArchivedStudent::create($student->toArray());
                            $student->delete();
                        })
                        ->successNotification(
                            Notification::make()
                                ->title('Student has been deactivated')
                                ->success()
                        ),
                    DeleteAction::make(),

                ]),

            ])
            ->headerActions([
                ExportAction::make()->exporter(StudentExporter::class),
                ImportAction::make()->importer(StudentImporter::class),
                Action::make('Archive Students')
                    ->databaseTransaction(function () {


                        // dd($this->activeTab);
            



                        $graduatingStudents = Student::where('status', 'graduating')->get();

                        if ($graduatingStudents->isEmpty()) {
                            Notification::make()
                                ->title('There are no Graduating Students to archive')
                                ->danger()
                                ->send();

                            return;
                        }

                        $archiveStudet = new ArchivedStudent();

                        foreach ($graduatingStudents as $graduatingStudent) {

                            $archiveStudet->create([
                                'name' => $graduatingStudent->name,
                                'email' => $graduatingStudent->email,
                                'index_number' => $graduatingStudent->index_number,
                                'program_id' => $graduatingStudent->program_id,
                                'telephone' => $graduatingStudent->telephone,
                                "status" => "graduated",
                                'level' => $graduatingStudent->level,
                                'program_type' => $graduatingStudent->program_type,
                                'telcos_number' => $graduatingStudent->telcos_number,
                                'serial_number' => $graduatingStudent->serial_number,
                                'expected_completion_year' => $graduatingStudent->expected_completion_year,
                                'registered_at' => $graduatingStudent->created_at,
                                'last_updated_at' => $graduatingStudent->updated_at,
                            ]);

                            Student::where('id', $graduatingStudent->id)->delete();

                        };

                        Notification::make()
                            ->title('All Graduating Students have been archived')
                            ->success()
                            ->send();
                    })
                    ->hidden(function () {
                        return Student::where('status', 'graduating')->get()->isEmpty();
                    })
                ,


            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
                ExportBulkAction::make()->exporter(StudentExporter::class),

            ])

        ;
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


enum Status: string implements HasLabel
{
    case Active = 'active';
    case Graduating = 'graduating';
    // case Graduated = 'graduated';

    public function getLabel(): ?string
    {
        return $this->name;

    }
}


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