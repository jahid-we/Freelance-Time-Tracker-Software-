<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class DashboardPageController extends Controller
{
    // Dashboard page Function Start ***************************
    public function dashboard(Request $request): Response
    {
        return Inertia::render('DashboardPage', [
            'auth' => [
                'user' => Auth::user(),
            ],
        ]);
    }
    // Dashboard page Function End *****************************
}
