<?php

namespace App\Console\Commands;

use App\Models\Program;
use App\Models\Student;
use Illuminate\Console\Command;

class PromoteStudentScheduled extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:promote-student-scheduled';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Promote students to the next level based on their current level and  program';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $programs = Program::with('students')->get();

        foreach ($programs as $program) {
            foreach ($program->students as $student) {
                // Calculate the maximum level based on the program's regular duration
                $maxLevel = $program->regular_duration * 100;

                // Promote the student if they are not in their final level
                if ((int) $student->level < $maxLevel) {
                    $student->level = (string) ((int) $student->level + 100);
                    $student->save();

                    $this->info("Promoted student ID {$student->id} to level {$student->level}");
                } else {
                    $this->info("Student ID {$student->id} is already at the maximum level.");
                }
            }
        }



        // return Command::SUCCESS;
    }

}
