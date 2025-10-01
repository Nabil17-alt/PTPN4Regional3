wa
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
    <link rel="stylesheet" href="{{ asset('css/buyseeunit.css') }}">
</head>

<body>
    <div id="topLoader"></div>
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
            @if (session('success') || session('error'))
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        @if (session('success'))
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
                        @endif
                            @if (session('error'))
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 5000,
                                    timerProgressBar: true,
                                });
                                Toast.fire({
                                    icon: 'error',
                                    text: {!! json_encode(session('error')) !!}
                                });
                            @endif
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
                            <li>
                                <span class="mx-2 text-gray-400">/</span>
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
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800">Pembelian - Lihat Pembelian</h2>
                    </div>
                </div>
                <div class="flex justify-end items-center mb-4">
                </div>
                <div class="max-w-5xl mx-auto overflow-x-auto">
                    <table class="w-full text-sm text-left divide-y divide-gray-200 table-auto">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="px-4 py-3 font-semibold">Grade</th>
                                <th class="px-4 py-3 font-semibold">Harga Penetapan</th>
                                <th class="px-4 py-3 font-semibold">Harga Ekskalasi</th>
                                <th class="px-4 py-3 font-semibold">Margin Ekskalasi</th>
                                <th class="px-4 py-3 text-center font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($pembelians as $pembelian)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-3">{{ $pembelian->grade }}</td>
                                    <td class="px-4 py-3">{{ $pembelian->harga_penetapan}}</td>
                                    <td class="px-4 py-3">{{ $pembelian->harga_escalasi}}</td>
                                    <td class="px-4 py-3">
                                        <span class="{{ $pembelian->margin < 0 ? 'text-red-600' : 'text-green-600' }}">
                                            {{ number_format($pembelian->margin, 2, ',', '.') }}%
                                        </span>
                                    </td>
                                    @php
                                        $levelOrder = [
                                            'Manager' => 1,
                                            'Admin' => 2,
                                            'General_Manager' => 3,
                                            'Region_Head' => 4,
                                        ];
                                        $userLevel = Auth::user()->level;
                                        $userOrder = $levelOrder[$userLevel] ?? 0;
                                        $highestApproval = 0;
                                        if ($pembelian->status_approval_rh) {
                                            $highestApproval = $levelOrder['Region_Head'];
                                        } elseif ($pembelian->status_approval_gm) {
                                            $highestApproval = $levelOrder['General_Manager'];
                                        } elseif ($pembelian->status_approval_admin) {
                                            $highestApproval = $levelOrder['Admin'];
                                        } elseif ($pembelian->status_approval_manager) {
                                            $highestApproval = $levelOrder['Manager'];
                                        }
                                        $canEdit = $userOrder > 0 && $userOrder > $highestApproval;
                                    @endphp
                                    <td class="px-4 py-3 text-center">
                                        <div class="flex justify-center items-center gap-2">
                                            @php
                                                $currentUserLevel = Auth::user()->level;
                                                $showButtons = false;

                                                // Jika RH sudah approve, tombol tersedia untuk semua level
                                                if ($pembelian->status_approval_rh) {
                                                    $showButtons = true;
                                                } else {
                                                    // Logika bertahap: tombol hilang setelah level user di-approve
                                                    switch ($currentUserLevel) {
                                                        case 'Asisten':
                                                        case 'Manager':
                                                            // Tombol hilang jika Manager sudah approve
                                                            $showButtons = !$pembelian->status_approval_manager;
                                                            break;
                                                        case 'Admin':
                                                            // Tombol hilang jika Admin sudah approve
                                                            $showButtons = !$pembelian->status_approval_admin;
                                                            break;
                                                        case 'General_Manager':
                                                            // Tombol hilang jika GM sudah approve
                                                            $showButtons = !$pembelian->status_approval_gm;
                                                            break;
                                                        case 'Region_Head':
                                                            // Tombol hilang jika RH sudah approve
                                                            $showButtons = !$pembelian->status_approval_rh;
                                                            break;
                                                        default:
                                                            $showButtons = false;
                                                            break;
                                                    }
                                                }
                                            @endphp

                                            @if ($showButtons)
                                                <a href="{{ route('buy.detail', ['id' => $pembelian->id, 'back' => request()->fullUrl()]) }}"
                                                    class="flex items-center gap-1 text-xs px-3 py-1 bg-gray-800 text-white rounded hover:bg-gray-700 transition">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                        fill="currentColor" viewBox="0 0 24 24">
                                                        <path
                                                            d="M12 5c-7.633 0-11 7-11 7s3.367 7 11 7 11-7 11-7-3.367-7-11-7zm0 12c-2.761 0-5-2.239-5-5s2.239-5 5-5 5 2.239 5 5-2.239 5-5 5zm0-8a3 3 0 100 6 3 3 0 000-6z" />
                                                    </svg>
                                                    Detail
                                                </a>
                                                <a href="{{ route('pembelian.edit', ['id' => $pembelian->id, 'back' => request()->fullUrl()]) }}"
                                                    class="flex items-center gap-1 text-xs px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                        fill="currentColor" viewBox="0 0 24 24">
                                                        <path
                                                            d="M5 20h14v2H5c-1.103 0-2-.897-2-2V6h2v14zM20.707 7.293l-1-1a1.001 1.001 0 0 0-1.414 0L10 14.586V17h2.414l8.293-8.293a1 1 0 0 0 0-1.414z" />
                                                    </svg>
                                                    Edit
                                                </a>
                                                <form id="delete-form-{{ $pembelian->id }}"
                                                    action="{{ route('pembelian.destroy', $pembelian->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" onclick="confirmDelete({{ $pembelian->id }})"
                                                        class="flex items-center gap-1 px-3 py-1 text-xs bg-red-600 text-white rounded hover:bg-red-700 transition">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                            fill="currentColor" viewBox="0 0 24 24">
                                                            <path
                                                                d="M9 3v1H4v2h16V4h-5V3H9zm2 4h2v10h-2V7zm-4 0h2v10H7V7zm8 0h2v10h-2V7z" />
                                                        </svg>
                                                        Hapus
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-xs text-gray-400">Sudah diapprove</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-gray-500 py-4">Tidak ada data ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="flex justify-between items-center pt-4 border-t mt-4">
                    <div class="pt-6">
                        <a id="backForm" href="{{ route('buy.admin') }}"
                            class="flex items-center gap-1 text-sm px-4 py-2 bg-gray-900 text-white rounded hover:bg-gray-800 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z" />
                            </svg>
                            Kembali
                        </a>
                    </div>
                    @php
                        $latestApproval = null;
                        foreach ($pembelians as $pembelian) {
                            if ($pembelian->status_approval_rh) {
                                $latestApproval = 'Region_Head';
                            } elseif ($pembelian->status_approval_gm) {
                                $latestApproval = 'General_Manager';
                            } elseif ($pembelian->status_approval_admin) {
                                $latestApproval = 'Admin';
                            } elseif ($pembelian->status_approval_manager) {
                                $latestApproval = 'Manager';
                            }
                        }
                        $levelOrder = [
                            'Manager' => 1,
                            'Admin' => 2,
                            'General_Manager' => 3,
                            'Region_Head' => 4,
                        ];
                        $userLevel = Auth::user()->level;
                        $userOrder = $levelOrder[$userLevel] ?? 0;
                        $approvalOrder = $levelOrder[$latestApproval] ?? 0;
                        $canApprove = $userOrder > 0 && $userOrder == $approvalOrder + 1;
                    @endphp
                    @if (in_array($userLevel, ['Manager', 'Admin', 'General_Manager', 'Region_Head']))
                        @if ($approvalOrder >= $userOrder)
                            <span class="text-sm text-red-600 font-semibold">
                                Telah disetujui oleh {{ str_replace('_', ' ', $latestApproval) }}, anda tidak dapat melakukan
                                approval.
                            </span>
                        @else
                            <form method="POST" action="{{ route('pembelian.approvePerUnit', ['unit' => $unitCode]) }}">
                                @csrf
                                <button type="submit" id="approveBtnUnit"
                                    class="flex items-center gap-1 text-sm px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z" />
                                    </svg>
                                    Approve
                                </button>
                            </form>
                        @endif
                    @endif
                </div>
            </div>
            @if(auth()->check() && auth()->user()->level === 'Admin')
                <div class="bg-white rounded-lg shadow-md p-6 mt-6">
                    <div class="flex justify-between items-start border-b pb-4 mb-4">
                        <h2 class="text-xl font-semibold text-gray-800">
                            Riwayat Perubahan ({{ $pembelians->count() }} Data)
                        </h2>
                    </div>
                    <div class="max-w-5xl mx-auto overflow-x-auto">
                        <table class="w-full text-sm text-left divide-y divide-gray-200 table-auto">
                            <thead class="bg-gray-100 text-gray-700">
                                <tr>
                                    <th class="px-4 py-3 font-semibold">Grade</th>
                                    <th class="px-4 py-3 font-semibold text-center">Manager</th>
                                    <th class="px-4 py-3 font-semibold text-center">Admin</th>
                                    <th class="px-4 py-3 font-semibold text-center">General Manager</th>
                                    <th class="px-4 py-3 font-semibold text-center">Region Head</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($pembelians as $pembelian)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-4 py-3 font-semibold">{{ $pembelian->grade }}</td>
                                        <td class="px-4 py-3 text-center">
                                            @php
                                                $managerApproval = $pembelian->approvals->where('role', 'Manager')->first();
                                            @endphp
                                            @if($managerApproval)
                                                <div>Penetapan: {{ number_format($managerApproval->harga_penetapan, 2, '.', '') }}</div>
                                                <div>Ekskalasi: {{ number_format($managerApproval->harga_escalasi, 0, '', '') }}</div>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            @php
                                                $adminApproval = $pembelian->approvals->where('role', 'Admin')->first();
                                            @endphp
                                            @if($adminApproval)
                                                <div>Penetapan: {{ number_format($adminApproval->harga_penetapan, 2, '.', '') }}</div>
                                                <div>Ekskalasi: {{ number_format($adminApproval->harga_escalasi, 0, '', '') }}</div>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            @php
                                                $gmApproval = $pembelian->approvals->where('role', 'General_Manager')->first();
                                            @endphp
                                            @if($gmApproval)
                                                <div>Penetapan: {{ number_format($gmApproval->harga_penetapan, 2, '.', '') }}</div>
                                                <div>Ekskalasi: {{ number_format($gmApproval->harga_escalasi, 0, '', '') }}</div>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            @php
                                                $rhApproval = $pembelian->approvals->where('role', 'Region_Head')->first();
                                            @endphp
                                            @if($rhApproval)
                                                <div>Penetapan: {{ number_format($rhApproval->harga_penetapan, 2, '.', '') }}</div>
                                                <div>Ekskalasi: {{ number_format($rhApproval->harga_escalasi, 0, '', '') }}</div>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-gray-500 py-4">Tidak ada riwayat ditemukan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                    </div>
                </div>
            @endif
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
    <script src="{{ asset('js/buyseeunit.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>