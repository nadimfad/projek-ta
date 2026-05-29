<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dosen;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserManagementController extends Controller
{
    public function index(): View
    {
        $users = User::with('dosen')->where('role', 'dosen')->latest()->get();

        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255', Rule::unique('dosens', 'nama')],
            'nip' => ['required', 'string', 'max:50', Rule::unique('dosens', 'nip'), Rule::unique('users', 'username')],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('dosens', 'email')],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'nama.unique' => 'Nama dosen sudah terdaftar.',
            'nip.unique' => 'NIP dosen sudah terdaftar.',
            'email.unique' => 'Email dosen sudah terdaftar.',
        ]);

        Dosen::create([
            'nip' => $data['nip'],
            'nama' => $data['nama'],
            'email' => $data['email'],
        ]);

        User::create([
            'username' => $data['nip'],
            'password' => Hash::make($data['password']),
            'role' => 'dosen',
        ]);

        return back()->with('success', 'Akun dosen berhasil dibuat.');
    }

    // UPDATE USER
    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'nama' => [
                'required',
                'string',
                'max:255',
                Rule::unique('dosens', 'nama')->ignore($user->dosen?->id_dosen, 'id_dosen'),
            ],
            'nip' => [
                'required',
                'string',
                'max:50',
                Rule::unique('dosens', 'nip')->ignore($user->dosen?->id_dosen, 'id_dosen'),
                Rule::unique('users', 'username')->ignore($user->id_user, 'id_user'),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('dosens', 'email')->ignore($user->dosen?->id_dosen, 'id_dosen'),
            ],
        ], [
            'nama.unique' => 'Nama dosen sudah terdaftar.',
            'nip.unique' => 'NIP dosen sudah terdaftar.',
            'email.unique' => 'Email dosen sudah terdaftar.',
        ]);

        $oldUsername = $user->username;

        Dosen::updateOrCreate(
            ['nip' => $oldUsername],
            [
                'nip' => $data['nip'],
                'nama' => $data['nama'],
                'email' => $data['email'],
            ]
        );

        $user->update([
            'username' => $data['nip'],
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Data dosen berhasil diupdate.');
    }

    // HAPUS USER
    public function destroy(User $user): RedirectResponse
    {
        Dosen::where('nip', $user->username)->delete();
        $user->delete();

        return back()->with('success', 'Akun dosen berhasil dihapus.');
    }
}
