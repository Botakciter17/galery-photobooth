<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Photobooth Platform</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@600;700;800;900&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #0B3B60;
            --primary-shadow: #041B2D;
            --bg: #F4F7FB;
            --font: 'Plus Jakarta Sans', sans-serif;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: var(--font);
            background: var(--bg);
            background-image: radial-gradient(circle at 50% 0%, #FFFFFF 0%, #EDF2F7 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        .login-card {
            background: #FFFFFF;
            border: 2px solid #E2E8F0;
            border-radius: 28px;
            box-shadow: 0 20px 45px -10px rgba(11, 59, 96, 0.12);
            width: 100%;
            max-width: 420px;
            padding: 2.5rem 2rem;
            text-align: center;
        }

        .brand-icon {
            width: 56px;
            height: 56px;
            background: var(--primary);
            color: #FFFFFF;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.25rem auto;
            box-shadow: 0 8px 20px rgba(11, 59, 96, 0.25);
        }

        .title { font-size: 1.4rem; font-weight: 900; color: #0F172A; margin-bottom: 0.35rem; }
        .subtitle { font-size: 0.85rem; color: #64748B; font-weight: 600; margin-bottom: 1.8rem; }

        .input-group { text-align: left; margin-bottom: 1.25rem; }
        .label { display: block; font-size: 0.75rem; font-weight: 800; color: #0F172A; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.04em; }

        .input-text {
            width: 100%;
            padding: 0.85rem 1.1rem;
            border: 2px solid #CBD5E1;
            border-radius: 14px;
            font-family: var(--font);
            font-size: 1rem;
            outline: none;
            transition: all 0.15s ease;
        }

        .input-text:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(11, 59, 96, 0.15);
        }

        .btn-submit {
            width: 100%;
            background: var(--primary);
            color: #FFFFFF;
            border: none;
            border-radius: 16px;
            padding: 0.95rem;
            font-family: var(--font);
            font-size: 1rem;
            font-weight: 800;
            cursor: pointer;
            box-shadow: 0 4px 0 var(--primary-shadow), 0 10px 20px rgba(11, 59, 96, 0.25);
            transition: all 0.15s ease;
        }

        .btn-submit:hover { background: #072B47; transform: translateY(-2px); }
        .btn-submit:active { transform: translateY(2px); box-shadow: 0 2px 0 var(--primary-shadow); }

        .error-msg {
            background: #FEF2F2;
            border: 1.5px solid #FECACA;
            color: #991B1B;
            padding: 0.75rem 1rem;
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 700;
            margin-bottom: 1.25rem;
            text-align: left;
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="brand-icon">
        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
    </div>

    <h1 class="title">Admin Photobooth</h1>
    <p class="subtitle">Masuk untuk mengelola galeri dan unduh backup acara.</p>

    @if ($errors->any())
    <div class="error-msg">
        {{ $errors->first() }}
    </div>
    @endif

    <form method="POST" action="{{ route('admin.login.post') }}">
        @csrf
        <div class="input-group">
            <label class="label">Password Admin</label>
            <input type="password" name="password" class="input-text" placeholder="Masukkan password admin" required autofocus autocomplete="current-password">
        </div>

        <button type="submit" class="btn-submit">Masuk ke Dashboard</button>
    </form>
</div>

</body>
</html>
