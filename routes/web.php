<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pages\AuthPageController;
use App\Http\Controllers\pages\HomePageController;

// =====================================================
// =============== Home Routes ===============
// =====================================================
Route::middleware('guest')->controller(HomePageController::class)->group(function () {

    Route::get('/', 'home')->name('home');


});

// =====================================================
// =============== Authentication Page Routes ===============
// =====================================================
Route::middleware('guest')->controller(AuthPageController::class)->group(function () {


    Route::get('/registerPage', 'registerPage')->name('registerPage');
    Route::get('/loginPage', 'loginPage')->name('loginPage');
    Route::get('/reset-link', 'sendResetPasswordEmailPage')->name('sendResetPasswordEmailPage');
    Route::get('/reset-password/{token}', 'resetPasswordPage')->name('resetPasswordPage');

});
