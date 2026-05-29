<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin — Seblak Saiton</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&family=Inter:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/order.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #F8FAFC; color: #0F172A; min-height: 100vh; display: flex; }
        .login-wrapper { display: flex; width: 100%; min-height: 100vh; }
        
        .login-banner {
            flex: 1.2;
            background: url('https://images.unsplash.com/photo-1623341214825-9f4f963727da?q=80&w=2070&auto=format&fit=crop') center/cover no-repeat;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            padding: 3rem;
            text-align: center;
        }
        .banner-overlay {
            position: absolute; top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(135deg, rgba(15,23,42,0.9) 0%, rgba(37,99,235,0.7) 100%);
            backdrop-filter: blur(2px);
        }
        .banner-content {
            position: relative;
            z-index: 10;
            max-width: 400px;
        }
        .banner-content i {
            display: inline-block;
            font-size: 4rem;
            color: #93C5FD;
            margin-bottom: 1rem;
            filter: drop-shadow(0 0 20px rgba(147, 197, 253, 0.5));
            animation: float 3s ease-in-out infinite;
        }
        .banner-content h1 {
            font-family: 'Poppins', sans-serif;
            font-size: 3rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 1rem;
        }
        .banner-content p {
            font-size: 1.1rem;
            color: #E2E8F0;
            line-height: 1.6;
        }

        .login-form-container {
            flex: 1;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem;
        }
        .login-box {
            width: 100%;
            max-width: 400px;
        }
        .login-box-header {
            margin-bottom: 2.5rem;
        }
        .login-box-header h2 {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 1.8rem;
            color: #0F172A;
            margin-bottom: 0.5rem;
        }
        .login-box-header p {
            color: #64748B;
            font-size: 0.95rem;
        }
        
        .input-group { position: relative; margin-bottom: 1.25rem; }
        .input-group i {
            position: absolute; left: 1rem; top: 50%; transform: translateY(-50%);
            color: #94A3B8; font-size: 1.2rem; transition: color 0.3s;
        }
        .input-group input {
            width: 100%; padding: 0.875rem 1rem 0.875rem 3rem;
            border: 2px solid #E2E8F0; border-radius: 12px;
            font-family: 'Inter', sans-serif; font-size: 0.95rem;
            transition: all 0.3s; background: #F8FAFC;
        }
        .input-group input:focus {
            outline: none; border-color: #2563EB; background: white;
            box-shadow: 0 0 0 4px rgba(37,99,235,0.1);
        }
        .input-group input:focus + i { color: #2563EB; }
        
        .btn-login {
            width: 100%; background: #2563EB; color: white; border: none;
            padding: 0.8rem; border-radius: 10px; font-weight: 600; font-size: 0.95rem;
            cursor: pointer; transition: all 0.3s; margin-top: 1rem;
            font-family: 'Poppins', sans-serif; display: flex; align-items: center; justify-content: center; gap: 0.5rem;
        }
        .btn-login:hover { background: #1D4ED8; transform: translateY(-2px); box-shadow: 0 8px 20px rgba(37,99,235,0.25); }
        
        .back-link {
            display: inline-block; margin-top: 2rem; color: #64748B;
            text-decoration: none; font-size: 0.9rem; font-weight: 500; transition: color 0.3s;
        }
        .back-link:hover { color: #0F172A; }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        @media (max-width: 900px) {
            .login-wrapper { flex-direction: column; }
            .login-banner { padding: 4rem 2rem; flex: none; }
            .banner-content h1 { font-size: 2.2rem; }
            .login-form-container { padding: 3rem 2rem; }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-banner">
            <div class="banner-overlay"></div>
            <div class="banner-content">
                <i class="bi bi-fire"></i>
                <h1>Seblak Saiton</h1>
                <p>Sistem Informasi Kasir & Manajemen Pemesanan Digital</p>
            </div>
        </div>
        <div class="login-form-container">
            <div class="login-box animate-slide-up">
                <div class="login-box-header">
                    <h2>Selamat Datang! 👋</h2>
                    <p>Silakan login untuk mengakses admin panel.</p>
                </div>

                @if($errors->any())
                    <div class="alert-error" style="margin-bottom:1.5rem; border-radius:12px;">
                        @foreach($errors->all() as $error)
                            <p style="margin:0;"><i class="bi bi-exclamation-triangle-fill"></i> {{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="input-group">
                        <input type="email" name="email" placeholder="Email Address" value="{{ old('email') }}" required autofocus>
                        <i class="bi bi-envelope"></i>
                    </div>
                    <div class="input-group">
                        <input type="password" name="password" placeholder="Password" required>
                        <i class="bi bi-shield-lock"></i>
                    </div>
                    <button type="submit" class="btn-login">
                        Login ke Dashboard <i class="bi bi-arrow-right-short" style="font-size:1.3rem;"></i>
                    </button>
                </form>

                <div style="text-align:center;">
                    <a href="/" class="back-link"><i class="bi bi-arrow-left"></i> Kembali ke Beranda</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
