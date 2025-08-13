<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $user = Auth::user();

        if ($user->level_user == 1) {
            $request->session()->regenerate();
            return redirect()->route('dashboard')->with('success', 'Selamat datang Admin!');
        } elseif ($user->level_user == 2) {
            $request->session()->regenerate();
            return redirect()->route('barista.dashboard')->with('success', 'Selamat datang Barista!');
        } else {
            $request->session()->regenerate();
            return redirect()->route('dashboard.kasir')->with('success', 'Selamat datang Kasir!');
        }

        return redirect()->intended(route('dashboard', absolute: false))->with('success', 'Selamat datang kembali!');
    }

   
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
