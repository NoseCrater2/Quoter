<?php

namespace App\Http\Controllers\Api;

use App\ErrorMessages;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ], ErrorMessages::getMessages());
        if ($validator->fails())
        {
            return response($validator->errors(), 422);
        }
        $request['password']=Hash::make($request['password']);
        $request['remember_token'] = Str::random(10);
        $user = User::create($request->toArray());
        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        $response = ['token' => $token];
        return response($response, 200);
    }

    public function login(Request $request)
    {


            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email|max:255',
                'password' => 'required|string|min:6',
            ], ErrorMessages::getMessages());
            if ($validator->fails())
            {
                return response($validator->errors(), 422);
            }
            $user = User::where('email', $request->email)->first();
            if ($user) {
                
                if (Hash::check($request->password, $user->password)) {
                    $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                    $response = ['token' => $token];
                    return response($response, 200);
                } else {
                    $response = ["password" => "Contraseña incorrecta"];
                    return response($response, 422);
                }
            } else {
                $response = ["email" =>'El email proporcionado no está asociado a un usuario registrado'];
                return response($response, 422);
            }
    }

    public function logout(Request $request)
    {
        $token = auth('api')->user()->token();
        $token->revoke();
        
        $response = [
            
            'message' => "Has cerrado tu sesión existosamente"
        ];
        return response($response, 200);
    }
}
