<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\Auth\AuthService;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService  $authService   
    ){

    }

    public function login(LoginRequest $request)
    {
        list($user,$token) = $this->authService->login($request->validated());

        //todo:improve --> return by Resources
        return response()->json([
            'token_type' => 'Bearer',
            'token' => $token,
            'user'  => $user,
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()?->delete();

        return response()->json(['message' => 'Logged out.'], 200);
    }

    public function profile(Request $request)
    {
        return response()->json(['data' => $request->user()], 200);
    }
}
