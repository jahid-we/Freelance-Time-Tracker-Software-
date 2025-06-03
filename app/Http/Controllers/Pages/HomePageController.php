<?php

namespace App\Http\Controllers\pages;

use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomePageController extends Controller
{
    // Home page Function Start ***************************
    public function home(Request $request):Response{
        return Inertia::render('HomePage');
    }
    // Home page Function End *****************************
}
