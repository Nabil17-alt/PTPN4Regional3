<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grade; // atau model yang merepresentasikan tabel grade
use App\Models\Unit; // Model untuk unit jika diperlukan
use Illuminate\Support\Facades\Auth;
use App\Models\Pembelian;

class PembelianController extends Controller
{
    // public function create()
    // {
    //     // Mengambil semua data grade
    //     $grades = Grade::all();
    //     $units = Unit::all();

    //     // Mengirim data user dan grades ke view
    //     $user = auth()->user();
    //     return view('buyform', compact('user', 'grades', 'units'));
    // }


    // Menampilkan form + tabel
    public function create()
    {
        $grades = Grade::all();
        $units = Unit::all();

        $user = auth()->user();
        return view('buyform', compact('user', 'grades', 'units'));
    }
    // public function buy()
    // {
    //     $user = Auth::user();

    //     if (!$user) {
    //         return redirect()->route('login');
    //     }

    //     // Ambil semua data pembelian, urutkan terbaru dulu
    //     $pembelians = Pembelian::orderByDesc('created_at')->get();

    //     // Kirim variabel ke view bersama $user
    //     return view('buy', [
    //         'user' => $user,
    //         'pembelians' => $pembelians,
    //     ]);
    // }

    public function buy()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Ambil semua pembelian, urutkan terbaru dulu
        $pembelians = Pembelian::orderByDesc('created_at')->get();

        // Kirim ke view
        return view('buy', compact('user', 'pembelians'));
    }


    public function store(Request $request)
    {
        // Validasi input, kode_unit harus integer karena berasal dari id_unit
        $validated = $request->validate([
            'kode_unit' => 'required|integer',
            'tanggal' => 'required|date',
            'grade' => 'required|string|max:255',
            'harga_cpo' => 'required|numeric',
            'harga_pk' => 'required|numeric',
            'rendemen_cpo' => 'required|numeric',
            'rendemen_pk' => 'required|numeric',
            'biaya_olah' => 'required|numeric',
            'tarif_angkut_cpo' => 'required|numeric',
            'tarif_angkut_pk' => 'required|numeric',
            'biaya_angkut_jual' => 'required|numeric',
            'harga_escalasi' => 'required|numeric',
        ]);

        // Cari namaunit dari id_unit
        $unit = Unit::find($validated['kode_unit']);
        if (!$unit) {
            return redirect()->back()->with('error', 'Unit tidak ditemukan.');
        }

        // Cek panjang namaunit supaya tidak melebihi kapasitas kolom kode_unit
        if (strlen($unit->namaunit) > 255) {
            return redirect()->back()->with('error', 'Nama unit terlalu panjang untuk disimpan.');
        }

        $pembelian = new Pembelian();
        $pembelian->kode_unit = $unit->namaunit;  // Simpan nama unit langsung ke kolom kode_unit
        $pembelian->tanggal = $validated['tanggal'];
        $pembelian->grade = $validated['grade'];
        $pembelian->harga_cpo = $validated['harga_cpo'];
        $pembelian->harga_pk = $validated['harga_pk'];
        $pembelian->rendemen_cpo = $validated['rendemen_cpo'];
        $pembelian->rendemen_pk = $validated['rendemen_pk'];
        $pembelian->biaya_olah = $validated['biaya_olah'];
        $pembelian->tarif_angkut_cpo = $validated['tarif_angkut_cpo'];
        $pembelian->tarif_angkut_pk = $validated['tarif_angkut_pk'];
        $pembelian->biaya_angkut_jual = $validated['biaya_angkut_jual'];
        $pembelian->harga_escalasi = $validated['harga_escalasi'];

        $pembelian->save();

        return redirect()->back()->with('success', 'Data pembelian berhasil disimpan');
    }

    public function destroy(Pembelian $pembelian)
    {
        $pembelian->delete();
        return redirect()->route('pembelian.index')->with('success', 'Berhasil menghapus data!');
    }

    public function edit(Pembelian $pembelian)
    {
        $grades = Grade::all();
        $units = Unit::all();
        return view('editform', compact('pembelian', 'grades', 'units'));
    }
}