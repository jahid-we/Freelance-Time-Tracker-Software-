<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AuthPageController extends Controller
{
    // Register Page Start ***************************
    public function registerPage(Request $request): Response
    {
        return Inertia::render('Authentication/RegisterPage');
    }
    // Register Page End ******************************

    // Login Page Start ***************************
    public function loginPage(Request $request): Response
    {
        return Inertia::render('Authentication/LoginPage');
    }
    // Login Page End ******************************

    // Send Reset Password  Email Page Start ****************
    public function sendResetPasswordEmailPage(Request $request): Response
    {
        return Inertia::render('Authentication/ResetPassEmailPage');
    }
    // Send Reset Password  Email Page End ******************

    // Reset Password Page Start ****************
    public function resetPasswordPage(string $token): Response
    {
        return Inertia::render('Authentication/ResetPasswordPage',
            [
                'token' => $token,
            ]);
    }
    // Reset Password Page End ******************
}
