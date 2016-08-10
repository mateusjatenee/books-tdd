<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password'); //

        try {
            // attempt to verify the credentials and create a token for the user
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'user_not_found'], 422);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));
    }

    public function register(Request $request)
    {
        $credentials = $request->only(['name', 'email', 'password']);
        $email = $credentials['email'];

        if (User::findByEmail($email)) {
            return response()->json(['error' => 'emails_already_been_used'], 422);
        }

        $user = $this->createUser($credentials);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('token'));

    }

    protected function createUser($credentials)
    {
        return User::create([
            'name' => $credentials['name'],
            'email' => $credentials['email'],
            'password' => bcrypt($credentials['password']),
        ]);
    }
}
