<?php

use App\Livewire\StudentForm;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('student', StudentForm::class);

// Route::view('/welcome', 'welcome');



