<?php

namespace App\Http\Controllers;

use App\Models\Insurer;
use Inertia\Inertia;

class InsurerController extends Controller
{
    public function index()
    {
        return Inertia::render('Insurer/Index', [
            'count' => Insurer::all()->count(),
        ]);
    }
}
