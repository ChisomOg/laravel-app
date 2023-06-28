<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    //Register form 
    public function create() {
        return view('user.register');
    }

    //store user
    public function store(Request $request) {
        $formfields = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => 'required|confirmed|min:6'
        ]);

        // Hash Password
        $formfields['password'] = bcrypt($formfields['password']);

        $user = User::create($formfields);

        auth()->login($user);

        return redirect('/')->with('message', 'User created and logged in');
    }
    //logout
    public function logout(Request $request){
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'successful logout');

    }


    //login form
    public function login(){
        return view ('user.login');
    }

    //login user
    public function auth(Request $request){
        $formfields = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required'
        ]);

        if(auth()->attempt($formfields)) {
            $request->session()->regenerate();

            return redirect('/')->with('message', 'Welcome back!');
        }

        return back()->withErrors(['email' => 'invalid credentials'])->onlyInput('email');
    }
}
