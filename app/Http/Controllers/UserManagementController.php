<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserManagementController extends Controller
{
    public function index(): View
    {
        $users = User::where('role', 'dosen')->latest()->get();

        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'dosen',
        ]);

        return back()->with('success', 'Akun dosen berhasil dibuat.');
    }

    // DETAIL USER
    public function show(User $user): View
    {
        return view('admin.users.show', compact('user'));
    }

    // FORM EDIT
    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    // UPDATE USER
    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
        ]);

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Data dosen berhasil diupdate.');
    }

    // HAPUS USER
    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return back()->with('success', 'Akun dosen berhasil dihapus.');
    }
}