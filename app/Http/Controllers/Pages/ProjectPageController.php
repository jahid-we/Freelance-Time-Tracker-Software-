<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProjectPageController extends Controller
{
    // Client page Function Start ***************************
    public function project(Request $request): Response
    {
        return Inertia::render('Project/ProjectPage');
    }
    // Client page Function End *****************************
}
