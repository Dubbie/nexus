<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class PageController extends Controller
{
    public function home()
    {
        return redirect()->route('dashboard');
    }

    public function dashboard()
    {
        return Inertia::render('Dashboard');
    }
}
