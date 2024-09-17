<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
      
     
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!auth()->attempt(request(['email', 'password']))) {
            return back()->withErrors([
                'error' => 'Email or password is incorrect'
            ]); 
        }

        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request) 
    {
        $request->session()->invalidate();
        auth()->logout();
        

        return redirect()->route('login');
    }
}
