<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Akun - PTPN4</title>
    <link rel="icon" href="{{ asset('images/logo_ptpn4.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/flowbite@1.6.5/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@1.6.5/dist/flowbite.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/akun.css') }}">
    <link rel="stylesheet" href="{{ asset('css/loaders.css') }}">
</head>

<body>
    @extends('layouts.app')
    @section('content')
        <div class="loader hidden" id="pageLoader">
            <div class="square-spin">
                <img src="{{ asset('images/logo_ptpn4.png') }}" alt="Loading..." />
            </div>
            <span class="tooltip">
                <p>Memuat...</p>
            </span>
        </div>
        <div class="p-4 sm:ml-64">
            @if (session('success'))
                <script>
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 5000,
                        timerProgressBar: true,
                    });
                    Toast.fire({
                        icon: 'success',
                        title: '{{ session('success') }}'
                    });
                </script>
            @endif
            <div class="px-4 py-3 mb-4 bg-white shadow rounded-lg">
                <nav class="flex justify-between items-center flex-wrap">
                    <div>
                        <ol class="flex items-center space-x-2 text-sm text-gray-500">
                            <li>
                                <a id="greeting" class="hover:text-gray-700"
                                    data-username="{{ Auth::user()->username }}"></a>
                            </li>
                            <li>
                                <span class="mx-2 text-gray-400">/</span>
                            </li>
                        </ol>
                        <h6 class="text-xl font-semibold text-gray-800 mt-1">
                            {{ Auth::user()->level }}
                        </h6>
                    </div>
                    <div class="flex items-center gap-6">
                        <button id="openSidebar" class="md:hidden text-gray-700 hover:text-black">
                            <i data-lucide="menu"></i>
                        </button>
                        <a id="logoutForm" href="{{ route('logout') }}"
                            class="flex items-center gap-1 text-sm px-4 py-2 bg-gray-900 text-white rounded hover:bg-gray-800">
                            Keluar
                        </a>
                    </div>
                </nav>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-start border-b pb-4 mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">Akun</h2>
                    @if(in_array(Auth::user()->level, ['Admin', 'Asisten']))
                        <button onclick="openAddModal()"
                            class="flex items-center gap-1 text-sm px-4 py-2 bg-gray-900 text-white rounded hover:bg-gray-800">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z" />
                            </svg>
                            Tambah Akun
                        </button>
                    @endif
                </div>
                @if(in_array(Auth::user()->level, ['Admin', 'Asisten']))
                    <form id="cariForm" method="GET" action="{{ route('admin.akun') }}"
                        class="flex justify-end items-center mb-4">
                        <div class="relative w-64">
                            <input type="text" name="search" value="{{ request('search') }}"
                                class="w-full pl-4 pr-10 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Cari akun..." />
                            <div class="absolute right-3 top-2.5 text-gray-500">
                                <button type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M21 21l-4.35-4.35M16.65 10.5a6.15 6.15 0 11-12.3 0 6.15 6.15 0 0112.3 0z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </form>
                @endif
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[1000px] divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold">Username</th>
                                <th class="px-4 py-3 text-center font-semibold">Jabatan</th>
                                <th class="px-4 py-3 text-center font-semibold">Unit Kerja</th>
                                <th class="px-4 py-3 text-center font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($users as $user)
                                @if(in_array(Auth::user()->level, ['Admin']) || Auth::user()->username == $user->username)
                                    <tr>
                                        <td class="px-4 py-3 flex items-center space-x-3">
                                            <img src="{{ asset('images/logo_ptpn4.png') }}" alt="Logo PTPN4"
                                                class="rounded-full h-8 w-8" />
                                            <div class="font-medium text-gray-800">{{ $user->username }}</div>
                                        </td>
                                        <td class="text-center px-4 py-3 text-gray-600">{{ $user->level }}</td>
                                        <td class="text-center px-4 py-3 text-gray-600">
                                            {{ $user->unit ? $user->unit->nama_unit : '-' }}
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <div class="flex justify-center items-center gap-2">
                                                @if(in_array(Auth::user()->level, ['Admin']) || Auth::user()->username == $user->username)
                                                    <button type="button"
                                                        onclick="openEditModal('{{ $user->username }}', '{{ $user->name }}', '{{ $user->email }}', '{{ $user->level }}', '{{ $user->kode_unit }}')"
                                                        class="flex items-center gap-1 text-xs px-3 py-1 bg-gray-900 text-white rounded hover:bg-gray-800 transition-all">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                            fill="currentColor" viewBox="0 0 24 24">
                                                            <path
                                                                d="M5 19h14v2H5c-1.103 0-2-.897-2-2V7h2v12zM20.707 7.293l-1-1a1 1 0 00-1.414 0L10 14.586V17h2.414l8.293-8.293a1 1 0 000-1.414z" />
                                                        </svg>
                                                        Edit
                                                    </button>
                                                @endif
                                                @if(in_array(Auth::user()->level, ['Admin']))
                                                    <form id="delete-form-{{ $user->username }}"
                                                        action="{{ route('akun.delete', $user->username) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" onclick="confirmDelete('{{ $user->username }}')"
                                                            class="flex items-center gap-1 px-3 py-1 text-xs bg-red-600 text-white rounded hover:bg-red-700 transition-all">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                                fill="currentColor" viewBox="0 0 24 24">
                                                                <path
                                                                    d="M9 3v1H4v2h16V4h-5V3H9zm2 4h2v10h-2V7zm-4 0h2v10H7V7zm8 0h2v10h-2V7z" />
                                                            </svg>
                                                            Hapus
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if(in_array(Auth::user()->level, ['Admin']))
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-6 border-t mt-6">
                        <p class="text-sm text-gray-500">
                            Menampilkan <span class="font-medium text-gray-700">{{ $users->firstItem() }}</span>
                            sampai <span class="font-medium text-gray-700">{{ $users->lastItem() }}</span>
                            dari <span class="font-medium text-gray-700">{{ $users->total() }}</span> akun
                        </p>
                        <div class="flex items-center space-x-2">
                            @php
                                $start = max(1, $users->currentPage() - 2);
                                $end = min($users->lastPage(), $users->currentPage() + 2);
                            @endphp
                            @if ($start > 1)
                                <a href="{{ $users->url(1) }}"
                                    class="px-4 py-2 text-sm text-gray-900 border border-gray-400 rounded-lg hover:bg-gray-100 transition-all">
                                    1
                                </a>
                                @if ($start > 2)
                                    <span class="px-2 text-sm text-gray-500">...</span>
                                @endif
                            @endif
                            @for ($page = $start; $page <= $end; $page++)
                                @if ($page == $users->currentPage())
                                    <span
                                        class="px-4 py-2 text-sm font-semibold text-white bg-gray-700 rounded-lg shadow hover:bg-gray-800 transition-all">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $users->url($page) }}"
                                        class="px-4 py-2 text-sm text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-100 transition-all">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endfor
                            @if ($end < $users->lastPage())
                                @if ($end < $users->lastPage() - 1)
                                    <span class="px-2 text-sm text-gray-500">...</span>
                                @endif
                                <a href="{{ $users->url($users->lastPage()) }}"
                                    class="px-4 py-2 text-sm text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-100 transition-all">
                                    {{ $users->lastPage() }}
                                </a>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
            <footer class="footer p-5 bg-gray-50 border-t">
                <div class="row align-items-center justify-content-lg-between">
                    <div class="col-lg-6 mb-lg-0 mb-4">
                        <div class="text-center text-muted text-m text-lg-start">
                            Copyright &copy;
                            <script>
                                document.write(new Date().getFullYear())
                            </script>
                            PT. Perkebunan Nusantara IV
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <div id="editModal" tabindex="-1"
            class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white rounded-xl shadow-lg w-full max-w-md mx-4 sm:mx-auto p-6 animate-fade-in-down">
                <div class="flex justify-between items-center border-b pb-4 mb-4">
                    <h3 class="text-xl font-bold text-gray-800" id="modalTitle">Edit Akun</h3>
                    <button type="button" onclick="closeModal()"
                        class="text-gray-400 hover:text-gray-600 text-2xl font-bold">&times;</button>
                </div>
                <form id="editForm" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                        <input type="text" id="editUsername" name="username" required
                            value="{{ old('username', $editUser->username ?? '') }}"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan</label>
                        <select id="editLevel" name="level" required
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 px-3 py-2"
                            @if(!in_array(Auth::user()->level, ['Admin', 'Asisten'])) disabled @endif>
                            <option value="" disabled>Pilih Jabatan</option>
                            @foreach ($jabatanOptions as $option)
                                <option value="{{ $option }}" {{ old('level', $editUser->level ?? '') == $option ? 'selected' : '' }}>{{ str_replace('_', ' ', $option) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Unit Kerja</label>
                        <select id="unitSelectEdit" name="kode_unit" required
                            class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-gray-500 focus:border-gray-500 px-3 py-2"
                            @if(!in_array(Auth::user()->level, ['Admin', 'Asisten'])) disabled @endif>
                            <option value="" disabled>Pilih Unit</option>
                            @foreach ($units as $unit)
                                <option value="{{ $unit->kode_unit }}" {{ old('kode_unit', $editUser->kode_unit ?? '') == $unit->kode_unit ? 'selected' : '' }}>
                                    {{ $unit->nama_unit }}
                                </option>
                            @endforeach
                        </select>
                        @error('kode_unit')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru (opsional)</label>
                        <input type="password" id="editPassword" name="password"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 px-3 py-2"
                            placeholder="Kosongkan jika tidak ingin diubah">
                    </div>
                    <div class="flex justify-end space-x-2 pt-4 border-t mt-6">
                        <button type="button" onclick="closeModal()"
                            class="px-4 py-2 text-gray-600 hover:text-gray-800 hover:underline text-sm">Batal</button>
                        <button type="submit"
                            class="flex items-center gap-2 text-sm px-4 py-2 bg-gray-900 text-white rounded hover:bg-gray-800 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z" />
                            </svg>
                            Edit Akun
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div id="addModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white rounded-xl shadow-lg w-full max-w-2xl mx-4 sm:mx-6 p-6 relative animate-fade-in-down">
                <div class="flex justify-between items-center border-b pb-4 mb-4">
                    <h2 class="text-2xl font-bold text-gray-800">Tambah Akun</h2>
                    <button onclick="closeAddModal()"
                        class="text-gray-400 hover:text-gray-600 text-2xl font-bold">&times;</button>
                </div>
                <form id="addakunForm" action="{{ route('akun.add') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Username</label>
                            <input type="text" name="username" required
                                class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-gray-500 focus:border-gray-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan</label>
                            <select id="jabatanSelect" name="level" required
                                class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-gray-500 focus:border-gray-500 px-3 py-2">
                                <option value="" disabled selected>Pilih Jabatan</option>
                                @foreach ($jabatanOptions as $option)
                                    <option value="{{ $option }}">{{ str_replace('_', ' ', $option) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kode Unit</label>
                            <input type="hidden" name="kode_unit" id="kodeUnitHidden">
                            <select id="unitSelectAdd"
                                class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-gray-500 focus:border-gray-500 px-3 py-2">
                                <option value="" disabled selected>Pilih Unit</option>
                                @foreach ($units as $unit)
                                    <option value="{{ $unit->kode_unit }}" {{ old('kode_unit', $editUser->kode_unit ?? '') == $unit->kode_unit ? 'selected' : '' }}>
                                        {{ $unit->nama_unit }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kode_unit')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Password</label>
                            <input type="password" name="password" required
                                class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-gray-500 focus:border-gray-500">
                        </div>
                    </div>
                    <div class="flex justify-end space-x-2 pt-4 border-t">
                        <button type="button" onclick="closeAddModal()"
                            class="px-4 py-2 text-gray-600 hover:text-gray-800 hover:underline text-sm">Batal</button>
                        <button type="submit"
                            class="flex items-center gap-2 text-sm px-4 py-2 bg-gray-900 text-white rounded hover:bg-gray-800 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z" />
                            </svg>
                            Simpan Akun
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endsection
    <script src="{{ asset('js/akun.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>