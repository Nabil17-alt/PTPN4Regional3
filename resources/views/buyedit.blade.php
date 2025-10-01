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
                                {{ Auth::user()->username }}
                            </li>
                        </ol>
                        <h6 class="text-lg font-semibold text-gray-800 mt-1">
                            {{ Auth::user()->level }} - {{ Auth::user()->unit->nama_unit ?? Auth::user()->kode_unit }}
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
                                <label class="block text-sm font-medium text-gray-700">Unit Kerja</label>
                                @php
                                    $user = auth()->user();
                                @endphp
                                @if ($user->level === 'Admin' || $user->level === 'General_Manager' || $user->level === 'Region_Head')
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
                                <div class="flex items-center">
                                    <input type="number" step="any" name="harga_cpo"
                                        value="{{ old('harga_cpo', $pembelian->harga_cpo) }}"
                                        class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-indigo-200"
                                        @if(Auth::user()->level !== 'Admin') readonly @endif required>
                                    <span class="ml-2 text-gray-700 font-semibold">%</span>
                                </div>
                            </div>
                            <div class="w-full md:w-1/2">
                                <label class="block text-sm font-medium text-gray-700">Harga PK</label>
                                <div class="flex items-center">
                                    <input type="number" step="any" name="harga_pk"
                                        value="{{ old('harga_pk', $pembelian->harga_pk) }}"
                                        class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-indigo-200"
                                        @if(Auth::user()->level !== 'Admin') readonly @endif required>
                                    <span class="ml-2 text-gray-700 font-semibold">%</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col md:flex-row gap-6">
                            <div class="w-full md:w-1/2">
                                <label class="block text-sm font-medium text-gray-700">Rendemen CPO</label>
                                <input type="number" step="any" name="rendemen_cpo"
                                    value="{{ old('rendemen_cpo', $pembelian->rendemen_cpo) }}"
                                    class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-indigo-200"
                                    required>
                            </div>
                            <div class="w-full md:w-1/2">
                                <label class="block text-sm font-medium text-gray-700">Rendemen PK</label>
                                <input type="number" step="any" name="rendemen_pk"
                                    value="{{ old('rendemen_pk', $pembelian->rendemen_pk) }}"
                                    class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-indigo-200"
                                    required>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Total Rendemen</label>
                            <input type="number" step="any" name="total_rendemen"
                                value="{{ old('total_rendemen', $pembelian->total_rendemen) }}"
                                class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-indigo-200">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Biaya Olah</label>
                            <input type="number" step="any" name="biaya_olah"
                                value="{{ old('biaya_olah', $pembelian->biaya_olah) }}"
                                class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-indigo-200"
                                required>
                        </div>
                        <div class="flex flex-col md:flex-row gap-6">
                            <div class="w-full md:w-1/2">
                                <label class="block text-sm font-medium text-gray-700">Tarif Angkut (CPO)</label>
                                <input type="number" step="any" name="tarif_angkut_cpo"
                                    value="{{ old('tarif_angkut_cpo', $pembelian->tarif_angkut_cpo) }}"
                                    class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-indigo-200"
                                    required>
                            </div>
                            <div class="w-full md:w-1/2">
                                <label class="block text-sm font-medium text-gray-700">Tarif Angkut (PK)</label>
                                <input type="number" step="any" name="tarif_angkut_pk"
                                    value="{{ old('tarif_angkut_pk', $pembelian->tarif_angkut_pk) }}"
                                    class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-indigo-200"
                                    required>
                            </div>
                        </div>
                        <div class="flex flex-col md:flex-row gap-6">
                            <div class="w-full md:w-1/2">
                                <label class="block text-sm font-medium text-gray-700">Pendapatan CPO</label>
                                <input type="number" step="any" name="pendapatan_cpo"
                                    value="{{ old('pendapatan_cpo', $pembelian->pendapatan_cpo) }}"
                                    class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-indigo-200">
                            </div>
                            <div class="w-full md:w-1/2">
                                <label class="block text-sm font-medium text-gray-700">Pendapatan PK</label>
                                <input type="number" step="any" name="pendapatan_pk"
                                    value="{{ old('pendapatan_pk', $pembelian->pendapatan_pk) }}"
                                    class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-indigo-200">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Total Pendapatan</label>
                            <input type="number" step="any" name="total_pendapatan"
                                value="{{ old('total_pendapatan', $pembelian->total_pendapatan) }}"
                                class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-indigo-200">
                        </div>
                        <div class="flex flex-col md:flex-row gap-6">
                            <div class="w-full md:w-1/2">
                                <label class="block text-sm font-medium text-gray-700">Biaya Produksi</label>
                                <input type="number" step="any" name="biaya_produksi"
                                    value="{{ old('biaya_produksi', $pembelian->biaya_produksi) }}"
                                    class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-indigo-200">
                            </div>
                            <div class="w-full md:w-1/2">
                                <label class="block text-sm font-medium text-gray-700">Biaya Angkut</label>
                                <input type="number" step="any" name="biaya_angkut_jual"
                                    value="{{ old('biaya_angkut_jual', $pembelian->biaya_angkut_jual) }}"
                                    class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-indigo-200"
                                    required>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Total Biaya</label>
                            <input type="number" step="any" name="total_biaya"
                                value="{{ old('total_biaya', $pembelian->total_biaya) }}"
                                class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-indigo-200">
                        </div>
                        <div class="flex flex-col md:flex-row gap-6">
                            <div class="w-full md:w-1/2">
                                <label class="block text-sm font-medium text-gray-700">Harga Penetapan</label>
                                <input type="number" step="any" name="harga_penetapan"
                                    value="{{ old('harga_penetapan', $pembelian->harga_penetapan) }}"
                                    class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-indigo-200">
                            </div>
                            <div class="w-full md:w-1/2">
                                <label class="block text-sm font-medium text-gray-700">Harga Eskalasi</label>
                                <input type="number" step="any" name="harga_escalasi"
                                    value="{{ old('harga_escalasi', $pembelian->harga_escalasi) }}"
                                    class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-indigo-200"
                                    required>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Margin Ekskalasi</label>
                            <input type="number" step="any" name="margin" value="{{ old('margin', $pembelian->margin) }}"
                                class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring focus:ring-indigo-200">
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
    @endsection
    <script src="{{ asset('js/buyedit.js') }}"></script>
</body>

</html>