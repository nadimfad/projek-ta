<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    // =========================
    // 🔥 INDEX + FILTER KEGIATAN
    // =========================
    public function index(Request $request)
    {
        $query = Laporan::query();

        // 🔥 FILTER KEGIATAN
        if ($request->kegiatan) {
            $query->where('kegiatan', $request->kegiatan);
        }

        // 🔐 ROLE CHECK
        if (auth()->user()->role == 'admin') {
            $laporans = $query->latest()->get();
        } else {
            $laporans = $query
                ->where('email', auth()->user()->email)
                ->latest()
                ->get();
        }

        return view('laporan.index', compact('laporans'));
    }

    // =========================
    // CREATE
    // =========================
    public function create()
    {
        return view('laporan.create');
    }

    // =========================
    // STORE
    // =========================
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_pelapor' => 'required',
            'kegiatan' => 'required',
            'deskripsi' => 'required',
            'bukti' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        // 🔥 AUTO EMAIL LOGIN
        $data['email'] = auth()->user()->email;

        $data['status'] = 'menunggu';

        if ($request->hasFile('bukti')) {
            $data['bukti'] = $request->file('bukti')->store('bukti', 'public');
        }

        Laporan::create($data);

        return redirect('/laporan')->with('success', 'Data berhasil ditambahkan');
    }

    // =========================
    // SHOW
    // =========================
    public function show($id)
    {
        $laporan = Laporan::findOrFail($id);
        return view('laporan.show', compact('laporan'));
    }

    // =========================
    // EDIT
    // =========================
    public function edit($id)
    {
        $laporan = Laporan::findOrFail($id);
        return view('laporan.edit', compact('laporan'));
    }

    // =========================
    // UPDATE
    // =========================
    public function update(Request $request, $id)
    {
        $laporan = Laporan::findOrFail($id);

        // ✅ UPDATE STATUS (ADMIN CEPAT)
        if ($request->has('status') && count($request->all()) <= 3) {
            $laporan->update([
                'status' => $request->status
            ]);

            return back()->with('success', 'Status berhasil diupdate');
        }

        // ✅ UPDATE FULL DATA
        $data = $request->validate([
            'nama_pelapor' => 'required',
            'kegiatan' => 'required',
            'deskripsi' => 'required',
            'status' => 'required',
            'bukti' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        // 🔥 JAGA EMAIL
        $data['email'] = auth()->user()->email;

        // upload file baru
        if ($request->hasFile('bukti')) {

            if ($laporan->bukti) {
                Storage::disk('public')->delete($laporan->bukti);
            }

            $data['bukti'] = $request->file('bukti')->store('bukti', 'public');
        }

        $laporan->update($data);

        return redirect('/laporan')->with('success', 'Data berhasil diupdate');
    }

    // =========================
    // DELETE
    // =========================
    public function destroy($id)
    {
        $laporan = Laporan::findOrFail($id);

        if ($laporan->bukti) {
            Storage::disk('public')->delete($laporan->bukti);
        }

        $laporan->delete();

        return redirect('/laporan')->with('success', 'Data berhasil dihapus');
    }

    // =========================
    // HISTORY
    // =========================
    public function history()
    {
        $laporans = Laporan::where('email', auth()->user()->email)
                            ->latest()
                            ->get();

        return view('laporan.history', compact('laporans'));
    }
}