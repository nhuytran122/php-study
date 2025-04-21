<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'name' =>  'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);
        $user = User::create([
            'name' => $request->name,
            'email'=> $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = Auth::login($user);
        return $this->respondWithToken($token);
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        $credential = $request->only('email', 'password');

        $token = Auth::attempt($credential);
        if(!$token){
            return response()->json([
                'status' => 'error',
                'message' => 'Incorrect email or password'
            ], 401);
        }
        $user = Auth::user();
        return $this->respondWithToken($token);
    }

    public function logout(){
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Logged out successfully'
        ]);
    }

    public function refresh(){
        $refresh_token = Auth::refresh();
        return $this->respondWithToken($refresh_token);
    }

    public function profile(){
        return response()->json([
            'infor' =>  Auth::user(),
            // 'roles' => Auth::user()->roles->pluck('name')->implode(', ')
        ]);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ]);
    }
}