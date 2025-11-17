<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Biaya;
use App\Models\HasilKalkulasi;

class KalkulatorController extends Controller
{
    public function index()
    {
        $biaya = Biaya::first();
        return view('input_kalkulator', compact('biaya'));
    }

    public function hitung(Request $request)
    {
        $request->validate([
            'berat' => 'required|numeric',
            'harga_cpo' => 'required|numeric',
        ]);

        $biaya = Biaya::first();
        if (!$biaya) {
            return back()->with('error', 'Input biaya belum diisi!');
        }

        $total = ($request->berat * $request->harga_cpo)
            - $biaya->biaya_operasional
            - $biaya->biaya_produksi;

        $result = HasilKalkulasi::create([
            'berat' => $request->berat,
            'harga_cpo' => $request->harga_cpo,
            'total' => $total,
            'status' => 'Pending'
        ]);

        return back()->with('success', 'Hitung berhasil! Total: ' . number_format($total));
    }
}
