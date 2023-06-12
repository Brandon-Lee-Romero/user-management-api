<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(LoginRequest $request)
    {
        /* get only the validated fields */
        $validated = $request->safe()->only(['username', 'password']);

        /* retrieve user */
        $data = User::where('username', $validated['username'])->first();

        /* Checking if the user exists and if the password is correct */
        if (!$data || !Hash::check($validated['password'], $data->password) || $data->type != 1) {
            return response()->json([
                'message' => 'Invalid login details.',
                'status' => 'error',
            ], 401);
        }

        /* Delete user tokens */
        $data->tokens()->delete();
        
        $ability = $data->type == 1 ? 'admin' : 'user';

        /* create token */
        $token = $data->createToken('auth_token', [$ability])->plainTextToken;

        return response()->json([
            'access_token'  => $token,
            'token_type' => 'Bearer',
            'status' => 'success',
        ]);
    }
}
