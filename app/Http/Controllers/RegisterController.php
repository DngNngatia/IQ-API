<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string'
        ]);
        if (!$validator->fails()) {
            $user = new User([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'device_notification_token' => $request->token
            ]);
            $user->save();
            return response()->json([
                'message' => 'Successfully created user!',
                'data' => $user
            ], 200);
        } else {
            return response()->json([
                'message' => 'error',
                'data' => $validator->errors()
            ], 500);
        }

    }

    public function token(Request $request)
    {
        $request->user()->update([
            'device_notification_token' => $request->token
        ]);
        return response()->json(['message' => 'token saved'], 200);
    }

    public function destroy(Request $request)
    {
        $request->user()->delete();
        return response()->json(['message' => 'profile deleted'], 200);
    }
}
