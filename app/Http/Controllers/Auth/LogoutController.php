<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

class LogoutController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'status' => 'success',
        ]);
    }
}
