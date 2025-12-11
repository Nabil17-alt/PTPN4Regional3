<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Biaya;
use App\Models\Pembelian;
use App\Models\Pks;
use App\Models\Grade;
use Illuminate\Support\Collection;

class KalkulatorController extends Controller
{
    public function index()
    {
        $pksList = Pks::orderBy('nama_pks')->get();
        $biayaList = Biaya::select(
            'id',
            'nama_pks',
            'bulan',
            'biaya_olah',
            'tarif_angkut_cpo',
            'tarif_angkut_pk',
            'b_produksi_per_tbs_olah',
            'biaya_angkut_jual'
        )->get();
        $gradeList = Grade::orderBy('nama_grade')->get();

        // Ambil data pembelian terbaru untuk ditampilkan di tabel preview
        $pembelianList = Pembelian::orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc')
            ->take(50)
            ->get();

        // Hitung harga_kemarin dan selisih per PKS+Grade berdasarkan baris sebelumnya dalam daftar
        $grouped = $pembelianList->groupBy(function ($row) {
            return ($row->nama_pks ?? '-') . '||' . ($row->grade ?? '-');
        });

        foreach ($grouped as $group) {
            // $group sudah dalam urutan desc (terbaru -> lama)
            for ($i = 0; $i < $group->count(); $i++) {
                $current = $group[$i];
                $next = $group[$i + 1] ?? null; // baris berikutnya adalah data lebih lama (kemarin)
                $hargaKemarin = $next?->harga_penetapan;
                $current->harga_kemarin = $hargaKemarin;
                $current->selisih_harga = isset($hargaKemarin)
                    ? ($current->harga_penetapan - $hargaKemarin)
                    : null;
            }
        }

        return view('input_kalkulator', compact('pksList', 'biayaList', 'gradeList', 'pembelianList'));
    }

    public function hitung(Request $request)
    {
        $validated = $request->validate([
            'pks' => 'required|string',
            'tanggal' => 'required|date',
            'biaya_digunakan' => 'required|exists:tb_biayabulanan,id',

            // harga referensi (atas)
            'hargaCPO' => 'required|numeric',
            'hargaPK' => 'required|numeric',

            // per-grade sebagai array
            'grade' => 'required|array|min:1',
            'grade.*' => 'required|string',
            'rend_cpo' => 'required|array',
            'rend_cpo.*' => 'required|numeric',
            'rend_pk' => 'required|array',
            'rend_pk.*' => 'required|numeric',
            'harga_bep' => 'required|array',
            'harga_bep.*' => 'required|numeric',
            'harga_penetapan_grade' => 'required|array',
            'harga_penetapan_grade.*' => 'required|numeric',
            'harga_eskalasi' => 'required|array',
            'harga_eskalasi.*' => 'required|numeric',
            'info_harga_pesaing' => 'nullable|array',
            'info_harga_pesaing.*' => 'nullable|numeric',
        ]);

        $biaya = Biaya::findOrFail($validated['biaya_digunakan']);

        $grades = $validated['grade'];
        $rendCpoArr = $validated['rend_cpo'];
        $rendPkArr = $validated['rend_pk'];
        $hargaBepArr = $validated['harga_bep'];
        $hargaPenetapanArr = $validated['harga_penetapan_grade'];
        $eskalasiArr = $validated['harga_eskalasi'];
        $pesaingArr = $validated['info_harga_pesaing'] ?? [];

        $rowCount = count($grades);
        for ($i = 0; $i < $rowCount; $i++) {
            // lewati jika grade kosong (antisipasi baris tidak lengkap)
            if (!isset($grades[$i]) || $grades[$i] === null || $grades[$i] === '') {
                continue;
            }

            Pembelian::create([
                'nama_pks' => $validated['pks'],
                'tanggal' => $validated['tanggal'],
                'biaya_bulan_berapa' => $biaya->bulan,
                'biayabulanan_id' => $biaya->id,

                // harga referensi
                'harga_cpo_penetapan' => $validated['hargaCPO'],
                'harga_pk' => $validated['hargaPK'],

                // salin beberapa info biaya (opsional, sesuai migrasi)
                'biaya_olah' => $biaya->biaya_olah,
                'tarif_angkut_cpo' => $biaya->tarif_angkut_cpo,
                'tarif_angkut_pk' => $biaya->tarif_angkut_pk,

                // per grade
                'grade' => $grades[$i] ?? null,
                'rendemen_cpo' => $rendCpoArr[$i] ?? null,
                'rendemen_pk' => $rendPkArr[$i] ?? null,
                'harga_bep' => $hargaBepArr[$i] ?? null,
                'harga_penetapan' => $hargaPenetapanArr[$i] ?? null,
                'eskalasi' => $eskalasiArr[$i] ?? null,
                'harga_pesaing' => $pesaingArr[$i] ?? null,
            ]);
        }

        return redirect()->route('input.kalkulator')->with('success', 'Data kalkulator berhasil disimpan.');
    }
}
