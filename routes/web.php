<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\SocialShareImageController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/social-share-image', SocialShareImageController::class)->name('social-share-image');

Route::post('/register', [RegistrationController::class, 'store'])
    ->middleware('throttle:12,1')
    ->name('registrations.store');
