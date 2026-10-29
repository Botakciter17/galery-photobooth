<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Photobooth Platform</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #0B3B60;
            --primary-hover: #072B47;
            --primary-shadow: #041B2D;
            --accent-gold: #F59E0B;
            --accent-gold-hover: #D97706;
            --bg: #F4F7FB;
            --card-bg: #FFFFFF;
            --border-soft: #E2E8F0;
            --border-strong: #CBD5E1;
            --text-dark: #0F172A;
            --text-muted: #64748B;
            --danger: #EF4444;
            --font: 'Plus Jakarta Sans', sans-serif;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: var(--font);
            background: var(--bg);
            background-image: radial-gradient(circle at 50% 0%, #FFFFFF 0%, #EDF2F7 100%);
            color: var(--text-dark);
            min-height: 100vh;
            padding: 1.5rem;
            -webkit-font-smoothing: antialiased;
        }

        .container {
            max-width: 1300px;
            margin: 0 auto;
        }

        /* Top Bar */
        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 2rem;
            background: #FFFFFF;
            border: 2px solid var(--border-soft);
            border-radius: 20px;
            padding: 1.25rem 1.75rem;
            box-shadow: 0 4px 20px rgba(11, 59, 96, 0.05);
        }

        .brand-wrap {
            display: flex;
            align-items: center;
            gap: 0.85rem;
        }

        .brand-icon {
            width: 44px;
            height: 44px;
            background: var(--primary);
            color: #FFFFFF;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .brand-title { font-size: 1.3rem; font-weight: 900; color: var(--text-dark); }
        .brand-sub { font-size: 0.8rem; color: var(--text-muted); font-weight: 600; }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        /* Stat Pills */
        .stat-pill {
            background: #EFF6FF;
            border: 1.5px solid #BFDBFE;
            padding: 0.45rem 1rem;
            border-radius: 12px;
            font-size: 0.82rem;
            font-weight: 800;
            color: var(--primary);
        }

        .stat-pill strong { color: var(--text-dark); }

        /* Buttons */
        .btn {
            font-family: var(--font);
            font-size: 0.88rem;
            font-weight: 800;
            padding: 0.65rem 1.2rem;
            border-radius: 12px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            border: none;
            transition: all 0.15s ease;
        }

        .btn-gold {
            background: linear-gradient(180deg, #FBBF24 0%, #F59E0B 100%);
            color: #1E293B;
            box-shadow: 0 3px 0 #D97706, 0 6px 14px rgba(245, 158, 11, 0.25);
        }
        .btn-gold:hover { transform: translateY(-2px); }
        .btn-gold:active { transform: translateY(2px); box-shadow: 0 1px 0 #D97706; }

        .btn-logout {
            background: #F1F5F9;
            color: var(--text-dark);
            border: 1.5px solid var(--border-soft);
        }
        .btn-logout:hover { background: #E2E8F0; }

        .btn-danger-sm {
            background: #FEF2F2;
            border: 1px solid #FECACA;
            color: var(--danger);
            padding: 0.35rem 0.65rem;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 800;
            cursor: pointer;
        }
        .btn-danger-sm:hover { background: var(--danger); color: #FFF; }

        /* Flash Message */
        .alert {
            background: #ECFDF5;
            border: 1.5px solid #A7F3D0;
            color: #065F46;
            padding: 0.85rem 1.25rem;
            border-radius: 14px;
            margin-bottom: 1.5rem;
            font-weight: 700;
            font-size: 0.9rem;
        }

        /* Filter Section Card */
        .filter-card {
            background: #FFFFFF;
            border: 2px solid var(--border-soft);
            border-radius: 20px;
            padding: 1.25rem 1.75rem;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .event-tabs {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .tab-item {
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 800;
            background: #F8FAFC;
            border: 1.5px solid var(--border-soft);
            color: var(--text-muted);
            transition: all 0.15s ease;
        }

        .tab-item:hover { border-color: #93C5FD; color: var(--primary); }

        .tab-item.active {
            background: var(--primary);
            border-color: var(--primary);
            color: #FFFFFF;
        }

        /* Grid Sessions */
        .sessions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .session-card {
            background: #FFFFFF;
            border: 2px solid var(--border-soft);
            border-radius: 20px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
        }

        .session-card:hover {
            border-color: #93C5FD;
            transform: translateY(-4px);
            box-shadow: 0 12px 28px -5px rgba(11, 59, 96, 0.12);
        }

        .session-thumb-box {
            height: 300px;
            background: #0F172A;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem;
            position: relative;
        }

        .session-thumb-img {
            max-height: 100%;
            max-width: 100%;
            border-radius: 8px;
            object-fit: contain;
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.4);
        }

        .session-info {
            padding: 1.1rem;
            display: flex;
            flex-direction: column;
            flex: 1;
            justify-content: space-between;
        }

        .session-code-title {
            font-size: 0.95rem;
            font-weight: 900;
            color: var(--text-dark);
            margin-bottom: 0.25rem;
            word-break: break-all;
        }

        .session-meta-sub {
            font-size: 0.75rem;
            color: var(--text-muted);
            font-weight: 600;
            margin-bottom: 0.75rem;
        }

        .session-chips {
            display: flex;
            gap: 0.4rem;
            flex-wrap: wrap;
            margin-bottom: 0.85rem;
        }

        .chip-sm {
            font-size: 0.7rem;
            font-weight: 800;
            padding: 2px 7px;
            border-radius: 6px;
            background: #EFF6FF;
            color: var(--primary);
            border: 1px solid #BFDBFE;
        }

        .session-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.5rem;
            border-top: 1px solid var(--border-soft);
            padding-top: 0.85rem;
            margin-top: auto;
        }

        .link-guest {
            font-size: 0.78rem;
            font-weight: 800;
            color: var(--primary);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .link-guest:hover { text-decoration: underline; }

        .empty-box {
            text-align: center;
            padding: 4rem 2rem;
            background: #FFFFFF;
            border: 2px dashed var(--border-strong);
            border-radius: 20px;
            color: var(--text-muted);
        }

        .empty-title { font-size: 1.2rem; font-weight: 800; color: var(--text-dark); margin-bottom: 0.4rem; }

        .icon-svg {
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

    <!-- Topbar -->
    <div class="topbar">
        <div class="brand-wrap">
            <div class="brand-icon">
                <svg class="icon-svg" width="22" height="22" viewBox="0 0 24 24"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
            </div>
            <div>
                <h1 class="brand-title">Admin Photobooth Platform</h1>
                <p class="brand-sub">Kelola arsip sesi foto & unduh backup galeri acara</p>
            </div>
        </div>

        <div class="topbar-actions">
            <span class="stat-pill">Total Sesi: <strong>{{ $totalSessions }}</strong></span>
            <span class="stat-pill">Total Foto: <strong>{{ $totalPhotos }}</strong></span>

            <form method="POST" action="{{ route('admin.logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-logout">Logout</button>
            </form>
        </div>
    </div>

    @if (session('success'))
    <div class="alert">
        {{ session('success') }}
    </div>
    @endif

    <!-- Filter Card & Backup Action -->
    <div class="filter-card">
        <div class="event-tabs">
            <a href="{{ route('admin.dashboard') }}" class="tab-item {{ empty($selectedEventId) ? 'active' : '' }}">Semua Acara</a>
            @foreach ($events as $ev)
            <a href="{{ route('admin.dashboard', ['event_id' => $ev->id]) }}" class="tab-item {{ $selectedEventId == $ev->id ? 'active' : '' }}">
                {{ $ev->name }} ({{ $ev->photo_sessions_count }})
            </a>
            @endforeach
        </div>

        @php
            $activeEvent = $selectedEventId ? $events->firstWhere('id', $selectedEventId) : $events->first();
        @endphp

        @if ($activeEvent && $activeEvent->photo_sessions_count > 0)
        <div>
            <a href="{{ route('admin.backup.event', ['eventId' => $activeEvent->id]) }}" class="btn btn-gold" title="Download seluruh foto polaroid dan foto satuan dalam satu file ZIP">
                <svg class="icon-svg" width="16" height="16" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Download Backup Galeri (ZIP) untuk Drive
            </a>
        </div>
        @endif
    </div>

    <!-- Sessions Grid -->
    @if ($sessions->isEmpty())
    <div class="empty-box">
        <h3 class="empty-title">Belum ada sesi foto yang tersimpan</h3>
        <p>Jalankan sesi foto di mesin Photobooth. Foto akan otomatis terkirim dan muncul di sini.</p>
    </div>
    @else
    <div class="sessions-grid">
        @foreach ($sessions as $session)
        @php
            $strip = $session->stripPhoto;
            $singlesCount = $session->photos->where('type', 'single')->count();
        @endphp
        <div class="session-card">
            <div class="session-thumb-box">
                @if ($strip)
                    <img src="{{ $strip->url }}" alt="{{ $session->session_code }}" class="session-thumb-img" loading="lazy" />
                @else
                    <div style="color: #64748B; font-size: 0.8rem;">No Strip Image</div>
                @endif
            </div>

            <div class="session-info">
                <div>
                    <div class="session-code-title">{{ $session->session_code }}</div>
                    <div class="session-meta-sub">
                        {{ $session->event->name ?? 'Acara' }} &bull; {{ $session->created_at->format('d/m/Y H:i') }}
                    </div>

                    <div class="session-chips">
                        <span class="chip-sm">{{ $singlesCount }} Foto Pose</span>
                        @if ($session->user_email)
                        <span class="chip-sm">{{ $session->user_email }}</span>
                        @endif
                    </div>
                </div>

                <div class="session-actions">
                    <a href="{{ route('guest.session', ['slug' => $session->slug]) }}" target="_blank" class="link-guest">
                        Buka Halaman HP
                        <svg class="icon-svg" width="12" height="12" viewBox="0 0 24 24"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                    </a>

                    <form method="POST" action="{{ route('admin.session.delete', ['id' => $session->id]) }}" onsubmit="return confirm('Yakin ingin menghapus sesi foto ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-danger-sm">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div style="margin-top: 1.5rem;">
        {{ $sessions->links() }}
    </div>
    @endif

</div>

</body>
</html>
