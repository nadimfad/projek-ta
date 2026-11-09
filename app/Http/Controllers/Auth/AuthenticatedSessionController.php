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

        if ($userRole === 'kajur') {
            $request->session()->put('active_role', 'pending');

            return redirect()->route('login.role-selection');
        }

        $activeRole = $userRole;

        $request->session()->put('active_role', $activeRole);

        if (in_array($activeRole, ['admin', 'kajur'], true)) {
            return redirect()->route('dashboard')
                ->with('success', $activeRole === 'kajur' ? 'Selamat datang Kajur.' : 'Selamat datang Admin.');
        }

        return redirect()->route('laporan.index')
            ->with('success', 'Login berhasil.');
    }

    /**
     * Display the role selector for an authenticated department head.
     */
    public function showRoleSelection(): View|RedirectResponse
    {
        if (auth()->user()->role !== 'kajur') {
            return redirect()->route('redirect');
        }

        return view('auth.role-selection');
    }

    /**
     * Store the active role selected by a department head.
     */
    public function selectRole(Request $request): RedirectResponse
    {
        abort_unless(auth()->user()->role === 'kajur', 403);

        $data = $request->validate([
            'login_as' => ['required', 'in:dosen,kajur'],
        ]);

        $request->session()->put('active_role', $data['login_as']);

        if ($data['login_as'] === 'kajur') {
            return redirect()->route('dashboard')->with('success', 'Selamat datang Kajur.');
        }

        return redirect()->route('laporan.index')->with('success', 'Login sebagai dosen berhasil.');
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
