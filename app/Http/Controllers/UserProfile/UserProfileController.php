<?php

namespace App\Http\Controllers\UserProfile;

use App\Helper\ResponseHelper;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserProfileController extends Controller
{
    // GET USER PROFILE INFORMATION***********************
    public function getUserProfile(Request $request)
    {
        try {
            $user = Auth::user();

            if (! $user) {
                return ResponseHelper::Out(false, 'User not authenticated', 401);
            }

            return ResponseHelper::Out(true, $user, 200);
        } catch (Exception $e) {
            return ResponseHelper::Out(false, 'An error occurred while fetching user profile: ', 500);
        }

    }
    //  GET USER PROFILE INFORMATION END***********************

    // UPDATE USER PROFILE INFORMATION***********************
    public function updateUserProfile(Request $request)
    {
        try {
            $user = Auth::user();

            if (! $user) {
                return ResponseHelper::Out(false, 'User not authenticated', 401);
            }

            $data = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            ]);

            $emailChanged = $data['email'] !== $user->email;

            $user->update($data);

            if ($emailChanged) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return ResponseHelper::Out(true, 'User Profile updated. Please log in again.', 200);
            }

            return ResponseHelper::Out(true, 'User profile updated successfully', 200);

        } catch (Exception $e) {
            return ResponseHelper::Out(false, 'An error occurred while updating user profile: '.$e->getMessage(), 500);
        }
    }
    // UPDATE USER PROFILE INFORMATION END***********************

    // UPDATE USER PASSWORD INFORMATION***********************
    public function updateUserPassword(Request $request)
    {
        try {
            $user = Auth::user();

            if (! $user) {
                return ResponseHelper::Out(false, 'User not authenticated', 401);
            }

            $data = $request->validate([
                'current_password' => 'required|string',
                'new_password' => 'required|string|min:6|confirmed',
            ]);

            // Check if the current password is correct
            if (! password_verify($data['current_password'], $user->password)) {
                return ResponseHelper::Out(false, 'Current password is incorrect', 400);
            }

            // Hash the new password before saving
            $hashedPassword = Hash::make($data['new_password']);

            // Update the user's password
            $user->update(['password' => $hashedPassword]);

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return ResponseHelper::Out(true, 'Password updated successfully,Please Log In Again', 200);

        } catch (Exception $e) {
            return ResponseHelper::Out(false, 'An error occurred while updating password', 500);
        }
    }
    // UPDATE USER PASSWORD INFORMATION END***********************

}
