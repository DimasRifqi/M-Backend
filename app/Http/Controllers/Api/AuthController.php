<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function register(Request $request){
        $input = [
            "nama" => $request->nama,
            "username" => $request->username,
            "email" => $request->email,
            "phone" => $request->phone,
            "password" => Hash::make($request->password),
        ];

        User::create($input);
        return response()->json([
            "status" => "success",
            "message" => "Registrasi berhasil"
        ]);
    }
    public function login(Request $request){
        $input = [
            "email" => $request->email,
            "password" => $request->password,
        ];
        $user = User::where("email", $input["email"])->first();



        if(Auth::attempt($input)){
            $token = $user->createToken("token")->plainTextToken;

            $adminData = [
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'phone' => $user->phone,
                'email' => $user->email,
            ];

            return response()->json([
                'status' => 'success',
                'message' => 'Login berhasil',
                'data' => [
                    'token' => $token,
                    'admin' => $adminData,
                ],
            ]);
        }else{
            return response()->json([
                "status" => "error",
                "message" => "Login gagal"
            ]);
        }
    }

    public function logout(Request $request)
    {
   
        $user = Auth::user();

        $user->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Logout berhasil',
        ]);
    }

}