<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Penjualan Toko</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #047857 0%, #065f46 60%, #064e3b 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        /* Dekorasi background */
        body::before, body::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.04);
        }
        body::before { width: 500px; height: 500px; top: -200px; right: -150px; }
        body::after  { width: 400px; height: 400px; bottom: -150px; left: -100px; }

        .login-card {
            background: white;
            border-radius: 24px;
            padding: 44px 40px;
            width: 100%;
            max-width: 440px;
            box-shadow: 0 24px 64px rgba(0, 0, 0, 0.25);
            position: relative;
            z-index: 1;
            animation: slideUp 0.5s ease;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .brand-badge {
            width: 72px;
            height: 72px;
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin: 0 auto 20px;
            box-shadow: 0 12px 32px rgba(5, 150, 105, 0.35);
        }

        .login-title {
            text-align: center;
            font-weight: 800;
            font-size: 1.6rem;
            color: #0f172a;
            margin-bottom: 6px;
            letter-spacing: -0.03em;
        }

        .login-sub {
            text-align: center;
            color: #64748b;
            font-size: 0.9rem;
            margin-bottom: 32px;
        }

        .input-group-custom {
            position: relative;
            margin-bottom: 16px;
        }

        .input-group-custom i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 1.1rem;
            pointer-events: none;
        }

        .input-group-custom input {
            width: 100%;
            padding: 14px 16px 14px 46px;
            border: 1.5px solid #e2e8f0;
            border-radius: 14px;
            font-size: 0.95rem;
            font-family: inherit;
            transition: all 0.2s;
            background: #f8fafc;
        }

        .input-group-custom input:focus {
            outline: none;
            border-color: #059669;
            background: white;
            box-shadow: 0 0 0 4px rgba(5, 150, 105, 0.12);
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            color: white;
            border: none;
            border-radius: 14px;
            font-weight: 700;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 8px 24px rgba(5, 150, 105, 0.35);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-family: inherit;
            margin-top: 8px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(5, 150, 105, 0.45);
        }

        .alert-custom {
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .alert-error   { background: #fee2e2; color: #991b1b; }
        .alert-success { background: #d1fae5; color: #065f46; }

        /* ============ SHOP LINK (Baru) ============ */
        .shop-link-wrapper {
            text-align: center;
            margin-top: 24px;
            padding-top: 24px;
            border-top: 1px solid #e2e8f0;
        }

        .shop-link-label {
            font-size: 0.75rem;
            color: #94a3b8;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 10px;
        }

        .shop-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 11px 22px;
            background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
            color: #047857;
            border: 1px solid #a7f3d0;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.88rem;
            text-decoration: none;
            transition: all 0.2s;
        }

        .shop-link:hover {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #065f46;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(5, 150, 105, 0.2);
        }

        /* ============ DEMO BOX ============ */
        .demo-box {
            margin-top: 20px;
            padding: 16px;
            background: #f8fafc;
            border-radius: 14px;
            border: 1px dashed #cbd5e1;
        }

        .demo-title {
            font-size: 0.7rem;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 10px;
            text-align: center;
        }

        .demo-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
        }

        .demo-item {
            text-align: center;
            padding: 8px 4px;
            background: white;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
        }

        .demo-role {
            font-size: 0.7rem;
            font-weight: 700;
            color: #059669;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .demo-cred {
            font-size: 0.7rem;
            color: #64748b;
            margin-top: 2px;
            font-family: 'Courier New', monospace;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="brand-badge">🛒</div>
        <h1 class="login-title">Selamat Datang</h1>
        <p class="login-sub">Silakan login untuk melanjutkan ke sistem</p>

        @if(session('error'))
            <div class="alert-custom alert-error">
                <i class="bi bi-exclamation-circle-fill"></i>
                {{ session('error') }}
            </div>
        @endif
        @if(session('success'))
            <div class="alert-custom alert-success">
                <i class="bi bi-check-circle-fill"></i>
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="/login">
            @csrf
            <div class="input-group-custom">
                <i class="bi bi-person"></i>
                <input type="text" name="username" placeholder="Username"
                       value="{{ old('username') }}" autofocus required>
            </div>

            <div class="input-group-custom">
                <i class="bi bi-lock"></i>
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <button type="submit" class="btn-login">
                <i class="bi bi-box-arrow-in-right"></i> Login
            </button>
        </form>

        {{-- ============ LINK KE TOKO ONLINE ============ --}}
        <div class="shop-link-wrapper">
            <div class="shop-link-label">Bukan Staff?</div>
            <a href="{{ route('shop.index') }}" class="shop-link">
                <i class="bi bi-shop"></i> Kunjungi Toko Online
                <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        {{-- ============ AKUN DEMO ============ --}}
        <div class="demo-box">
            <div class="demo-title">🔑 Akun Demo</div>
            <div class="demo-grid">
                <div class="demo-item">
                    <div class="demo-role">Admin</div>
                    <div class="demo-cred">admin</div>
                </div>
                <div class="demo-item">
                    <div class="demo-role">Kasir</div>
                    <div class="demo-cred">kasir</div>
                </div>
                <div class="demo-item">
                    <div class="demo-role">Pemilik</div>
                    <div class="demo-cred">pemilik</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>