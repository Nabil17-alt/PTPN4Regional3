<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - PTPN4</title>
    <link rel="icon" href="{{ asset('images/logo_ptpn4.png') }}" type="image/png">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <link rel="stylesheet" href="{{ asset('css/loaders.css') }}">
</head>

<body>
    {{-- Loader --}}
    <div class="loader hidden" id="pageLoader">
        <div class="square-spin">
            <img src="{{ asset('images/logo_ptpn4.png') }}" alt="Loading..." />
        </div>
        <span class="tooltip">
            <p>Memuat...</p>
        </span>
    </div>
    <div class="container">
                <div class="right">
            <div class="register-title">Buat Akun Baru</div>
            <form id="registerForm" method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" value="{{ old('username') }}" required>
                    @error('username') <div class="error-messages">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                    @error('email') <div class="error-messages">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                    @error('password') <div class="error-messages">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required>
                </div>
                <div class="form-group">
                        <label for="level">Jabatan</label>
                        <select id="level" name="level" required>
                        <option value="" disabled selected>Pilih Jabatan</option>
                        <option value="Asisten">Asisten</option>
                        <option value="Manager">Manager</option>
                        <option value="Admin">Admin</option>
                        <option value="General_Manager">General Manager</option>
                        <option value="Region_Head">Region Head</option>
                    </select>
                    @error('level') <div class="error-messages">{{ $message }}</div> @enderror

                </div>
                <div class="form-group">
                        <label for="kode_unit">Unit Kerja</label>
                        <select id="kode_unit" name="kode_unit" required>
                        <option value="" disabled selected>Pilih Unit Kerja</option>
                        @foreach($unit as $a)
                            <option value="{{ $a->kode_unit }}" {{ old('kode_unit') == $a->kode_unit ? 'selected' : '' }}>
                                {{ $a->nama_unit }}
                            </option>
                        @endforeach
                    </select>
                    @error('kode_unit') <div class="error-messages">{{ $message }}</div> @enderror

                <button type="submit" class="btn-register">Daftar</button>
                </div>
            </form>
        </div>
        <div class="left">
            <div class="logo-circle">
                <img src="{{ asset('images/logo_ptpn4.png') }}" alt="PTPN Logo" class="logo-login">
            </div>
            <div class="welcome-msg">Selamat Datang!</div>
            <div class="welcome-sub">Silakan buat akun terlebih dahulu</div>
            <a href="{{ route('login') }}" id="backLink" class="btn-back">Kembali ke Login</a>
        </div>
    <script src="{{ asset('js/register.js') }}"></script>   
</body>
</html>