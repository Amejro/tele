<?php

namespace App\Livewire;

// use App\Models\Post;
use App\Models\School;
use Blueprint\Builder;
use App\Models\Program;
use App\Models\Student;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Livewire\Component;
use Filament\Forms\Form;
use Filament\Actions\Action;

use Filament\Actions\CreateAction;
use Illuminate\Support\Collection;
// use Filament\Forms\Components\Actions\Action;
use Illuminate\Contracts\View\View;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Support\Contracts\HasLabel;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Actions\Concerns\InteractsWithActions;

class StudentForm extends Component implements HasForms, HasActions
{
    use InteractsWithForms;
    use InteractsWithActions;
    public ?array $data = [];

    // public function mount(): void
    // {
    //     $this->form->fill();
    // }

    public Student $students;
    public function mount(Student $student): void
    {
        $this->form->fill($student->toArray());
    }




    public function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make()

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
                    ])->columns(2),


                Section::make()

                    ->schema([
                        Select::make('school')
                            ->options(function () {
                                return School::all()->pluck('name', 'id');

                            })
                            ->label('School')
                            ->live()
                            ->required(),

                        Select::make('program_id')
                            // ->relationship('program', 'name')
                            ->label('Program')
                            ->options(fn(Get $get): Collection => Program::query()
                                ->where('school_id', $get('school'))
                                ->pluck('name', 'id'))
                            ->live()
                            ->required(),


                        Select::make('level')->options(Level::class, )
                            ->live()
                            ->disabled(fn(Get $get) => $get('program_id') === null)
                            // ->visible(fn(Get $get) => $get('program_id') !== null)
                            ->afterStateUpdated(function (Set $set, Get $get) {

                                $duration = Program::find($get('program_id'))->regular_duration;

                                $remaining = $duration - (int) substr($get('level'), 0, 1) + 1;

                                $completion_year = date('Y') + $remaining;

                                $set('expected_completion_year', $completion_year);
                            })
                            ->required(),

                        Radio::make('program_type')
                            ->options(ProgramType::class)->columns(2),

                        TextInput::make('expected_completion_year')
                            ->required()
                            ->numeric()
                            ->live()
                            ->readOnly()
                        ,

                        TextInput::make('telcos_number')
                            ->label('Telcel Number')
                            ->tel()
                        ,


                    ])->columns(2),



            ])
            ->statePath('data')
            ->model(Student::class);


    }



    public function publishAction(): Action
    {
        // dd($this->form->getState());
        return Action::make('publish')
            ->label('Submite')
            ->action(function () {
                $st = Student::create($this->form->getState());

                if ($st->wasRecentlyCreated) {
                    Notification::make()
                        ->title('Created successfully')
                        ->success()
                        ->send();
                } else {
                    Notification::make()
                        ->title('Failed to create')
                        ->error()
                        ->send();
                }

                $this->form->fill();

            });




    }


    public function render(): View
    {
        return view('livewire.student-form');
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

