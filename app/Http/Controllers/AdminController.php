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
            'Admin',
            'Asisten',
            'Manager',
            'General_Manager',
            'Region_Head',
            'SEVP'
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
        $user = User::where('username', $username)->firstOrFail();

        $validatedData = $request->validate([
            'username' => 'required|string',
            'email' => 'required|email|unique:tb_users,email,' . $user->id,
            'level' => 'required|string',
            'password' => 'nullable|string|min:6',
        ]);

        $user->username = $validatedData['username'];
        $user->email = $validatedData['email'];
        $user->level = $validatedData['level'];

        if (!empty($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']);
        }

        $user->save();

        return redirect()->route('admin.akun')->with('success', 'Akun berhasil diedit');
    }
    public function deleteAccount($username)
    {
        $user = User::where('username', $username)->firstOrFail();
        $user->delete();

        return redirect()->route('admin.akun')->with('success', 'Akun berhasil dihapus');
    }
    public function storeAccount(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required|string|unique:tb_users,username',
                'email' => 'required|email|unique:tb_users,email',
                'password' => 'required|string|min:6',
                'level' => 'required|string',
                'kode_unit' => 'required|string',
            ]);

            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'level' => $request->level,
                'kode_unit' => $request->kode_unit,
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