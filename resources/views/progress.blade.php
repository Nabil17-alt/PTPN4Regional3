<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Progres - PTPN4</title>
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
                                <a href="#" class="hover:text-gray-700">Selamat Datang</a>
                            </li>
                            <li>
                                <span class="mx-2 text-gray-400">/</span>
                            </li>
                            <li class="text-gray-700 font-medium">
                                {{ Auth::user()->level }}
                            </li>
                        </ol>
                        <h6 class="text-xl font-semibold text-gray-800 mt-1">
                            {{ Auth::user()->username }}
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
                        <h2 class="text-xl font-semibold text-gray-800">Progress</h2>
                    </div>
                </div>
                <div class="flex justify-end items-center mb-4">
                    <div class="relative w-64">
                        <input type="text"
                            class="w-full pl-4 pr-10 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Search..." />
                        <div class="absolute right-3 top-2.5 text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 21l-4.35-4.35M16.65 10.5a6.15 6.15 0 11-12.3 0 6.15 6.15 0 0112.3 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[1000px] divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold">Nama</th>
                                <th class="px-4 py-3 text-center font-semibold">Title</th>
                                <th class="px-4 py-3 text-center font-semibold">Status</th>
                                <th class="px-4 py-3 text-left font-semibold">Role</th>
                                <th class="px-4 py-3 text-center font-semibold">Email</th>
                                <th class="px-4 py-3 text-center font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-4 py-3 flex items-center space-x-3">
                                    <img src="https://i.pravatar.cc/40" class="rounded-full h-8 w-8" />
                                    <div>
                                        <div class="font-medium text-gray-800">John Michael</div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <div class="font-medium text-gray-800">Procurement Lead</div>
                                    </div>
                                </td>
                                <td class="text-center px-4 py-3">
                                    <span class="text-xs px-2 py-1 bg-green-100 text-green-700 rounded-full">Active</span>
                                </td>
                                <td>
                                    <div class="font-medium text-gray-400">Manager</div>
                                </td>
                                <td>
                                    <div class="font-medium text-gray-400">johnmichael@gmail.com</div>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap text-center text-sm font-medium space-x-2">
                                    <a href="#"
                                        class="inline-block px-3 py-1 text-xs font-semibold text-white bg-green-500 rounded hover:bg-green-600 transition duration-200">
                                        Approve
                                    </a>
                                    <a href="#"
                                        class="inline-block px-3 py-1 text-xs font-semibold text-white bg-blue-500 rounded hover:bg-blue-600 transition duration-200">
                                        Edit
                                    </a>
                                    <a href="#"
                                        class="inline-block px-3 py-1 text-xs font-semibold text-white bg-red-500 rounded hover:bg-red-600 transition duration-200">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="flex justify-between items-center pt-4 border-t mt-4">
                    <p class="text-sm text-gray-600">Page 1 of 10</p>
                    <div class="space-x-2">
                        <button class="px-3 py-1 text-sm border rounded bg-white hover:bg-gray-100">Previous</button>
                        <button class="px-3 py-1 text-sm border rounded bg-white hover:bg-gray-100">Next</button>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    <script src="{{ asset('js/progress.js') }}"></script>
</body>

</html>