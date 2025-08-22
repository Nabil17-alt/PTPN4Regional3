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
                                <a href="#" class="hover:text-gray-700">Selamat Datang</a>
                            </li>
                            <li>
                                <span class="mx-2 text-gray-400">/</span>
                            </li>
                            <li class="text-gray-700 font-medium">
                                {{ Auth::user()->level }}
                            </li>
                        </ol>
                        <h6 class="text-xl font-semibold text-gray-800 mt-1">
                            {{ Auth::user()->username }}
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
                <div class="overflow-x-auto">
                    @php
                        $user = Auth::user();
                    @endphp

                    <table class="w-full min-w-[1000px] divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold">Nama</th>
                                <th class="px-4 py-3 text-center font-semibold">Email</th>
                                <th class="px-4 py-3 text-center font-semibold">Jabatan</th>
                                <th class="px-4 py-3 text-center font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-4 py-3 flex items-center space-x-3">
                                    <img src="https://i.pravatar.cc/40?u={{ $user->username }}" alt="{{ $user->username }}"
                                        class="rounded-full h-8 w-8" />
                                    <div class="font-medium text-gray-800">{{ $user->username }}</div>
                                </td>
                                <td class="text-center px-4 py-3 text-gray-600">{{ $user->email }}</td>
                                <td class="text-center px-4 py-3 text-gray-600">{{ $user->level }}</td>
                                <td class="px-4 py-3 text-center">
                                    <div class="flex justify-center items-center gap-2">
                                        <button type="button"
                                            onclick="openEditModal('{{ $user->username }}', '{{ $user->name }}', '{{ $user->email }}', '{{ $user->level }}')"
                                            class="flex items-center gap-1 text-xs px-3 py-1 bg-gray-900 text-white rounded hover:bg-gray-800 transition-all">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M5 19h14v2H5c-1.103 0-2-.897-2-2V7h2v12zM20.707 7.293l-1-1a1 1 0 00-1.414 0L10 14.586V17h2.414l8.293-8.293a1 1 0 000-1.414z" />
                                            </svg>
                                            Edit
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-6 border-t mt-6">
                </div>
            </div>
        </div>
        <div id="editModal" tabindex="-1"
            class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white rounded-xl shadow-lg w-full max-w-md mx-4 sm:mx-auto p-6 animate-fade-in-down">
                <div class="flex justify-between items-center border-b pb-4 mb-4">
                    <h3 class="text-xl font-bold text-gray-800" id="modalTitle">Edit Akun</h3>
                    <button type="button" onclick="closeModal()"
                        class="text-gray-400 hover:text-gray-600 text-2xl font-bold">&times;</button>
                </div>
                <form id="editForm" method="POST" action="" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                        <input type="text" id="editUsername" name="username" required
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" id="editEmail" name="email" required
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan</label>
                        <select id="editLevel" name="level" required
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 px-3 py-2">
                            <option value="" disabled selected>Pilih Jabatan</option>
                            @foreach ($jabatanOptions as $option)
                                <option value="{{ $option }}">{{ str_replace('_', ' ', $option) }}</option>
                            @endforeach
                        </select>
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
    @endsection
    <script src="{{ asset('js/akununit.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>