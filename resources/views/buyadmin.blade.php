<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pembelian - PTPN4</title>
    <link rel="icon" href="{{ asset('images/logo_ptpn4.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/flowbite@1.6.5/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@1.6.5/dist/flowbite.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/loaders.css') }}">
    <link rel="stylesheet" href="{{ asset('css/buyadmin.css') }}">
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
                    document.addEventListener('DOMContentLoaded', function () {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 5000,
                            timerProgressBar: true,
                        });
                        Toast.fire({
                            icon: 'success',
                            title: @json(session('success'))
                        });
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
                <div class="flex justify-between items-start border-b pb-4 mb-4">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800">Pembelian</h2>
                    </div>
                </div>
                <div class="flex justify-end items-center mb-4">
                    <div class="relative w-64">
                        <input type="text" id="searchDate" placeholder="Masukkan Tanggal..."
                            class="w-full pl-4 pr-10 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                        <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 7V3M16 7V3M3 11h18M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="max-w-5xl mx-auto overflow-x-auto">
                    <table class="w-full min-w-[800px] divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold">Grade</th>
                                <th class="px-4 py-3 text-center font-semibold">Status</th>
                                <th class="px-4 py-3 text-center font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($items as $pembelian)
                                @php
                                    $firstItem = $items->first();
                                    $badgeColors = [
                                        'Sudah Diapprove' => 'bg-green-100 text-green-700',
                                        'Tidak Mengolah' => 'bg-yellow-100 text-yellow-800',
                                        'Belum Diinput' => 'bg-red-100 text-red-800',
                                    ];
                                    $badgeClass = $badgeColors[$firstItem->status] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <tr class="transition-all duration-500 hover:bg-gray-50">
                                    <td class="px-4 py-3">
                                        {{ $pembelian->grade }}
                                    </td>
                                    <td class="text-center px-4 py-3">
                                        <span class="text-xs px-2 py-1 rounded-full {{ $badgeClass }}">
                                            {{ ucfirst($firstItem->status ?? 'Tidak Diketahui') }}
                                        </span>
                                    </td>
                                    <td class="text-center px-4 py-3">
                                        <div class="flex justify-center items-center gap-2">
                                            <a href="{{ route('buy.detail', ['id' => $pembelian->id, 'back' => request()->fullUrl()]) }}"
                                                class="detailForm flex items-center gap-1 text-xs px-3 py-1 bg-gray-900 text-white rounded hover:bg-gray-800 transition-all">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                    fill="currentColor" viewBox="0 0 24 24">
                                                    <path
                                                        d="M12 5c-7.633 0-11 7-11 7s3.367 7 11 7 11-7 11-7-3.367-7-11-7zm0 12c-2.761 0-5-2.239-5-5s2.239-5 5-5 5 2.239 5 5-2.239 5-5 5zm0-8a3 3 0 100 6 3 3 0 000-6z" />
                                                </svg>
                                                Detail
                                            </a>
                                            <a href="{{ route('pembelian.edit', ['id' => $pembelian->id, 'back' => request()->fullUrl()]) }}"
                                                class="flex items-center gap-1 text-xs px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition-all">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                    fill="currentColor" viewBox="0 0 24 24">
                                                    <path
                                                        d="M5 20h14v2H5c-1.103 0-2-.897-2-2V6h2v14zM20.707 7.293l-1-1a1.001 1.001 0 0 0-1.414 0L10 14.586V17h2.414l8.293-8.293a1 1 0 0 0 0-1.414z" />
                                                </svg>
                                                Edit
                                            </a>
                                            <form id="delete-form-{{ $pembelian->id }}"
                                                action="{{ route('pembelian.destroy', $pembelian->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" onclick="confirmDelete({{ $pembelian->id }})"
                                                    class="flex items-center gap-1 px-3 py-1 text-xs bg-red-600 text-white rounded hover:bg-red-700 transition-all">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                        fill="currentColor" viewBox="0 0 24 24">
                                                        <path
                                                            d="M9 3v1H4v2h16V4h-5V3H9zm2 4h2v10h-2V7zm-4 0h2v10H7V7zm8 0h2v10h-2V7z" />
                                                    </svg>
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center px-4 py-3 text-gray-500">
                                        Tidak ada data.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="flex justify-end pt-4 border-t mt-4">
                </div>
            </div>
        </div>
    @endsection
    <script src="{{ asset('js/buyadmin.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>