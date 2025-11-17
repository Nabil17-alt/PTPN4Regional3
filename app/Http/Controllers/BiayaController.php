<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Biaya;

class BiayaController extends Controller
{
    public function index()
    {
        $biaya = Biaya::first();
        return view('input_biaya', compact('biaya'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'biaya_operasional' => 'required|numeric',
            'biaya_produksi' => 'required|numeric',
        ]);

        Biaya::updateOrCreate(
            ['id' => 1],
            [
                'biaya_operasional' => $request->biaya_operasional,
                'biaya_produksi' => $request->biaya_produksi,
            ]
        );

        return back()->with('success', 'Biaya berhasil disimpan!');
    }
}
