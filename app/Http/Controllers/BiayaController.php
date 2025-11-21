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
        $selectedPeriode = request('periode', now()->format('Y-m'));

        $biaya = null;
        if ($selectedPks) {
            $pks = Pks::where('kode_pks', $selectedPks)->first();
            if ($pks) {
                $biaya = Biaya::where('nama_pks', $pks->nama_pks)
                    ->where('bulan', $selectedPeriode)
                    ->first();
            }
        }

        return view('input_biaya', [
            'pksList' => $pksList,
            'selectedPks' => $selectedPks,
            'selectedPeriode' => $selectedPeriode,
            'biaya' => $biaya,
        ]);
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'pks' => 'required|exists:tb_pks,kode_pks',
            'periode' => 'required|date_format:Y-m',
            'biaya_olah' => 'required|numeric',
            'tarif_angkut_cpo' => 'required|numeric',
            'tarif_angkut_pk' => 'required|numeric',
        ]);

        $pks = Pks::where('kode_pks', $validated['pks'])->firstOrFail();

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
            ->route('input.biaya', ['pks' => $validated['pks'], 'periode' => $validated['periode']])
            ->with('success', 'Biaya berhasil disimpan.');
    }
}