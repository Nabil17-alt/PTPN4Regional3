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
                                    <option value="" disabled selected>-- Pilih PKS --</option>
                                    @foreach ($pksList as $pks)
                                        <option value="{{ $pks->nama_pks }}">{{ $pks->nama_pks }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="w-full md:w-1/2">
                                <label for="tanggal" class="block mb-1 text-sm font-medium text-gray-700">Tanggal</label>
                                <input type="date" id="tanggal" name="tanggal"
                                    class="block w-full rounded-lg border-gray-300 text-sm focus:ring-gray-900 focus:border-gray-900" />
                            </div>
                        </div>

                        <div class="w-full lg:w-1/3">
                            <label class="block mb-1 text-sm font-medium text-gray-700">Status Input</label>
                            <div
                                class="text-xs md:text-sm text-gray-500 bg-gray-50 border border-dashed border-gray-300 rounded-lg px-3 py-2">
                                <p>Belum ada data kalkulator harga tersimpan untuk tanggal ini.</p>
                                <p class="mt-1">Jika sudah diinput, informasi terakhir update akan ditampilkan di sini.</p>
                            </div>
                        </div>
                    </div>

                    {{-- Baris kedua: Pilih biaya yang sudah disimpan & harga referensi --}}

                    <div class="grid gap-4 md:grid-cols-3">
                        <div>
                            <label for="biaya_digunakan" class="block mb-1 text-sm font-medium text-gray-700">Pilih biaya
                                yang akan digunakan</label>
                            <select id="biaya_digunakan" name="biaya_digunakan"
                                class="block w-full rounded-lg border-gray-300 text-sm focus:ring-gray-900 focus:border-gray-900"
                                disabled>
                                <option value="" disabled selected>Biaya bulan mana...</option>
                            </select>
                        </div>

                        <div>
                            <label for="harga_penetapan" class="block mb-1 text-sm font-medium text-gray-700">Harga CPO
                                Penetapan</label>
                            <input type="number" step="0.01" id="harga_penetapan" name="harga_penetapan"
                                placeholder="Rp 13.400,-"
                                class="block w-full rounded-lg border-gray-300 text-sm focus:ring-gray-900 focus:border-gray-900" />
                        </div>

                        <div>
                            <label for="harga_pk_penetapan" class="block mb-1 text-sm font-medium text-gray-700">Harga PK
                                Penetapan</label>
                            <input type="number" step="0.01" id="harga_pk_penetapan" name="harga_pk_penetapan"
                                placeholder="Rp 8.600,-"
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

                        <div id="gradeContainer" class="space-y-3">
                            {{-- Header labels --}}
                            <div class="grid gap-4 grid-cols-7 mb-2">
                                <div class="text-xs font-medium text-gray-700">Grade</div>
                                <div class="text-xs font-medium text-gray-700">Rend. CPO (%)</div>
                                <div class="text-xs font-medium text-gray-700">Rend. PK (%)</div>
                                <div class="text-xs font-medium text-gray-700">Harga BEP</div>
                                <div class="text-xs font-medium text-gray-700">Harga Penetapan</div>
                                <div class="text-xs font-medium text-gray-700">Eskalasi (%)</div>
                                <div class="text-xs font-medium text-gray-700">Informasi Harga Pesaing</div>
                            </div>

                            <div class="grid gap-4 grid-cols-7 items-end grade-row">
                                <div>
                                    <select name="grade[]"
                                        class="block w-full rounded-lg border-gray-300 text-xs focus:ring-gray-900 focus:border-gray-900">
                                        <option value="" disabled selected>Pilih Grade</option>
                                        @foreach ($gradeList as $grade)
                                            <option value="{{ $grade->nama_grade }}">{{ $grade->nama_grade }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <input type="number" step="0.01" name="rend_cpo[]" placeholder="18.75"
                                        class="block w-full rounded-lg border-gray-300 text-xs focus:ring-gray-900 focus:border-gray-900" />
                                </div>

                                <div>
                                    <input type="number" step="0.01" name="rend_pk[]" placeholder="1.70"
                                        class="block w-full rounded-lg border-gray-300 text-xs focus:ring-gray-900 focus:border-gray-900" />
                                </div>

                                <div>
                                    <input type="number" step="0.01" name="harga_bep[]" placeholder="Rp 3.000"
                                        class="block w-full rounded-lg border-gray-200 text-xs text-gray-400 bg-gray-50 focus:ring-0 focus:border-gray-200"
                                        readonly />
                                </div>

                                <div>
                                    <input type="number" step="0.01" name="harga_penetapan_grade[]" placeholder="Rp 3.600"
                                        class="block w-full rounded-lg border-gray-300 text-xs focus:ring-gray-900 focus:border-gray-900" />
                                </div>

                                <div>
                                    <input type="number" step="0.01" name="harga_eskalasi[]" placeholder="1.10"
                                        class="block w-full rounded-lg border-gray-300 text-xs focus:ring-gray-900 focus:border-gray-900" />
                                </div>

                                <div>
                                    <input type="number" step="0.01" name="info_harga_pesaing[]" placeholder="Rp 3.200"
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
                            <table class="w-full text-xs md:text-sm text-left text-gray-700">
                                <thead class="bg-gray-50 text-gray-600 uppercase">
                                    <tr>
                                        <th rowspan="2" class="px-3 py-2 border-b align-middle">No</th>
                                        <th rowspan="2" class="px-3 py-2 border-b align-middle">PKS</th>
                                        <th rowspan="2" class="px-3 py-2 border-b align-middle">Grade</th>
                                        <th colspan="2" class="px-3 py-2 border-b text-center">Harga</th>
                                        <th colspan="2" class="px-3 py-2 border-b text-center">Rendemen</th>
                                        <th colspan="5" class="px-3 py-2 border-b text-center">Harga</th>
                                        <th rowspan="2" class="px-3 py-2 border-b align-middle">Eskalasi</th>
                                    </tr>
                                    <tr>
                                        <th class="px-3 py-2 border-b">CPO</th>
                                        <th class="px-3 py-2 border-b">PK</th>
                                        <th class="px-3 py-2 border-b">CPO</th>
                                        <th class="px-3 py-2 border-b">PK</th>
                                        <th class="px-3 py-2 border-b">Harga BEP</th>
                                        <th class="px-3 py-2 border-b">Harga Saat Ini</th>
                                        <th class="px-3 py-2 border-b">Harga Kemarin</th>
                                        <th class="px-3 py-2 border-b">Selisih</th>
                                        <th class="px-3 py-2 border-b">Harga Pesaing</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="px-3 py-2 border-b text-center" colspan="12">Belum ada data ditampilkan.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Ringkasan bawah (sesuai gambar 2) --}}
                    <div class="mt-6 border-t border-gray-100 pt-4 space-y-3 text-xs text-gray-700">
                        <h2 class="text-sm font-semibold text-gray-800 mb-2">Ringkasan Input Kalkulator Harga (per grade)
                        </h2>
                        <div class="grid gap-2 md:grid-cols-2 lg:grid-cols-3">
                            <div class="flex items-center justify-between gap-2">
                                <span>Perkiraan Pendapatan dari CPO (Rp/kg)</span>
                                <span
                                    class="px-3 py-1 rounded bg-gray-50 border border-gray-200 min-w-[90px] text-right">0</span>
                            </div>
                            <div class="flex items-center justify-between gap-2">
                                <span>Perkiraan Pendapatan dari PK (Rp/kg)</span>
                                <span
                                    class="px-3 py-1 rounded bg-gray-50 border border-gray-200 min-w-[90px] text-right">0</span>
                            </div>
                            <div class="flex items-center justify-between gap-2">
                                <span>Total Perkiraan Pendapatan</span>
                                <span
                                    class="px-3 py-1 rounded bg-gray-50 border border-gray-200 min-w-[90px] text-right">0</span>
                            </div>
                            <div class="flex items-center justify-between gap-2">
                                <span>Perkiraan Biaya: Biaya Produksi per TBS olah (Rp/kg)</span>
                                <span
                                    class="px-3 py-1 rounded bg-gray-50 border border-gray-200 min-w-[90px] text-right">0</span>
                            </div>
                            <div class="flex items-center justify-between gap-2">
                                <span>Perkiraan Biaya: Biaya Angkut Gabungan (Rp/kg)</span>
                                <span
                                    class="px-3 py-1 rounded bg-gray-50 border border-gray-200 min-w-[90px] text-right">0</span>
                            </div>
                            <div class="flex items-center justify-between gap-2">
                                <span>Total Perkiraan Biaya</span>
                                <span
                                    class="px-3 py-1 rounded bg-gray-50 border border-gray-200 min-w-[90px] text-right">0</span>
                            </div>
                            <div class="flex items-center justify-between gap-2">
                                <span>Grade</span>
                                <span
                                    class="px-3 py-1 rounded bg-gray-50 border border-gray-200 min-w-[60px] text-center">FND</span>
                            </div>
                            <div class="flex items-center justify-between gap-2">
                                <span>Harga BEP</span>
                                <span
                                    class="px-3 py-1 rounded bg-gray-50 border border-gray-200 min-w-[90px] text-right">0</span>
                            </div>
                            <div class="flex items-center justify-between gap-2">
                                <span>Harga Penetapan</span>
                                <span
                                    class="px-3 py-1 rounded bg-gray-50 border border-gray-200 min-w-[90px] text-right">0</span>
                            </div>
                            <div class="flex items-center justify-between gap-2">
                                <span>Eskalasi %</span>
                                <span
                                    class="px-3 py-1 rounded bg-gray-50 border border-gray-200 min-w-[60px] text-right">0%</span>
                            </div>
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
            newRow.className = 'grid gap-4 grid-cols-7 items-end grade-row';
            
            const gradeOptions = gradeList.map(g => `<option value="${g.nama_grade}">${g.nama_grade}</option>`).join('');
            
            newRow.innerHTML = `
                <div>
                    <select name="grade[]"
                        class="block w-full rounded-lg border-gray-300 text-xs focus:ring-gray-900 focus:border-gray-900">
                        <option value="" disabled selected>Pilih Grade</option>
                        ${gradeOptions}
                    </select>
                </div>

                <div>
                    <input type="number" step="0.01" name="rend_cpo[]" placeholder="18.75"
                        class="block w-full rounded-lg border-gray-300 text-xs focus:ring-gray-900 focus:border-gray-900" />
                </div>

                <div>
                    <input type="number" step="0.01" name="rend_pk[]" placeholder="1.70"
                        class="block w-full rounded-lg border-gray-300 text-xs focus:ring-gray-900 focus:border-gray-900" />
                </div>

                <div>
                    <input type="number" step="0.01" name="harga_bep[]" placeholder="Rp 3.000"
                        class="block w-full rounded-lg border-gray-200 text-xs text-gray-400 bg-gray-50 focus:ring-0 focus:border-gray-200"
                        readonly />
                </div>

                <div>
                    <input type="number" step="0.01" name="harga_penetapan_grade[]" placeholder="Rp 3.600"
                        class="block w-full rounded-lg border-gray-300 text-xs focus:ring-gray-900 focus:border-gray-900" />
                </div>

                <div>
                    <input type="number" step="0.01" name="harga_eskalasi[]" placeholder="1.10"
                        class="block w-full rounded-lg border-gray-300 text-xs focus:ring-gray-900 focus:border-gray-900" />
                </div>

                <div>
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
        document.addEventListener('DOMContentLoaded', function() {
            updateDeleteButton();
        });
    </script>
    </script>
</body>

</html>