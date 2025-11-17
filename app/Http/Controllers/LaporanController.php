<?php

namespace App\Http\Controllers;

use App\Models\HasilKalkulasi;

class LaporanController extends Controller
{
    public function index()
    {
        $data = HasilKalkulasi::latest()->get();
        return view('rekap', compact('data'));
    }
}
