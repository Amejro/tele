<?php

use App\Livewire\StudentForm;
use Illuminate\Support\Facades\Route;

// Route::get('/welcome', function () {
//     return view('welcome');
// });

Route::get('/', StudentForm::class);





