<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="theme-color" content="#ffffff">
    <title>Sesi Berakhir — {{ config('app.name') }}</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #fff;
            min-height: 100dvh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .wrap {
            text-align: center;
            max-width: 320px;
        }

        .icon {
            width: 72px;
            height: 72px;
            background: #fff3f3;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 24px;
        }

        h1 {
            font-size: 20px;
            font-weight: 800;
            color: #111;
            margin-bottom: 10px;
        }

        p {
            font-size: 14px;
            color: #6b7280;
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
        <h1>Sesi Berakhir</h1>
        <p>Verifikasi SSO gagal.<br>Code tidak valid, sudah digunakan, atau sudah kadaluarsa. Silakan kembali ke
            aplikasi dan buka menu Kencana Arena kembali.</p>
    </div>
</body>

</html>
