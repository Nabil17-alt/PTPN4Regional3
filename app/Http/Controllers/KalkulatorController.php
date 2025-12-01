<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Biaya;
use App\Models\Pembelian;
use App\Models\Pks;
use App\Models\Grade;

class KalkulatorController extends Controller
{
    public function index()
    {
        $pksList = Pks::orderBy('nama_pks')->get();
        $biayaList = Biaya::select('id', 'nama_pks', 'bulan', 'biaya_olah', 'tarif_angkut_cpo', 'tarif_angkut_pk')->get();
        $gradeList = Grade::orderBy('nama_grade')->get();

        return view('input_kalkulator', compact('pksList', 'biayaList', 'gradeList'));
    }

    public function hitung(Request $request)
    {
        $validated = $request->validate([
            'pks' => 'required|string',
            'tanggal' => 'required|date',
            'biaya_digunakan' => 'required|exists:tb_biayabulanan,id',
            'harga_penetapan' => 'required|numeric',
            'harga_pk_penetapan' => 'required|numeric',
            'grade' => 'required|string',
            'rend_cpo' => 'required|numeric',
            'rend_pk' => 'required|numeric',
            'harga_bep' => 'required|numeric',
            'harga_penetapan_grade' => 'required|numeric',
            'harga_eskalasi' => 'required|numeric',
            'info_harga_persing' => 'required|numeric',
        ]);

        $biaya = Biaya::findOrFail($validated['biaya_digunakan']);

        Pembelian::create([
            'nama_pks' => $validated['pks'],
            'tanggal' => $validated['tanggal'],
            'biaya_bulan_berapa' => $biaya->bulan,
            'biayabulanan_id' => $biaya->id,
            'harga_cpo_penetapan' => $validated['harga_penetapan'],
            'harga_pk' => $validated['harga_pk_penetapan'],
            'penetapan' => 'otomatis', // atau isi sesuai aturanmu
            'grade' => $validated['grade'],
            'rendemen_cpo' => $validated['rend_cpo'],
            'rendemen_pk' => $validated['rend_pk'],
            'harga_bep' => $validated['harga_bep'],
            'harga_penetapan' => $validated['harga_penetapan_grade'],
            'eskalasi' => $validated['harga_eskalasi'],
            'harga_pesaing' => $validated['info_harga_persing'],
        ]);

        return redirect()->route('input.kalkulator')->with('success', 'Data kalkulator berhasil disimpan.');
    }
}
