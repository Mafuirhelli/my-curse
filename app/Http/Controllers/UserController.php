<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

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

    public function loginAuth(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required',],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('profile')->with('success', 'Welcome, ' . Auth::user()->name . '!');
        }

        return back()->withErrors([
            'email' => 'Wrong login or password',
        ]);

    }
        public function profile(): View
    {
        $user = Auth::user();
        $orders = $user->orders()->with('items.product')->latest()->get();
        return view('users.profile', compact('user', 'orders'));
    }
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function updateAvatar(Request $request): RedirectResponse
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $user = Auth::user();

        if ($request->hasFile('avatar')) {
            if ($user->avatar !== 'images/user-info/avatars/default-avatar.png') {
                Storage::disk('public')->delete($user->avatar);
            }

            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
            $user->save();

            return redirect()->back()->with('success', 'Аватар успешно обновлен');
        }

        return redirect()->back()->with('error', 'Ошибка при загрузке аватара');
    }

}
