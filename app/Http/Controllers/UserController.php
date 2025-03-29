<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserLoginRequest;

class UserController extends Controller
{
    public function create_user(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'status' => true,
            'message' => 'User created successfully',
            'data' => $user
        ]);
    }

    public function get_user()
    {
        $user = Auth::user();
        
        if(!$user)
        {
            return response()->json([
                'status' => false,
                'message' => 'User not authenticated'
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'User listed successfully',
            'data' => $user
        ]);
    }

    public function login(UserLoginRequest $request)
    {
        $user = Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ]);

        if(!$user)
        {
            return response()->json([
                'status' => false,
                'message' => 'Invalid login credentials'
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Login successful',
            'data' => $user
        ]);
    }

    public function logout()
    {
        Auth::logout();
        
        return response()->json([
            'status' => true,
            'message' => 'Logout successful'
        ]);
    }

    public function get_user_from_id(int $user_id)
    {
        $user = User::find($user_id);

        if(!$user)
        {
            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'User listed successfully',
            'data' => $user
        ]);
    }
}
