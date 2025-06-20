<?php

namespace App\Http\Controllers\Pages;

use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProjectPageController extends Controller
{
    // Client page Function Start ***************************
    public function  project(Request $request): Response
    {
        return Inertia::render('Project/ProjectPage');
    }
    // Client page Function End *****************************
}
