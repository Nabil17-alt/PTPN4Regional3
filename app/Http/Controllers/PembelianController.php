<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembelianController extends Controller
{
    public function storeKalkulator(Request $request)
    {
        $validated = $request->validate([
            'pks' => 'required|string',
            'tanggal' => 'required|date',
            'hargaCPO' => 'nullable|numeric',
            'hargaPK' => 'nullable|numeric',
            'grade' => 'required|array',
            'grade.*' => 'nullable|string',
            'rend_cpo' => 'required|array',
            'rend_cpo.*' => 'nullable|numeric',
            'rend_pk' => 'required|array',
            'rend_pk.*' => 'nullable|numeric',
            'b_produksi_per_tbs_olah' => 'required|array',
            'b_produksi_per_tbs_olah.*' => 'nullable|numeric',
            'biaya_angkut_jual' => 'required|array',
            'biaya_angkut_jual.*' => 'nullable|numeric',
            'harga_bep' => 'required|array',
            'harga_bep.*' => 'nullable|numeric',
            'harga_penetapan_grade' => 'required|array',
            'harga_penetapan_grade.*' => 'nullable|numeric',
            'harga_eskalasi' => 'required|array',
            'harga_eskalasi.*' => 'nullable|numeric',
            'info_harga_pesaing' => 'required|array',
            'info_harga_pesaing.*' => 'nullable|numeric',
        ]);

        DB::transaction(function () use ($request) {
            $namaPks = $request->input('pks');
            $tanggal = $request->input('tanggal');
            $biayaBulan = $request->input('biaya_digunakan');  // nanti diisi jika select‑nya sudah aktif
            $biayaId = null; // isi jika Anda kirim id di form

            $hargaCpo = $request->input('hargaCPO');
            $hargaPk = $request->input('hargaPK');

            $grades = $request->input('grade', []);
            $rendCpoArr = $request->input('rend_cpo', []);
            $rendPkArr = $request->input('rend_pk', []);
            $bProduksiArr = $request->input('b_produksi_per_tbs_olah', []);
            $biayaAngkutArr = $request->input('biaya_angkut_jual', []);
            $hargaBepArr = $request->input('harga_bep', []);
            $hargaPenetapanArr = $request->input('harga_penetapan_grade', []);
            $eskalasiArr = $request->input('harga_eskalasi', []);
            $hargaPesaingArr = $request->input('info_harga_pesaing', []);

            foreach ($grades as $i => $grade) {
                if ($grade === null || $grade === '') {
                    continue; // skip baris grade kosong
                }

                Pembelian::create([
                    'nama_pks' => $namaPks,
                    'tanggal' => $tanggal,
                    'biaya_bulan_berapa' => $biayaBulan,
                    'biayabulanan_id' => $biayaId,

                    'harga_cpo_penetapan' => $hargaCpo,
                    'harga_pk' => $hargaPk,

                    // isi dari input per-grade
                    'biaya_olah' => $request->b_produksi_per_tbs_olah[$i] ?? null,
                    'tarif_angkut_cpo' => $request->biaya_angkut_jual[$i] ?? null,
                    'tarif_angkut_pk' => $request->tarif_angkut_pk[$i] ?? null, // kalau ada field‑nya

                    'grade' => $request->grade[$i],
                    'rendemen_cpo' => $request->rend_cpo[$i] ?? null,
                    'rendemen_pk' => $request->rend_pk[$i] ?? null,
                    'harga_bep' => $request->harga_bep[$i] ?? null,
                    'harga_penetapan' => $request->harga_penetapan_grade[$i] ?? null,
                    'eskalasi' => $request->harga_eskalasi[$i] ?? null,
                    'harga_pesaing' => $request->info_harga_pesaing[$i] ?? null,
                ]);
            }
        });

        return redirect()
            ->back()
            ->with('success', 'Data kalkulator berhasil disimpan ke database.');
    }
}