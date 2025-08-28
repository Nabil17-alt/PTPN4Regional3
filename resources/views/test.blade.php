<div id="editModal" tabindex="-1"
    class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-md mx-4 sm:mx-auto p-6 animate-fade-in-down">
        <div class="flex justify-between items-center border-b pb-4 mb-4">
            <h3 class="text-xl font-bold text-gray-800" id="modalTitle">Edit Akun</h3>
            <button type="button" onclick="closeModal()"
                class="text-gray-400 hover:text-gray-600 text-2xl font-bold">&times;</button>
        </div>
        <form id="editForm" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
        
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Username -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Username</label>
                    <input type="text" name="username" id="editUsername"
                        value="{{ old('username', $editUser->username ?? '') }}" required
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-gray-500 focus:border-gray-500">
                </div>
        
                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="editEmail" value="{{ old('email', $editUser->email ?? '') }}" required
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-gray-500 focus:border-gray-500"
                        @if(!in_array(Auth::user()->level, ['Admin'])) readonly @endif>
                </div>
        
                <!-- Jabatan -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan</label>
                    <select id="editLevel" name="level" required
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-gray-500 focus:border-gray-500 px-3 py-2"
                        @if(!in_array(Auth::user()->level, ['Admin'])) disabled @endif>
                        <option value="" disabled>Pilih Jabatan</option>
                        @foreach ($jabatanOptions as $option)
                            <option value="{{ $option }}" {{ old('level', $editUser->level ?? '') == $option ? 'selected' : '' }}>
                                {{ str_replace('_', ' ', $option) }}
                            </option>
                        @endforeach
                    </select>
                </div>
        
                <!-- Unit Kerja -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Unit Kerja</label>
                    <input type="hidden" name="kode_unit" id="kodeUnitHidden"
                        value="{{ old('kode_unit', $editUser->kode_unit ?? '') }}">
                    <select id="unitSelect"
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-gray-500 focus:border-gray-500 px-3 py-2"
                        @if(!in_array(Auth::user()->level, ['Admin'])) disabled @endif>
                        <option value="" disabled>Pilih Unit</option>
                        @foreach ($units as $unit)
                            <option value="{{ $unit->kode_unit }}" {{ old('kode_unit', $editUser->kode_unit ?? '') == $unit->kode_unit ? 'selected' : '' }}>
                                {{ $unit->nama_unit }}
                            </option>
                        @endforeach
                    </select>
                    @error('kode_unit')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
        
                <!-- Password -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Password Baru (opsional)</label>
                    <input type="password" name="password"
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-gray-500 focus:border-gray-500"
                        placeholder="Kosongkan jika tidak ingin diubah">
                </div>
            </div>
        
            <!-- Buttons -->
            <div class="flex justify-end space-x-2 pt-4 border-t">
                <button type="button" onclick="closeEditModal()"
                    class="px-4 py-2 text-gray-600 hover:text-gray-800 hover:underline text-sm">Batal</button>
                <button type="submit"
                    class="flex items-center gap-2 text-sm px-4 py-2 bg-gray-900 text-white rounded hover:bg-gray-800 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z" />
                    </svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>

        <!-- <form id="editForm" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                <input type="text" id="editUsername" name="username" required
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" id="editEmail" name="email" required
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 px-3 py-2"
                    @if(!in_array(Auth::user()->level, ['Admin', 'Asisten'])) readonly @endif>

            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan</label>
                <select id="editLevel" name="level" required
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 px-3 py-2"
                    @if(!in_array(Auth::user()->level, ['Admin', 'Asisten'])) disabled @endif>
                    <option value="" disabled selected>Pilih Jabatan</option>
                    @foreach ($jabatanOptions as $option)
                        <option value="{{ $option }}">{{ str_replace('_', ' ', $option) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru (opsional)</label>
                <input type="password" id="editPassword" name="password"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 px-3 py-2"
                    placeholder="Kosongkan jika tidak ingin diubah">
            </div>
            <div class="flex justify-end space-x-2 pt-4 border-t mt-6">
                <button type="button" onclick="closeModal()"
                    class="px-4 py-2 text-gray-600 hover:text-gray-800 hover:underline text-sm">Batal</button>
                <button type="submit"
                    class="flex items-center gap-2 text-sm px-4 py-2 bg-gray-900 text-white rounded hover:bg-gray-800 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path
                            d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z" />
                    </svg>
                    Edit Akun
                </button>
            </div>
        </form> -->
    </div>
</div>
<div id="addModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-2xl mx-4 sm:mx-6 p-6 relative animate-fade-in-down">
        <div class="flex justify-between items-center border-b pb-4 mb-4">
            <h2 class="text-2xl font-bold text-gray-800">Tambah Akun</h2>
            <button onclick="closeAddModal()"
                class="text-gray-400 hover:text-gray-600 text-2xl font-bold">&times;</button>
        </div>
        <form id="addakunForm" action="{{ route('akun.add') }}" method="POST" class="space-y-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Username</label>
                    <input type="text" name="username" required
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-gray-500 focus:border-gray-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" required
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-gray-500 focus:border-gray-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan</label>
                    <select id="jabatanSelect" name="level" required
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-gray-500 focus:border-gray-500 px-3 py-2">
                        <option value="" disabled selected>Pilih Jabatan</option>
                        @foreach ($jabatanOptions as $option)
                            <option value="{{ $option }}">{{ str_replace('_', ' ', $option) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Unit Kerja</label>
                    <input type="hidden" name="kode_unit" id="kodeUnitHidden">
                    <select id="unitSelect"
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-gray-500 focus:border-gray-500 px-3 py-2">
                        <option value="" disabled selected>Pilih Unit</option>
                        @foreach ($units as $unit)
                            <option value="{{ $unit->kode_unit }}" {{ old('kode_unit', $editUser->kode_unit ?? '') == $unit->kode_unit ? 'selected' : '' }}>
                                {{ $unit->nama_unit }}
                            </option>
                        @endforeach
                    </select>
                    @error('kode_unit')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" required
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-gray-500 focus:border-gray-500">
                </div>
            </div>
            <div class="flex justify-end space-x-2 pt-4 border-t">
                <button type="button" onclick="closeAddModal()"
                    class="px-4 py-2 text-gray-600 hover:text-gray-800 hover:underline text-sm">Batal</button>
                <button type="submit"
                    class="flex items-center gap-2 text-sm px-4 py-2 bg-gray-900 text-white rounded hover:bg-gray-800 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path
                            d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z" />
                    </svg>
                    Simpan Akun
                </button>
            </div>
        </form>
    </div>
</div>