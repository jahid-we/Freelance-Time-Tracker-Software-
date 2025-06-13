<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ClientPageController extends Controller
{
    // Client page Function Start ***************************
    public function client(Request $request): Response
    {
        return Inertia::render('Client/ClientPage');
    }
    // Client page Function End *****************************
}
