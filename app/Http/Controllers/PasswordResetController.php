<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Mail\Message;
use Illuminate\Support\Str;
use Carbon\Carbon;

// =========== Models ================= //
use App\Models\User;
use App\Models\PasswordReset;
// =========== Models ================= //


class PasswordResetController extends Controller
{
    public function sent_reset_password_email(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        // Check User Email Exists  Or Does Not Exist

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response([
                'message' => 'Email does not exist',
                'status' => 'error'
            ], 404);
        }

        // Genrate Token
        $token = Str::random(60);

        // Saving Data to Password Reset table

        PasswordReset::create([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        // dump("http://127.0.0.1:3000/api/reset/" . $token);

        // Sending Email with Password Reset View

        Mail::send('reset', ['token' => $token], function (Message $message) use ($request) {
            $message->subject('Reset Your Password');
            $message->to($request->email);
        });


        // Mesage
        return response([
            'message' => 'Password Reset Email Sent... Check Your Email',
            'status' => 'success'
        ], 200);
    }

    // Reset Password
    public function ResetPassword(Request $request, $token)
    {
        // Delete Token older than 1 minute
        $formatted = Carbon::now()->subMinutes(1)
            ->toDateTimeString();
        PasswordReset::where('created_at', '<=', $formatted)
            ->delete();

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

        $password_reset = PasswordReset::where('token', $token)->first();

        if (!$password_reset) {
            return response([
                'message' => 'Token is invalid or has expired',
                'status' => 'error'
            ], 404);
        }

        $user = User::where('email', $password_reset->email)->first();

        $user->password = Hash::make($request->password);
        $user->save();

        // Delete the token after resetting the password
        PasswordReset::where('email', $user->email)->delete();

        // Message confirmation
        return response([
            'message' => 'Password has been changed',
            'status' => 'success'
        ], 200);
    }
}
