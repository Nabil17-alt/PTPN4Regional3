<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Kalkulator Harga - Input Biaya - PTPN4</title>
    <link rel="icon" href="{{ asset('images/logo_ptpn4.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/flowbite@1.6.5/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@1.6.5/dist/flowbite.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/loaders.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{{ asset('css/inputbiaya.css') }}">
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
            @if (session('success'))
                <script>
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 5000,
                        timerProgressBar: true,
                    });
                    Toast.fire({
                        icon: 'success',
                        title: '{{ session('success') }}'
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
                @if ($errors->any())
                    <div class="mb-4 px-4 py-2 text-sm text-red-800 bg-red-50 border border-red-200 rounded">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="formBiaya" method="POST" action="{{ route('input.biaya.store') }}" class="space-y-4">
                    @csrf
                    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-5">
                        <div class="w-full md:w-1/2">
                            <label for="pks" class="block mb-1 text-sm font-medium text-gray-700">Pilih PKS</label>
                            <select id="pks" name="pks" required
                                class="block w-full rounded-lg border-gray-300 text-sm focus:ring-gray-900 focus:border-gray-900">
                                <option value="" disabled {{ empty($selectedPks) ? 'selected' : '' }}>Pilih PKS
                                </option>
                                @isset($pksList)
                                    @foreach ($pksList as $pks)
                                        <option value="{{ $pks->nama_pks }}" {{ ($selectedPks ?? old('pks')) == $pks->nama_pks ? 'selected' : '' }}>
                                            {{ $pks->nama_pks }}
                                        </option>
                                    @endforeach
                                @endisset
                            </select>
                            @if(isset($biaya))
                                <p class="mt-1 text-xs text-blue-600">Data biaya sudah tersimpan.</p>
                            @elseif(!empty($selectedPks))
                                <p class="mt-1 text-xs text-red-600">Belum ada data biaya yang disimpan.</p>
                            @endif
                        </div>

                        <div class="w-full md:w-1/3">
                            <label for="periode" class="block mb-1 text-sm font-medium text-gray-700">Pilih Biaya</label>
                            <input type="month" id="periode" name="periode" required
                                value="{{ $biaya->bulan ?? old('periode', now()->format('Y-m')) }}"
                                class="block w-full rounded-lg border-gray-300 text-sm focus:ring-gray-900 focus:border-gray-900" />
                            <p class="mt-1 text-xs text-gray-500">Jika sudah ada data, bulan akan mengikuti data terakhir.
                            </p>
                        </div>
                    </div>

                    <div class="grid gap-4 md:grid-cols-3">
                        <div>
                            <label for="biaya_olah" class="block mb-1 text-sm font-medium text-gray-700">1. Biaya Olah
                                (Rp/kg)</label>
                            <input type="number" step="0.01" id="biaya_olah" name="biaya_olah" placeholder="0"
                                value="{{ $biaya->biaya_olah ?? old('biaya_olah') }}"
                                class="block w-full rounded-lg border-gray-300 text-sm focus:ring-gray-900 focus:border-gray-900" />
                        </div>

                        <div>
                            <label for="tarif_angkut_cpo" class="block mb-1 text-sm font-medium text-gray-700">2. Tarif
                                Angkut CPO (Rp/kg)</label>
                            <input type="number" step="0.01" id="tarif_angkut_cpo" name="tarif_angkut_cpo" placeholder="0"
                                value="{{ $biaya->tarif_angkut_cpo ?? old('tarif_angkut_cpo') }}"
                                class="block w-full rounded-lg border-gray-300 text-sm focus:ring-gray-900 focus:border-gray-900" />
                        </div>

                        <div>
                            <label for="tarif_angkut_pk" class="block mb-1 text-sm font-medium text-gray-700">3. Tarif
                                Angkut PK (Rp/kg)</label>
                            <input type="number" step="0.01" id="tarif_angkut_pk" name="tarif_angkut_pk" placeholder="0"
                                value="{{ $biaya->tarif_angkut_pk ?? old('tarif_angkut_pk') }}"
                                class="block w-full rounded-lg border-gray-300 text-sm focus:ring-gray-900 focus:border-gray-900" />
                        </div>
                        <div>
                            <label for="b_produksi_per_tbs_olah" class="block mb-1 text-sm font-medium text-gray-700">4. B.
                                Produksi Per TBS Olah (Rp/kg)</label>
                            <input type="number" step="0.01" id="b_produksi_per_tbs_olah" name="b_produksi_per_tbs_olah"
                                placeholder="0"
                                value="{{ $biaya->b_produksi_per_tbs_olah ?? old('b_produksi_per_tbs_olah') }}"
                                class="block w-full rounded-lg border-gray-300 text-sm focus:ring-gray-900 focus:border-gray-900" />
                        </div>
                        <div>
                            <label for="biaya_angkut_jual" class="block mb-1 text-sm font-medium text-gray-700">5. Biaya
                                Angkut dan Jual (Rp/kg)</label>
                            <input type="number" step="0.01" id="biaya_angkut_jual" name="biaya_angkut_jual" placeholder="0"
                                value="{{ $biaya->biaya_angkut_jual ?? old('biaya_angkut_jual') }}"
                                class="block w-full rounded-lg border-gray-300 text-sm focus:ring-gray-900 focus:border-gray-900" />
                        </div>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-gray-100 mt-4">
                        <button type="submit"
                            class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-medium text-white bg-gray-900 rounded hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900">
                            {{ isset($biaya) ? 'EDIT' : 'SIMPAN' }}
                        </button>
                    </div>
                </form>
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
    <script src="{{ asset('js/inputbiaya.js') }}"></script>

</body>

</html>