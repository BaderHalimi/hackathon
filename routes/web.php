<?php

use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

Route::post('/register', [RegistrationController::class, 'store'])
    ->middleware('throttle:12,1')
    ->name('registrations.store');
