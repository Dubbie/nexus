<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        // Authenticate the user using the LoginRequest's authenticate method
        $request->authenticate();

        // Regenerate the session after successful authentication
        $request->session()->regenerate();

        // If the request expects a JSON response (like from a relay project)
        $redirectTo = $request->input('redirect_to', route('dashboard'));

        return response()->json(['message' => 'Successfully logged in', 'redirect_to' => $redirectTo]);
    }
}
