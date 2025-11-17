<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HasilKalkulasi;

class ApprovalController extends Controller
{
    public function index()
    {
        $data = HasilKalkulasi::orderBy('created_at', 'desc')->get();
        return view('approval', compact('data'));
    }

    public function proses(Request $request)
    {
        $data = HasilKalkulasi::findOrFail($request->id);
        $data->status = $request->status;
        $data->save();

        return back()->with('success', 'Status berhasil diperbarui!');
    }
}
