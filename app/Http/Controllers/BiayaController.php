<?php

namespace App\Http\Controllers;

use App\Models\Biaya;
use App\Models\Pks;
use Illuminate\Http\Request;

class BiayaController extends Controller
{
    public function create()
    {
        $pksList = Pks::orderBy('nama_pks')->get();
        $selectedPks = request('pks');

        $biaya = null;
        if ($selectedPks) {
            $pks = Pks::where('nama_pks', $selectedPks)->first();
            if ($pks) {
                // Ambil data biaya terbaru untuk PKS tersebut
                $biaya = Biaya::where('nama_pks', $pks->nama_pks)
                    ->orderByDesc('bulan')
                    ->first();
            }
        }

        return view('input_biaya', [
            'pksList' => $pksList,
            'selectedPks' => $selectedPks,
            'biaya' => $biaya,
        ]);
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            // pks berisi nama_pks dari select
            'pks' => 'required|exists:tb_pks,nama_pks',
            'periode' => 'required|date_format:Y-m',
            'biaya_olah' => 'required|numeric',
            'tarif_angkut_cpo' => 'required|numeric',
            'tarif_angkut_pk' => 'required|numeric',
        ]);

        // cari PKS berdasarkan nama_pks
        $pks = Pks::where('nama_pks', $validated['pks'])->firstOrFail();

        // jika sudah ada data untuk kombinasi nama_pks + bulan → update,
        // kalau belum ada → create (tidak akan dobel untuk kombinasi yang sama)
        Biaya::updateOrCreate(
            [
                'nama_pks' => $pks->nama_pks,
                'bulan' => $validated['periode'],
            ],
            [
                'biaya_olah' => $validated['biaya_olah'],
                'tarif_angkut_cpo' => $validated['tarif_angkut_cpo'],
                'tarif_angkut_pk' => $validated['tarif_angkut_pk'],
            ]
        );

        return redirect()
            ->route('input.biaya', ['pks' => $pks->nama_pks])
            ->with('success', 'Biaya berhasil disimpan.');
    }
}