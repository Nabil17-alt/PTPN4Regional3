<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Kalkulator Harga - Input Kalkulator Harga - PTPN4</title>
    <link rel="icon" href="{{ asset('images/logo_ptpn4.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/flowbite@1.6.5/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@1.6.5/dist/flowbite.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/loaders.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{{ asset('css/inputkalkulator.css') }}">
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
                {{-- Baris atas: Preview Rekap & Filter --}}
                <form id="formKalkulator" method="POST" action="{{ route('input.kalkulator.hitung') }}" class="space-y-6">
                    @csrf
                    <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4 mb-6">
                        <div class="flex items-center gap-3">
                            <button type="button"
                                class="inline-flex items-center justify-center px-4 py-1.5 rounded border border-gray-300 text-xs font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300">
                                Preview Rekap
                            </button>
                        </div>

                        <div class="flex flex-col md:flex-row gap-4 w-full lg:w-2/3">
                            <div class="w-full md:w-1/2">
                                <label for="pks" class="block mb-1 text-sm font-medium text-gray-700">Pilih PKS</label>
                                <select id="pks" name="pks"
                                    class="block w-full rounded-lg border-gray-300 text-sm focus:ring-gray-900 focus:border-gray-900">
                                    <option value="" disabled selected>Pilih PKS</option>
                                    @foreach ($pksList as $pks)
                                        <option value="{{ $pks->nama_pks }}">{{ $pks->nama_pks }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="w-full md:w-1/2">
                                <label for="tanggal" class="block mb-1 text-sm font-medium text-gray-700">Pilih
                                    Tanggal</label>
                                <input type="date" id="tanggal" name="tanggal"
                                    value="{{ now()->subDay()->format('Y-m-d') }}"
                                    class="block w-full rounded-lg border-gray-300 text-sm focus:ring-gray-900 focus:border-gray-900" />
                            </div>
                        </div>
                    </div>

                    {{-- Baris kedua: Pilih biaya yang sudah disimpan & harga referensi --}}

                    <div class="grid gap-4 md:grid-cols-3">
                        <div>
                            <label for="biaya_digunakan" class="block mb-1 text-sm font-medium text-gray-700">Pilih biaya
                                bulan
                            </label>
                            <select id="biaya_digunakan" name="biaya_digunakan"
                                class="block w-full rounded-lg border-gray-300 text-sm focus:ring-gray-900 focus:border-gray-900"
                                disabled>
                                <option value="" disabled selected>Biaya bulan mana...</option>
                            </select>
                        </div>

                        <div>
                            <label for="hargaCPO" class="block mb-1 text-sm font-medium text-gray-700">Harga CPO</label>
                            <input type="number" step="0.01" id="hargaCPO" name="hargaCPO" placeholder="13.400"
                                class="block w-full rounded-lg border-gray-300 text-sm focus:ring-gray-900 focus:border-gray-900" />
                        </div>

                        <div>
                            <label for="hargaPK" class="block mb-1 text-sm font-medium text-gray-700">Harga PK</label>
                            <input type="number" step="0.01" id="hargaPK" name="hargaPK" placeholder="8.600"
                                class="block w-full rounded-lg border-gray-300 text-sm focus:ring-gray-900 focus:border-gray-900" />
                        </div>
                    </div>

                    {{-- Bagian Grade: perhitungan per grade --}}
                    <div class="mt-6 border-t border-gray-100 pt-4 space-y-4">
                        <div class="flex items-center justify-between">
                            <h2 class="text-sm font-semibold text-gray-800 flex items-center gap-2">
                                <span>Grade / Kualitas yang dihitung</span>
                            </h2>
                            <div class="flex items-center gap-2">
                                <button type="button" id="deleteGradeBtn" onclick="deleteLastGradeRow()"
                                    class="inline-flex items-center justify-center px-3 py-1.5 rounded border border-red-300 text-xs font-medium text-red-700 bg-red-50 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-300 hidden">
                                    Hapus
                                </button>
                                <button type="button" onclick="addGradeRow()"
                                    class="inline-flex items-center justify-center px-3 py-1.5 rounded border border-gray-300 text-xs font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300">
                                    + Grade
                                </button>
                            </div>
                        </div>

                        <div id="gradeContainer" class="space-y-4">
                            <div class="grade-row p-4 border rounded-lg bg-gray-50 space-y-4">
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Grade</label>
                                    <select name="grade[]"
                                        class="block w-full rounded-lg border-gray-300 text-xs focus:ring-gray-900 focus:border-gray-900">
                                        <option value="" disabled selected>Pilih Grade</option>
                                        @foreach ($gradeList as $grade)
                                            <option value="{{ $grade->nama_grade }}">{{ $grade->nama_grade }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="grid gap-4 md:grid-cols-2">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Rend. CPO (%)</label>
                                        <input type="number" step="0.01" name="rend_cpo[]" placeholder="19.54"
                                            class="block w-full rounded-lg border-gray-300 text-xs focus:ring-gray-900 focus:border-gray-900" />
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Rend. PK (%)</label>
                                        <input type="number" step="0.01" name="rend_pk[]" placeholder="4.20"
                                            class="block w-full rounded-lg border-gray-300 text-xs focus:ring-gray-900 focus:border-gray-900" />
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Harga BEP (Rp)</label>
                                    <input type="number" step="0.01" name="harga_bep[]"
                                        class="harga_bep block w-full rounded-lg border-gray-300 text-xs bg-gray-100 focus:ring-gray-900 focus:border-gray-900"
                                        readonly />
                                </div>

                                {{-- Hidden fields to carry biaya produksi & angkut per grade --}}
                                <input type="hidden" name="b_produksi_per_tbs_olah[]" class="b_produksi" />
                                <input type="hidden" name="biaya_angkut_jual[]" class="biaya_angkut" />

                                <div class="grid gap-4 md:grid-cols-2">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Harga Penetapan
                                            (Rp)</label>
                                        <input type="number" step="0.01" name="harga_penetapan_grade[]"
                                            class="hargaPenetapan block w-full rounded-lg border-gray-300 text-xs focus:ring-gray-900 focus:border-gray-900" />
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Eskalasi (%)</label>
                                        <input type="number" step="0.01" name="harga_eskalasi[]"
                                            class="hargaEskalasi block w-full rounded-lg border-gray-300 text-xs bg-gray-100 focus:ring-gray-900 focus:border-gray-900"
                                            readonly />
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Informasi Harga
                                        Pesaing (Rp)</label>
                                    <input type="number" step="0.01" name="info_harga_pesaing[]" placeholder="3.200"
                                        class="block w-full rounded-lg border-gray-300 text-xs focus:ring-gray-900 focus:border-gray-900" />
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-medium text-white bg-gray-900 rounded hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900">
                                Simpan
                            </button>
                        </div>
                    </div>

                    {{-- Tabel Preview Rekap di bawah form grade --}}
                    <div class="mt-6 w-full">
                        <h2 class="text-sm font-semibold text-gray-800 mb-3">Preview Rekap</h2>
                        <div class="overflow-x-auto border border-gray-200 rounded-lg">
                            <table class="w-full text-xs md:text-sm text-center text-gray-700">
                                <thead class="bg-gray-50 text-gray-600 uppercase">
                                    <tr>
                                        <th rowspan="2" class="px-3 py-2 border-b align-middle text-center">No</th>
                                        <th rowspan="2" class="px-3 py-2 border-b align-middle text-center">PKS</th>
                                        <th rowspan="2" class="px-3 py-2 border-b align-middle text-center">Grade</th>
                                        <th colspan="2" class="px-3 py-2 border-b text-center">Harga</th>
                                        <th colspan="2" class="px-3 py-2 border-b text-center">Rendemen</th>
                                        <th colspan="5" class="px-3 py-2 border-b text-center">Harga</th>
                                        <th rowspan="2" class="px-3 py-2 border-b align-middle text-center">Eskalasi</th>
                                    </tr>
                                    <tr>
                                        <th class="px-3 py-2 border-b text-center">CPO</th>
                                        <th class="px-3 py-2 border-b text-center">PK</th>
                                        <th class="px-3 py-2 border-b text-center">CPO</th>
                                        <th class="px-3 py-2 border-b text-center">PK</th>
                                        <th class="px-3 py-2 border-b text-center">Harga BEP</th>
                                        <th class="px-3 py-2 border-b text-center">Harga Saat Ini</th>
                                        <th class="px-3 py-2 border-b text-center">Harga Kemarin</th>
                                        <th class="px-3 py-2 border-b text-center">Selisih</th>
                                        <th class="px-3 py-2 border-b text-center">Harga Pesaing</th>
                                    </tr>
                                </thead>
                                <tbody id="previewTbody">
                                    @forelse(($pembelianList ?? []) as $i => $row)
                                        <tr>
                                            <td class="px-3 py-2 border-b align-middle text-center">{{ $i + 1 }}</td>
                                            <td class="px-3 py-2 border-b align-middle text-center">{{ is_object($row) ? ($row->nama_pks ?? '-') : '-' }}</td>
                                            <td class="px-3 py-2 border-b align-middle text-center">{{ is_object($row) ? ($row->grade ?? '-') : '-' }}</td>
                                            <td class="px-3 py-2 border-b align-middle text-center">{{ (is_object($row) && isset($row->harga_cpo_penetapan)) ? number_format($row->harga_cpo_penetapan, 3, ',', '.') : '-' }}</td>
                                            <td class="px-3 py-2 border-b align-middle text-center">{{ (is_object($row) && isset($row->harga_pk)) ? number_format($row->harga_pk, 3, ',', '.') : '-' }}</td>
                                            <td class="px-3 py-2 border-b align-middle text-center">{{ (is_object($row) && isset($row->rendemen_cpo)) ? number_format($row->rendemen_cpo, 2, ',', '.') : '-' }}</td>
                                            <td class="px-3 py-2 border-b align-middle text-center">{{ (is_object($row) && isset($row->rendemen_pk)) ? number_format($row->rendemen_pk, 2, ',', '.') : '-' }}</td>
                                            <td class="px-3 py-2 border-b align-middle text-center">{{ (is_object($row) && isset($row->harga_bep)) ? number_format($row->harga_bep, 2, ',', '.') : '-' }}</td>
                                            <td class="px-3 py-2 border-b align-middle text-center">{{ (is_object($row) && isset($row->harga_penetapan)) ? number_format($row->harga_penetapan, 3, ',', '.') : '-' }}</td>
                                            <td class="px-3 py-2 border-b align-middle text-center">{{ (is_object($row) && isset($row->harga_kemarin)) ? number_format($row->harga_kemarin, 2, ',', '.') : '-' }}</td>
                                            <td class="px-3 py-2 border-b align-middle text-center">{{ (is_object($row) && isset($row->selisih_harga)) ? number_format($row->selisih_harga, 2, ',', '.') : '-' }}</td>
                                            <td class="px-3 py-2 border-b align-middle text-center">{{ (is_object($row) && isset($row->harga_pesaing)) ? number_format($row->harga_pesaing, 3, ',', '.') : '-' }}</td>
                                            <td class="px-3 py-2 border-b align-middle text-center">{{ (is_object($row) && isset($row->eskalasi)) ? number_format($row->eskalasi, 2, ',', '.') : '-' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="px-3 py-2 border-b text-center" colspan="12">Belum ada data ditampilkan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
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
    <script src="{{ asset('js/inputkalkulator.js') }}"></script>
    <script>
        const biayaList = @json($biayaList);
        const gradeList = @json($gradeList);

        function addGradeRow() {
            const container = document.getElementById('gradeContainer');
            const newRow = document.createElement('div');
            newRow.className = 'grade-row p-4 border rounded-lg bg-gray-50 space-y-4 mt-2';

            const gradeOptions = gradeList.map(g => `<option value="${g.nama_grade}">${g.nama_grade}</option>`).join('');

            newRow.innerHTML = `
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Grade</label>
                    <select name="grade[]"
                        class="block w-full rounded-lg border-gray-300 text-xs focus:ring-gray-900 focus:border-gray-900">
                        <option value="" disabled selected>Pilih Grade</option>
                        ${gradeOptions}
                    </select>
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Rend. CPO (%)</label>
                        <input type="number" step="0.01" name="rend_cpo[]" placeholder="18.75"
                            class="block w-full rounded-lg border-gray-300 text-xs focus:ring-gray-900 focus:border-gray-900" />
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Rend. PK (%)</label>
                        <input type="number" step="0.01" name="rend_pk[]" placeholder="1.70"
                            class="block w-full rounded-lg border-gray-300 text-xs focus:ring-gray-900 focus:border-gray-900" />
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Harga BEP</label>
                    <input type="number" step="0.01" name="harga_bep[]" class="harga_bep"
                        class="block w-full rounded-lg border-gray-200 text-xs text-gray-500 bg-gray-100 focus:ring-0 focus:border-gray-200"
                        readonly />
                </div>

                <!-- Hidden fields to carry biaya produksi & angkut per grade -->
                <input type="hidden" name="b_produksi_per_tbs_olah[]" class="b_produksi" />
                <input type="hidden" name="biaya_angkut_jual[]" class="biaya_angkut" />

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Harga Penetapan</label>
                        <input type="number" step="0.01" name="harga_penetapan_grade[]" class="hargaPenetapan"
                            class="block w-full rounded-lg border-gray-200 text-xs focus:ring-gray-900 focus:border-gray-200" />
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Eskalasi (%)</label>
                        <input type="number" step="0.01" name="harga_eskalasi[]" class="hargaEskalasi"
                            class="block w-full rounded-lg border-gray-200 text-xs text-gray-500 bg-gray-100 focus:ring-0 focus:border-gray-200"
                            readonly />
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Informasi Harga Pesaing</label>
                    <input type="number" step="0.01" name="info_harga_pesaing[]" placeholder="Rp 3.200"
                        class="block w-full rounded-lg border-gray-300 text-xs focus:ring-gray-900 focus:border-gray-900" />
                </div>
            `;

            container.appendChild(newRow);
            updateDeleteButton();
        }

        function deleteLastGradeRow() {
            const rows = document.querySelectorAll('.grade-row');
            if (rows.length > 1) {
                rows[rows.length - 1].remove();
                updateDeleteButton();
            }
        }

        function updateDeleteButton() {
            const rows = document.querySelectorAll('.grade-row');
            const deleteBtn = document.getElementById('deleteGradeBtn');

            // Tampilkan tombol hapus hanya jika ada lebih dari 1 row
            if (rows.length > 1) {
                deleteBtn.style.display = 'inline-flex';
            } else {
                deleteBtn.style.display = 'none';
            }
        }

        // Panggil saat halaman load
        document.addEventListener('DOMContentLoaded', function () {
            updateDeleteButton();
        });
    </script>
    </script>
</body>

</html>