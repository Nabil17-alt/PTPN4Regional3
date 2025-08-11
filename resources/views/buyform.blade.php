<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Beranda - PTPN4</title>
    <link rel="icon" href="{{ asset('images/logo_ptpn4.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/flowbite@1.6.5/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@1.6.5/dist/flowbite.min.js"></script>
</head>

<body>

    @extends('layouts.app')

    @section('content')
        <div class="p-4 sm:ml-64 mt-15">
            @if (session('success'))
                <div class="mb-4 p-3 bg-green-200 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('pembelian.store') }}" method="POST" class="w-full max-w-full">
                @csrf
                <div class="space-y-12">
                    <div class="pb-12">
                        <h2 class="text-base/7 font-semibold text-gray-900">Pembelian</h2>
                        <div class="mt-5 max-w-xs">
                            <label for="tanggal" class="block mb-5 text-sm font-medium text-gray-900">Tanggal</label>
                            <input id="tanggal" type="date" name="tanggal" value="{{ old('tanggal') }}" required
                                class="bg-gray-50 border border-gray-300 rounded-lg p-2.5 w-120" />
                        </div>
                        <div id="input-container" class="border-gray-900/10 pb-12 mt-5 max-w-[28rem]">
                            <label class="block mb-2 text-sm font-medium text-gray-900">
                                <div class="flex items-center justify-between w-full max-w-xs">
                                    <span class="mr-119">Grade</span>
                                    <span class="mr-122">Unit</span>
                                    <button id="tambah-button" type="button"
                                        class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5">
                                        Tambah
                                    </button>
                                </div>
                            </label>
                            <div id="inputs-wrapper">
                                <div class="flex space-x-4 mb-4 items-center">
                                    <div class="flex flex-col">
                                        <select name="grade" required
                                            class="bg-gray-50 border border-gray-300 rounded-lg p-2.5 w-120 text-sm">
                                            <option value="" disabled selected>Pilih Grade</option>
                                            @foreach ($grades as $grade)
                                                <option value="{{ $grade->nama_grade }}">{{ $grade->nama_grade }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="flex flex-col">
                                        <select name="kode_unit" required
                                            class="bg-gray-50 border border-gray-300 rounded-lg p-2.5 w-152 text-sm">
                                            <option value="" disabled selected>Pilih Unit</option>
                                            @foreach ($units as $unit)
                                                <option value="{{ $unit->id_unit }}">{{ $unit->namaunit }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <label class="block mb-2 text-sm font-medium text-gray-900">
                                    <div class="flex items-center justify-between w-full max-w-xs">
                                        <span>Harga&nbsp;</span> <span>CPO</span>
                                        <span class="ml-111">Harga&nbsp;</span><span class="mr-131">PK</span>
                                    </div>
                                </label>
                                <div class="flex space-x-4 mb-4 items-center">
                                    <div class="flex flex-col">
                                        <div class="flex items-center shrink-0">
                                            <input type="number" id="hargaCPO" name="harga_cpo" required
                                                placeholder="Masukkan Harga CPO"
                                                class="block p-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg w-120" />
                                        </div>
                                    </div>

                                    <div class="flex items-center shrink-0">
                                        <input type="number" id="hargaPK" name="harga_pk" required
                                            placeholder="Masukkan Harga PK"
                                            class="block p-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg w-152" />
                                    </div>
                                </div>
                                <label class="block mb-2 text-sm font-medium text-gray-900">
                                    <div class="flex items-center justify-between w-full max-w-xs">
                                        <span>Rendemen&nbsp;</span> <span>CPO</span>
                                        <span class="ml-104">Rendemen&nbsp;</span><span class="mr-131">PK</span>
                                    </div>
                                </label>
                                <div class="flex space-x-4 mb-4 items-center">
                                    <div class="flex flex-col">
                                        <div class="flex items-center shrink-0">
                                            <input type="number" step="any" id="rendemen_cpo" name="rendemen_cpo" required
                                                placeholder="Masukkan Rendemen CPO"
                                                class="block p-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg w-120" />
                                        </div>
                                    </div>

                                    <div class="flex items-center shrink-0">
                                        <input type="number" step="any" id="rendemen_pk" name="rendemen_pk" required
                                            placeholder="Masukkan Rendemen PK"
                                            class="block p-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg w-152" />
                                    </div>
                                </div>
                                <label class="block mb-2 text-sm font-medium text-gray-900">
                                    <div class="flex items-center justify-between w-full max-w-xs">
                                        <h2>Total Rendemen</h2>
                                    </div>
                                </label>
                                <div class="flex space-x-4 mb-4 items-center">
                                    <div class="flex flex-col">
                                        <div class="flex items-center shrink-0">
                                            <input type="number" step="any" id="total_rendemen" required readonly
                                                placeholder="Total Rendemen"
                                                class="block p-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg w-120" />
                                        </div>
                                    </div>
                                </div>
                                <label class="block mb-2 text-sm font-medium text-gray-900">
                                    <div class="flex items-center justify-between w-full max-w-xs">
                                        <h2>Biaya Olah</h2>
                                    </div>
                                </label>
                                <div class="flex space-x-4 mb-4 items-center">
                                    <div class="flex flex-col">
                                        <div class="flex items-center shrink-0">
                                            <input type="number" step="any" name="biaya_olah" required
                                                placeholder="Masukkan Biaya Olah"
                                                class="block p-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg w-120" />
                                        </div>
                                    </div>
                                </div>
                                <label class="block mb-2 text-sm font-medium text-gray-900">
                                    <div class="flex items-center justify-between w-full max-w-xs">
                                        <span>Tarif&nbsp;</span> <span>Angkut&nbsp(CPO)</span>
                                        <span class="ml-99">Tarif&nbsp;</span><span class="mr-131">Angkut&nbsp(PK)</span>
                                    </div>
                                </label>
                                <div class="flex space-x-4 mb-4 items-center">
                                    <div class="flex flex-col">
                                        <div class="flex items-center shrink-0">
                                            <input type="number" step="any" name="tarif_angkut_cpo" required
                                                placeholder="Masukkan Tarif Angkut CPO"
                                                class="block p-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg w-120" />
                                        </div>
                                    </div>

                                    <div class="flex items-center shrink-0">
                                        <input type="number" step="any" name="tarif_angkut_pk" required
                                            placeholder="Masukkan Tarif Angkut PK"
                                            class="block p-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg w-152" />
                                    </div>
                                </div>
                                <label class="block mb-2 text-sm font-medium text-gray-900">
                                    <div class="flex items-center justify-between w-full max-w-xs">
                                        <span>Pendapatan&nbsp;</span> <span>CPO</span>
                                        <span class="ml-102">Pendapatan&nbsp;</span><span class="mr-131">PK</span>
                                    </div>
                                </label>
                                <div class="flex space-x-4 mb-4 items-center">
                                    <div class="flex flex-col">
                                        <div class="flex items-center shrink-0">
                                            <input type="number" step="any" id="pendapatanCPO" required
                                                placeholder="Masukkan Pendapatan CPO"
                                                class="block p-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg w-120" />
                                        </div>
                                    </div>

                                    <div class="flex items-center shrink-0">
                                        <input type="number" step="any" id="pendapatanPK" required
                                            placeholder="Masukkan Pendapatan PK"
                                            class="block p-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg w-152" />
                                    </div>
                                </div>
                                <label class="block mb-2 text-sm font-medium text-gray-900">
                                    <div class="flex items-center justify-between w-full max-w-xs">
                                        <span>Total Pendapatan</span>
                                    </div>
                                </label>
                                <div class="flex space-x-4 mb-4 items-center">
                                    <div class="flex flex-col">
                                        <div class="flex items-center shrink-0">
                                            <input type="number" step="any" id="totalPendapatan" required
                                                placeholder="Total Pendapatan"
                                                class="block p-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg w-120" />
                                        </div>
                                    </div>
                                </div>
                                <label class="block mb-2 text-sm font-medium text-gray-900">
                                    <div class="flex items-center justify-between w-full max-w-xs">
                                        <span>Biaya&nbsp;</span> <span>Produksi</span>
                                        <span class="ml-105">Biaya&nbsp;</span><span class="mr-130">Angkut </span>
                                    </div>
                                </label>
                                <div class="flex space-x-4 mb-4 items-center">
                                    <div class="flex flex-col">
                                        <div class="flex items-center shrink-0">
                                            <input type="number" step="any" id="biayaProduksi" required
                                                placeholder="Masukkan Biaya Produksi"
                                                class="block p-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg w-120" />
                                        </div>
                                    </div>
                                    <div class="flex items-center shrink-0">
                                        <input type="number" step="any" id="biayaAngkut" name="biaya_angkut_jual" required
                                            placeholder="Masukkan Baiya Angkut"
                                            class="block p-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg w-153" />
                                    </div>
                                </div>
                                <label class="block mb-2 text-sm font-medium text-gray-900">
                                    <div class="flex items-center justify-between w-full max-w-xs">
                                        <h2>Total Biaya</h2>
                                    </div>
                                </label>
                                <div class="flex space-x-4 mb-4 items-center">
                                    <div class="flex flex-col">
                                        <div class="flex items-center shrink-0">
                                            <input type="number" step="any" id="totalBiaya" required readonly
                                                placeholder="Total Biaya"
                                                class="block p-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg w-120" />
                                        </div>
                                    </div>
                                </div>
                                <label class="block mb-2 text-sm font-medium text-gray-900">
                                    <div class="flex items-center justify-between w-full max-w-xs">
                                        <span>Harga&nbsp;</span> <span>Penetapan</span>
                                        <span class="ml-101">Harga&nbsp;</span><span class="mr-130">Eskalasi </span>
                                    </div>
                                </label>
                                <div class="flex space-x-4 mb-4 items-center">
                                    <div class="flex flex-col">
                                        <div class="flex items-center shrink-0">
                                            <input type="number" step="any" id="hargaPenetapan" required readonly
                                                placeholder="Harga Pendapatan"
                                                class="block p-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg w-120" />
                                        </div>
                                    </div>
                                    <div class="flex items-center shrink-0">
                                        <input type="number" step="any" id="hargaEskalasi" name="harga_escalasi" required
                                            placeholder="Masukkan Harga Eskalasi"
                                            class="block p-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg w-153" />
                                    </div>
                                </div>
                            </div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">
                                <div class="flex items-center justify-between w-full max-w-xs">
                                    <h2>Margin</h2>
                                </div>
                            </label>
                            <div class="flex space-x-4 mb-4 items-center">
                                <div class="flex flex-col">
                                    <div class="flex items-center shrink-0">
                                        <input type="number" step="any" name="margin" id="margin" readonly
                                            placeholder="Margin"
                                            class="block p-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg w-120" />
                                    </div>
                                </div>
                            </div>
                            <button type="submit"
                                class="text-white bg-green-500 hover:bg-green-700 font-medium rounded-lg text-sm px-5 py-2.5 mt-4">
                                Simpan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <script>
            function updateColumn() {
                const rendemenCpoInput = document.getElementById('rendemen_cpo');
                const rendemenPkInput = document.getElementById('rendemen_pk');
                const hargaCpoInput = document.getElementById('hargaCPO');
                const hargaPkInput = document.getElementById('hargaPK');
                const totalRendemenInput = document.getElementById('total_rendemen');
                const pendapatanCpoInput = document.getElementById('pendapatanCPO');
                const pendapatanPkInput = document.getElementById('pendapatanPK');
                const totalPendapatanInput = document.getElementById('totalPendapatan');
                const biayaProduksiInput = document.getElementById('biayaProduksi');
                const biayaAngkutInput = document.getElementById('biayaAngkut');
                const totalBiayaInput = document.getElementById('totalBiaya');
                const hargaPenetapanInput = document.getElementById('hargaPenetapan');
                const hargaEskalasiInput = document.getElementById('hargaEskalasi');
                const marginInput = document.getElementById('margin');

                // Parsing input values ke float, default 0 jika kosong atau invalid
                const rendemenCpoValue = parseFloat(rendemenCpoInput.value) || 0;
                const rendemenPkValue = parseFloat(rendemenPkInput.value) || 0;
                const hargaCpoValue = parseFloat(hargaCpoInput.value) || 0;
                const hargaPkValue = parseFloat(hargaPkInput.value) || 0;
                const biayaAngkutValue = parseFloat(biayaAngkutInput.value) || 0;
                const hargaEskalasiValue = parseFloat(hargaEskalasiInput.value) || 0;

                // Hitungan sesuai rumus
                const totalRendemen = rendemenCpoValue + rendemenPkValue;
                const pendapatanCpo = hargaCpoValue * rendemenCpoValue;
                const pendapatanPk = hargaPkValue * rendemenPkValue;
                const totalPendapatan = pendapatanCpo + pendapatanPk;
                const biayaProduksi = totalRendemen * totalPendapatan;
                const totalBiaya = biayaProduksi + biayaAngkutValue;
                const hargaPenetapan = totalPendapatan - totalBiaya;

                let margin = 0;
                if (hargaPenetapan !== 0) {
                    margin = 1 - (hargaEskalasiValue / hargaPenetapan);
                }

                // Output hasil, dibulatkan 2 desimal kecuali margin 4 desimal
                totalRendemenInput.value = totalRendemen.toFixed(2);
                pendapatanCpoInput.value = pendapatanCpo.toFixed(2);
                pendapatanPkInput.value = pendapatanPk.toFixed(2);
                totalPendapatanInput.value = totalPendapatan.toFixed(2);
                biayaProduksiInput.value = biayaProduksi.toFixed(2);
                biayaProduksiInput.readOnly = true;
                totalBiayaInput.value = totalBiaya.toFixed(2);
                if (hargaPenetapanInput) hargaPenetapanInput.value = hargaPenetapan.toFixed(2);
                if (marginInput) marginInput.value = margin.toFixed(4);
            }

            // Pasang event listener supaya perhitungan otomatis ketika input berubah
            ['rendemen_cpo', 'rendemen_pk', 'hargaCPO', 'hargaPK', 'biayaAngkut', 'hargaEskalasi'].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.addEventListener('input', updateColumn);
            });
        </script>
    @endsection
</body>


</html>