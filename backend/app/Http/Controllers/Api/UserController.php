<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserController extends Controller
{
    //adding users by signing up
    public function signingUp(Request $request)
    {
        try {
            $request->validate([
                'firstname' => 'required|String|max:255',
                'lastname' => 'required|String|max:255',
                'username' => 'required|String|max:255|unique:users,username',
                'email' => 'required|String|email|max:255',
                'password' => 'required|String|min:8',
            ]);

            DB::table('users')->insert([
                'firstname'=>$request->firstname,
                'lastname'=>$request->lastname,
                'username'=>$request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            
            return response()->json(["message"=>"success"], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Validation failed
            return response()->json([
                'message' => 'Validation error',
                'errors'  => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            // Any other error
            Log::error('User creation failed: '.$e->getMessage());

            return response()->json([
                'message' => 'Something went wrong while creating the user.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    //loggin in the user
    public function loggingIn(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required|String|max:255',
                'password' => 'required|String|max:255',
            ]);

            $user = User::where('username', $request->username)->first();

            if (!$user) {
                return response()->json([
                    'message' => 'User not found.'
                ], 404);
            }

            if (!Hash::check($request->password, $user->password)) {
                return response()->json([
                    'message' => 'Invalid password.'
                ], 401);
            }
            return response()->json([
                'message' => 'Login successful!',
                'user'    => $user,
                // 'token' => $token, // uncomment if using tokens
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation error',
                'errors'  => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage(), // add this for debugging
            ], 500);
        }
    }
}
