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
        html,
        body {
            background: #ffffff !important;
            height: 100dvh;
            min-height: 100dvh;
            max-height: 100dvh;
            overflow: hidden;
            overscroll-behavior-y: none;
            font-family: Arial, Helvetica, sans-serif !important;
        }

        /* Safe-area agar konten tidak tertutup notch / system bar */
        #webview-root {
            padding-top: env(safe-area-inset-top, 0px);
            padding-bottom: env(safe-area-inset-bottom, 0px);
            height: 100dvh;
            max-height: 100dvh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            box-sizing: border-box;
        }

        /* ── Custom Primary Color #165dfc ── */
        :root {
            --color-blue-600: #165dfc !important;
            --color-blue-500: #165dfc !important;
        }

        .bg-blue-600 {
            background-color: #165dfc !important;
        }

        .text-blue-600 {
            color: #165dfc !important;
        }

        .border-blue-600 {
            border-color: #165dfc !important;
        }

        .shadow-blue-200 {
            box-shadow: 0 10px 25px -5px rgba(22, 93, 252, 0.28), 0 8px 10px -6px rgba(22, 93, 252, 0.2) !important;
        }

        .accent-blue-600 {
            accent-color: #165dfc !important;
        }

        /* Hide native scrollbar in webview */
        ::-webkit-scrollbar {
            display: none;
        }

        * {
            scrollbar-width: none;
        }
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
