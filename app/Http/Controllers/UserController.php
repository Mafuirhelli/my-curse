<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request){
        $request->validate([
           'name' => ['required', 'max:255'],
           'email' => ['required', 'email', 'max:255', 'unique:users'],
           'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = User::create($request->all());
        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('verification.notice');
    }
    public function login()
    {
        return view('users.login');
    }

    public function profile()
    {
        return view('users.profile');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

}
