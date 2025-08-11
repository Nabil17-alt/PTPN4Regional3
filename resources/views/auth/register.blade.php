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
    <div id="buttonLoader" class="loader hidden">
        <div class="square-spin">
            <div>
                <img src="{{ asset('images/logo_ptpn4.png') }}" alt="Loading" class="loader-logo" />
            </div>
        </div>
        <div class="tooltip">Memuat...</div>
    </div>
    <div class="register-container">
        <div class="logo-wrapper">
            <div class="logo-circle">
                <img src="{{ asset('images/logo_ptpn4.png') }}" alt="PTPN Logo" class="logo-login">
            </div>
            <h1 class="register-title">Buat Akun Baru</h1>
            <a href="{{ route('login') }}" class="btn-back" id="signinBtn">Kembali ke Login</a>
        </div>
        <form id="registerForm" class="register-form" method="POST" action="{{ route('register') }}">
            @csrf
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="{{ old('username') }}" required>
            @error('username') <div class="error-messages">{{ $message }}</div> @enderror
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
            @error('email') <div class="error-messages">{{ $message }}</div> @enderror
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            @error('password') <div class="error-messages">{{ $message }}</div> @enderror
            <label for="password_confirmation">Konfirmasi Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
            <label for="level">Jabatan</label>
            <select id="level" name="level" required>
                <option value="" disabled selected>Pilih Jabatan</option>
                <option value="Admin">Admin</option>
                <option value="Asisten">Asisten</option>
                <option value="Manager">Manager</option>
                <option value="General_Manager">General Manager</option>
                <option value="Region_Head">Region Head</option>
                <option value="SEVP">SEVP</option>
            </select>
            @error('level') <div class="error-messages">{{ $message }}</div> @enderror
            <label for="kode_unit">Kode Unit</label>
            <input type="text" id="kode_unit" name="kode_unit" value="{{ old('kode_unit') }}" required>
            @error('kode_unit') <div class="error-messages">{{ $message }}</div> @enderror
            <button type="submit" class="btn-register">Daftar</button>
        </form>
    </div>
    <script src="{{ asset('js/register.js') }}"></script>
</body>
</html>