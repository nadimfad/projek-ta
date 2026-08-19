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

        $request->session()->regenerate();

        $userRole = auth()->user()->role;
        $requestedRole = $request->input('login_as');
        $activeRole = $userRole === 'kajur'
            ? ($requestedRole ?: 'kajur')
            : $userRole;

        $request->session()->put('active_role', $activeRole);

        if (in_array($activeRole, ['admin', 'kajur'], true)) {
            return redirect()->route('dashboard')
                ->with('success', $activeRole === 'kajur' ? 'Selamat datang Kajur.' : 'Selamat datang Admin.');
        }

        return redirect()->route('laporan.index')
            ->with('success', 'Login berhasil.');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
