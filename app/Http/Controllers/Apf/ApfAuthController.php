<?php

namespace App\Http\Controllers\Apf;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApfAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.apf-login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::guard('apf')->attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return redirect()->intended(route('apf.demandes.index'));
        }

        return back()
            ->withErrors(['email' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.'])
            ->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::guard('apf')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('apf.login')
            ->with('success', 'Vous avez été déconnecté avec succès.');
    }
}
