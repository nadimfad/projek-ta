<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    public function index()
    {
        if (auth()->user()->role == 'admin') {
            $laporans = Laporan::latest()->get();
        } else {
            $laporans = Laporan::where('email', auth()->user()->email)->get();
        }

        return view('laporan.index', compact('laporans'));
    }

    public function create()
    {
        return view('laporan.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_pelapor' => 'required',
            'email' => 'required|email',
            'kegiatan' => 'required',
            'deskripsi' => 'required',
            'bukti' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        $data['status'] = 'menunggu';

        if ($request->hasFile('bukti')) {
            $data['bukti'] = $request->file('bukti')->store('bukti', 'public');
        }

        Laporan::create($data);

        return redirect('/laporan')->with('success', 'Data berhasil ditambahkan');
    }

    // ✅ DETAIL LAPORAN
    public function show($id)
    {
        $laporan = Laporan::findOrFail($id);

        return view('laporan.show', compact('laporan'));
    }

    public function edit($id)
    {
        $laporan = Laporan::findOrFail($id);
        return view('laporan.edit', compact('laporan'));
    }

public function update(Request $request, $id)
{
    $laporan = Laporan::findOrFail($id);

    // ✅ Jika hanya update status (admin)
   if ($request->has('status') && count($request->all()) <= 3) {
    $laporan->update([
        'status' => $request->status
    ]);

    return back()->with('success', 'Status berhasil diupdate');
}

    // ✅ Jika update full data (user)
    $data = $request->validate([
        'nama_pelapor' => 'required',
        'email' => 'required|email',
        'kegiatan' => 'required',
        'deskripsi' => 'required',
        'status' => 'required',
        'bukti' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048'
    ]);

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

    public function destroy($id)
    {
        $laporan = Laporan::findOrFail($id);

        if ($laporan->bukti) {
            Storage::disk('public')->delete($laporan->bukti);
        }

        $laporan->delete();

        return redirect('/laporan')->with('success', 'Data berhasil dihapus');
    }

    public function history()
    {
        $laporans = Laporan::where('email', auth()->user()->email)
                            ->latest()
                            ->get();

        return view('laporan.history', compact('laporans'));
    }
}