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
            $user = User::where('email', $request->get('email'))->first();
            if($user){
                if(Hash::check( $request->get('password'), $user->password )== false){
                    return response()->json(['message' => 'invalid password'], 401);
                }else{
                    $tokenResult = $user->createToken('Personal Access Token');
                    $token = $tokenResult->token;
                    $token->save();
                    return response()->json([
                        'access_token' => $tokenResult->accessToken,
                        'token_type' => 'Bearer',
                    ]);
                }
            }else{
                return response()->json(['message' => 'User does not exists!!!'], 401);
            }
        }else{
            return response()->json([
                'message' => 'field error',
                'data' => $validator->errors()
            ], 400);
        }

    }
}
