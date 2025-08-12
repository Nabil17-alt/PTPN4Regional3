<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        $unit = DB::table('tb_unit')->select('kode_unit', 'nama_unit')->get();

        return view('auth.register', compact('unit'));
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|unique:tb_users,username',
            'email' => 'required|email|unique:tb_users,email',
            'password' => 'required|string|min:6|confirmed',
            'level' => 'required|in:Admin,Asisten,Manager,General_Manager,Region_Head,SEVP',
            'kode_unit' => 'required|string|max:50',
        ]);

        User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'level' => $validated['level'],
            'kode_unit' => $validated['kode_unit'],
        ]);

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil, silakan login.');
    }
}