<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<!--

  Name              : Kencana Arena
  Version           : 1.0
  Date              : Februari 01, 2026
  Url               : kencana.pekanbaru.go.id

-->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ isset($title) ? $title . ' - ' . config('app.name') : config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>

<body>
    {{ $slot }}

    @livewireScripts
</body>

</html>
