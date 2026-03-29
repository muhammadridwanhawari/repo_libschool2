<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Kata Sandi - LibSchool</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: #f1f5f9;
            color: #334155;
            padding: 40px 16px;
        }
        .wrapper {
            max-width: 560px;
            margin: 0 auto;
        }
        .logo-wrap {
            text-align: center;
            margin-bottom: 28px;
        }
        .logo-wrap img {
            height: 56px;
            width: auto;
        }
        .card {
            background: #ffffff;
            border-radius: 16px;
            padding: 40px 40px 36px;
            box-shadow: 0 4px 24px rgba(99, 102, 241, 0.10);
            border: 1px solid #e0e7ff;
        }
        .badge {
            display: inline-block;
            background: #eef2ff;
            color: #4f46e5;
            font-size: 12px;
            font-weight: 700;
            padding: 5px 14px;
            border-radius: 999px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-bottom: 20px;
        }
        h1 {
            font-size: 22px;
            font-weight: 800;
            color: #1e1b4b;
            margin-bottom: 12px;
        }
        p {
            font-size: 15px;
            color: #475569;
            line-height: 1.7;
            margin-bottom: 14px;
        }
        .btn-wrap {
            text-align: center;
            margin: 32px 0 28px;
        }
        .btn {
            display: inline-block;
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            color: #ffffff !important;
            text-decoration: none;
            padding: 14px 36px;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 700;
            letter-spacing: 0.3px;
            box-shadow: 0 4px 14px rgba(99, 102, 241, 0.35);
        }
        .divider {
            border: none;
            border-top: 1px solid #e2e8f0;
            margin: 28px 0;
        }
        .url-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 12px;
            color: #64748b;
            word-break: break-all;
            line-height: 1.6;
        }
        .url-box a {
            color: #4f46e5;
            text-decoration: underline;
        }
        .warning {
            background: #fff7ed;
            border: 1px solid #fed7aa;
            border-left: 4px solid #f97316;
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 13px;
            color: #9a3412;
            margin-top: 20px;
            line-height: 1.6;
        }
        .footer {
            text-align: center;
            margin-top: 28px;
            font-size: 12px;
            color: #94a3b8;
            line-height: 1.8;
        }
        .footer strong {
            color: #64748b;
        }
    </style>
</head>
<body>
    <div class="wrapper">

        {{-- Logo --}}
        <div class="logo-wrap">
            <img src="{{ asset('images/logo/LogoBlack.png') }}" alt="LibSchool">
        </div>

        <div class="card">
            <span class="badge">🔒 Keamanan Akun</span>

            <h1>Reset Kata Sandi</h1>

            <p>Halo, <strong>{{ $user->name ?? $user->username }}</strong>!</p>

            <p>
                Kami menerima permintaan untuk mereset kata sandi akun LibSchool Anda.
                Klik tombol di bawah ini untuk membuat kata sandi baru.
            </p>

            <div class="btn-wrap">
                <a href="{{ $resetUrl }}" class="btn">
                    🔑 &nbsp; Reset Kata Sandi
                </a>
            </div>

            <div class="warning">
                ⏳ <strong>Tautan ini akan kedaluwarsa dalam 60 menit.</strong><br>
                Jika Anda tidak merasa meminta reset kata sandi, abaikan email ini —
                akun Anda tetap aman.
            </div>

            <hr class="divider">

            <p style="font-size: 13px; color: #94a3b8; margin-bottom: 8px;">
                Jika tombol di atas tidak berfungsi, salin dan tempel tautan berikut ke browser Anda:
            </p>
            <div class="url-box">
                <a href="{{ $resetUrl }}">{{ $resetUrl }}</a>
            </div>
        </div>

        <div class="footer">
            Email ini dikirim secara otomatis oleh <strong>LibSchool</strong>.<br>
            Mohon jangan membalas email ini.<br><br>
            &copy; {{ date('Y') }} LibSchool. Hak cipta dilindungi.
        </div>

    </div>
</body>
</html>
