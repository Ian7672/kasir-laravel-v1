<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // Menampilkan form signin
    public function showSigninForm()
    {
        if (Auth::check()) {
            return redirect()->route('barang');
        }
        return view('auth.signin');
    }

    // Menampilkan form signup
    public function showSignupForm()
    {
        if (Auth::check()) {
            return redirect()->route('barang');
        }
        return view('auth.signup');
    }
    // Menangani signin (POST)
    public function handleSignin(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Username atau email wajib diisi!',
            'password.required' => 'Password wajib diisi!',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Coba login dengan username atau email
        $credentials = $request->only('username', 'password');
        $remember = $request->has('remember');

        // Cek apakah input adalah email
        $field = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Ambil data pengguna dari database
        $user = User::where($field, $request->username)->first();

        // Cek apakah user ditemukan dan password valid
        if ($user && Hash::check($request->password, $user->password)) {
            // Login user
            Auth::login($user, $remember);

            // Regenerate session untuk keamanan
            $request->session()->regenerate();

            // Redirect berdasarkan role pengguna
            return match ($user->role) {
                'admin' => redirect()->intended(route('barang')),
                'karyawan' => redirect()->intended(route('barang')),
                default => redirect()->route('home'),
            };
        }

        // Jika login gagal
        return back()->with('error', 'Username/email atau password salah!')->withInput();
    }


    // Menangani signup (POST)
    public function handleSignup(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:user,username|min:3|max:20|alpha_dash',
            'email' => 'required|email|unique:user,email|max:100',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
            'role' => 'required|in:admin,karyawan',
            'admin_token' => 'required_if:role,admin',
        ], [
            'username.required' => 'Username wajib diisi!',
            'username.unique' => 'Username sudah digunakan!',
            'username.min' => 'Username minimal 3 karakter!',
            'username.max' => 'Username maksimal 20 karakter!',
            'username.alpha_dash' => 'Username hanya boleh berisi huruf, angka, dash, dan underscore!',
            'email.required' => 'Email wajib diisi!',
            'email.email' => 'Format email tidak valid!',
            'email.unique' => 'Email sudah digunakan!',
            'email.max' => 'Email maksimal 100 karakter!',
            'password.required' => 'Password wajib diisi!',
            'password.min' => 'Password minimal 6 karakter!',
            'password.confirmed' => 'Konfirmasi password tidak cocok!',
            'password_confirmation.required' => 'Konfirmasi password wajib diisi!',
            'role.required' => 'Role wajib dipilih!',
            'role.in' => 'Role tidak valid!',
            'admin_token.required_if' => 'Token admin wajib diisi untuk mendaftar sebagai admin!',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Cek token admin jika role adalah admin
        if ($request->role === 'admin') {
            if ($request->admin_token !== env('ADMIN_REGISTER_TOKEN', '0KASIRADMIN9##')) {
                return back()->with('error', 'Token admin tidak valid!')->withInput();
            }
        }

        // Buat user baru
        try {
            $user = User::create([
                'username' => Str::lower($request->username),
                'email' => Str::lower($request->email),
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);

            // Auto login setelah registrasi (opsional)
            // Auth::login($user);

            return redirect()->route('signin')
                ->with('success', 'Akun berhasil dibuat! Silakan login.')
                ->with('verified', false);
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Terjadi kesalahan saat membuat akun: ' . $e->getMessage())
                ->withInput();
        }
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('signin')->with('success', 'Berhasil logout!');
    }
}
