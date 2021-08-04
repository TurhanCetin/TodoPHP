<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;


class RegisterController extends Controller
{

    public function __invoke(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'name' => 'required'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
    
        return response()->json([
            'user' => $user,
            'token' => $user->createToken('default_token')->plainTextToken
        ]);
    }
}