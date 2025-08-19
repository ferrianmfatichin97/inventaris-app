<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Sistem Inventaris - Bank DP Taspen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        :root { color-scheme: light; }
        body{
            margin:0; padding:0; min-height:100vh;
            background:#003f5c url('https://bankdptaspen.co.id/wp-content/uploads/2024/07/Banner-Website-paralax-1366-x-768-piksel.jpg') no-repeat center/cover;
            position:relative; font-family:system-ui,-apple-system,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans","Liberation Sans",sans-serif;
        }
        /* Overlay gradasi biru transparan */
        body::before{
            content:""; position:absolute; inset:0; background:rgba(0,64,102,.6);
        }
        .welcome-card{
            position:relative; z-index:2; background:rgba(255,255,255,.95);
            border-radius:15px; padding:40px; text-align:center; color:#333;
            box-shadow:0 8px 30px rgba(0,0,0,.3); max-width:460px; width:100%;
            animation:fadeIn 800ms ease;
        }
        .logo{
            width:250px; max-width:100%; height:auto; margin-bottom:20px;
            animation:fadeDown 800ms ease;
        }
        .btn-custom{ padding:12px 24px; font-size:1.05rem; border-radius:8px; }
        footer{
            position:fixed; bottom:15px; width:100%; text-align:center; color:#fff;
            font-size:.9rem; z-index:2;
        }
        @keyframes fadeIn { from{opacity:0; transform:translateY(24px)} to{opacity:1; transform:translateY(0)} }
        @keyframes fadeDown{ from{opacity:0; transform:translateY(-16px)} to{opacity:1; transform:translateY(0)} }
        /* Hormati preferensi reduce motion */
        @media (prefers-reduced-motion: reduce){
            .welcome-card,.logo{ animation:none !important; }
        }
    </style>
</head>
<body class="d-flex flex-column justify-content-center align-items-center">

    <div class="welcome-card">
        <img
            src="https://bankdptaspen.co.id/wp-content/uploads/2024/01/Logo-Bank-DP-Taspen-Version-New.png"
            alt="Logo Bank DP Taspen"
            class="logo"
            loading="lazy"
            width="250"
            height="64"
        >
        <h2 class="mb-3">Sistem Inventaris</h2>

        <p class="mb-4">
            Selamat datang di Sistem Inventaris Bank DP Taspen. Silakan pilih menu di bawah untuk melanjutkan.
        </p>

        <div class="d-grid gap-3">
            {{-- Jika panel Filament kamu bernama "admin", rute login default-nya /admin/login --}}
            <a href="{{ url('/admin/login') }}" class="btn btn-primary btn-custom">Login Pegawai</a>

            {{-- Jika nanti butuh menu publik lain, tinggal aktifkan tombol berikut --}}
            {{--
            <a href="{{ url('/inventaris') }}" class="btn btn-outline-primary btn-custom">Lihat Inventaris</a>
            --}}
        </div>
    </div>

    <footer>
        &copy; {{ date('Y') }} Bank DP Taspen. All rights reserved.
    </footer>

</body>
</html>
