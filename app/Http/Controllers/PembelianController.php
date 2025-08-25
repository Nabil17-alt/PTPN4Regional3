<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grade; 
use App\Models\Unit; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Pembelian;
use Carbon\Carbon;

class PembelianController extends Controller
{
    public function create()
    {
        $grades = Grade::all();
        $units = Unit::all();

        $user = auth()->user();
        return view('buyform', compact('user', 'grades', 'units'));
    }
    public function buy()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }
        $pembelians = Pembelian::with('unit')->orderByDesc('created_at')->paginate(10);

        return view('buy', compact('user', 'pembelians'));
    }

    public function buyadmin(Request $request)
    {
        $tanggal = $request->tanggal ?? Carbon::yesterday()->toDateString();
        $units = Unit::where('jenis', '!=', 'Kantor Regional')->get();

        $pembelianPadaTanggal = Pembelian::whereDate('tanggal', $tanggal)->get()->keyBy('kode_unit');

        $userLevel = Auth::user()->level;

        $items = $units->map(function ($unit) use ($pembelianPadaTanggal, $userLevel, $tanggal) {
            $kodeUnit = $unit->kode_unit;
            $pembelian = $pembelianPadaTanggal->get($kodeUnit);

            if ($pembelian) {
                switch ($userLevel) {
                    case 'Admin':
                        $pembelian->status = $pembelian->status_approval_admin ? 'Diapprove Admin' : 'Sudah Diinput';
                        break;
                    case 'Manager':
                        $pembelian->status = $pembelian->status_approval_manager ? 'Diapprove Manager' : 'Sudah Diinput';
                        break;
                    case 'General_Manager':
                        $pembelian->status = $pembelian->status_approval_gm ? 'Diapprove General_Manager' : 'Sudah Diinput';
                        break;
                    case 'Region_Head':
                        $pembelian->status = $pembelian->status_approval_rh ? 'Diapprove Region_Head' : 'Sudah Diinput';
                        break;
                    case 'SEVP':
                        $pembelian->status = $pembelian->status_approval_sevp ? 'Diapprove SEVP' : 'Sudah Diinput';
                        break;
                    default:
                        $pembelian->status = 'Sudah Diinput';
                }


                return $pembelian;
            } else {
                $adaData = DB::table('tb_pembelian_cpo_pk')
                    ->where('kode_unit', $kodeUnit)
                    ->whereDate('tanggal', $tanggal)
                    ->exists();

                if ($adaData) {
                    $pembelianDummy = new Pembelian();
                    $pembelianDummy->unit = $unit;
                    $pembelianDummy->status = 'Sudah Diinput';
                    return $pembelianDummy;
                } else {
                    $pembelianDummy = new Pembelian();
                    $pembelianDummy->unit = $unit;
                    $pembelianDummy->status = 'Belum Diinput';
                    return $pembelianDummy;
                }
            }
        });

        return view('buyadmin', compact('items', 'tanggal'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_unit' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'grade' => 'required|string|max:50',
            'harga_cpo' => 'required|numeric',
            'harga_pk' => 'required|numeric',
            'rendemen_cpo' => 'required|numeric',
            'rendemen_pk' => 'required|numeric',
            'biaya_olah' => 'required|numeric',
            'tarif_angkut_cpo' => 'required|numeric',
            'tarif_angkut_pk' => 'required|numeric',
            'biaya_angkut_jual' => 'required|numeric',
            'harga_escalasi' => 'required|numeric',
        ]);

        $unit = Unit::where('kode_unit', $validated['kode_unit'])->first();

        if (!$unit) {
            return redirect()->back()->with('error', 'Unit tidak ditemukan.');
        }

        $pembelian = new Pembelian();
        $pembelian->kode_unit = $validated['kode_unit']; 
        $pembelian->tanggal = $validated['tanggal'];
        $pembelian->grade = $validated['grade'];
        $pembelian->harga_cpo = $validated['harga_cpo'];
        $pembelian->harga_pk = $validated['harga_pk'];
        $pembelian->rendemen_cpo = $validated['rendemen_cpo'];
        $pembelian->rendemen_pk = $validated['rendemen_pk'];
        $pembelian->biaya_olah = $validated['biaya_olah'];
        $pembelian->tarif_angkut_cpo = $validated['tarif_angkut_cpo'];
        $pembelian->tarif_angkut_pk = $validated['tarif_angkut_pk'];
        $pembelian->biaya_angkut_jual = $validated['biaya_angkut_jual'];
        $pembelian->harga_escalasi = $validated['harga_escalasi'];

        $pembelian->save();

        return redirect()->back()->with('success', 'Data pembelian berhasil disimpan');
    }

    public function destroy(Pembelian $pembelian)
    {
        $pembelian->delete();
        return redirect()->back()->with('success', 'Berhasil menghapus data!');
    }

    public function edit($id)
    {
        $pembelian = Pembelian::findOrFail($id);
        $grades = Grade::all();
        $units = Unit::all(); 

        return view('buyedit', compact('pembelian', 'grades', 'units')); 
    }

    public function update(Request $request, $id)
    {
        $pembelian = Pembelian::findOrFail($id);

        $validated = $request->validate([
            'kode_unit' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'grade' => 'required|string|max:50',
            'harga_cpo' => 'required|numeric',
            'harga_pk' => 'required|numeric',
            'rendemen_cpo' => 'required|numeric',
            'rendemen_pk' => 'required|numeric',
            'biaya_olah' => 'required|numeric',
            'tarif_angkut_cpo' => 'required|numeric',
            'tarif_angkut_pk' => 'required|numeric',
            'biaya_angkut_jual' => 'required|numeric',
            'harga_escalasi' => 'required|numeric',
            
        ]);

        $pembelian->update($validated);

        return redirect()->back()->with('success', 'Data pembelian berhasil diedit');

    }

    public function lihatTanggal($tanggal)
    {
        $items = Pembelian::whereDate('tanggal', $tanggal)->get(); 
        return view('buysee', compact('items')); 
    }

    public function detail($id)
    {
        $pembelian = Pembelian::with('unit')->findOrFail($id);
        $unit = $pembelian->unit;
        return view('buydetail', compact('pembelian', 'unit'));
    }

    public function lihatPerUnit($unit, $tanggal)
    {
        $pembelians = Pembelian::with('unit')
            ->where('kode_unit', $unit)
            ->whereDate('tanggal', $tanggal)
            ->get(['grade', 'margin', 'id', 'kode_unit', 'tanggal']);

        return view('buyseeunit', compact('pembelians'));
    }

    public function approve($id)
    {
        $pembelian = Pembelian::findOrFail($id);

        $user = auth()->user();

        if ($user->level === 'Admin') {
            $pembelian->status = 'Diapprove Admin';
        } elseif ($user->level === 'Manager') {
            $pembelian->status = 'Diapprove Manager';
        } elseif ($user->level === 'General_Manager') {
            $pembelian->status = 'Diapprove General_Manager';
        } elseif ($user->level === 'Region_Head') {
            $pembelian->status = 'Diapprove Region_Head';
        }

        $pembelian->save();

        return redirect()->route('buy.admin')->with('success', 'Data berhasil di-approve.');
    }

}