<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{

    public function login(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'email' => 'required|string',
            'password' => 'required|string'
        ]);
        if (!$validator->fails()){
            if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
                $user = Auth::user();
                return response()->json(['success' => $user]);
            }
            else{
                return response()->json(['error'=>'Unauthorised'], 401);
            }
        }else{
            return response()->json([
                'message' => 'field error',
                'data' => $validator->errors()
            ], 400);
        }

    }
}
