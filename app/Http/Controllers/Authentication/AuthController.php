<?php

namespace App\Http\Controllers\Authentication;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helper\ResponseHelper;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Notifications\ResetPasswordNotification;

class AuthController extends Controller
{
    // Registration Part start ***************************
    public function register(request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6',
            ]);
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return ResponseHelper::Out(true, 'Registration Successful', 201);

        } catch (ValidationException $e) {
            return ResponseHelper::Out(false, $e->errors(), 422);
        } catch (Exception $e) {
            return ResponseHelper::Out(false, 'Registration Failed, Please Try Again.', 500);

        }
    }
    // Registration Part end ***************************

    // Login Part start ***************************
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|string|email|max:255|exists:users,email',
                'password' => 'required|string|min:6',
            ]);
            $credentials = $request->only('email', 'password');
            $remember = ($request->filled('remember')) ? true : false;
            if (Auth::attempt($credentials, $remember)) {
                $user = Auth::user();
                $token = $user->createToken('auth_token')->plainTextToken;

                return ResponseHelper::Out(true, 'Login Successful', 200, $token);
            } else {
                return ResponseHelper::Out(false, 'Invalid Credentials,Check Your Email Or Password.', 401);
            }
        } catch (ValidationException $e) {
            return ResponseHelper::Out(false, $e->errors(), 422);
        } catch (Exception $e) {
            return ResponseHelper::Out(false, 'Login Failed, Please Try Again.', 500);
        }
    }
    // Login Part end ***************************

    // Logout Part start ***************************
    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return ResponseHelper::Out(true, 'Logout Successful', 200);
        } catch (Exception $e) {
            return ResponseHelper::Out(false, 'Logout Failed, Please Try Again.', 500);
        }
    }
    // Logout Part end ***************************

    // Reset Password Email Send Part start ***************************
    public function resetPasswordEmail(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|string|email|max:255|exists:users,email',
            ]);

            $token = Str::random(64);
            DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $request->email],
                [
                    'token' => $token,
                    'created_at' => Carbon::now(),
                ]
            );
            $user = User::where('email', $request->email)->first();
            $user->notify(new ResetPasswordNotification($token));

            return ResponseHelper::Out(true, 'Reset Password Link Sent to Your Email', 200);
        } catch (ValidationException $e) {
            return ResponseHelper::Out(false, $e->errors(), 422);
        } catch (Exception $e) {
            return ResponseHelper::Out(false, 'Failed to Send Reset Password Link, Please Try Again.', 500);
        }
    }
    // Reset Password Email Send Part end ***************************

    // Reset Password Part start ***************************
    public function resetPassword(Request $request)
    {
        try {
            $request->validate([
                'token' => 'required',
                'password' => 'required|string|min:6|confirmed',
            ]);

            $token = DB::table('password_reset_tokens')->where('token', $request->token)->first();
            if (! $token) {
                return ResponseHelper::Out(false, 'Invalid or Expired Token', 400);
            }
            $user = User::where('email', $token->email)
                ->update(['password' => Hash::make($request->password)]);
            DB::table('password_reset_tokens')->where(['token' => $request->token])->delete();

            return ResponseHelper::Out(true, 'Password Reset Successful', 200);

        } catch (ValidationException $e) {
            return ResponseHelper::Out(false, $e->errors(), 422);
        } catch (Exception $e) {
            return ResponseHelper::Out(false, 'Failed to Reset Password, Please Try Again.', 500);
        }
    }
    // Reset Password Part end ***************************
}
