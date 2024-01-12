<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

use function PHPSTORM_META\type;

class AuthController extends Controller
{
    public function __construct()
    {
    }

    public function register(CreateUserRequest $request)
    {
        $userData = $request->only(['name', 'email', 'password']);
        $userData['password'] = Hash::make($request->get('password'));

        $user = User::create($userData);

        return response()->json([
            'message'   => 'Successfully registered!',
            'user'      => $user
        ], Response::HTTP_CREATED);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']);
        $token = auth()->attempt($credentials);
        if (!$token) {
            return response()->json([
                'error' => 'Unauthorized!'
            ], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json([
            'token' => $token,
            'type' => 'Bearer',
        ], Response::HTTP_OK);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json([
            'message' => 'Logged out successfully!'
        ], Response::HTTP_OK);
    }
}
