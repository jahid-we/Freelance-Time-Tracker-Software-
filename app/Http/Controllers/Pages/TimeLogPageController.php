<?php

namespace App\Http\Controllers\Pages;

use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TimeLogPageController extends Controller
{
    // Client page Function Start ***************************
    public function timeLog(Request $request): Response
    {
        return Inertia::render('TimeLog/TimeLogPage');
    }
    // Client page Function End *****************************
}
