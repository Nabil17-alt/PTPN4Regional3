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
</head>

<body>
    @extends('layouts.app')

    @section('content')
        <div class="p-4 sm:ml-64 mt-15">
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
                        <input type="text"
                            class="w-full pl-4 pr-10 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Cari Unit..." />
                        <div class="absolute right-3 top-2.5 text-gray-500">
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[800px] divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold">Tanggal</th>
                                <th class="px-4 py-3 text-center font-semibold">Status</th>
                                <th class="px-4 py-3 text-center font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($pembelians as $item)
                                <tr class="transition-all duration-500 hover:bg-gray-50">
                                    <td class="px-4 py-3 text-gray-800 font-medium">
                                        {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d-F-Y') }}
                                    </td>
                                    <td class="text-center px-4 py-3">
                                        @php
                                            $badgeColors = [
                                                'approve' => 'bg-green-100 text-green-700',
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'reject' => 'bg-red-100 text-red-800',
                                            ];
                                            $badgeClass = $badgeColors[$item->status] ?? 'bg-gray-100 text-gray-800';
                                        @endphp
                                        <span class="text-xs px-2 py-1 rounded-full {{ $badgeClass }}">
                                            {{ ucfirst($item->status ?? 'Tidak Diketahui') }}
                                        </span>
                                    </td>
                                    <td class="text-center px-4 py-3">
                                        <div class="flex justify-center items-center gap-2">
                                            <a href=""
                                                class="flex items-center gap-1 text-xs px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition-all">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                    fill="currentColor" viewBox="0 0 24 24">
                                                    <path
                                                        d="M12 5c-7.633 0-11 7-11 7s3.367 7 11 7 11-7 11-7-3.367-7-11-7zm0 12c-2.761 0-5-2.239-5-5s2.239-5 5-5
                                                                                    5 2.239 5 5-2.239 5-5 5zm0-8a3 3 0 100 6 3 3 0 000-6z" />
                                                </svg>
                                                Lihat
                                            </a>
                                            <a href=""
                                                class="flex items-center gap-1 text-xs px-3 py-1 bg-gray-900 text-white rounded hover:bg-gray-800 transition-all">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                    fill="currentColor" viewBox="0 0 24 24">
                                                    <path
                                                        d="M5 19h14v2H5c-1.103 0-2-.897-2-2V7h2v12zM20.707 7.293l-1-1a1 
                                                                                    1 0 00-1.414 0L10 14.586V17h2.414l8.293-8.293a1 1 0 000-1.414z" />
                                                </svg>
                                                Detail
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center px-4 py-3 text-gray-500">
                                        Tidak ada data.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
                <div class="flex justify-end pt-4 border-t mt-4">
                    <div class="flex items-center space-x-2">
                        @php
                            $start = max(1, $pembelians->currentPage() - 2);
                            $end = min($pembelians->lastPage(), $pembelians->currentPage() + 2);
                        @endphp
                        @if ($start > 1)
                            <a href="{{ $pembelians->url(1) }}"
                                class="px-4 py-2 text-sm text-gray-900 border border-gray-400 rounded-lg hover:bg-gray-100 transition-all">
                                1
                            </a>
                            @if ($start > 2)
                                <span class="px-2 text-sm text-gray-500">...</span>
                            @endif
                        @endif
                        @for ($page = $start; $page <= $end; $page++)
                            @if ($page == $pembelians->currentPage())
                                <span
                                    class="px-4 py-2 text-sm font-semibold text-white bg-gray-700 rounded-lg shadow hover:bg-gray-800 transition-all">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $pembelians->url($page) }}"
                                    class="px-4 py-2 text-sm text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-100 transition-all">
                                    {{ $page }}
                                </a>
                            @endif
                        @endfor
                        @if ($end < $pembelians->lastPage())
                            @if ($end < $pembelians->lastPage() - 1)
                                <span class="px-2 text-sm text-gray-500">...</span>
                            @endif
                            <a href="{{ $pembelians->url($pembelians->lastPage()) }}"
                                class="px-4 py-2 text-sm text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-100 transition-all">
                                {{ $pembelians->lastPage() }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endsection
    <script src="{{ asset('js/buy.js') }}"></script>
</body>

</html>