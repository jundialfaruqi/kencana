<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ isset($title) ? $title . ' - ' . config('app.name') : config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
    <script>
        document.addEventListener('livewire:navigated', () => {
            let lastScrollTop = 0;
            const navbar = document.getElementById('navbar');
            const threshold = 50;

            if (!navbar) return;

            window.addEventListener('scroll', () => {
                let scrollTop = window.pageYOffset || document.documentElement.scrollTop;

                if (scrollTop < 0) scrollTop = 0;

                if (scrollTop > lastScrollTop && scrollTop > threshold) {
                    navbar.style.transform = 'translateY(-100%)';
                } else {
                    navbar.style.transform = 'translateY(0)';
                }

                lastScrollTop = scrollTop;
            });
        });
    </script>
</head>

<body>
    <div data-theme="chaotictoast" class="min-h-screen bg-base-100 relative overflow-x-hidden">
        <!-- Main Background with Smooth Overlay -->
        <div class="fixed inset-0 z-0">
            <img src="{{ asset('assets/images/landing-pages/bg.webp') }}"
                class="w-full h-full object-cover object-top opacity-40 grayscale-[0.3]" alt="Background">
            <div class="absolute inset-0 bg-linear-to-b from-base-100/40 via-base-100/85 to-base-100/95"></div>
        </div>

        <div class="relative z-10 flex flex-col min-h-screen">
            <div id="navbar"
                class="navbar bg-base-100/40 backdrop-blur-md fixed top-0 inset-x-0 z-50 px-5 py-3 border-b border-info/5 transition-transform duration-300">
                <div class="navbar-start">
                    <a href="/" wire:navigate class="flex items-center gap-1.5 sm:gap-2 group cursor-pointer">
                        <div class="shrink-0">
                            <img src="{{ asset('assets/images/logo/logo-kencana-mini-soccer.webp') }}" alt="Logo"
                                class="h-10 w-10 sm:h-10 sm:w-10 object-contain">
                        </div>
                        <div class="flex flex-col leading-none">
                            <span
                                class="text-1xl sm:text-1xl font-black italic tracking-tighter uppercase text-info group-hover:text-base-content transition-colors">
                                Kencana
                            </span>
                            <span
                                class="text-xs font-bold italic tracking-wider uppercase text-base-content -mt-0.2 sm:-mt-0.2">
                                Mini Soccer
                            </span>
                        </div>
                    </a>
                </div>

                <div class="navbar-end">
                    <div class="flex items-center gap-2">
                        <a href="/login" wire:navigate
                            class="btn btn-info btn-xs sm:btn-sm italic uppercase font-bold -skew-x-12 px-4 sm:px-6 shadow-lg shadow-info/20">
                            <span class="skew-x-12">Pesan Arena</span>
                        </a>
                    </div>
                </div>
            </div>

            <main class="grow container-xl px-4 pt-21 pb-18 sm:pt-22 sm:px-6 sm:pb-25">
                {{ $slot }}
            </main>

            <div
                class="dock dock-md sm:dock-xl bg-base-100/40 backdrop-blur-xl border-t border-info/5 h-16 sm:h-20 pb-safe z-50">
                <button class="dock-active text-info group relative">
                    <div
                        class="absolute -top-1 left-1/2 -translate-x-1/2 w-8 h-1 bg-info rounded-full blur-[2px] opacity-50 sm:hidden">
                    </div>
                    <svg class="size-5 sm:size-6 transition-transform group-hover:scale-110"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span
                        class="dock-label text-[8px] sm:text-[9px] font-black italic uppercase tracking-wider">Home</span>
                </button>

                <button class="hover:text-info transition-all group">
                    <svg class="size-5 sm:size-6 transition-transform group-hover:scale-110"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span
                        class="dock-label text-[8px] sm:text-[9px] font-black italic uppercase tracking-wider transition-colors">Booking</span>
                </button>

                <button class="hover:text-info transition-all group">
                    <svg class="size-5 sm:size-6 transition-transform group-hover:scale-110"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <span
                        class="dock-label text-[8px] sm:text-[9px] font-black italic uppercase tracking-wider transition-colors">Store</span>
                </button>

                <button class="hover:text-info transition-all group">
                    <svg class="size-5 sm:size-6 transition-transform group-hover:scale-110"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span
                        class="dock-label text-[8px] sm:text-[9px] font-black italic uppercase tracking-wider transition-colors">History</span>
                </button>

                <button class="hover:text-info transition-all group">
                    <svg class="size-5 sm:size-6 transition-transform group-hover:scale-110"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span
                        class="dock-label text-[8px] sm:text-[9px] font-black italic uppercase tracking-wider transition-colors">Profile</span>
                </button>
            </div>
        </div>
    </div>
    @livewireScripts
</body>

</html>
