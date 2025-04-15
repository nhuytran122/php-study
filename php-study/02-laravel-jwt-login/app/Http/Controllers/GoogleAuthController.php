<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Throwable;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        // return Socialite::driver('google')->redirect();
        $url = Socialite::driver('google')->stateless()->redirect()->getTargetUrl();
        return response()->json([
            'url' => $url
        ]);
    }

    public function callback()
    {
        try {
            // $user = Socialite::driver('google')->user();
            $user = Socialite::driver('google')->stateless()->user();
        } catch (Throwable $e) {
            return response() -> json([
                'error' => 'Login with Google failed',
                'message' => $e
            ]);
        }

        $existingUser = User::where('email', $user->email)->first();

        if ($existingUser) {
            $token = Auth::login($existingUser);
        } else {
            $newUser = User::updateOrCreate([
                'email' => $user->email,
                'full_name' => $user->name,
                'password' => bcrypt(Str::random(16)),
                'email_verified_at' => now()
            ]);
            $token = Auth::login($newUser);
        }
        return $this->respondWithToken($token);
    }

    private function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ]);
    }
}