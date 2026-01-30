<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ isset($title) ? $title . ' - ' . config('app.name') : config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles

    <style>
        /* Custom scrollbar for sidebar if needed */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-base-200 font-sans text-base-content">

    <div class="drawer lg:drawer-open">
        <input id="my-drawer" type="checkbox" class="drawer-toggle" />

        <!-- Drawer Content (Main Page) -->
        <div class="drawer-content flex flex-col h-screen overflow-hidden">
            <!-- Top Header -->
            <header class="h-16 bg-base-100 flex items-center justify-between px-6 border-b border-base-200 shrink-0">
                <style>
                    @keyframes bell-ring {

                        0%,
                        100% {
                            transform: rotate(0deg);
                        }

                        5%,
                        15%,
                        25% {
                            transform: rotate(15deg);
                        }

                        10%,
                        20%,
                        30% {
                            transform: rotate(-15deg);
                        }

                        35% {
                            transform: rotate(0deg);
                        }
                    }

                    .animate-bell-ring {
                        animation: bell-ring 2s ease-in-out infinite;
                        transform-origin: top center;
                    }
                </style>
                <div class="flex items-center gap-4">
                    <!-- Hamburger Menu (Mobile Toggle) -->
                    <label for="my-drawer" class="btn btn-square btn-ghost lg:hidden drawer-button">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            class="inline-block w-6 h-6 stroke-current">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16">
                            </path>
                        </svg>
                    </label>
                    <!-- Search -->
                    <div class="form-control hidden sm:block">
                        <div class="input-group">
                            <div class="relative">
                                <input type="text" placeholder="Search"
                                    class="input input-bordered w-full max-w-xs pl-10 h-10 bg-base-100 rounded-full" />
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-base-content/50" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <!-- Notifications -->
                    {{-- <div class="dropdown dropdown-end">
                        <button tabindex="0" class="btn btn-ghost btn-circle btn-sm">
                            <div class="indicator">
                                @if ($dashboardNotifications->count() > 0)
                                    <div class="indicator-item inline-grid *:[grid-area:1/1] scale-75">
                                        <div class="status status-primary animate-ping"></div>
                                        <div class="status status-primary"></div>
                                    </div>
                                @endif
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor"
                                    class="w-5 h-5 @if ($dashboardNotifications->count() > 0) animate-bell-ring @endif">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                                </svg>
                            </div>
                        </button>
                        <div tabindex="0"
                            class="dropdown-content z-1 card card-compact w-80 shadow bg-base-100 border border-base-200 mt-2">
                            <div class="card-body p-3">
                                <div class="flex items-center justify-between mb-1.5">
                                    <h3 class="font-bold text-sm">Notifikasi</h3>
                                    <span
                                        class="badge badge-sm badge-neutral">{{ $dashboardNotifications->count() }}</span>
                                </div>
                                <div class="max-h-80 overflow-y-auto space-y-1 -mx-1 px-1">
                                    @forelse($dashboardNotifications as $notif)
                                        <a href="{{ $notif['url'] }}"
                                            class="flex items-start gap-2 p-2 rounded-lg hover:bg-base-200 transition-colors border border-transparent hover:border-base-300 group">
                                            <div
                                                class="w-8 h-8 rounded-full bg-{{ $notif['color'] }}/10 flex items-center justify-center shrink-0 group-hover:bg-{{ $notif['color'] }}/20">
                                                @if ($notif['icon'] === 'calendar')
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-4 h-4 text-{{ $notif['color'] }}">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                                    </svg>
                                                @elseif($notif['icon'] === 'ticket')
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-4 h-4 text-{{ $notif['color'] }}">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z" />
                                                    </svg>
                                                @else
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-4 h-4 text-{{ $notif['color'] }}">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                                                    </svg>
                                                @endif
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center gap-1 mb-0.5">
                                                    <span
                                                        class="text-[9px] font-bold uppercase tracking-wider text-base-content/40">{{ $notif['category'] }}</span>
                                                    <span
                                                        class="text-[9px] font-bold px-1 rounded-full bg-{{ $notif['color'] }}/10 text-{{ $notif['color'] }}">{{ $notif['type'] }}</span>
                                                </div>
                                                <p class="text-xs font-bold truncate text-base-content">
                                                    {{ $notif['title'] }}
                                                </p>
                                                <p
                                                    class="text-[11px] text-base-content/60 line-clamp-2 mt-0.5 leading-tight">
                                                    {{ $notif['message'] }}</p>
                                            </div>
                                        </a>
                                    @empty
                                        <div class="py-10 text-center">
                                            <div
                                                class="w-12 h-12 rounded-full bg-base-200 flex items-center justify-center mx-auto mb-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-6 h-6 opacity-20">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                                                </svg>
                                            </div>
                                            <p class="text-sm font-medium text-base-content/40">Tidak ada data yang
                                                memerlukan
                                                perhatian</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <!-- Theme Toggle -->
                    <button id="theme-toggle"
                        class="btn btn-circle btn-sm btn-primary hover:bg-base hover:text-base-content">
                        <!-- Sun Icon -->
                        <svg id="sun-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                        </svg>
                        <!-- Moon Icon -->
                        <svg id="moon-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hidden">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
                        </svg>
                    </button>

                    <!-- Divider -->
                    <div class="hidden md:block h-8 border-l border-dotted border-base-content/20"></div>

                    <!-- Date and Time -->
                    <div class="hidden md:flex flex-col items-start leading-tight">
                        <span class="text-xs font-bold text-base-content/80">
                            {{ \Carbon\Carbon::now()->timezone('Asia/Jakarta')->locale('id')->isoFormat('dddd') }}
                        </span>
                        <span class="text-[10px] text-base-content/50">
                            {{ \Carbon\Carbon::now()->timezone('Asia/Jakarta')->locale('id')->isoFormat('D MMMM YYYY') }}
                        </span>
                    </div>
                </div>
            </header>


            <!-- Scrollable Main Content -->
            <main class="flex-1 overflow-y-auto p-6">
                {{ $slot }}
            </main>

            <footer class="footer footer-center p-4 bg-base-100 text-base-content border-t border-base-200 mt-auto">
                <aside>
                    <p>Copyright © {{ date('Y') }} - <span class="font-bold">DISKOMINFOTIKSAN</span></p>
                </aside>
            </footer>
        </div>

        <!-- Sidebar (Drawer Side) -->
        <div class="drawer-side z-50">
            <label for="my-drawer" aria-label="close sidebar" class="drawer-overlay"></label>
            <aside class="menu p-0 w-64 h-full bg-base-100 border-r border-base-300 flex flex-col overflow-hidden">
                <!-- Logo -->
                <div class="h-16 flex items-center px-6 border-b border-base-200 shrink-0">
                    <div class="flex items-center gap-2 text-secondary font-bold text-2xl group">
                        <img src="{{ asset('assets/images/logo/logo-kencana-mini-soccer.webp') }}" alt="Logo"
                            class="h-10 w-10 sm:h-10 sm:w-10 object-contain">
                        <div class="flex flex-col">
                            <span
                                class="font-black italic tracking-tighter uppercase text-base-content group-hover:text-base-content transition-colors leading-none">AMAN</span>
                            <span
                                class="text-[10px] font-bold italic tracking-widest uppercase text-base-content/50 group-hover:text-base-content/70 transition-colors leading-none">Arena</span>
                        </div>
                    </div>
                </div>

                <!-- Scrollable Navigation -->
                <div class="flex-1 overflow-y-auto no-scrollbar py-4">
                    <ul class="menu w-full px-4 gap-1">
                        <li class="menu-title text-xs font-semibold opacity-50 uppercase mb-1">Overview</li>

                        <li>
                            <a wire:navigate href="/dashboard"
                                class="{{ request()->is('dashboard*') ? 'active bg-base-300 text-base-content font-medium' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                                </svg>
                                Dashboard
                            </a>
                        </li>

                        <li class="menu-title text-xs font-semibold opacity-50 uppercase mt-4 mb-1">Apps</li>
                        {{-- @can('view-agenda') --}}
                        <li>
                            <a wire:navigate href="#"
                                class="{{ request()->routeIs('agenda.*') ? 'active bg-base-200 text-base-content font-medium' : '' }} flex flex-col items-start gap-0.5">
                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12V12.75zm3 0h.008v.008H15V12.75zm0 3h.008v.008H15v-.008zm-3 0h.008v.008H12v-.008zm-3 0h.008v.008H9v-.008zm0-3h.008v.008H9V12.75z" />
                                    </svg>
                                    <span>Agenda</span>
                                </div>
                                <span class="text-[8px] text-base-content opacity-50 ml-7">Manajemen agenda dan absensi
                                    digital</span>
                            </a>
                        </li>
                        {{-- @endcan --}}

                        {{-- @can('view-event') --}}
                        <li>
                            <a wire:navigate href="#"
                                class="{{ request()->routeIs('event.*') ? 'active bg-base-300 text-base-content font-medium' : '' }} flex flex-col items-start gap-0.5">
                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                    </svg>
                                    <span>Event</span>
                                </div>
                                <span class="text-[8px] text-base-content opacity-50 ml-7">Manajemen publikasi kegiatan
                                    dan
                                    event</span>
                            </a>
                        </li>
                        {{-- @endcan --}}

                        {{-- @can('view-survey') --}}
                        <li>
                            <a wire:navigate href="#"
                                class="{{ request()->routeIs('survey.*') ? 'active bg-base-200 text-base-content font-medium' : '' }} flex flex-col items-start gap-0.5">
                                <div class="flex items-center gap-2 w-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0 1 18 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3 1.5 1.5 3-3.75" />
                                    </svg>
                                    <span>Survei</span>
                                    <span class="badge badge-primary badge-sm ml-auto">New</span>
                                </div>
                                <span class="text-[8px] text-base-content opacity-50 ml-7">Manajemen survei dan
                                    feedback
                                    masyarakat</span>
                            </a>
                        </li>
                        {{-- @endcan --}}

                        {{-- @can('view-dokumentasi') --}}
                        <li>
                            <a wire:navigate href="#"
                                class="{{ request()->routeIs('dokumentasi.*') ? 'active bg-base-200 text-base-content font-medium' : '' }} flex flex-col items-start gap-0.5">
                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                    </svg>
                                    <span>Dokumentasi</span>
                                </div>
                                <span class="text-[8px] text-base-content opacity-50 ml-7">Manajemen dokumentasi
                                    Rapat</span>
                            </a>
                        </li>
                        {{-- @endcan --}}

                        <li class="menu-title text-xs font-semibold opacity-50 uppercase mt-4 mb-1">Settings</li>

                        {{-- @role(['super-admin', 'admin']) --}}
                        <li>
                            <details
                                {{ request()->is('manajemen-user*') || request()->is('user-detail*') || request()->routeIs('role_permission.*') ? 'open' : '' }}>
                                <summary class="group">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                    </svg>
                                    User
                                </summary>
                                <ul>
                                    <li>
                                        <a wire:navigate href="/manajemen-user"
                                            class="{{ request()->is('manajemen-user*') || request()->is('user-detail*') ? 'active bg-base-300 text-base-content font-medium' : '' }}">
                                            Manajemen User
                                        </a>
                                    </li>
                                </ul>
                            </details>
                        </li>
                        {{-- @endrole --}}

                        {{-- @can('view-master-opd') --}}
                        <li>
                            <a href="#"
                                class="{{ request()->routeIs('opd.*') ? 'active bg-base-200 text-base-content font-medium' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
                                </svg>

                                Master OPD
                            </a>
                        </li>
                        {{-- @endcan --}}

                        {{-- @can('view-master-pakaian') --}}
                        <li>
                            <details
                                {{ request()->routeIs('kategori-pakaian.*') || request()->routeIs('pakaian.*') ? 'open' : '' }}>
                                <summary class="group">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                    </svg>
                                    Master Pakaian
                                </summary>
                                <ul>
                                    <li>
                                        <a wire:navigate href="#"
                                            class="{{ request()->routeIs('kategori-pakaian.*') ? 'active bg-base-200 text-base-content font-medium' : '' }}">
                                            Kategori Pakaian
                                        </a>
                                    </li>
                                    <li>
                                        <a wire:navigate href="#"
                                            class="{{ request()->routeIs('pakaian.*') ? 'active bg-base-200 text-base-content font-medium' : '' }}">
                                            Pakaian
                                        </a>
                                    </li>
                                </ul>
                            </details>
                        </li>
                        {{-- @endcan --}}
                        <li class="mt-4">
                            <a class="text-primary font-medium">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 7.5l-2.25-1.313M21 7.5v2.25m0-2.25l-2.25 1.313M3 7.5l2.25-1.313M3 7.5l2.25 1.313M3 7.5v2.25m9 3l2.25-1.313M12 12.75l-2.25-1.313M12 12.75V15m0 6.75l2.25-1.313M12 21.75V19.5m0 2.25l-2.25-1.313m0-16.875L12 2.25l2.25 1.313M21 14.25v2.25l-2.25 1.313m-13.5 0L3 16.5v-2.25" />
                                </svg>
                                Cashier
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- User Profile (Bottom Sidebar) -->
                <div class="p-4 border-t border-base-200 shrink-0">
                    <div class="flex items-center gap-3">
                        <div class="avatar">
                            <div class="w-10 rounded-full">
                                <img
                                    src="{{ auth()->user()->photo_url ?? 'https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp' }}" />
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold truncate">
                                {{-- {{ auth()->user()->name }} --}}
                                Super Admin
                            </p>
                            <p class="text-xs text-base-content/60 truncate">
                                {{-- {{ auth()->user()->email }} --}}
                                superadmin@mail.com
                            </p>
                        </div>
                        <div class="dropdown dropdown-end dropdown-top">
                            <label tabindex="0" class="btn btn-ghost btn-xs btn-circle">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                </svg>
                            </label>
                            <ul tabindex="0"
                                class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-40 border border-base-200">
                                <li class="{{ request()->routeIs('profile') ? 'bg-primary/10 rounded-lg' : '' }}">
                                    <a href="#"
                                        class="{{ request()->routeIs('profile') ? 'text-primary font-medium' : '' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                        </svg>
                                        Profile
                                    </a>
                                </li>
                                <li>
                                    @csrf
                                    <button type="button" onclick="logout_modal_profile.showModal()"
                                        class="flex items-center gap-2 cursor-pointer w-full text-left">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M5.636 5.636a9 9 0 1 0 12.728 0M12 3v9" />
                                        </svg>
                                        Logout
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </aside>

        </div>

    </div>
    @livewireScripts
    <script>
        (function() {
            function setIcons(theme) {
                var sun = document.getElementById('sun-icon');
                var moon = document.getElementById('moon-icon');
                if (!sun || !moon) return;
                if (theme === 'chaotictoast') {
                    sun.classList.add('hidden');
                    moon.classList.remove('hidden');
                } else {
                    sun.classList.remove('hidden');
                    moon.classList.add('hidden');
                }
            }

            function init() {
                var body = document.body;
                var saved = localStorage.getItem('adminTheme');
                var current = saved || body.getAttribute('data-theme') || 'goldcandy';
                body.setAttribute('data-theme', current);
                setIcons(current);
                var btn = document.getElementById('theme-toggle');
                if (btn && !btn.__bound) {
                    btn.addEventListener('click', function() {
                        var now = body.getAttribute('data-theme') || 'goldcandy';
                        var next = now === 'goldcandy' ? 'chaotictoast' : 'goldcandy';
                        body.setAttribute('data-theme', next);
                        localStorage.setItem('adminTheme', next);
                        setIcons(next);
                    });
                    btn.__bound = true;
                }
            }
            document.addEventListener('DOMContentLoaded', init);
            document.addEventListener('livewire:navigated', init);
        })();
    </script>
    <livewire:admin::logout />
    {{-- <script src="{{ asset('js/global-loading.js') }}"></script>
    <script src="{{ asset('js/theme-toggle.js') }}"></script>
    @stack('scripts') --}}
</body>

</html>
