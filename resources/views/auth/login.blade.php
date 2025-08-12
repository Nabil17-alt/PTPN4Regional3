<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PTPN4</title>
    <link rel="icon" href="{{ asset('images/logo_ptpn4.png') }}" type="image/png">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="{{ asset('css/loaders.css') }}">

</head>
<body>
    <div class="loader hidden" id="pageLoader">
        <div class="square-spin">
            <img src="{{ asset('images/logo_ptpn4.png') }}" alt="Loading..." />
        </div>
        <span class="tooltip">
            <p>Memuat...</p>
        </span>
    </div>
    <div class="container">
        <div class="left">
            <div class="logo-circle">
                <img src="{{ asset('images/logo_ptpn4.png') }}" alt="PTPN Logo" class="logo-login">
            </div>
            <div class="welcome-msg">Selamat Datang!</div>
            <div class="welcome-sub">Silakan login terlebih dahulu untuk melanjutkan</div>
            <a href="{{ route('register') }}" class="btn-signup" id="signupBtn">Buat Akun</a>
        </div>
        <div class="right">
            <div class="sign-in-title">Masuk ke Akun Anda</div>
            <form id="loginForm" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" value="{{ old('username') }}" required autofocus>
                    @error('username')
                        <div class="error-messages">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                    @error('password')
                        <div class="error-messages">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn-login">Masuk</button>
            </form>
        </div>
    </div>
    <script src="{{ asset('js/login.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if(session('login_error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Login Gagal',
                text: '{{ session('login_error') }}',
                confirmButtonColor: '#d33',
                confirmButtonText: 'Tutup'
            });
        </script>
    @endif

</body>
</html>