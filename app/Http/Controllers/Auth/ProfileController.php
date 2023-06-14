<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $user = auth()->user();

        return response()->json([
            'data'  => $user,
            'status' => 'success'
        ]);
    }
}
