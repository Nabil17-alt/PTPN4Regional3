<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PTPN IV</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/loaders.css') }}">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-gray-50 text-gray-900 flex min-h-screen">
    <div id="buttonLoader" class="loader hidden">
        <div class="square-spin">
            <div>
                <img src="{{ asset('images/logo_ptpn4.png') }}" alt="Loading" class="loader-logo" />
            </div>
        </div>
        <div class="tooltip">Memuat...</div>
    </div>

    <aside id="sidebar" class="hidden bg-gray-900 text-white w-64 h-full fixed z-50 flex-col">
        <div class="p-6 text-2xl font-bold border-gray-700 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <img src="{{ asset('images/logo_ptpn4.png') }}" alt="Logo" class="h-10 w-10 object-contain">
                <span class="text-white text-xl font-semibold">PTPN IV</span>
            </div>
            <button id="closeSidebar" class="text-gray-400 hover:text-white md:hidden">
                <i data-lucide="x"></i>
            </button>
        </div>
        <div class="flex flex-col justify-between flex-1 px-4 pb-6">
            <ul class="space-y-2 text-sm">
                <li>
                    <a href="{{ route('dashboard') }}"
                        class="menu-item {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white' : '' }}">
                        <i data-lucide="home" class="icon"></i> Dashboard
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.akun') }}"
                        class="menu-item {{ request()->routeIs('admin.akun') ? 'bg-blue-600 text-white' : '' }}">
                        <i data-lucide="user-circle" class="icon"></i> Akun
                    </a>
                </li>

                {{-- Dropdown Kalkulator Harga --}}
                @php
$isKalkulatorActive = request()->routeIs('input.biaya')
    || request()->routeIs('input.biaya.store')
    || request()->routeIs('input.kalkulator')
    || request()->routeIs('input.kalkulator.hitung')
    || request()->routeIs('approval')
    || request()->routeIs('approval.proses');
                @endphp

                <li class="relative">
                    <button type="button" class="menu-item w-full flex items-center justify-between transition-colors duration-150
               {{ $isKalkulatorActive ? 'bg-blue-600 text-white' : 'hover:bg-gray-800' }}"
                        onclick="toggleKalkulatorMenu(this)">
                        <span class="flex items-center gap-2">
                            <i data-lucide="calculator" class="icon"></i>
                            <span class="font-medium">Kalkulator Harga</span>
                        </span>
                        <i data-lucide="chevron-down"
                            class="chevron icon transition-transform duration-150 {{ $isKalkulatorActive ? 'rotate-180' : '' }}">
                        </i>
                    </button>

                    <ul id="kalkulatorSubmenu"
                        class="submenu ml-8 mt-1 space-y-1 text-sm {{ $isKalkulatorActive ? '' : 'hidden' }}">
                        <li>
                            <a href="{{ route('input.biaya') }}" class="submenu-item block px-2 py-1 rounded hover:bg-gray-800
                      {{ request()->routeIs('input.biaya') ? 'font-semibold text-blue-400' : 'text-gray-300' }}">
                                • Input Biaya
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('input.kalkulator') }}" class="submenu-item block px-2 py-1 rounded hover:bg-gray-800
                      {{ request()->routeIs('input.kalkulator') ? 'font-semibold text-blue-400' : 'text-gray-300' }}">
                                • Input Kalkulator Harga
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('approval') }}" class="submenu-item block px-2 py-1 rounded hover:bg-gray-800
                      {{ request()->routeIs('approval') ? 'font-semibold text-blue-400' : 'text-gray-300' }}">
                                • Approval
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Rekap Laporan --}}
                <li>
                    <a href="{{ route('rekap.laporan') }}"
                        class="menu-item {{ request()->routeIs('rekap.laporan') ? 'bg-blue-600 text-white' : '' }}">
                        <i data-lucide="file-text" class="icon"></i>
                        Rekap Laporan
                    </a>
                </li>



            </ul>
        </div>
    </aside>
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-30 md:hidden"></div>
    <div class="flex-1 md:ml-64 p-4 w-full">
        @yield('content')
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        function toggleKalkulatorMenu(button) {
            const submenu = document.getElementById('kalkulatorSubmenu');
            const chevron = button.querySelector('.chevron');

            if (!submenu) return;

            submenu.classList.toggle('hidden');
            chevron.classList.toggle('rotate-180');
        }
    </script>
</body>

</html>