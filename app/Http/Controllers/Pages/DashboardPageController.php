<?php

namespace App\Http\Controllers\Pages;

use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardPageController extends Controller
{
     // Dashboard page Function Start ***************************
    public function dashboard(Request $request): Response
    {
        return Inertia::render('DashboardPage', [
            'auth' => [
                'user' => Auth::user(),
            ]
        ]);
    }
    // Dashboard page Function End *****************************
}
