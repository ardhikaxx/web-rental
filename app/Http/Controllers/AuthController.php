<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect($this->dashboardFor(Auth::user()));
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors(['email' => 'Email atau password salah.'])->withInput()->with('error', 'Login gagal.');
        }

        $user = Auth::user();
        if (! $user->is_active) {
            Auth::logout();
            return back()->withErrors(['email' => 'Akun Anda dinonaktifkan.'])->with('error', 'Akun dinonaktifkan.');
        }

        $this->log('login', 'auth', $user->name . ' login ke sistem.', $user);

        return redirect()->intended($request->query('redirect', $this->dashboardFor($user)));
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'confirmed', 'min:6'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'whatsapp' => $data['phone'],
            'password' => Hash::make($data['password']),
            'is_active' => true,
        ]);
        $user->assignRole('customer');

        Auth::login($user);
        $this->log('register', 'auth', 'Pendaftaran akun baru: ' . $user->name, $user);

        return redirect()->route('customer.dashboard')->with('success', 'Selamat datang! Akun berhasil dibuat.');
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            $this->log('logout', 'auth', Auth::user()->name . ' logout dari sistem.', Auth::user());
        }
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    private function dashboardFor(User $user): string
    {
        if ($user->hasAnyRole(['super_admin', 'owner', 'admin_operasional', 'customer_service',
            'driver', 'tour_leader', 'keuangan', 'marketing'])) {
            return route('admin.dashboard');
        }
        return route('customer.dashboard');
    }
}