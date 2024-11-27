<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->validate([
            'count' => 'nullable|integer|min:1'
        ]);

        $count = $data['count'] ?? 5;

        return response()->json(ActivityLog::orderByDesc('created_at')->limit($count)->get());
    }
}
