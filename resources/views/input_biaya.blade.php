<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Kalkulator Harga - Input Biaya - PTPN4</title>
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
                                <a id="greeting" class="hover:text-gray-700"
                                    data-username="{{ Auth::user()->username }}"></a>
                            </li>
                            <li>
                                <span class="mx-2 text-gray-400">/</span>
                            </li>
                        </ol>
                        <h6 class="text-lg font-semibold text-gray-800 mt-1">
                            {{ Auth::user()->level }} -
                            {{ Auth::user()->unit->nama_unit ?? Auth::user()->kode_unit }}
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
            <div class="px-4 py-5 mb-6 bg-white shadow rounded-lg">
                <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-5">
                    <div class="w-full md:w-1/2">
                        <label for="pks" class="block mb-1 text-sm font-medium text-gray-700">Pilih PKS</label>
                        <select id="pks" name="pks"
                            class="block w-full rounded-lg border-gray-300 text-sm focus:ring-gray-900 focus:border-gray-900">
                            <option value="" disabled selected>-- Pilih PKS --</option>
                            {{-- opsi PKS akan diisi dari controller --}}
                        </select>
                        <p class="mt-1 text-xs text-gray-500">Bisa dipilih sesuai PKS tujuan.</p>
                    </div>

                    <div class="w-full md:w-1/3">
                        <label for="periode" class="block mb-1 text-sm font-medium text-gray-700">Filter Bulan</label>
                        <input type="month" id="periode" name="periode"
                            class="block w-full rounded-lg border-gray-300 text-sm focus:ring-gray-900 focus:border-gray-900" />
                        <p class="mt-1 text-xs text-gray-500">Pilih bulan biaya berlaku.</p>
                    </div>

                    <div class="w-full md:w-1/4 flex items-center md:justify-end">
                        <div
                            class="text-xs md:text-sm text-gray-500 bg-gray-50 border border-dashed border-gray-300 rounded-lg px-3 py-2 w-full">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex h-2 w-2 rounded-full bg-red-500"></span>
                                <span>Belum ada data biaya tersimpan.</span>
                            </div>
                            <p class="mt-1">Jika sudah diinput, blok ini akan berubah menjadi biru dan menampilkan informasi
                                terakhir diupdate.</p>
                        </div>
                    </div>
                </div>

                <form id="formBiaya" method="POST" action="#" class="space-y-4">
                    @csrf
                    <h2 class="text-base font-semibold text-gray-800">Biaya yang diinput</h2>

                    <div class="grid gap-4 md:grid-cols-3">
                        <div>
                            <label for="biaya_olah" class="block mb-1 text-sm font-medium text-gray-700">1. Biaya Olah
                                (Rp/kg)</label>
                            <input type="number" step="0.01" id="biaya_olah" name="biaya_olah" placeholder="0"
                                class="block w-full rounded-lg border-gray-300 text-sm focus:ring-gray-900 focus:border-gray-900" />
                        </div>

                        <div>
                            <label for="tarif_angkut_cpo" class="block mb-1 text-sm font-medium text-gray-700">2. Tarif
                                Angkut CPO (Rp/kg)</label>
                            <input type="number" step="0.01" id="tarif_angkut_cpo" name="tarif_angkut_cpo" placeholder="0"
                                class="block w-full rounded-lg border-gray-300 text-sm focus:ring-gray-900 focus:border-gray-900" />
                        </div>

                        <div>
                            <label for="tarif_angkut_pk" class="block mb-1 text-sm font-medium text-gray-700">3. Tarif
                                Angkut PK (Rp/kg)</label>
                            <input type="number" step="0.01" id="tarif_angkut_pk" name="tarif_angkut_pk" placeholder="0"
                                class="block w-full rounded-lg border-gray-300 text-sm focus:ring-gray-900 focus:border-gray-900" />
                        </div>
                    </div>

                    <div
                        class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 pt-4 border-t border-gray-100 mt-4">
                        <p class="text-xs text-gray-500">Input biaya hanya dapat dilakukan oleh <span
                                class="font-semibold">User Admin</span>.</p>
                        <div class="flex items-center gap-3">
                            <div class="text-xs text-gray-500 flex items-center gap-1">
                                <span class="inline-flex h-2 w-2 rounded-full bg-blue-500"></span>
                                <span>Menandakan biaya sudah diinput.</span>
                            </div>
                            <button type="submit"
                                class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-medium text-white bg-gray-900 rounded hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900">
                                SIMPAN
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <footer class="footer p-5 bg-gray-50">
                <div class="text-center text-muted text-m">
                    Copyright &copy;
                    <script>document.write(new Date().getFullYear())</script>
                    PT. Perkebunan Nusantara IV
                </div>
            </footer>
        </div>
    @endsection
    <script src="{{ asset('js/dashboard.js') }}"></script>
</body>

</html>