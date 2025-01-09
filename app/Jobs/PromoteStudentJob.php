<?php

namespace App\Jobs;

use Auth;
use App\Models\User;
use App\Models\Program;
use App\Models\JobRunYear;
use Illuminate\Support\Carbon;
use Filament\Notifications\Notification;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class PromoteStudentJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $currentYear = Carbon::now()->year;

        if (JobRunYear::where('year', $currentYear)->exists()) {

            info("The job has already run for this year");

            return;
        }

        info("The job needs to run for this year");

        // $programs = Program::with('students')->where('student.status', 'active')->get();

        $programs = Program::with([
            'students' => function ($query) {
                $query->where('status', 'active');
            }
        ])->get();

        foreach ($programs as $program) {
            foreach ($program->students as $student) {
                // Calculate the maximum level based on the program's regular duration
                $maxLevel = $program->regular_duration * 100;

                // Promote the student if they are not in their final level
                if ((int) $student->level < $maxLevel) {
                    $student->level = (string) ((int) $student->level + 100);
                    $student->save();

                    info("Promoted student ID {$student->id} to level {$student->level}");
                } else {
                    info("Student ID {$student->id} is already at the maximum level.");
                    $student->status = "graduating";
                    $student->save();
                }
            }
        }

        JobRunYear::create([
            'year' => $currentYear,
        ]);


        Notification::make()
            ->title('Student promotion')
            ->warning()
            ->body('Students have been promoted successfully')
            ->sendToDatabase(User::where('id', '===', 1));




    }
}
