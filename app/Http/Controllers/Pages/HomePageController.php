<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class HomePageController extends Controller
{
    // Home page Function Start ***************************
    public function home(Request $request): Response
    {
        return Inertia::render('HomePage');
    }
    // Home page Function End *****************************
}
