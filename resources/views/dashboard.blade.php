<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Tambah Unit - PTPN4</title>
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
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-start border-b pb-4 mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">Pembelian - Tambah Unit</h2>
                </div>

                <form action="#" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tanggal</label>
                                <input type="date" name="tanggal" value="{{ old('tanggal') }}"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring focus:ring-indigo-200">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Grade</label>
                                <input type="text" name="grade"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring focus:ring-indigo-200">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Unit</label>
                                <input type="text" name="unit"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring focus:ring-indigo-200">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Harga CPO</label>
                                <input type="number" name="harga_cpo"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring focus:ring-indigo-200">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Harga PK</label>
                                <input type="number" name="harga_pk"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring focus:ring-indigo-200">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Rendemen CPO</label>
                                <input type="number" name="rendemen_cpo"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring focus:ring-indigo-200">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Rendemen PK</label>
                                <input type="number" name="rendemen_pk"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring focus:ring-indigo-200">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Total Rendemen</label>
                                <input type="number" name="total_rendemen"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring focus:ring-indigo-200">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Biaya Olah</label>
                                <input type="number" name="biaya_olah"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring focus:ring-indigo-200">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tarif Angkut (CPO)</label>
                                <input type="number" name="tarif_angkut_cpo"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring focus:ring-indigo-200">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tarif Angkut (PK)</label>
                                <input type="number" name="tarif_angkut_pk"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring focus:ring-indigo-200">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Pendapatan CPO</label>
                                <input type="number" name="pendapatan_cpo"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring focus:ring-indigo-200">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Pendapatan PK</label>
                                <input type="number" name="pendapatan_pk"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring focus:ring-indigo-200">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Total Pendapatan</label>
                                <input type="number" name="total_pendapatan"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring focus:ring-indigo-200">
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Biaya Produksi</label>
                                <input type="number" name="biaya_produksi"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring focus:ring-indigo-200">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Biaya Angkut</label>
                                <input type="number" name="biaya_angkut"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring focus:ring-indigo-200">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Total Biaya</label>
                                <input type="number" name="total_biaya"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring focus:ring-indigo-200">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Harga Penetapan</label>
                                <input type="number" name="harga_penetapan"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring focus:ring-indigo-200">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Harga Eskalasi</label>
                                <input type="number" name="harga_eskalasi"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring focus:ring-indigo-200">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Margin</label>
                                <input type="number" name="margin" step="0.01"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring focus:ring-indigo-200">
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end pt-6">
                        <button type="submit"
                            class="flex items-center gap-1 text-sm px-4 py-2 bg-gray-900 text-white rounded hover:bg-gray-800">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M5 19h14v2H5c-1.103 0-2-.897-2-2V7h2v12zM20.707 7.293l-1-1a1 1 0 00-1.414 0L10 14.586V17h2.414l8.293-8.293a1 1 0 000-1.414z" />
                            </svg>
                            Simpan
                        </button>
                    </div>


                </form>


            </div>
        </div>
    @endsection



</body>

</html>