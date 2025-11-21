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
    <link rel="stylesheet" href="{{ asset('css/buysee.css') }}">
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
                <div class="max-w-full mx-auto overflow-x-auto">
                    <table class="w-full text-xs md:text-sm text-left text-gray-700">
                        <thead class="bg-gray-50 text-gray-600 uppercase">
                            <tr>
                                <th rowspan="2" class="px-3 py-2 border-b align-middle">NO</th>
                                <th rowspan="2" class="px-3 py-2 border-b align-middle">PKS</th>
                                <th rowspan="2" class="px-3 py-2 border-b align-middle">GRADE</th>
                                <th colspan="2" class="px-3 py-2 border-b text-center">HARGA</th>
                                <th colspan="2" class="px-3 py-2 border-b text-center">RENDEMEN</th>
                                <th rowspan="2" class="px-3 py-2 border-b align-middle">HARGA BEP</th>
                                <th colspan="4" class="px-3 py-2 border-b text-center">HARGA</th>
                                <th rowspan="2" class="px-3 py-2 border-b align-middle">ESKALASI</th>
                                <th rowspan="2" class="px-3 py-2 border-b align-middle">AKSI</th>
                            </tr>
                            <tr>
                                <th class="px-3 py-2 border-b">CPO</th>
                                <th class="px-3 py-2 border-b">PK</th>
                                <th class="px-3 py-2 border-b">CPO</th>
                                <th class="px-3 py-2 border-b">PK</th>
                                <th class="px-3 py-2 border-b">HARGA SAAT INI</th>
                                <th class="px-3 py-2 border-b">HARGA KEMARIN</th>
                                <th class="px-3 py-2 border-b">SELISIH</th>
                                <th class="px-3 py-2 border-b">HARGA PESAING</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($items as $idx => $pembelian)
                                <tr>
                                    <td class="px-3 py-2 border-b text-center">{{ $idx + 1 }}</td>
                                    <td class="px-3 py-2 border-b">{{ $pembelian->nama_pks ?? '-' }}</td>
                                    <td class="px-3 py-2 border-b">{{ $pembelian->grade ?? '-' }}</td>
                                    <td class="px-3 py-2 border-b">{{ $pembelian->harga_cpo_penetapan ?? '-' }}</td>
                                    <td class="px-3 py-2 border-b">{{ $pembelian->harga_pk ?? '-' }}</td>
                                    <td class="px-3 py-2 border-b">{{ $pembelian->rendemen_cpo ?? '-' }}</td>
                                    <td class="px-3 py-2 border-b">{{ $pembelian->rendemen_pk ?? '-' }}</td>
                                    <td class="px-3 py-2 border-b">{{ $pembelian->harga_bep ?? '-' }}</td>
                                    <td class="px-3 py-2 border-b">{{ $pembelian->harga_penetapan ?? '-' }}</td>
                                    <td class="px-3 py-2 border-b">{{ $pembelian->harga_kemarin ?? '-' }}</td>
                                    <td class="px-3 py-2 border-b">{{ $pembelian->selisih ?? '-' }}</td>
                                    <td class="px-3 py-2 border-b">{{ $pembelian->harga_pesaing ?? '-' }}</td>
                                    <td class="px-3 py-2 border-b">{{ $pembelian->eskalasi ?? '-' }}</td>
                                    <td class="text-center px-3 py-2 border-b">
                                        <div class="flex justify-center items-center gap-1">
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
                                                    class="detailForm flex items-center gap-1 text-xs px-3 py-1 bg-gray-900 text-white rounded hover:bg-gray-800 transition-all">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                        fill="currentColor" viewBox="0 0 24 24">
                                                        <path
                                                            d="M12 5c-7.633 0-11 7-11 7s3.367 7 11 7 11-7 11-7-3.367-7-11-7zm0 12c-2.761 0-5-2.239-5-5s2.239-5 5-5 5 2.239 5 5-2.239 5-5 5zm0-8a3 3 0 100 6 3 3 0 000-6z" />
                                                    </svg>
                                                    Detail
                                                </a>
                                                <a href="{{ route('pembelian.edit', ['id' => $pembelian->id, 'back' => request()->fullUrl()]) }}"
                                                    class="flex items-center gap-1 text-xs px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition-all">
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
                                                    <button type="button"
                                                        class="delete-btn flex items-center gap-1 px-3 py-1 text-xs bg-red-600 text-white rounded hover:bg-red-700 transition-all">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                            fill="currentColor" viewBox="0 0 24 24" class="inline-block">
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
                                    <td colspan="14" class="px-4 py-3 text-center text-gray-500">
                                        Tidak ada data pembelian pada tanggal ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="flex justify-end pt-4 border-t mt-4">
                    <div class="pt-6">
                        <a id="backForm" href="{{ route('buy') }}"
                            class="flex items-center gap-1 text-sm px-4 py-2 bg-gray-900 text-white rounded hover:bg-gray-800 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z" />
                            </svg>
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/buysee.js') }}"></script>

</body>

</html>