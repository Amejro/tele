<?php

use App\Jobs\PromoteStudentJob;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


Schedule::command('app:promote-student-scheduled')->everyMinute()->sendOutputTo('storage/logs/promote-student-scheduled.log');



Schedule::job(new PromoteStudentJob)->weekly()->where();
