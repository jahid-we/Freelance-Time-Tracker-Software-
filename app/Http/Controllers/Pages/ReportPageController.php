<?php

namespace App\Http\Controllers\Pages;

use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportPageController extends Controller
{
    // Report page Function Start ***************************
    public function report(Request $request): Response
    {
        return Inertia::render('Report/ReportPage');
    }
    // Report page Function End *****************************
}
