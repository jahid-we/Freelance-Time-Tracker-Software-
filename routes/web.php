<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Clients\ClientController;
use App\Http\Controllers\Pages\AuthPageController;
use App\Http\Controllers\pages\HomePageController;
use App\Http\Controllers\Pages\ClientPageController;
use App\Http\Controllers\Pages\ReportPageController;
use App\Http\Controllers\Projects\ProjectController;
use App\Http\Controllers\TimeLogs\TimeLogController;
use App\Http\Controllers\Pages\ProjectPageController;
use App\Http\Controllers\Pages\TimeLogPageController;
use App\Http\Controllers\Authentication\AuthController;
use App\Http\Controllers\Pages\DashboardPageController;
use App\Http\Controllers\Pages\UserProfilePageController;
use App\Http\Controllers\UserProfile\UserProfileController;

// ==================================================
// API Route Definitions for Freelance Time Tracker
// Uses Laravel Sanctum for API token authentication
// ==================================================

// =====================================================
// =============== Authentication Routes ===============
// =====================================================
Route::middleware('guest')->controller(AuthController::class)->group(function () {

    Route::post('/register', 'register')->name('register');
    Route::post('/login', 'login')->name('login');
    Route::post('/reset-password-email', 'resetPasswordEmail')->name('reset-password-email');
    Route::post('/reset-password', 'resetPassword')->name('reset-password');

});

// =====================================================
// =============== Protected Auth Routes ===============
// =====================================================
Route::middleware('auth')->controller(AuthController::class)->group(function () {
    Route::get('/logout', 'logout')->name('logout');
});

// =====================================================
// =============== User Profile Routes =================
// =====================================================
Route::middleware('auth')->controller(UserProfileController::class)->group(function () {

    Route::get('/get-user-profile', 'getUserProfile')->name('get-user-profile');
    Route::post('/update-user-profile', 'updateUserProfile')->name('update-user-profile');
    Route::post('/update-user-password', 'updateUserPassword')->name('update-user-password');

});

// =====================================================
// =============== Client Routes =======================
// =====================================================
Route::middleware('auth')->controller(ClientController::class)->group(function () {

    Route::post('/create-client', 'createClient')->name('create-client');
    Route::get('/get-clients', 'getClients')->name('get-clients');
    Route::get('/get-client/{id}', 'getClient')->name('get-client');
    Route::post('/update-client/{id}', 'updateClient')->name('update-client');
    Route::delete('/delete-client/{id}', 'deleteClient')->name('delete-client');
    Route::delete('/delete-all-clients', 'deleteAllClients')->name('delete-all-clients');

});

// =====================================================
// =============== Project Routes ======================
// =====================================================
Route::middleware('auth')->controller(ProjectController::class)->group(function () {

    Route::post('/create-project', 'createProject')->name('create-project');
    Route::get('/get-all-projects', 'getAllProjects')->name('get-all-projects');
    Route::get('/get-project/{id}', 'getProject')->name('get-project');
    Route::post('/update-project/{id}', 'updateProject')->name('update-project');
    Route::delete('/delete-project/{id}', 'deleteProject')->name('delete-project');
    Route::delete('/delete-all-projects', 'deleteAllProjects')->name('delete-all-projects');
    Route::get('/get-projects-by-client/{clientId}', 'getProjectsByClient')->name('get-projects-by-client');

});

// =====================================================
// =============== Time Log Related Routes =============
// =====================================================
Route::middleware('auth')->controller(TimeLogController::class)->group(function () {

    Route::post('/start-timelog/{projectId}', 'start')->name('start-timelog');
    Route::post('/end-timelog/{projectId}', 'end')->name('end-timelog');

    Route::post('/manual-entry/{projectId}', 'manualEntry')->name('manual-entry');

    Route::get('/get-timelogs', 'getTimeLogs')->name('get-timelogs');
    Route::get('/get-timelog/{id}', 'getTimeLogById')->name('get-timelog');
    Route::post('/update-timelog/{id}', 'update')->name('update-timelog');
    Route::delete('/delete-timelog/{id}', 'delete')->name('delete-timelog');
    Route::delete('/delete-all-timelogs', 'deleteAll')->name('delete-all-timelogs');

    // Report Route (search or filter time logs)
    Route::get('/search', 'search')->name('timelog.search');

    // Export PDF Route (generates a downloadable report)
    Route::get('/export-pdf', 'exportTimeLogs')->name('export-pdf');

});

// =====================================================
// =============== Home Page Routes ===============
// =====================================================
Route::controller(HomePageController::class)->group(function () {

    Route::get('/', 'home')->name('home');

});

// =====================================================
// =============== Authentication Page Routes ===============
// =====================================================
Route::middleware('guest')->controller(AuthPageController::class)->group(function () {

    Route::get('/registerPage', 'registerPage')->name('registerPage');
    Route::get('/login', 'loginPage')->name('loginPage');
    Route::get('/reset-link', 'sendResetPasswordEmailPage')->name('sendResetPasswordEmailPage');
    Route::get('/reset-password/{token}', 'resetPasswordPage')->name('resetPasswordPage');

});
// =====================================================
// =============== User Profile Page Routes ===============
// =====================================================
Route::middleware('auth')->controller(UserProfilePageController::class)->group(function () {

    Route::get('/profile', 'userProfile')->name('userProfile');

});

// =====================================================
// =============== DashBoard Page Routes ===============
// =====================================================
Route::middleware('auth')->controller(DashboardPageController::class)->group(function () {

    Route::get('/dashboard', 'dashboard')->name('dashboard');

});

// =====================================================
// =============== Client Page Routes ==================
// =====================================================
Route::middleware('auth')->controller(ClientPageController::class)->group(function () {

    Route::get('/client', 'client')->name('client');

});

// =====================================================
// =============== Project Page Routes ==================
// =====================================================
Route::middleware('auth')->controller(ProjectPageController::class)->group(function () {

    Route::get('/project', 'project')->name('project');

});
// =====================================================
// =============== Time Log Page Routes ==================
// =====================================================
Route::middleware('auth')->controller(TimeLogPageController::class)->group(function () {

    Route::get('/timeLog', 'timeLog')->name('timeLog');

});
// =====================================================
// =============== Report Page Routes ==================
// =====================================================
Route::middleware('auth')->controller(ReportPageController::class)->group(function () {

    Route::get('/report', 'report')->name('report');

});
