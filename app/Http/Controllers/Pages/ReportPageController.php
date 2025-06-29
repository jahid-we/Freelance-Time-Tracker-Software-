<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ReportPageController extends Controller
{
    // Report page Function Start ***************************
    public function report(Request $request): Response
    {
        return Inertia::render('Report/ReportPage');
    }
    // Report page Function End *****************************
}
