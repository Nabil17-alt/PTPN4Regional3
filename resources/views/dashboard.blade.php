<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Beranda - PTPN4</title>
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
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-2xl shadow p-6">
                    <h2 class="text-sm font-medium text-gray-500">Total Pembelian</h2>
                    <p class="mt-2 text-2xl font-bold text-indigo-600">
                        {{ number_format($totalPembelian, 0, ',', '.') }}
                    </p>
                </div>
                <div class="bg-white rounded-2xl shadow p-6">
                    <h2 class="text-sm font-medium text-gray-500">Rata-rata Margin Ekskalasi</h2>
                    <p class="mt-2 text-2xl font-bold {{ $rataRataMargin < 0 ? 'text-red-600' : 'text-green-600' }}">
                        {{ number_format($rataRataMargin, 2, ',', '.') }}
                    </p>
                </div>
                <div class="bg-white rounded-2xl shadow p-6">
                    <h2 class="text-sm font-medium text-gray-500">Rata-rata Total Biaya</h2>
                    <p class="mt-2 text-2xl font-bold text-green-600">
                        {{ number_format($rataRataBiaya, 2, ',', '.') }}
                    </p>
                </div>
            </div>
            <div class="bg-white rounded-2xl shadow p-6 mb-8">
                <h2 class="text-lg font-semibold text-gray-700 mb-4">Status Approval - Hari Ini</h2>
                <div class="w-full overflow-x-auto">
                    <table class="w-full min-w-[900px] divide-y divide-gray-200 text-sm table-auto">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold">Unit</th>
                                <th class="px-4 py-3 text-left font-semibold">Grade</th>
                                <th class="px-4 py-3 text-left font-semibold">Harga Penetapan</th>
                                <th class="px-4 py-3 text-left font-semibold">Harga Ekskalasi</th>
                                <th class="px-4 py-3 text-left font-semibold">Margin Ekskalasi</th>
                                <th class="px-4 py-3 text-center font-semibold">Approval</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($pembelianHariIni as $p)
                                <tr class="transition-all duration-300 hover:bg-gray-50">
                                    <td class="px-4 py-3">{{ $p->nama_unit ?? $p->kode_unit }}</td>
                                    <td class="px-4 py-3">{{ $p->grade }}</td>
                                    <td class="px-4 py-3">{{ number_format($p->harga_penetapan, 2, ',', '.') }}</td>
                                    <td class="px-4 py-3">{{ number_format($p->harga_escalasi, 0, ',', '.') }}</td>
                                    <td
                                        class="px-4 py-3 
                                                                {{ $p->margin < 0 ? 'text-red-600 font-semibold' : 'text-green-600 font-semibold' }}">
                                        {{ number_format($p->margin, 2, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        @php
                                            $unitKode = $p->kode_unit ?? null;
                                            $pembeliansPerUnit = \App\Models\Pembelian::where('kode_unit', $unitKode)
                                                ->whereDate('tanggal', $p->tanggal)
                                                ->get();
                                            if ($pembeliansPerUnit->isEmpty()) {
                                                $status = 'Belum Diinput';
                                                $badgeClass = 'bg-red-100 text-red-700';
                                            } else {
                                                $levelOrder = [
                                                    'Manager' => 1,
                                                    'Admin' => 2,
                                                    'General Manager' => 3,
                                                    'Region Head' => 4,
                                                ];
                                                $approvedLevels = $pembeliansPerUnit->map(function ($item) {
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
                                                if ($approvedLevels->isEmpty()) {
                                                    $status = 'Sudah Diinput';
                                                    $badgeClass = 'bg-blue-100 text-blue-700';
                                                } else {
                                                    $latestApproval = $approvedLevels->sortBy(fn($lvl) => $levelOrder[$lvl])->last();
                                                    $status = "Diapprove {$latestApproval}";
                                                    $badgeClass = 'bg-green-100 text-green-700';
                                                }
                                            }
                                        @endphp
                                        <span class="text-xs px-2 py-1 rounded-full font-medium {{ $badgeClass }}">
                                            {{ $status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-4 text-center text-gray-500">
                                        Tidak ada data pembelian hari ini
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
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