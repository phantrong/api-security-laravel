<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt', ['except' => ['login']]);
    }
    public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (!$token = auth('admin')->attempt($data)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->createNewToken($token);
    }

    public function logout()
    {
        auth('admin')->logout();

        return response()->json(['message' => 'User successfully signed out']);
    }

    protected function createNewToken($token)
    {
        return $this->sendResponse([
            'success' => true,
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }
}
