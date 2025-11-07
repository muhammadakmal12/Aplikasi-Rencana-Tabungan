<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm() 
    { 
        return view('login'); 
    } 
 
    public function login(Request $request) 
    { 
        $credentials = $request->validate([ 
            'email' => 'required|email', 
            'password' => 'required', 
        ]); 
 
        if (Auth::attempt($credentials)) { 
            $request->session()->regenerate(); 
            return redirect()->intended('/home'); 
        }

        return back()->withErrors([ 
            'email' => 'Email atau password salah.', 
        ]); 
    }

    public function showRegisterForm() 
    { 
        return view('register'); 
    }

     public function register(Request $request) 
    { 
        $data = $request->validate([ 
            'name' => 'required|string|max:255', 
            'email' => 'required|email|unique:users,email', 
            'password' => 'required|min:6|confirmed', // butuh input password_confirmation 
        ]);

        $user = User::create([ 
            'name' => $data['name'], 
            'email' => $data['email'], 
            'password' => Hash::make($data['password']), 
        ]);

        return redirect()->route('login');
    }

    public function logout(Request $request) 
    { 
        Auth::logout(); 
        $request->session()->invalidate(); 
        $request->session()->regenerateToken(); 
        return redirect('/login'); 
    }
}
