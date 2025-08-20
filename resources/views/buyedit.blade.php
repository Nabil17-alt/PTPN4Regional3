<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Pembelian - PTPN4</title>
    <link rel="icon" href="{{ asset('images/logo_ptpn4.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/flowbite@1.6.5/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@1.6.5/dist/flowbite.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/loaders.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
                <div class="flex justify-between items-start border-b pb-4 mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">Pembelian - Edit Pembelian</h2>
                </div>

                <form id="editbuyForm" action="{{ route('pembelian.update', $pembelian->id) }}" method="POST"
                    class="space-y-6">
                    @csrf
                    @method('PUT')
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal</label>
                            <input type="date" name="tanggal" value="{{ old('tanggal', $pembelian->tanggal) }}"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring focus:ring-indigo-200"
                                required>
                        </div>

                        <div class="flex flex-col gap-6">
                            <div class="w-full">
                                <label class="block text-sm font-medium text-gray-700">Unit</label>

                                @php
                                    $user = auth()->user();
                                @endphp

                                @if ($user->level === 'Admin' || $user->level === 'Asisten')
                                    <select name="kode_unit"
                                        class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 bg-white">
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->kode_unit }}" {{ old('kode_unit', $pembelian->kode_unit) == $unit->kode_unit ? 'selected' : '' }}>
                                                {{ $unit->nama_unit }}
                                            </option>
                                        @endforeach
                                    </select>
                                @else
                                    <input type="text" value="{{ $user->unit->nama_unit }}" disabled
                                        class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-100">
                                    <input type="hidden" name="kode_unit" value="{{ $user->kode_unit }}">
                                @endif
                            </div>
                            <div class="w-full">
                                <label class="block text-sm font-medium text-gray-700">Grade</label>
                                <select name="grade" required
                                    class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-indigo-200">
                                    <option value="" disabled selected>Pilih Grade</option>
                                    @foreach ($grades as $grade)
                                        <option value="{{ $grade->nama_grade }}" {{ old('grade', $pembelian->grade) == $grade->nama_grade ? 'selected' : '' }}>
                                            {{ $grade->nama_grade }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="flex flex-col md:flex-row gap-6">
                            <div class="w-full md:w-1/2">
                                <label class="block text-sm font-medium text-gray-700">Harga CPO</label>
                                <input type="number" name="harga_cpo" id="hargaCPO"
                                    value="{{ old('harga_cpo', $pembelian->harga_cpo) }}" readonly
                                    class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-100"
                                    required>
                            </div>
                            <div class="w-full md:w-1/2">
                                <label class="block text-sm font-medium text-gray-700">Harga PK</label>
                                <input type="number" name="harga_pk" id="hargaPK"
                                    value="{{ old('harga_pk', $pembelian->harga_pk) }}" readonly
                                    class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-100"
                                    required>
                            </div>
                        </div>

                        <div class="flex flex-col md:flex-row gap-6">
                            <div class="w-full md:w-1/2">
                                <label class="block text-sm font-medium text-gray-700">Rendemen CPO</label>
                                <input type="number" step="any" name="rendemen_cpo" id="rendemen_cpo"
                                    value="{{ old('rendemen_cpo', $pembelian->rendemen_cpo) }}"
                                    class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-indigo-200"
                                    required>
                            </div>
                            <div class="w-full md:w-1/2">
                                <label class="block text-sm font-medium text-gray-700">Rendemen PK</label>
                                <input type="number" step="any" name="rendemen_pk" id="rendemen_pk"
                                    value="{{ old('rendemen_pk', $pembelian->rendemen_pk) }}"
                                    class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-indigo-200"
                                    required>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Total Rendemen</label>
                            <input type="number" step="any" name="total_rendemen" id="total_rendemen"
                                value="{{ old('total_rendemen', $pembelian->total_rendemen) }}" readonly
                                class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-100">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Biaya Olah</label>
                            <input type="number" step="any" name="biaya_olah" id="biayaOlah"
                                value="{{ old('biaya_olah', $pembelian->biaya_olah) }}"
                                class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-indigo-200"
                                required>
                        </div>

                        <div class="flex flex-col md:flex-row gap-6">
                            <div class="w-full md:w-1/2">
                                <label class="block text-sm font-medium text-gray-700">Tarif Angkut (CPO)</label>
                                <input type="number" step="any" name="tarif_angkut_cpo" id="tarifAngkutCPO"
                                    value="{{ old('tarif_angkut_cpo', $pembelian->tarif_angkut_cpo) }}"
                                    class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-indigo-200"
                                    required>
                            </div>
                            <div class="w-full md:w-1/2">
                                <label class="block text-sm font-medium text-gray-700">Tarif Angkut (PK)</label>
                                <input type="number" step="any" name="tarif_angkut_pk" id="tarifAngkutPK"
                                    value="{{ old('tarif_angkut_pk', $pembelian->tarif_angkut_pk) }}"
                                    class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-indigo-200"
                                    required>
                            </div>
                        </div>

                        <div class="flex flex-col md:flex-row gap-6">
                            <div class="w-full md:w-1/2">
                                <label class="block text-sm font-medium text-gray-700">Pendapatan CPO</label>
                                <input type="number" step="any" name="pendapatan_cpo" id="pendapatanCPO"
                                    value="{{ old('pendapatan_cpo', $pembelian->pendapatan_cpo) }}" readonly
                                    class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-100">
                            </div>
                            <div class="w-full md:w-1/2">
                                <label class="block text-sm font-medium text-gray-700">Pendapatan PK</label>
                                <input type="number" step="any" name="pendapatan_pk" id="pendapatanPK"
                                    value="{{ old('pendapatan_pk', $pembelian->pendapatan_pk) }}" readonly
                                    class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-100">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Total Pendapatan</label>
                            <input type="number" step="any" name="total_pendapatan" id="totalPendapatan"
                                value="{{ old('total_pendapatan', $pembelian->total_pendapatan) }}" readonly
                                class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-100">
                        </div>

                        <div class="flex flex-col md:flex-row gap-6">
                            <div class="w-full md:w-1/2">
                                <label class="block text-sm font-medium text-gray-700">Biaya Produksi</label>
                                <input type="number" step="any" name="biaya_produksi" id="biayaProduksi"
                                    value="{{ old('biaya_produksi', $pembelian->biaya_produksi) }}" readonly
                                    class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-100">

                            </div>
                            <div class="w-full md:w-1/2">
                                <label class="block text-sm font-medium text-gray-700">Biaya Angkut</label>
                                <input type="number" step="any" name="biaya_angkut_jual" id="biayaAngkut"
                                    value="{{ old('biaya_angkut_jual', $pembelian->biaya_angkut_jual) }}"
                                    class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-indigo-200"
                                    required>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Total Biaya</label>
                            <input type="number" step="any" name="total_biaya" id="totalBiaya"
                                value="{{ old('total_biaya', $pembelian->total_biaya) }}" readonly
                                class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-100">
                        </div>

                        <div class="flex flex-col md:flex-row gap-6">
                            <div class="w-full md:w-1/2">
                                <label class="block text-sm font-medium text-gray-700">Harga Penetapan</label>
                                <input type="number" step="any" name="harga_penetapan" id="hargaPenetapan"
                                    value="{{ old('harga_penetapan', $pembelian->harga_penetapan) }}" readonly
                                    class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-100">
                            </div>
                            <div class="w-full md:w-1/2">
                                <label class="block text-sm font-medium text-gray-700">Harga Ekskalasi</label>
                                <input type="number" step="any" name="harga_escalasi" id="hargaEskalasi"
                                    value="{{ old('harga_escalasi', $pembelian->harga_escalasi) }}"
                                    class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-indigo-200"
                                    required>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Margin</label>
                            <input type="number" step="any" name="margin" id="margin"
                                value="{{ old('margin', $pembelian->margin) }}" readonly
                                class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-100">
                        </div>
                        <div class="flex justify-between items-center pt-6">
                            <a href="{{ request('back') ?? url()->previous() }}"
                                class="flex items-center gap-1 text-sm px-4 py-2 bg-gray-900 text-white rounded hover:bg-gray-800">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z" />
                                </svg>
                                Kembali
                            </a>
                            <button type="submit"
                                class="flex items-center gap-1 text-sm px-4 py-2 bg-gray-900 text-white rounded hover:bg-gray-800">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M5 19h14v2H5c-1.103 0-2-.897-2-2V7h2v12zM20.707 7.293l-1-1a1 1 0 00-1.414 0L10 14.586V17h2.414l8.293-8.293a1 1 0 000-1.414z" />
                                </svg>
                                Edit
                            </button>
                        </div>
                    </div>
                </form>
            </div>
    @endsection
        <script src="{{ asset('js/buyedit.js') }}"></script>
</body>

</html>