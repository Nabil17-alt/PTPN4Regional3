<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Unit;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;


class AdminController extends Controller
{
    public function akun(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $query = User::select('tb_users.*', 'tb_unit.nama_unit')
            ->leftJoin('tb_unit', 'tb_users.kode_unit', '=', 'tb_unit.kode_unit');


        if (!in_array($user->level, ['Admin', 'Asisten'])) {
            $query->where('tb_users.username', $user->username);
        }

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('tb_users.username', 'like', "%$search%")
                    ->orWhere('tb_users.email', 'like', "%$search%")
                    ->orWhere('tb_users.level', 'like', "%$search%")
                    ->orWhere('tb_unit.nama_unit', 'like', "%$search%");
            });
        }

        $users = $query->paginate(10)->withQueryString();
        $units = Unit::all();

        $jabatanOptions = [
            'Asisten',
            'Manager',
            'Admin',
            'General_Manager',
            'Region_Head',
        ];


        $editUser = null;
        if ($request->has('edit')) {
            $editUser = User::where('username', $request->edit)->first();
        }

        return view('admin.akun', [
            'user' => $user,
            'users' => $users,
            'units' => $units,
            'jabatanOptions' => $jabatanOptions,
            'editUser' => $editUser,
        ]);
    }


    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('username', $request->username)->first();

        if ($user && $request->password === $user->password) {
            Auth::login($user);
            return redirect()->intended('dashboard');
        }

        return back()->withErrors(['username' => 'Username atau password salah']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function updateAccount(Request $request, $username)
    {
        $me = Auth::user();
        $user = User::where('username', $username)->firstOrFail();

        // Cek hak akses
        if (!in_array($me->level, ['Admin', 'Asisten']) && $me->username !== $username) {
            return redirect()->route('admin.akun')->withErrors(['error' => 'Tidak memiliki izin mengubah akun lain.']);
        }

        // Validasi berbeda untuk Admin/Asisten vs User biasa
        if (in_array($me->level, ['Admin', 'Asisten'])) {
            $rules = [
                'username' => 'required|string',
                'email' => 'required|email|unique:tb_users,email,' . $user->id,
                'level' => 'required|string',
                'kode_unit' => 'required|string',
                'password' => 'nullable|string|min:6',
            ];
        } else {
            $rules = [
                'username' => 'required|string',
                'password' => 'nullable|string|min:6',
            ];
        }

        $validated = $request->validate($rules);

        // Update hanya jika ada perubahan
        $updated = false;

        if ($user->username !== $validated['username']) {
            $user->username = $validated['username'];
            $updated = true;
        }

        if (isset($validated['email']) && $user->email !== $validated['email']) {
            $user->email = $validated['email'];
            $updated = true;
        }

        if (isset($validated['level']) && $user->level !== $validated['level']) {
            $user->level = $validated['level'];
            $updated = true;
        }

        if (isset($validated['kode_unit']) && $user->kode_unit !== $validated['kode_unit']) {
            $user->kode_unit = $validated['kode_unit'];
            $updated = true;
        }

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
            $updated = true;
        }

        if ($updated) {
            $user->save();
        }

        return redirect()->route('admin.akun')->with('success', 'Akun berhasil diedit');
    }

    public function deleteAccount($username)
    {
        $me = Auth::user();
        if (!in_array($me->level, ['Admin'])) {
            return redirect()->route('admin.akun')->withErrors(['error' => 'Tidak memiliki izin untuk menghapus akun.']);
        }

        $user = User::where('username', $username)->firstOrFail();
        $user->delete();

        return redirect()->route('admin.akun')->with('success', 'Akun berhasil dihapus');
    }
    public function storeAccount(Request $request)
    {
        try {
            $me = Auth::user();
            if (!in_array($me->level, ['Admin', 'Asisten'])) {
                return redirect()->route('admin.akun')->withErrors(['error' => 'Tidak memiliki izin membuat akun.']);
            }

            $rules = [
                'username' => 'required|string|unique:tb_users,username',
                'email' => 'required|email|unique:tb_users,email',
                'password' => 'required|string|min:6',
                'kode_unit' => 'required|string',
                'level' => 'required|string',
            ];

            $validated = $request->validate($rules);

            $user = User::create([
                'username' => $validated['username'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'level' => $validated['level'],
                'kode_unit' => $validated['kode_unit'],
            ]);

            Log::info('User created:', ['user' => $user]);

            return redirect()->route('admin.akun')->with('success', 'Akun berhasil ditambahkan');
        } catch (\Exception $e) {
            Log::error('Gagal tambah akun: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Gagal menambahkan akun. Lihat log untuk detail.']);
        }
    }

    public function view()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        return view('view', ['user' => $user]);
    }

    public function progress()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        return view('progress', ['user' => $user]);
    }
}
