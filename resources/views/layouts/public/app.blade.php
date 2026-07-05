<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<!--

  Name              : Kencana Arena
  Version           : 1.0
  Date              : Februari 01, 2026
  Url               : kencana.pekanbaru.go.id

  ============================================================================
  NOTE :
  Website ini dikembangkan oleh tim DISKOMINFOTIKSAN Kota Pekanbaru.
  ============================================================================

-->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {!! seo() !!}

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
    @include('layouts.public.app-scripts')

</head>

<body>
    <div data-theme="chaotictoast" class="min-h-screen bg-base-200 relative overflow-x-hidden">

        <div class="relative z-10 flex flex-col min-h-screen">
            <div id="navbar"
                class="navbar bg-base-200 fixed top-0 inset-x-0 z-50 px-4 sm:px-12 md:px-24 lg:px-48 xl:px-70 py-3 border-b border-info/5 transition-transform duration-300">
                <div class="navbar-start">
                    <a href="/" wire:navigate class="flex items-center gap-1.5 sm:gap-2 group cursor-pointer">
                        <div class="shrink-0">
                            <img src="{{ asset('assets/images/logo/logo-kencana-mini-soccer.webp') }}" alt="Logo"
                                class="h-10 w-10 sm:h-10 sm:w-10 object-contain">
                        </div>
                        <div class="flex flex-col leading-none">
                            <span id="aman-text" wire:ignore
                                class="text-[21.4px] sm:text-[24.3px] font-black italic tracking-tighter uppercase text-base-content group-hover:text-info transition-colors min-w-25">
                                Kencana
                            </span>
                            <span
                                class="text-[11px] sm:text-[12px] font-black uppercase text-warning tracking-[0.2em] -mt-0.2 sm:-mt-0.2 transform -skew-x-12">
                                Arena
                            </span>
                        </div>
                    </a>
                </div>

                <div class="navbar-end">
                    <div class="flex items-center gap-2">
                        <a href="/booking" wire:navigate
                            class="btn btn-ghost btn-xs sm:btn-sm uppercase font-bold px-4 sm:px-6 shadow-lg">
                            <span class="flex items-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2.5" stroke="currentColor" class="size-3.5 sm:size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                </svg>
                                Pesan
                            </span>
                        </a>
                    </div>
                </div>
            </div>

            <main class="grow container-xl px-4 pt-21 pb-18 sm:pt-22 sm:px-12 md:px-24 lg:px-48 xl:px-70 sm:pb-25">
                {{ $slot }}
            </main>

            <div
                class="dock dock-md sm:dock-xl bg-base-200 border-t border-info/5 h-16 sm:h-20 pb-safe z-50 transition-all duration-1000 sm:bottom-6 sm:left-1/2 sm:right-auto sm:-translate-x-1/2 sm:w-max sm:rounded-full sm:border sm:border-base-300 sm:shadow-2xl sm:px-8 sm:pb-0 gap-2 sm:gap-6">
                <a wire:navigate href="/" wire:current.exact="text-info !opacity-100 !border-none"
                    class="hover:text-info opacity-70 hover:opacity-100 transition-all duration-700 group relative flex flex-col items-center justify-center">
                    <svg class="size-5 sm:size-5 transition-transform duration-700 group-hover:scale-110 {{ request()->is('/') ? 'scale-110' : '' }}"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="{{ request()->is('/') ? '2.5' : '2' }}">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span class="dock-label text-[8px] sm:text-[9px] font-bold uppercase tracking-wider">
                        Home
                    </span>
                </a>

                <a wire:navigate href="/booking" wire:current="text-info !opacity-100 !border-none"
                    class="hover:text-info opacity-70 hover:opacity-100 transition-all duration-700 group relative flex flex-col items-center justify-center">
                    <svg class="size-5 sm:size-5 transition-transform duration-700 group-hover:scale-110 {{ request()->is('booking*') ? 'scale-110' : '' }}"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="{{ request()->is('booking*') ? '2.5' : '2' }}">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="dock-label text-[8px] sm:text-[9px] font-bold uppercase tracking-wider">
                        Booking
                    </span>
                </a>

                <a wire:navigate href="{{ route('lapangan') }}" wire:current="text-info !opacity-100 !border-none"
                    class="hover:text-info opacity-70 hover:opacity-100 transition-all duration-700 group relative flex flex-col items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="{{ request()->is('store*') ? '2.5' : '2' }}" stroke="currentColor"
                        class="size-5 sm:size-5 transition-transform duration-700 group-hover:scale-110 {{ request()->is('store*') ? 'scale-110' : '' }}">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.59 14.37a6 6 0 0 1-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 0 0 6.16-12.12A14.98 14.98 0 0 0 9.631 8.41m5.96 5.96a14.926 14.926 0 0 1-5.841 2.58m-.119-8.54a6 6 0 0 0-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 0 0-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 0 1-2.448-2.448 14.9 14.9 0 0 1 .06-.312m-2.24 2.39a4.493 4.493 0 0 0-1.757 4.306 4.493 4.493 0 0 0 4.306-1.758M16.5 9a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                    </svg>
                    <span class="dock-label text-[8px] sm:text-[9px] font-bold uppercase tracking-wider">Arena</span>
                </a>

                <a wire:navigate href="/booking-history" wire:current="text-info !opacity-100 !border-none"
                    class="hover:text-info opacity-70 hover:opacity-100 transition-all duration-700 group relative flex flex-col items-center justify-center">
                    <svg class="size-5 sm:size-5 transition-transform duration-700 group-hover:scale-110 {{ request()->is('booking-history*') ? 'scale-110' : '' }}"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="{{ request()->is('booking-history*') ? '2.5' : '2' }}">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="dock-label text-[8px] sm:text-[9px] font-bold uppercase tracking-wider">
                        History
                    </span>
                </a>

                <a wire:navigate href="/profile" wire:current="text-info !opacity-100 !border-none"
                    class="hover:text-info opacity-70 hover:opacity-100 transition-all duration-700 group relative flex flex-col items-center justify-center">
                    <svg class="size-5 sm:size-5 transition-transform duration-700 group-hover:scale-110 {{ request()->is('login*') || request()->is('profile*') ? 'scale-110' : '' }}"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="{{ request()->is('login*') || request()->is('profile*') ? '2.5' : '2' }}">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span class="dock-label text-[8px] sm:text-[9px] font-bold uppercase tracking-wider">
                        Profile
                    </span>
                </a>
            </div>
        </div>
    </div>
    <livewire:public::public.auth-status-popup />
    <div id="global-toast" class="toast toast-top toast-center z-60 rounded-2xl" wire:ignore>
    </div>
    @livewireScripts

</body>

</html>
