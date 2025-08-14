<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lihat Pembelian - PTPN4</title>
    <link rel="icon" href="{{ asset('images/logo_ptpn4.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/flowbite@1.6.5/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@1.6.5/dist/flowbite.min.js"></script>
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
                        <h2 class="text-xl font-semibold text-gray-800">Pembelian - Lihat Pembelian</h2>
                    </div>
                </div>
                <div class="flex justify-end items-center mb-4">
                </div>
                <div class="max-w-5xl mx-auto overflow-x-auto">
                    <table class="min-w-[800px] w-full table-fixed">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="w-1/3 px-4 py-3 text-left font-semibold">Grade</th>
                                <th class="w-2/3 px-6 py-3 text-left font-semibold">Margin</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-4 py-3">{{ $pembelian->grade }}</td>
                                <td class="px-6 py-3">{{ number_format($pembelian->margin, 2, ',', '.') }}%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="flex justify-end pt-4 border-t mt-4">
                    <div class="pt-6">
                        <a id="backForm" href="{{ route('buy') }}"
                            class="inline-block px-4 py-2 text-sm bg-gray-700 text-white rounded hover:bg-gray-800 transition-all">
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    <script src="{{ asset('js/buysee.js') }}"></script>
</body>

</html>