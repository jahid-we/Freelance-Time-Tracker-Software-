<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\pages\HomePageController;

// =====================================================
// =============== Home Routes ===============
// =====================================================
Route::middleware('guest')->controller(HomePageController::class)->group(function () {

    Route::get('/', 'home')->name('home');

});
