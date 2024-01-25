<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


// ======== Models =========== //
use App\Models\User;
// ======== Models =========== //


class UserController extends Controller
{
    public function register(Request $request)
    {
        // Validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users|max:255',
            'password' => 'required|min:8|confirmed',
        ];

        // Custom error messages
        $messages = [
            'password.min' => 'The password must be at least 8 characters.',
            'password.confirmed' => 'The password confirmation does not match.',
        ];

        // Validate the request
        $request->validate($rules, $messages);

        // Create a new user
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        // Generate an API token for the user
        $token = $user->createToken($request->email)->plainTextToken;

        return ['message' => 'User registered successfully', 'api_token' => $token, 'status' => 'success'];
    }

    public function login(Request $request)
    {
        // Validation rules
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response(['message' => 'The provided credentials are incorrect'], 401);
        }

        // Generate an API token for the user using their email
        $token = $user->createToken($user->email)->plainTextToken;

        return ['message' => 'User Login successfully', 'api_token' => $token];
    }


    public function logout()
    {
        // Revoke all of the user's tokens
        auth()->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });

        return response(['message' => 'User logged out successfully', 'status' => 'success']);
    }


    public function logged_user()
    {
        $logged_user = auth()->user();


        return response(['message' => 'logged User Data ', 'status' => 'success', 'logged_user' => $logged_user]);
    }


    public function change_password(Request $request)
    {
        // Validation rules
        $rules = [
            'password' => 'required|min:8|confirmed',
        ];

        // Custom error messages
        $messages = [
            'password.min' => 'The password must be at least 8 characters.',
            'password.confirmed' => 'The password confirmation does not match.',
        ];

        // Validate the request
        $request->validate($rules, $messages);

        //Check if the password is correct
        $logged_user = auth()->user();

        $logged_user->password = Hash::make($request->password);
        $logged_user->save();


        return response(['message' => 'Your password changed successfully', 'status' => 'success']);
    }
}