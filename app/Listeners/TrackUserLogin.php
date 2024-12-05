<?php

namespace App\Listeners;

use App\Models\Program;
use App\Models\JobRunYear;
use Illuminate\Support\Carbon;
use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class TrackUserLogin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
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



    }
}
