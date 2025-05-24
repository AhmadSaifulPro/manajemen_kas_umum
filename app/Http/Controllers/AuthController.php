<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function do_login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        // Debugging
        Log::info('Login attempt', ['email' => $request->email, 'password_length' => strlen($request->password)]);

        // Metode 1: Auth::attempt standar
        $credentials = $request->only('email', 'password');
        $attemptResult = Auth::attempt($credentials);

        Log::info('Auth attempt result', ['result' => $attemptResult]);

        if ($attemptResult) {
            $request->session()->regenerate();
            return redirect()->route('dashboard.index');
        }

        // Metode 2: Login manual jika metode 1 gagal
        $user = \App\Models\User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Log::info('Manual login successful', ['user_id' => $user->id]);
            Auth::login($user);
            $request->session()->regenerate();
            return redirect()->route('dashboard.index');
        }

        Log::warning('Login failed completely', [
            'email' => $request->email,
            'user_exists' => $user ? 'yes' : 'no',
            'password_hash' => $user ? substr($user->password, 0, 10) . '...' : 'no user'
        ]);

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    // public function do_login(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required',
    //         'password' => 'required',
    //     ]);

    //     $credentials = $request->only('email', 'password');

    //     if (Auth::attempt($credentials)) {
    //         $request->session()->regenerate();
    //         Log::info('Login sukses', ['email' => $request->email]);
    //         return redirect()->route('dashboard.index');
    //     }

    //     Log::warning('Login gagal', ['email' => $request->email, 'password' => $request->password]);
    //     return back()->withErrors([
    //         'email' => 'Email atau password salah.',
    //     ]);
    // }


    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
