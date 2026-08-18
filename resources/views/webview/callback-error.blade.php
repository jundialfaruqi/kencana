<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="theme-color" content="#ffffff">
    <title>Verifikasi Gagal — {{ config('app.name') }}</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #fff;
            min-height: 100dvh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .wrap {
            text-align: center;
            max-width: 340px;
            width: 100%;
        }

        .icon {
            width: 72px;
            height: 72px;
            background: #fff3f3;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 20px;
            font-weight: 800;
            color: #111;
            margin-bottom: 8px;
        }

        .subtitle {
            font-size: 14px;
            color: #6b7280;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .error-box {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 14px;
            padding: 14px 16px;
            text-align: left;
        }

        .error-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #ef4444;
            margin-bottom: 4px;
        }

        .error-msg {
            font-size: 13px;
            color: #b91c1c;
            line-height: 1.5;
        }

        .hint {
            margin-top: 20px;
            font-size: 12px;
            color: #9ca3af;
            line-height: 1.6;
        }
    </style>
</head>

<body>
    <div class="wrap">
        <div class="icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none" viewBox="0 0 24 24"
                stroke="#ef4444" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
            </svg>
        </div>
        <h1>Verifikasi Gagal</h1>
        <div class="error-box">
            <div class="error-msg">{{ $message ?? 'Verifikasi SSO gagal.' }}</div>
            @if (!empty($ssoMessage))
                <div class="error-msg" style="margin-top:6px; color:#9ca3af;">{{ $ssoMessage }}</div>
            @endif
        </div>
        <p class="hint">Silakan kembali ke aplikasi dan coba buka menu Kencana Arena kembali.</p>
    </div>
</body>

</html>
