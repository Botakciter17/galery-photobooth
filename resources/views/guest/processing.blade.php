<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="refresh" content="3">
    <title>Menyiapkan Foto - Photobooth</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@600;700;800;900&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #0B3B60;
            --accent-gold: #F59E0B;
            --bg-main: #F4F7FB;
            --card-bg: #FFFFFF;
            --border-soft: #E2E8F0;
            --text-dark: #0F172A;
            --text-muted: #64748B;
            --font-main: 'Plus Jakarta Sans', sans-serif;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: var(--font-main);
            background: var(--bg-main);
            background-image: radial-gradient(circle at 50% 0%, #FFFFFF 0%, #EDF2F7 100%);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            text-align: center;
        }

        .card {
            background: var(--card-bg);
            border: 2px solid var(--border-soft);
            border-radius: 28px;
            padding: 2.5rem 2rem;
            max-width: 440px;
            width: 100%;
            box-shadow: 0 20px 45px -10px rgba(11, 59, 96, 0.12);
        }

        .spinner {
            width: 60px;
            height: 60px;
            border: 5px solid #E2E8F0;
            border-top: 5px solid var(--primary);
            border-radius: 50%;
            margin: 0 auto 1.5rem auto;
            animation: spin 0.9s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .title {
            font-size: 1.35rem;
            font-weight: 900;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
            letter-spacing: -0.02em;
        }

        .subtitle {
            font-size: 0.88rem;
            color: var(--text-muted);
            font-weight: 600;
            line-height: 1.5;
            margin-bottom: 1.25rem;
        }

        .notice {
            background: #EFF6FF;
            border: 1.5px solid #BFDBFE;
            color: var(--primary);
            font-size: 0.8rem;
            font-weight: 700;
            padding: 0.6rem 1rem;
            border-radius: 12px;
            display: inline-block;
        }
    </style>
</head>
<body>

<div class="card">
    <div class="spinner"></div>
    <h1 class="title">Foto Sedang Disiapkan!</h1>
    <p class="subtitle">Foto kamu sedang diproses dan diunggah dari mesin photobooth. Halaman ini akan memuat foto kamu secara otomatis.</p>
    <div class="notice">Memperbarui otomatis...</div>
</div>

<script>
    setTimeout(function() {
        window.location.reload();
    }, 2500);
</script>

</body>
</html>
