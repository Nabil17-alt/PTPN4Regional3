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
            'pks' => 'required|exists:tb_pks,nama_pks',
            'periode' => 'required|date_format:Y-m',
            'biaya_olah' => 'required|numeric',
            'tarif_angkut_cpo' => 'required|numeric',
            'tarif_angkut_pk' => 'required|numeric',
            'b_produksi_per_tbs_olah' => 'required|numeric',
            'biaya_angkut_jual' => 'required|numeric',
        ]);

        $pks = Pks::where('nama_pks', $validated['pks'])->firstOrFail();

        Biaya::updateOrCreate(
            [
                'nama_pks' => $pks->nama_pks,
                'bulan' => $validated['periode'],
            ],
            [
                'biaya_olah' => $validated['biaya_olah'],
                'tarif_angkut_cpo' => $validated['tarif_angkut_cpo'],
                'tarif_angkut_pk' => $validated['tarif_angkut_pk'],
                'b_produksi_per_tbs_olah' => $validated['b_produksi_per_tbs_olah'],
                'biaya_angkut_jual' => $validated['biaya_angkut_jual'],
            ]
        );

        return redirect()
            ->route('input.biaya', ['pks' => $pks->nama_pks])
            ->with('success', 'Biaya berhasil disimpan.');
    }
}