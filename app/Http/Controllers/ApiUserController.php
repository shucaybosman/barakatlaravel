<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class ApiUserController extends Controller
{
    public function register (Request $request) {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed','regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[!$#%@]).*$/'],
        ]);
        $user=new User();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=bcrypt($request->password);

        $user->save();
        $token=$user->createToken('registertoken')->plainTextToken;

        return response ([
            'user'=>$user,
            'token'=>$token,
            'message'=> 'user registered successfully'

        ]);

    }

    public function login(Request $request) {
        $request->validate([

            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8','regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[!$#%@]).*$/'],
        ]);
        //check email and password
        $user=User::where('email', $request->email)->first();

        if(!$user || !Hash::check($request->password,$user->password)) {
            return response('invalid credentials',401);
        }
        $token=$user->createToken('logintoken')->plainTextToken;
        return response ([
            'user'=>$user,
            'token'=>$token,
            'message'=> 'Login successfull'
        ]);
    }

    public function logout(Request $request) {
        if ($request->user()) {
            $request->user()->tokens()->delete();
        }

        return response()->json(['message' => 'Logout successful'], 200);
    }
}
