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
                                <a id="greeting" class="hover:text-gray-700"
                                    data-username="{{ Auth::user()->username }}"></a>
                            </li>
                            <li><span class="mx-2 text-gray-400">/</span></li>
                        </ol>
                        <h6 class="text-lg font-semibold text-gray-800 mt-1">
                            {{ Auth::user()->level }} - {{ Auth::user()->unit->nama_unit ?? Auth::user()->kode_unit }}
                        </h6>
                    </div>
                    <div class="flex items-center gap-6">
                        <button id="openSidebar" class="md:hidden text-gray-700 hover:text-black">
                            <i data-lucide="menu"></i>
                        </button>
                        <a id="logoutFormSubmit" href="{{ route('logout') }}"
                            class="flex items-center gap-1 text-sm px-4 py-2 bg-gray-900 text-white rounded hover:bg-gray-800">
                            Keluar
                        </a>
                    </div>
                </nav>
            </div>
            @php
                use Carbon\Carbon;
                $tanggalSemalam = request('tanggal') ?? Carbon::yesterday()->toDateString();
            @endphp
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-start border-b pb-4 mb-4">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800">
                            Pembelian - {{ Carbon::parse($tanggalSemalam)->translatedFormat('d F Y') }}
                        </h2>
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
                        <input type="date" id="searchDate" name="tanggal" value="{{ $tanggalSemalam }}"
                            class="w-full pl-4 pr-10 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    </div>
                </div>
                <div class="max-w-5xl mx-auto overflow-x-auto">
                    <table class="w-full min-w-[800px] divide-y divide-gray-200 text-sm table-auto">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold">Unit</th>
                                <th class="px-4 py-3 text-center font-semibold">Status</th>
                                <th class="px-4 py-3 text-center font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($items as $pembelian)
                                @php
                                    $unit = $pembelian->unit;
                                    $unitKode = $unit->kode_unit ?? null;
                                    $pembeliansPerUnit = \App\Models\Pembelian::where('kode_unit', $unitKode)
                                        ->whereDate('tanggal', $pembelian->tanggal)
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
                                <tr class="transition-all duration-300 hover:bg-gray-50">
                                    <td class="px-4 py-3">
                                        {{ $unit && $unit->jenis !== 'Kantor Regional' ? $unit->nama_unit : '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="text-xs px-2 py-1 rounded-full font-medium {{ $badgeClass }}">
                                            @php
                                                $statusGabungan = $status;
                                                // Gabungkan status waktu jika sudah diapprove
                                                if(isset($pembelian->status_approval_waktu)) {
                                                    // Ambil level yang diapprove
                                                    $approvedLevel = null;
                                                    if(strpos($status, 'Diapprove') !== false) {
                                                        $approvedLevel = trim(str_replace('Diapprove', '', $status));
                                                    }
                                                    if($approvedLevel && isset($pembelian->status_approval_waktu[$approvedLevel])) {
                                                        $statusGabungan = $status . ' - ' . $pembelian->status_approval_waktu[$approvedLevel];
                                                    }
                                                }
                                            @endphp
                                            {{ $statusGabungan }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="flex justify-center items-center gap-2">
                                            @if ($unit && $pembelian->tanggal)
                                                <a href="{{ route('pembelian.lihat.perunit', ['unit' => $unit->kode_unit, 'tanggal' => $pembelian->tanggal]) }}"
                                                    class="flex items-center gap-1 text-xs px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                        fill="currentColor" viewBox="0 0 24 24">
                                                        <path
                                                            d="M12 5c-7.633 0-11 7-11 7s3.367 7 11 7 11-7 11-7-3.367-7-11-7zm0 12c-2.761 0-5-2.239-5-5s2.239-5 5-5 5 2.239 5 5-2.239 5-5 5zm0-8a3 3 0 100 6 3 3 0 000-6z" />
                                                    </svg>
                                                    Lihat
                                                </a>
                                            @else
                                                <span class="text-xs text-gray-400"></span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center px-4 py-4 text-gray-500">
                                        Tidak ada data untuk tanggal ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="flex justify-end pt-4 border-t mt-4"></div>
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
    <script src="{{ asset('js/buyadmin.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>