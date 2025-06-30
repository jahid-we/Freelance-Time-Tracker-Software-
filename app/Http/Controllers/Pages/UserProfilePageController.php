<?php

namespace App\Http\Controllers\Pages;

use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserProfilePageController extends Controller
{
    // Profile page Function Start ***************************
    public function userProfile(Request $request): Response
    {
        return Inertia::render('UserProfile/UserProfilePage');
    }
    // Profile page Function End *****************************
}
