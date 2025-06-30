<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class UserProfilePageController extends Controller
{
    // Profile page Function Start ***************************
    public function userProfile(Request $request): Response
    {
        return Inertia::render('UserProfile/UserProfilePage');
    }
    // Profile page Function End *****************************
}
