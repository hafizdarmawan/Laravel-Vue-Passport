<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    //

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'     => 'required',
            'password'  => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::where('email', $request->email)->first();
        // dd($user);
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success'   => false,
                'message'   => 'Login Fiiled'
            ]);
        }

        return response()->json([
            'success'   => true,
            'message'   => 'Login Success',
            'data'      => $user,
            'token'     => $user->createToken('authToken')->accessToken
        ]);
    }


    public function logout(Request $request)
    {
        $removeToken = $request->user()->tokens()->delete();
        if ($removeToken) {
            return response()->json([
                'success'   => true,
                'message'   => 'Logout Success'
            ]);
        }
    }
}
