<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Kalkulator Harga - Approval - PTPN4</title>
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
            <div class="px-4 py-5 mb-6 bg-white shadow rounded-lg">
                <h1 class="text-base font-semibold text-gray-800 mb-4">Approval Harga TBS</h1>

                {{-- Tab untuk memilih tipe approval --}}
                <div class="mb-6 border-b border-gray-200">
                    <div class="flex flex-wrap gap-2">
                        <button type="button" data-tab="manager"
                            class="tab-btn px-4 py-2 text-sm font-medium text-gray-700 border-b-2 border-transparent hover:border-gray-300 hover:text-gray-900 transition"
                            onclick="showTab('manager')">
                            Manager
                        </button>
                        <button type="button" data-tab="gm"
                            class="tab-btn px-4 py-2 text-sm font-medium text-gray-700 border-b-2 border-transparent hover:border-gray-300 hover:text-gray-900 transition"
                            onclick="showTab('gm')">
                            GM
                        </button>
                        <button type="button" data-tab="rh"
                            class="tab-btn px-4 py-2 text-sm font-medium text-gray-700 border-b-2 border-transparent hover:border-gray-300 hover:text-gray-900 transition"
                            onclick="showTab('rh')">
                            RH
                        </button>
                    </div>
                </div>

                {{-- TAB MANAGER --}}
                <div id="manager-tab" class="tab-content mb-6 w-full">
                    <div class="mb-4">
                        <label for="manager_filter" class="block mb-2 text-sm font-semibold text-gray-800">Pilih Manager Kemitraan</label>
                        <select id="manager_filter" name="manager_filter" onchange="selectManager(this.value)"
                            class="block w-full md:w-1/3 rounded-lg border-gray-300 text-sm focus:ring-gray-900 focus:border-gray-900">
                            <option value="">-- Pilih Manager Kemitraan --</option>
                            <option value="TPU-TME">TPU / TME (Tanah Putih, Tanjung Medan)</option>
                            <option value="SGO-SPA-SGH">SGO / SPA / SGH (Sei Garo, Sei Pagar, Sei Galuh)</option>
                            <option value="SBT-LDA">SBT / LDA (Sei Buatan, Lubuk Dalam)</option>
                            <option value="STA-SSN-SSI">STA / SSN / SSI (Sei Tapung, Sei Intan, Sei Sijenggung)</option>
                        </select>
                    </div>
                    <div class="overflow-x-auto border border-gray-200 rounded-lg mb-4">
                        <table class="w-full text-xs md:text-sm text-left text-gray-700">
                            <thead class="bg-gray-50 text-gray-600 uppercase">
                                <tr>
                                    <th rowspan="2" class="px-3 py-2 border-b align-middle">No</th>
                                    <th rowspan="2" class="px-3 py-2 border-b align-middle">PKS</th>
                                    <th rowspan="2" class="px-3 py-2 border-b align-middle">Grade</th>
                                    <th colspan="2" class="px-3 py-2 border-b text-center">Harga</th>
                                    <th colspan="2" class="px-3 py-2 border-b text-center">Rendemen</th>
                                    <th rowspan="2" class="px-3 py-2 border-b align-middle">Harga BEP</th>
                                    <th colspan="4" class="px-3 py-2 border-b text-center">Harga</th>
                                    <th rowspan="2" class="px-3 py-2 border-b align-middle">Eskalasi</th>
                                    <th rowspan="2" class="px-3 py-2 border-b align-middle">Aksi</th>
                                </tr>
                                <tr>
                                    <th class="px-3 py-2 border-b">CPO</th>
                                    <th class="px-3 py-2 border-b">PK</th>
                                    <th class="px-3 py-2 border-b">CPO</th>
                                    <th class="px-3 py-2 border-b">PK</th>
                                    <th class="px-3 py-2 border-b">Harga Saat Ini</th>
                                    <th class="px-3 py-2 border-b">Harga Kemarin</th>
                                    <th class="px-3 py-2 border-b">Selisih</th>
                                    <th class="px-3 py-2 border-b">Harga Pesaing</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="px-3 py-2 border-b text-center" colspan="14">Pilih Manager Kemitraan untuk menampilkan data.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    @if(Auth::user()->level === 'Manager')
                    <div class="flex flex-col md:flex-row gap-4 items-stretch md:items-end justify-between">
                        <div class="flex-1">
                            <label for="catatan_manager" class="block mb-1 text-xs font-medium text-gray-700">Keterangan (wajib diisi bila memilih "Kembali ke Admin")</label>
                            <textarea id="catatan_manager" name="catatan_manager" rows="2"
                                class="block w-full rounded-lg border-gray-300 text-xs focus:ring-gray-900 focus:border-gray-900"
                                placeholder="Contoh: revisi harga grade FND di PKS TPU, sesuaikan dengan rendemen terbaru..."></textarea>
                        </div>
                        <div class="flex flex-col gap-2 w-full md:w-auto">
                            <button type="button"
                                class="inline-flex items-center justify-center px-4 py-2 text-xs font-medium text-white bg-green-600 rounded hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-600">
                                APPROVE
                            </button>
                            <button type="button"
                                class="inline-flex items-center justify-center px-4 py-2 text-xs font-medium text-white bg-red-600 rounded hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-600">
                                Kembali ke Admin
                            </button>
                        </div>
                    </div>
                    @else
                    <div class="px-4 py-3 bg-blue-50 border border-blue-200 rounded-lg text-xs text-blue-700">
                        <i class="fas fa-info-circle"></i> Hanya user level Manager yang dapat melakukan approval di tab ini.
                    </div>
                    @endif
                </div>

                {{-- TAB GM --}}
                <div id="gm-tab" class="tab-content mb-6 w-full hidden">
                    <div class="mb-4">
                        <h2 class="text-sm font-semibold text-gray-800 mb-2">Rekap semua PKS</h2>
                        <p class="text-xs text-gray-600 mb-3">GM melakukan review dan approval terhadap semua data yang sudah di-approve oleh Manager.</p>
                    </div>
                    <div class="overflow-x-auto border border-gray-200 rounded-lg mb-4">
                        <table class="w-full text-xs md:text-sm text-left text-gray-700">
                            <thead class="bg-gray-50 text-gray-600 uppercase">
                                <tr>
                                    <th rowspan="2" class="px-3 py-2 border-b align-middle">No</th>
                                    <th rowspan="2" class="px-3 py-2 border-b align-middle">PKS</th>
                                    <th rowspan="2" class="px-3 py-2 border-b align-middle">Grade</th>
                                    <th colspan="2" class="px-3 py-2 border-b text-center">Harga</th>
                                    <th colspan="2" class="px-3 py-2 border-b text-center">Rendemen</th>
                                    <th rowspan="2" class="px-3 py-2 border-b align-middle">Harga BEP</th>
                                    <th colspan="4" class="px-3 py-2 border-b text-center">Harga</th>
                                    <th rowspan="2" class="px-3 py-2 border-b align-middle">Eskalasi</th>
                                    <th rowspan="2" class="px-3 py-2 border-b align-middle">Status</th>
                                </tr>
                                <tr>
                                    <th class="px-3 py-2 border-b">CPO</th>
                                    <th class="px-3 py-2 border-b">PK</th>
                                    <th class="px-3 py-2 border-b">CPO</th>
                                    <th class="px-3 py-2 border-b">PK</th>
                                    <th class="px-3 py-2 border-b">Harga Saat Ini</th>
                                    <th class="px-3 py-2 border-b">Harga Kemarin</th>
                                    <th class="px-3 py-2 border-b">Selisih</th>
                                    <th class="px-3 py-2 border-b">Harga Pesaing</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="px-3 py-2 border-b text-center" colspan="14">Belum ada data ditampilkan.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    @if(Auth::user()->level === 'GM')
                    <div class="flex flex-col md:flex-row gap-4 items-stretch md:items-end justify-between">
                        <div class="flex-1">
                            <label for="catatan_gm" class="block mb-1 text-xs font-medium text-gray-700">Keterangan (wajib diisi bila memilih "Kembali ke Manager")</label>
                            <textarea id="catatan_gm" name="catatan_gm" rows="2"
                                class="block w-full rounded-lg border-gray-300 text-xs focus:ring-gray-900 focus:border-gray-900"
                                placeholder="Contoh: harga grade FND perlu disesuaikan dengan kebijakan terbaru..."></textarea>
                        </div>
                        <div class="flex flex-col gap-2 w-full md:w-auto">
                            <button type="button"
                                class="inline-flex items-center justify-center px-4 py-2 text-xs font-medium text-white bg-green-600 rounded hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-600">
                                APPROVE
                            </button>
                            <button type="button"
                                class="inline-flex items-center justify-center px-4 py-2 text-xs font-medium text-white bg-red-600 rounded hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-600">
                                Kembali ke Manager
                            </button>
                        </div>
                    </div>
                    @else
                    <div class="px-4 py-3 bg-blue-50 border border-blue-200 rounded-lg text-xs text-blue-700">
                        <i class="fas fa-info-circle"></i> Hanya user level GM yang dapat melakukan approval di tab ini.
                    </div>
                    @endif
                </div>

                {{-- TAB RH --}}
                <div id="rh-tab" class="tab-content mb-6 w-full hidden">
                    <div class="mb-4">
                        <h2 class="text-sm font-semibold text-gray-800 mb-2">Rekap semua PKS</h2>
                        <p class="text-xs text-gray-600 mb-3">RH melakukan final approval terhadap semua data yang sudah di-approve oleh GM.</p>
                    </div>
                    <div class="overflow-x-auto border border-gray-200 rounded-lg mb-4">
                        <table class="w-full text-xs md:text-sm text-left text-gray-700">
                            <thead class="bg-gray-50 text-gray-600 uppercase">
                                <tr>
                                    <th rowspan="2" class="px-3 py-2 border-b align-middle">No</th>
                                    <th rowspan="2" class="px-3 py-2 border-b align-middle">PKS</th>
                                    <th rowspan="2" class="px-3 py-2 border-b align-middle">Grade</th>
                                    <th colspan="2" class="px-3 py-2 border-b text-center">Harga</th>
                                    <th colspan="2" class="px-3 py-2 border-b text-center">Rendemen</th>
                                    <th rowspan="2" class="px-3 py-2 border-b align-middle">Harga BEP</th>
                                    <th colspan="4" class="px-3 py-2 border-b text-center">Harga</th>
                                    <th rowspan="2" class="px-3 py-2 border-b align-middle">Eskalasi</th>
                                    <th rowspan="2" class="px-3 py-2 border-b align-middle">Status</th>
                                </tr>
                                <tr>
                                    <th class="px-3 py-2 border-b">CPO</th>
                                    <th class="px-3 py-2 border-b">PK</th>
                                    <th class="px-3 py-2 border-b">CPO</th>
                                    <th class="px-3 py-2 border-b">PK</th>
                                    <th class="px-3 py-2 border-b">Harga Saat Ini</th>
                                    <th class="px-3 py-2 border-b">Harga Kemarin</th>
                                    <th class="px-3 py-2 border-b">Selisih</th>
                                    <th class="px-3 py-2 border-b">Harga Pesaing</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="px-3 py-2 border-b text-center" colspan="14">Belum ada data ditampilkan.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    @if(Auth::user()->level === 'region_head')
                    <div class="flex flex-col md:flex-row gap-4 items-stretch md:items-end justify-between">
                        <div class="flex-1">
                            <label for="catatan_rh" class="block mb-1 text-xs font-medium text-gray-700">Keterangan (wajib diisi bila memilih "Kembali ke GM")</label>
                            <textarea id="catatan_rh" name="catatan_rh" rows="2"
                                class="block w-full rounded-lg border-gray-300 text-xs focus:ring-gray-900 focus:border-gray-900"
                                placeholder="Contoh: terdapat data yang tidak sesuai dengan kebijakan kepala regional..."></textarea>
                        </div>
                        <div class="flex flex-col gap-2 w-full md:w-auto">
                            <button type="button"
                                class="inline-flex items-center justify-center px-4 py-2 text-xs font-medium text-white bg-green-600 rounded hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-600">
                                APPROVE FINAL
                            </button>
                            <button type="button"
                                class="inline-flex items-center justify-center px-4 py-2 text-xs font-medium text-white bg-red-600 rounded hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-600">
                                Kembali ke GM
                            </button>
                        </div>
                    </div>
                    @else
                    <div class="px-4 py-3 bg-blue-50 border border-blue-200 rounded-lg text-xs text-blue-700">
                        <i class="fas fa-info-circle"></i> Hanya user level RH yang dapat melakukan approval di tab ini.
                    </div>
                    @endif
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
    <script>
        function showTab(tabName) {
            // Hide all tab contents
            const tabs = document.querySelectorAll('.tab-content');
            tabs.forEach(tab => {
                tab.classList.add('hidden');
            });
            
            // Remove active state from all buttons
            const buttons = document.querySelectorAll('.tab-btn');
            buttons.forEach(btn => {
                btn.classList.remove('border-b-2', 'border-gray-900', 'text-gray-900');
                btn.classList.add('border-b-2', 'border-transparent', 'text-gray-700');
            });
            
            // Show selected tab content
            const selectedTab = document.getElementById(tabName + '-tab');
            if (selectedTab) {
                selectedTab.classList.remove('hidden');
            }
            
            // Add active state to clicked button
            const activeButton = document.querySelector(`[data-tab="${tabName}"]`);
            if (activeButton) {
                activeButton.classList.remove('border-b-2', 'border-transparent', 'text-gray-700');
                activeButton.classList.add('border-b-2', 'border-gray-900', 'text-gray-900');
            }
        }
        
        function selectManager(managerType) {
            console.log('Manager Kemitraan dipilih:', managerType);
            // TODO: Load data sesuai manager yang dipilih
        }
        
        // Set default tab on page load
        document.addEventListener('DOMContentLoaded', function() {
            showTab('manager');
        });
    </script>
</body>

</html>