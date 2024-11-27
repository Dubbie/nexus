<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Insurer;
use App\Models\Passport\Client;
use App\Models\User;

class StatisticsController extends Controller
{
    public function index()
    {
        return response()->json([
            'insurers' => Insurer::all()->count(),
            'clients' => Client::all()->count(),
            'users' => User::all()->count(),
        ]);
    }
}
