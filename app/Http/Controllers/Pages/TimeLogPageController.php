<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TimeLogPageController extends Controller
{
    // Client page Function Start ***************************
    public function timeLog(Request $request): Response
    {
        return Inertia::render('TimeLog/TimeLogPage');
    }
    // Client page Function End *****************************
}
