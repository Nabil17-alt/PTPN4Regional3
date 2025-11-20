<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Rekap Laporan - PTPN4</title>
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
                <h1 class="text-base font-semibold text-gray-800 mb-4">Rekap Laporan Penetapan Harga</h1>

                {{-- Filter tanggal & aksi utama --}}
                <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4 mb-6">
                    <div class="flex flex-col md:flex-row gap-4 w-full lg:w-2/3">
                        <div class="w-full md:w-1/3">
                            <label for="tanggal_laporan"
                                class="block mb-1 text-sm font-medium text-gray-700">Tanggal</label>
                            <input type="date" id="tanggal_laporan" name="tanggal_laporan"
                                class="block w-full rounded-lg border-gray-300 text-sm focus:ring-gray-900 focus:border-gray-900" />
                        </div>
                        <div class="flex items-end gap-3 w-full md:w-auto">
                            <button type="button"
                                class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-medium text-white bg-gray-900 rounded hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900">
                                Check
                            </button>
                        </div>
                    </div>

                    <div class="w-full lg:w-1/3 flex flex-col gap-2">
                        <button type="button"
                            class="inline-flex items-center justify-center px-4 py-2.5 text-xs md:text-sm font-medium text-white bg-emerald-600 rounded hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-600">
                            Cetak Rekap Penetapan Harga
                        </button>
                        <p class="text-[11px] text-gray-500">Menggabungkan semua kebun kemitraan yang sudah sampai approval
                            RH (misal untuk QR code approval).</p>
                    </div>
                </div>

                {{-- Rangking laporan per kebun kemitraan --}}
                <div class="mb-6">
                    <h2 class="text-sm font-semibold text-gray-800 mb-2">Rangking Laporan Kebun Kemitraan</h2>
                    <div class="overflow-x-auto border border-gray-200 rounded-lg">
                        <table class="min-w-full text-xs md:text-sm text-left text-gray-700">
                            <thead class="bg-gray-50 text-gray-600 uppercase">
                                <tr>
                                    <th class="px-3 py-2 border-b">Nama Kebun Kemitraan</th>
                                    <th class="px-3 py-2 border-b">Status</th>
                                    <th class="px-3 py-2 border-b">Waktu</th>
                                    <th class="px-3 py-2 border-b">Keterangan</th>
                                    <th class="px-3 py-2 border-b text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="px-3 py-2 border-b">TPU / TME</td>
                                    <td class="px-3 py-2 border-b text-emerald-700">Sudah dapat</td>
                                    <td class="px-3 py-2 border-b text-gray-500">10:23:21</td>
                                    <td class="px-3 py-2 border-b text-gray-500">Tepat waktu</td>
                                    <td class="px-3 py-2 border-b text-center">
                                        <div class="flex flex-wrap justify-center gap-2">
                                            <button type="button"
                                                class="px-3 py-1 text-[11px] font-medium rounded border border-gray-300 text-gray-700 hover:bg-gray-50">
                                                Lihat Laporan
                                            </button>
                                            <button type="button"
                                                class="px-3 py-1 text-[11px] font-medium rounded border border-indigo-300 text-indigo-700 bg-indigo-50 hover:bg-indigo-100">
                                                Lihat Approval
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-3 py-2 border-b">SGO / SPA / SGH</td>
                                    <td class="px-3 py-2 border-b text-emerald-700">Sudah dapat</td>
                                    <td class="px-3 py-2 border-b text-gray-500">10:40:00</td>
                                    <td class="px-3 py-2 border-b text-gray-500">Tepat waktu</td>
                                    <td class="px-3 py-2 border-b text-center">
                                        <div class="flex flex-wrap justify-center gap-2">
                                            <button type="button"
                                                class="px-3 py-1 text-[11px] font-medium rounded border border-gray-300 text-gray-700 hover:bg-gray-50">
                                                Lihat Laporan
                                            </button>
                                            <button type="button"
                                                class="px-3 py-1 text-[11px] font-medium rounded border border-indigo-300 text-indigo-700 bg-indigo-50 hover:bg-indigo-100">
                                                Lihat Approval
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-3 py-2 border-b">SBT / LDA</td>
                                    <td class="px-3 py-2 border-b text-orange-600">Sudah dapat</td>
                                    <td class="px-3 py-2 border-b text-gray-500">11:10:20</td>
                                    <td class="px-3 py-2 border-b text-gray-500">Terlambat</td>
                                    <td class="px-3 py-2 border-b text-center">
                                        <div class="flex flex-wrap justify-center gap-2">
                                            <button type="button"
                                                class="px-3 py-1 text-[11px] font-medium rounded border border-gray-300 text-gray-700 hover:bg-gray-50">
                                                Lihat Laporan
                                            </button>
                                            <button type="button"
                                                class="px-3 py-1 text-[11px] font-medium rounded border border-indigo-300 text-indigo-700 bg-indigo-50 hover:bg-indigo-100">
                                                Lihat Approval
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-3 py-2">STA / SSN / SSI</td>
                                    <td class="px-3 py-2 text-gray-400">Belum dapat</td>
                                    <td class="px-3 py-2 text-gray-400">-</td>
                                    <td class="px-3 py-2 text-gray-400">-</td>
                                    <td class="px-3 py-2 text-center">
                                        <div class="flex flex-wrap justify-center gap-2">
                                            <button type="button"
                                                class="px-3 py-1 text-[11px] font-medium rounded border border-gray-200 text-gray-400 cursor-not-allowed bg-gray-50">
                                                Lihat Laporan
                                            </button>
                                            <button type="button"
                                                class="px-3 py-1 text-[11px] font-medium rounded border border-gray-200 text-gray-400 cursor-not-allowed bg-gray-50">
                                                Lihat Approval
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Catatan penjelasan di bawah tabel --}}
                <div class="text-[11px] text-gray-600 space-y-1">
                    <p><span class="font-semibold">Lihat laporan:</span> semua data yang muncul seperti di menu input
                        kalkulator harga (yang sudah approve RH).</p>
                    <p><span class="font-semibold">Rekap final:</span> semua data yang muncul seperti di menu approval (yang
                        sudah di-approve RH) tetapi hanya per kebun kemitraan masing-masing.</p>
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