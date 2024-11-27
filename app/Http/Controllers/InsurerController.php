<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class InsurerController extends Controller
{
    public function index()
    {
        return Inertia::render('Insurer/Index');
    }
}
