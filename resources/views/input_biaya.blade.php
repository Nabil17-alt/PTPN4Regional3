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