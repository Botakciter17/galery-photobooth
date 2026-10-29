<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Hasil Foto Photobooth - {{ $session->event->name ?? 'Photobooth' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #0B3B60;
            --primary-dark: #072B47;
            --primary-shadow: #041B2D;
            --accent-gold: #F59E0B;
            --accent-gold-hover: #D97706;
            --bg-main: #F4F7FB;
            --card-bg: #FFFFFF;
            --border-soft: #E2E8F0;
            --border-strong: #CBD5E1;
            --text-dark: #0F172A;
            --text-muted: #64748B;
            --font-main: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            -webkit-tap-highlight-color: transparent;
        }

        body {
            font-family: var(--font-main);
            background: var(--bg-main);
            background-image: radial-gradient(circle at 50% 0%, #FFFFFF 0%, #EDF2F7 100%);
            color: var(--text-dark);
            min-height: 100vh;
            padding: 1.25rem 1rem 3rem 1rem;
            -webkit-font-smoothing: antialiased;
        }

        .container {
            max-width: 640px;
            margin: 0 auto;
        }

        /* Top Header */
        .header {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .event-tag {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            background: #EFF6FF;
            border: 1.5px solid #BFDBFE;
            color: var(--primary);
            font-size: 0.75rem;
            font-weight: 800;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            padding: 0.35rem 0.95rem;
            border-radius: 9999px;
            margin-bottom: 0.6rem;
        }

        .title {
            font-size: 1.6rem;
            font-weight: 900;
            letter-spacing: -0.02em;
            color: var(--text-dark);
            margin-bottom: 0.35rem;
        }

        .subtitle {
            font-size: 0.88rem;
            color: var(--text-muted);
            font-weight: 600;
        }

        /* Buttons */
        .btn {
            font-family: var(--font-main);
            font-size: 0.95rem;
            font-weight: 800;
            padding: 0.85rem 1.4rem;
            border-radius: 16px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: all 0.15s ease;
            border: none;
            width: 100%;
        }

        .btn-primary {
            background: linear-gradient(180deg, #0E4775 0%, #0B3B60 100%);
            color: #FFFFFF;
            box-shadow: 0 4px 0 var(--primary-shadow), 0 10px 20px rgba(11, 59, 96, 0.25);
        }

        .btn-primary:active {
            transform: translateY(2px);
            box-shadow: 0 2px 0 var(--primary-shadow);
        }

        .btn-gold {
            background: linear-gradient(180deg, #FBBF24 0%, #F59E0B 100%);
            color: #1E293B;
            box-shadow: 0 4px 0 #D97706, 0 10px 20px rgba(245, 158, 11, 0.28);
        }

        .btn-gold:active {
            transform: translateY(2px);
            box-shadow: 0 2px 0 #D97706;
        }

        .btn-outline {
            background: #FFFFFF;
            border: 2px solid var(--border-soft);
            color: var(--primary);
            padding: 0.65rem 1rem;
            font-size: 0.82rem;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
        }

        .btn-outline:active {
            background: #EFF6FF;
            transform: scale(0.97);
        }

        /* Polaroid Showcase Card */
        .card {
            background: var(--card-bg);
            border: 2px solid var(--border-soft);
            border-radius: 24px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 12px 36px -8px rgba(11, 59, 96, 0.1);
        }

        .strip-preview-wrapper {
            background: #0F172A;
            border-radius: 16px;
            padding: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.25rem;
            box-shadow: inset 0 2px 8px rgba(0, 0, 0, 0.4);
        }

        .strip-img {
            max-width: 100%;
            max-height: 480px;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
            display: block;
        }

        /* Section Singles */
        .section-header {
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .section-title {
            font-size: 1.05rem;
            font-weight: 900;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .singles-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.75rem;
            margin-bottom: 1.25rem;
        }

        @media (max-width: 480px) {
            .singles-grid {
                grid-template-columns: repeat(3, 1fr);
                gap: 0.5rem;
            }
        }

        .single-photo-card {
            background: #FFFFFF;
            border: 1.5px solid var(--border-soft);
            border-radius: 16px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
            transition: all 0.15s ease;
        }

        .single-photo-img-box {
            aspect-ratio: 4 / 3;
            background: #E2E8F0;
            overflow: hidden;
            position: relative;
        }

        .single-photo-img-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .single-photo-badge {
            position: absolute;
            top: 6px;
            left: 6px;
            background: rgba(11, 59, 96, 0.85);
            backdrop-filter: blur(4px);
            color: #FFFFFF;
            font-size: 0.65rem;
            font-weight: 800;
            padding: 2px 6px;
            border-radius: 6px;
        }

        .single-photo-action {
            padding: 0.5rem 0.4rem;
        }

        .btn-download-single {
            font-size: 0.75rem;
            font-weight: 800;
            padding: 0.5rem 0.25rem;
            border-radius: 10px;
            background: #EFF6FF;
            border: 1.5px solid #BFDBFE;
            color: var(--primary);
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.3rem;
            text-decoration: none;
        }

        .btn-download-single:active {
            background: #DBEAFE;
        }

        /* Footer Note */
        .footer {
            text-align: center;
            margin-top: 2rem;
            font-size: 0.8rem;
            color: var(--text-muted);
            font-weight: 600;
        }

        /* SVG icon helper */
        .icon {
            display: inline-block;
            vertical-align: middle;
            fill: none;
            stroke: currentColor;
            stroke-width: 2.2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }
    </style>
</head>
<body>

<div class="container">

    <!-- Top Header -->
    <header class="header">
        <div class="event-tag">
            <svg class="icon" width="14" height="14" viewBox="0 0 24 24"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
            {{ $session->event->name ?? 'Photobooth Event' }}
        </div>
        <h1 class="title">Foto Kamu Sudah Siap!</h1>
        <p class="subtitle">Unduh hasil polaroid strip dan foto satuan kamu di bawah ini.</p>
    </header>

    <!-- Polaroid Strip Showcase Card -->
    @if ($stripPhoto)
    <div class="card">
        <div class="strip-preview-wrapper">
            <img src="{{ route('guest.view.photo', ['slug' => $session->slug, 'photoId' => $stripPhoto->id]) }}" alt="Polaroid Strip" class="strip-img" />
        </div>

        <a href="{{ route('guest.download.photo', ['slug' => $session->slug, 'photoId' => $stripPhoto->id]) }}" class="btn btn-primary" download>
            <svg class="icon" width="18" height="18" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
            Unduh Polaroid Strip (.JPG)
        </a>
    </div>
    @endif

    <!-- Single Photos Section -->
    @if ($singlePhotos->count() > 0)
    <div class="card">
        <div class="section-header">
            <h2 class="section-title">
                <svg class="icon" width="18" height="18" viewBox="0 0 24 24"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                Foto Satuan Tiap Pose
            </h2>
            <span style="font-size: 0.78rem; font-weight: 800; color: var(--accent-gold); background: #FEF3C7; padding: 2px 8px; border-radius: 6px;">
                {{ $singlePhotos->count() }} Pose
            </span>
        </div>

        <div class="singles-grid">
            @foreach ($singlePhotos as $single)
            <div class="single-photo-card">
                <div class="single-photo-img-box">
                    <span class="single-photo-badge">#{{ $single->photo_index }}</span>
                    <img src="{{ route('guest.view.photo', ['slug' => $session->slug, 'photoId' => $single->id]) }}" alt="Pose {{ $single->photo_index }}" loading="lazy" />
                </div>
                <div class="single-photo-action">
                    <a href="{{ route('guest.download.photo', ['slug' => $session->slug, 'photoId' => $single->id]) }}" class="btn-download-single" download>
                        <svg class="icon" width="13" height="13" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        Pose #{{ $single->photo_index }}
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Download All ZIP Button -->
        <a href="{{ route('guest.download.zip', ['slug' => $session->slug]) }}" class="btn btn-gold" download>
            <svg class="icon" width="18" height="18" viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
            Unduh Semua Foto Sekaligus (.ZIP)
        </a>
    </div>
    @endif

    <!-- Footer -->
    <footer class="footer">
        <p>Photobooth Experience &bull; {{ $session->created_at->format('d M Y, H:i') }} WIB</p>
    </footer>

</div>

</body>
</html>
