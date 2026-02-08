<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<!--

  Name              : AMAN Arena
  Version           : 1.0
  Date              : Februari 01, 2026
  Url               : amanarena.pekanbaru.go.id
  Type              : Web APP
  Project Analyst   : Deni Hidayat
  Frontend          : M. Jundi Al faruqi
  Backend           : Fadel Setiawan

  ============================================================================
  NOTE :
  Website ini dibuat oleh tim DISKOMINFOTIKSAN Pekanbaru.
  ============================================================================

-->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ isset($title) ? $title . ' - ' . config('app.name') : config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>

<body>
    {{ $slot }}

    @livewireScripts
</body>

</html>
