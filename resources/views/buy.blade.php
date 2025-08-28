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
                                <a id="greeting" class="hover:text-gray-700"
                                    data-username="{{ Auth::user()->username }}"></a>
                            </li>
                            <li>
                                <span class="mx-2 text-gray-400">/</span>
                            </li>
                        </ol>
                        <h6 class="text-xl font-semibold text-gray-800 mt-1">
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
                        <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 7V3M16 7V3M3 11h18M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    @php
                        $groupedPembelians = $pembelians->groupBy(function ($item) {
                            return \Carbon\Carbon::parse($item->tanggal)->format('Y-m-d');
                        })->sortKeysDesc();
                    @endphp
                    <table class="w-full min-w-[800px] divide-y divide-gray-200 text-sm table-auto">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold">Tanggal</th>
                                <th class="px-4 py-3 text-center font-semibold">Status</th>
                                <th class="px-4 py-3 text-center font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($groupedPembelians as $tanggal => $items)
                                @php
                                    $approvedLevels = $items->map(function ($item) {
                                        if ($item->status_approval_rh)
                                            return 'Region Head';
                                        if ($item->status_approval_gm)
                                            return 'General Manager';
                                        if ($item->status_approval_admin)
                                            return 'Admin';
                                        if ($item->status_approval_manager)
                                            return 'Manager';
                                        return null;
                                    })->filter();
                                    $jumlahApproval = $approvedLevels->count();
                                    $totalItems = $items->count();
                                    $statusText = '';
                                    if ($totalItems === 0) {
                                        $statusText = 'Belum Diinput';
                                    } elseif ($jumlahApproval === 0) {
                                        $statusText = 'Sudah Diinput';
                                    } else {
                                        $uniqueLevels = $approvedLevels->unique();
                                        if ($uniqueLevels->count() === 1) {
                                            $statusText = "$jumlahApproval Diapprove " . $uniqueLevels->first();
                                        } else {
                                            $statusText = "$jumlahApproval Diapprove";
                                        }
                                    }
                                    $badgeColors = [
                                        'Belum Diinput' => 'bg-red-100 text-red-700',
                                        'Sudah Diinput' => 'bg-blue-100 text-blue-700',
                                    ];
                                    $badgeClass = collect($badgeColors)->filter(fn($v, $k) => str($statusText)->contains($k))->first()
                                        ?? 'bg-green-100 text-green-700';
                                @endphp
                                <tr class="transition-all duration-300 hover:bg-gray-50">
                                    <td class="px-4 py-3 text-gray-800 font-medium">
                                        {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="text-xs px-2 py-1 rounded-full font-medium {{ $badgeClass }}">
                                            {{ $statusText }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="flex justify-center items-center gap-2">
                                            <a href="{{ route('pembelian.lihat.tanggal', ['tanggal' => $tanggal]) }}"
                                                class="flex items-center gap-1 text-xs px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                    fill="currentColor" viewBox="0 0 24 24">
                                                    <path
                                                        d="M12 5c-7.633 0-11 7-11 7s3.367 7 11 7 11-7 11-7-3.367-7-11-7zm0 12c-2.761 0-5-2.239-5-5s2.239-5 5-5 5 2.239 5 5-2.239 5-5 5zm0-8a3 3 0 100 6 3 3 0 000-6z" />
                                                </svg>
                                                Lihat
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center px-4 py-4 text-gray-500">
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
    <script src="{{ asset('js/buy.js') }}"></script>
</body>

</html>