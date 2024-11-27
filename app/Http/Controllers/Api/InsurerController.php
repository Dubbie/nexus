<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Insurer;
use Illuminate\Http\Request;

class InsurerController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(Insurer::all());
    }

    public function store(Request $request)
    {
        $insurer = Insurer::create($request->all());
        return response()->json($insurer);
    }

    public function update(Request $request, $id)
    {
        $insurer = Insurer::find($id);
        $insurer->update($request->all());
        return response()->json($insurer);
    }

    public function destroy(Request $request, $id)
    {
        $insurer = Insurer::find($id);
        $insurer->delete();
        return response()->json($insurer);
    }
}
