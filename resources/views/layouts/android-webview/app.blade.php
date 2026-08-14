<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<!--

  Name              : Kencana Arena – Android WebView
  Version           : 1.0
  Date              : Agustus 2026
  Note              : Layout khusus untuk WebView Super App Pekanbaru

-->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="robots" content="noindex, nofollow">
    <meta name="theme-color" content="#ffffff">
    <title>{{ isset($title) ? $title . ' — ' . config('app.name') : config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        /* ── Clean white base untuk WebView ── */
        html, body {
            background: #ffffff !important;
            min-height: 100dvh;
            overscroll-behavior-y: none;
        }
        /* Safe-area agar konten tidak tertutup notch / system bar */
        #webview-root {
            padding-top: env(safe-area-inset-top);
            padding-bottom: env(safe-area-inset-bottom);
            min-height: 100dvh;
        }
        /* Hide native scrollbar in webview */
        ::-webkit-scrollbar { display: none; }
        * { scrollbar-width: none; }
    </style>
</head>

<body class="bg-white antialiased">
    <div id="webview-root">
        {{ $slot }}
    </div>

    @livewireScripts
    @stack('scripts')
</body>

</html>
