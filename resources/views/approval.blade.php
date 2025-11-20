<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Kalkulator Harga - Approval - PTPN4</title>
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
                <h1 class="text-base font-semibold text-gray-800 mb-4">Approval Harga TBS</h1>

                {{-- Tabel rekap seperti di preview rekap --}}
                <div class="mb-6">
                    <h2 class="text-sm font-semibold text-gray-800 mb-2">Rekap Harga per PKS & Grade</h2>
                    <div class="overflow-x-auto border border-gray-200 rounded-lg">
                        <table class="min-w-full text-xs md:text-sm text-left text-gray-700">
                            <thead class="bg-gray-50 text-gray-600 uppercase">
                                <tr>
                                    <th rowspan="2" class="px-3 py-2 border-b align-middle">No</th>
                                    <th rowspan="2" class="px-3 py-2 border-b align-middle">PKS</th>
                                    <th rowspan="2" class="px-3 py-2 border-b align-middle">Grade</th>
                                    <th colspan="2" class="px-3 py-2 border-b text-center">Harga</th>
                                    <th colspan="2" class="px-3 py-2 border-b text-center">Rendemen</th>
                                    <th colspan="4" class="px-3 py-2 border-b text-center">Harga</th>
                                    <th rowspan="2" class="px-3 py-2 border-b align-middle">Eskalasi</th>
                                </tr>
                                <tr>
                                    <th class="px-3 py-2 border-b">CPO</th>
                                    <th class="px-3 py-2 border-b">PK</th>
                                    <th class="px-3 py-2 border-b">CPO</th>
                                    <th class="px-3 py-2 border-b">PK</th>
                                    <th class="px-3 py-2 border-b">Harga BEP</th>
                                    <th class="px-3 py-2 border-b">Harga Saat Ini</th>
                                    <th class="px-3 py-2 border-b">Harga Kemarin</th>
                                    <th class="px-3 py-2 border-b">Selisih</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="px-3 py-2 border-b text-center" colspan="12">Belum ada data ditampilkan.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Approval Manager Kebun Kemitraan --}}
                <div class="mb-6 border-t border-gray-100 pt-4">
                    <h2 class="text-sm font-semibold text-gray-800 mb-3">Approval Manager Kebun Kemitraan</h2>
                    <ol class="list-decimal list-inside text-xs text-gray-700 space-y-1 mb-3">
                        <li>TPU/TME: mencakup harga TBS di 2 PKS (Tanah Putih, Tanjung Medan).</li>
                        <li>SGO/SPA/SGH: mencakup harga TBS di 3 PKS (Sei Garo, Sei Pagar, Sei Galuh).</li>
                        <li>SBT/LDA: mencakup harga TBS di 2 PKS (Sei Buatan, Lubuk Dalam).</li>
                        <li>STA/SSN/SSI: mencakup harga TBS di 3 PKS (Sei Tapung, Sei Intan, Sei Sijenggung).</li>
                    </ol>
                </div>

                <div class="mb-6 border-t border-gray-100 pt-4">
                    <h2 class="text-sm font-semibold text-gray-800 mb-1">Approval GM (Rekap semua PKS)</h2>
                    <p class="text-xs text-gray-500 mb-3">Pilih salah satu: setujui harga atau kembalikan ke Admin dengan
                        keterangan revisi.</p>
                    <div class="flex flex-col md:flex-row gap-4 items-stretch md:items-start">
                        <div class="flex flex-col gap-2 w-full md:w-auto">
                            <button type="button"
                                class="inline-flex items-center justify-center px-4 py-2 text-xs font-medium text-white bg-emerald-600 rounded hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-600">
                                APPROVE
                            </button>
                            <button type="button"
                                class="inline-flex items-center justify-center px-4 py-2 text-xs font-medium text-amber-800 bg-amber-50 border border-amber-300 rounded hover:bg-amber-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-300">
                                Kembali ke Admin
                            </button>
                        </div>
                        <div class="flex-1">
                            <label for="catatan_gm" class="block mb-1 text-xs font-medium text-gray-700">Keterangan (wajib
                                diisi bila memilih "Kembali ke Admin")</label>
                            <textarea id="catatan_gm" name="catatan_gm" rows="2"
                                class="block w-full rounded-lg border-gray-300 text-xs focus:ring-gray-900 focus:border-gray-900"
                                placeholder="Contoh: revisi harga grade FND di PKS TPU, sesuaikan dengan rendemen terbaru..."></textarea>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-100 pt-4">
                    <h2 class="text-sm font-semibold text-gray-800 mb-1">Approval RH (Rekap semua PKS)</h2>
                    <p class="text-xs text-gray-500 mb-3">Pilih salah satu: setujui harga atau kembalikan ke GM dengan
                        catatan.</p>
                    <div class="flex flex-col md:flex-row gap-4 items-stretch md:items-start">
                        <div class="flex flex-col gap-2 w-full md:w-auto">
                            <button type="button"
                                class="inline-flex items-center justify-center px-4 py-2 text-xs font-medium text-white bg-emerald-600 rounded hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-600">
                                APPROVE
                            </button>
                            <button type="button"
                                class="inline-flex items-center justify-center px-4 py-2 text-xs font-medium text-amber-800 bg-amber-50 border border-amber-300 rounded hover:bg-amber-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-300">
                                Kembali ke GM
                            </button>
                        </div>
                        <div class="flex-1">
                            <label for="catatan_fh" class="block mb-1 text-xs font-medium text-gray-700">Keterangan (wajib
                                diisi bila memilih "Kembali ke GM")</label>
                            <textarea id="catatan_fh" name="catatan_fh" rows="2"
                                class="block w-full rounded-lg border-gray-300 text-xs focus:ring-gray-900 focus:border-gray-900"
                                placeholder="Contoh: harga grade FND perlu disesuaikan dengan kebijakan terbaru..."></textarea>
                        </div>
                    </div>
                </div>
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