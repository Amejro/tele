<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


Schedule::command('app:promote-student-scheduled')->everyMinute()->sendOutputTo('storage/logs/promote-student-scheduled.log');


//  schedule(Schedule $schedule)
// {
//     $schedule->command('students:promote')->yearlyOn(1, 0, 0); // Runs every January 1st at midnight
// };