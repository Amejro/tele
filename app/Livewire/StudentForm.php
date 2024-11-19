<?php

namespace App\Livewire;

// use App\Models\Post;
use App\Models\Student;
use Livewire\Component;
use Filament\Forms\Form;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Illuminate\Contracts\View\View;
use Filament\Forms\Components\Select;

use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
// use Filament\Forms\Components\Actions\Action;
use Filament\Notifications\Notification;
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
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->email()
                    ->required(),
                TextInput::make('student_id')
                    ->required(),
                Select::make('program_id')
                    ->relationship('program', 'program_name')
                    ->required(),
                TextInput::make('telephone')
                    ->tel()
                    ->required(),
                TextInput::make('level')
                    ->required()
                    ->numeric(),
                TextInput::make('program_type:enum')
                    ->label('Program Type')
                    ->required(),
                TextInput::make('telcost_number')
                    ->label('Telecel Number')
                    ->tel()
                    ->required(),
                TextInput::make('expected_completion_year')
                    ->required()
                    ->numeric(),
            ])->columns(2)
            ->statePath('data')
            ->model(Student::class);


    }



    public function publishAction(): Action
    {
        return Action::make('publish')
            ->label('Submite')
            ->action(function () {
                Student::create($this->form->getState());
                Notification::make()
                    ->title('Created successfully')
                    ->success()
                    ->seconds(5)
                    ->send();
                $this->form->fill();

            });




    }




    // public function create(): void
    // {
    //     Student::create($this->form->getState());




    //     $this->form->fill();


    // }





    public function render(): View
    {
        return view('livewire.student-form');
    }
}

