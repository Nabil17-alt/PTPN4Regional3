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
                    <a href="{{ route('dashboard') }}" class="menu-item">
                        <i data-lucide="home" class="icon"></i> Beranda
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.akun') }}" class="menu-item">
                        <i data-lucide="user-circle" class="icon"></i> Akun
                    </a>
                </li>
                <li>
                    <a href="{{ in_array(Auth::user()->level, ['Admin', 'Asisten']) ? route('buy.admin') : route('buy') }}"
                        class="menu-item">
                        <i data-lucide="shopping-cart" class="icon"></i> Pembelian
                    </a>
                </li>
                <li>
                    <a href="{{ route('progress') }}" class="menu-item">
                        <i data-lucide="bar-chart-3" class="icon"></i> Progres
                    </a>
                </li>
                <li>
                    <a href="{{ route('view') }}" class="menu-item">
                        <i data-lucide="eye" class="icon"></i> Lihat
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
</body>

</html>