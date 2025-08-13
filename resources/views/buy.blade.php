<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Pembelian - PTPN4</title>
    <link rel="icon" href="{{ asset('images/logo_ptpn4.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/flowbite@1.6.5/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@1.6.5/dist/flowbite.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/loaders.css') }}">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

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
                    <div class="flex gap-2">
                        <a href="{{ route('pembelian.create') }}"
                            class="flex items-center gap-1 text-sm px-4 py-2 bg-gray-900 text-white rounded hover:bg-gray-800">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z" />
                            </svg>
                            Tambah Pembelian
                        </a>
                    </div>
                </div>
                <div class="flex justify-end items-center mb-4">
                    <div class="relative w-64">
                        <input type="text" id="searchDate" placeholder="Masukkan Tanggal..."
                            class="w-full pl-4 pr-10 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                        <!-- Ikon opsional di kanan input -->
                        <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 7V3M16 7V3M3 11h18M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full min-w-[800px] divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold">Tanggal</th>
                                <th class="px-4 py-3 text-center font-semibold">Status</th>
                                <th class="px-4 py-3 text-center font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($pembelians as $item)
                                <tr class="transition-all duration-500 hover:bg-gray-50">
                                    <td class="px-4 py-3 text-gray-800 font-medium">
                                        {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d-F-Y') }}
                                    </td>
                                    <td class="text-center px-4 py-3">
                                        @php
                                            $badgeColors = [
                                                'approve' => 'bg-green-100 text-green-700',
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'reject' => 'bg-red-100 text-red-800',
                                            ];
                                            $badgeClass = $badgeColors[$item->status] ?? 'bg-gray-100 text-gray-800';
                                        @endphp
                                        <span class="text-xs px-2 py-1 rounded-full {{ $badgeClass }}">
                                            {{ ucfirst($item->status ?? 'Tidak Diketahui') }}
                                        </span>
                                    </td>
                                    <td class="text-center px-4 py-3">
                                        <div class="flex justify-center items-center gap-2">
                                            <div x-data="{ openModal{{ $item->id }}: false }">
                                                <a href="#" @click.prevent="openModal{{ $item->id }} = true"
                                                    class="flex items-center gap-1 text-xs px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition-all">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                        fill="currentColor" viewBox="0 0 24 24">
                                                        <path
                                                            d="M12 5c-7.633 0-11 7-11 7s3.367 7 11 7 11-7 11-7-3.367-7-11-7zm0 12c-2.761 0-5-2.239-5-5s2.239-5 5-5
                                                                                                                                                                        5 2.239 5 5-2.239 5-5 5zm0-8a3 3 0 100 6 3 3 0 000-6z" />
                                                    </svg>
                                                    Lihat
                                                </a>
                                                <div x-show="openModal{{ $item->id }}" x-cloak
                                                    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                                                    <div @click.away="openModal{{ $item->id }} = false"
                                                        class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
                                                        <div class="flex justify-between items-center mb-4">
                                                            <h2 class="text-lg font-semibold">
                                                                {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}
                                                            </h2>
                                                            <button @click="openModal{{ $item->id }} = false"
                                                                class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
                                                        </div>
                                                        <table class="w-full text-sm border">
                                                            <thead>
                                                                <tr class="bg-gray-100">
                                                                    <th class="border px-4 py-2">Grade</th>
                                                                    <th class="border px-4 py-2">Margin (%)</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td class="border px-4 py-2">{{ $item->grade }}</td>
                                                                    <td class="border px-4 py-2">
                                                                        {{ number_format($item->margin, 2) }}%
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="{{ route('pembelian.detail', $item->id) }}"
                                                class="flex items-center gap-1 text-xs px-3 py-1 bg-gray-900 text-white rounded hover:bg-gray-800 transition-all">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                    fill="currentColor" viewBox="0 0 24 24">
                                                    <path
                                                        d="M5 19h14v2H5c-1.103 0-2-.897-2-2V7h2v12zM20.707 7.293l-1-1a1 
                                                                                                                                                                                                                                                                                        1 0 00-1.414 0L10 14.586V17h2.414l8.293-8.293a1 1 0 000-1.414z" />
                                                </svg>
                                                Detail
                                            </a>
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
                    <div class="flex items-center space-x-2">
                        @php
                            $start = max(1, $pembelians->currentPage() - 2);
                            $end = min($pembelians->lastPage(), $pembelians->currentPage() + 2);
                        @endphp
                        @if ($start > 1)
                            <a href="{{ $pembelians->url(1) }}"
                                class="px-4 py-2 text-sm text-gray-900 border border-gray-400 rounded-lg hover:bg-gray-100 transition-all">
                                1
                            </a>
                            @if ($start > 2)
                                <span class="px-2 text-sm text-gray-500">...</span>
                            @endif
                        @endif
                        @for ($page = $start; $page <= $end; $page++)
                            @if ($page == $pembelians->currentPage())
                                <span
                                    class="px-4 py-2 text-sm font-semibold text-white bg-gray-700 rounded-lg shadow hover:bg-gray-800 transition-all">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $pembelians->url($page) }}"
                                    class="px-4 py-2 text-sm text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-100 transition-all">
                                    {{ $page }}
                                </a>
                            @endif
                        @endfor
                        @if ($end < $pembelians->lastPage())
                            @if ($end < $pembelians->lastPage() - 1)
                                <span class="px-2 text-sm text-gray-500">...</span>
                            @endif
                            <a href="{{ $pembelians->url($pembelians->lastPage()) }}"
                                class="px-4 py-2 text-sm text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-100 transition-all">
                                {{ $pembelians->lastPage() }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endsection
    <script src="{{ asset('js/buy.js') }}"></script>
</body>

</html>