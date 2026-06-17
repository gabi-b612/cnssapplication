<?php

namespace App\Http\Controllers\Travailleur;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TravailleurAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.travailleur-login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::guard('travailleur')->attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $travailleur = Auth::guard('travailleur')->user();

            return redirect()->intended(route('travailleur.dashboard'))
                ->with('success', 'Bienvenue, ' . $travailleur->prenom . ' !');
        }

        return back()
            ->withErrors(['email' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.'])
            ->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::guard('travailleur')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('travailleur.login')
            ->with('success', 'Vous avez été déconnecté avec succès.');
    }
}
