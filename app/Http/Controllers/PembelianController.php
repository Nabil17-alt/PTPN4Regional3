<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grade; 
use App\Models\Unit; 
use Illuminate\Support\Facades\Auth;
use App\Models\Pembelian;

class PembelianController extends Controller
{
    public function create()
    {
        $grades = Grade::all();
        $units = Unit::all();

        $user = auth()->user();
        return view('buyform', compact('user', 'grades', 'units'));
    }
    public function buy()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }
        $pembelians = Pembelian::with('unit')->orderByDesc('created_at')->paginate(10);

        return view('buy', compact('user', 'pembelians'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_unit' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'grade' => 'required|string|max:50',
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

        $unit = Unit::where('kode_unit', $validated['kode_unit'])->first();

        if (!$unit) {
            return redirect()->back()->with('error', 'Unit tidak ditemukan.');
        }

        $pembelian = new Pembelian();
        $pembelian->kode_unit = $validated['kode_unit']; 
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
        return redirect()->back()->with('success', 'Berhasil menghapus data!');
    }

    public function edit($id)
    {
        $pembelian = Pembelian::findOrFail($id);
        $grades = Grade::all();
        $units = Unit::all(); 

        return view('buyedit', compact('pembelian', 'grades', 'units')); 
    }

    public function update(Request $request, $id)
    {
        $pembelian = Pembelian::findOrFail($id);

        $validated = $request->validate([
            'kode_unit' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'grade' => 'required|string|max:50',
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

        $pembelian->update($validated);

        return redirect()->route('buy')->with('success', 'Data pembelian berhasil diedit.');

    }

    public function lihatTanggal($tanggal)
    {
        $items = Pembelian::whereDate('tanggal', $tanggal)->get(); 
        return view('buysee', compact('items')); 
    }

    public function detail($id)
    {
        $pembelian = Pembelian::with('unit')->findOrFail($id);
        $unit = $pembelian->unit;
        return view('buydetail', compact('pembelian', 'unit'));
    }
}