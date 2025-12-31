<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ParentModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ParentAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.parent.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('parent')->attempt($credentials, $request->boolean('remember'))) {
            $parent = Auth::guard('parent')->user();

            if ($parent->status !== 'approved') {
                Auth::guard('parent')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'email' => 'Akun Anda belum disetujui oleh admin. Status saat ini: ' . ucfirst($parent->status),
                ])->onlyInput('email');
            }

            $request->session()->regenerate();

            return redirect()->intended(route('parent.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function showRegisterForm()
    {
        return view('auth.parent.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:parents'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        ParentModel::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'],
            'status' => 'pending',
        ]);

        return redirect()->route('parent.login')
            ->with('success', 'Registrasi berhasil! Mohon tunggu persetujuan dari Admin sebelum login.');
    }

    public function logout(Request $request)
    {
        Auth::guard('parent')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('parent.login');
    }
}
