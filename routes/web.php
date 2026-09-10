<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::post('/register', [RegistrationController::class, 'store'])
    ->middleware('throttle:12,1')
    ->name('registrations.store');
