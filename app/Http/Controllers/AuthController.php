<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Afficher le formulaire de login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Traiter la connexion
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        // Essayer tous les guards dans l'ordre de priorité
        $guards = ['administrateur', 'entreprise', 'travailleur', 'apf'];

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->attempt($credentials, $remember)) {
                $request->session()->regenerate();

                // Rediriger selon le guard
                return match ($guard) {
                    'administrateur' => redirect()->route('admin.dashboard'),
                    'entreprise' => redirect()->route('entreprise.dashboard'),
                    'travailleur' => redirect()->route('travailleur.dashboard'),
                    'apf' => redirect()->route('apf.dashboard'),
                };
            }
        }

        // Authentification échouée
        return back()
            ->withErrors(['email' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.'])
            ->onlyInput('email');
    }

    // Déconnecter l'utilisateur
    public function logout(Request $request)
    {
        // Déconnecter de tous les guards
        Auth::guard('administrateur')->logout();
        Auth::guard('entreprise')->logout();
        Auth::guard('travailleur')->logout();
        Auth::guard('apf')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Vous avez été déconnecté avec succès.');
    }
}
