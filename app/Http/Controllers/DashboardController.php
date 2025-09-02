<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Pembelian;

class DashboardController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $pembelianTerbaru = Pembelian::with('unit')
            ->orderBy('tanggal', 'desc')
            ->take(10)
            ->get();

        $totalPembelian = DB::table('tb_pembelian_cpo_pk')->count();
        $totalPendapatan = DB::table('tb_pembelian_cpo_pk')->sum('total_pendapatan');
        $totalBiaya = DB::table('tb_pembelian_cpo_pk')->sum('total_biaya');
        $totalMargin = DB::table('tb_pembelian_cpo_pk')->sum('margin');

        $rataRataMargin = DB::table('tb_pembelian_cpo_pk')->avg('margin');
        $rataRataBiaya = DB::table('tb_pembelian_cpo_pk')->avg('total_biaya');

        $pembelianHariIni = DB::table('tb_pembelian_cpo_pk as p')
            ->leftJoin('tb_unit as u', 'p.kode_unit', '=', 'u.kode_unit')
            ->select('p.*', 'u.nama_unit')
            ->whereDate('p.tanggal', Carbon::today())
            ->orderBy('p.tanggal', 'desc')
            ->get();

        return view('dashboard', compact(
            'totalPembelian',
            'totalPendapatan',
            'totalBiaya',
            'totalMargin',
            'rataRataMargin',
            'rataRataBiaya',
            'pembelianTerbaru',
            'pembelianHariIni'
        ));

    }
}
