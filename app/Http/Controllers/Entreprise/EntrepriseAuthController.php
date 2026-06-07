<?php

namespace App\Http\Controllers\Entreprise;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EntrepriseAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.entreprise-login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::guard('entreprise')->attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return redirect()->intended(route('entreprise.dashboard'));
        }

        return back()
            ->withErrors(['email' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.'])
            ->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::guard('entreprise')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('entreprise.login')
            ->with('success', 'Vous avez été déconnecté avec succès.');
    }
}
