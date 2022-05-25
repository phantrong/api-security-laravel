<?php

namespace App\Http\Controllers\Api;

use App\Models\Address;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth:user', ['except' => ['login']]);
    }
    public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (!$token = auth('user')->attempt($data)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->createNewToken($token);
    }

    public function logout()
    {
        auth('user')->logout();

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

    public function getSecurityInfomation()
    {
        return $this->sendResponse(Address::inRandomOrder()->first());
    }
}
