<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (session()->get('is_admin_authenticated') || session()->get('admin_logged_in')) {
            return redirect()->route('admin.dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $adminUser = config('auth.admin.username', env('ADMIN_USERNAME', 'admin'));
        $adminPass = config('auth.admin.password', env('ADMIN_PASSWORD', 'SuksesJaya2026'));

        if (
            $credentials['username'] === $adminUser &&
            $credentials['password'] === $adminPass
        ) {
            $request->session()->regenerate();
            session([
                'is_admin_authenticated' => true,
                'admin_logged_in' => true,
                'admin_username' => $credentials['username']
            ]);
            return redirect()->intended(route('admin.dashboard'));
        }

        return redirect()->route('login')->withErrors(['username' => 'Kredensial username atau password tidak valid.'])->withInput();
    }

    public function logout(Request $request)
    {
        session()->forget(['is_admin_authenticated', 'admin_logged_in', 'admin_username']);
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Berhasil logout dari sistem.');
    }
}