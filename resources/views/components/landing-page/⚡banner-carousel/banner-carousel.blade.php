<div class="mt-8 sm:mt-12" wire:init="load">
    @if ($ready)
        <div class="flex flex-col gap-4 sm:gap-6" wire:transition>
            <!-- Section Header -->
            <div class="px-2">
                <h3 class="text-xl sm:text-2xl font-black italic uppercase tracking-tighter text-base-content">
                    Special <span class="text-info">Promos</span>
                </h3>
                <p
                    class="text-[10px] sm:text-xs font-medium text-base-content/60 uppercase tracking-widest mt-0.5 sm:mt-1">
                    Don't miss our latest offers
                </p>
            </div>

            <!-- Banner Carousel with Indicators -->
            <div class="relative w-full group">
                <div class="carousel w-full rounded-2xl sm:rounded-3xl shadow-2xl aspect-video sm:aspect-21/9">
                    <!-- Banner 1 -->
                    <div id="banner1" class="carousel-item relative w-full overflow-hidden">
                        <img src="{{ asset('assets/images/landing-pages/banners/gb-1.jpg') }}"
                            class="w-full h-full object-cover" alt="Special Promo 1" />
                        <div class="absolute inset-0 bg-linear-to-r from-black/80 via-black/40 to-transparent"></div>
                        <div class="absolute inset-0 flex flex-col justify-center px-6 sm:px-12 gap-1 sm:gap-2">
                            <span
                                class="bg-info text-info-content text-[10px] sm:text-xs font-black uppercase italic px-2 py-1 rounded w-fit">Limited
                                Time</span>
                            <h2 class="text-white text-2xl sm:text-4xl font-black italic uppercase leading-none">
                                Weekend<br>Warriors</h2>
                            <p
                                class="text-white/80 text-[10px] sm:text-sm max-w-50 sm:max-w-md font-medium leading-relaxed">
                                Dapatkan diskon 20% untuk penyewaan lapangan di hari Sabtu & Minggu pagi. Mulai harimu
                                dengan energi!</p>
                        </div>
                    </div>

                    <!-- Banner 2 -->
                    <div id="banner2" class="carousel-item relative w-full overflow-hidden">
                        <img src="{{ asset('assets/images/landing-pages/banners/gb-2.jpg') }}"
                            class="w-full h-full object-cover" alt="Special Promo 2" />
                        <div class="absolute inset-0 bg-linear-to-r from-black/80 via-black/40 to-transparent"></div>
                        <div class="absolute inset-0 flex flex-col justify-center px-6 sm:px-12 gap-1 sm:gap-2">
                            <span
                                class="bg-info text-info-content text-[10px] sm:text-xs font-black uppercase italic px-2 py-1 rounded w-fit">New
                                Member</span>
                            <h2 class="text-white text-2xl sm:text-4xl font-black italic uppercase leading-none">Join
                                The<br>Community</h2>
                            <p
                                class="text-white/80 text-[10px] sm:text-sm max-w-50 sm:max-w-md font-medium leading-relaxed">
                                Daftar sekarang dan nikmati gratis 1 jam bermain untuk booking pertama Anda. Mari
                                bertanding!</p>
                        </div>
                    </div>

                    <!-- Banner 3 -->
                    <div id="banner3" class="carousel-item relative w-full overflow-hidden">
                        <img src="{{ asset('assets/images/landing-pages/banners/gb-3.jpg') }}"
                            class="w-full h-full object-cover" alt="Special Promo 3" />
                        <div class="absolute inset-0 bg-linear-to-r from-black/80 via-black/40 to-transparent"></div>
                        <div class="absolute inset-0 flex flex-col justify-center px-6 sm:px-12 gap-1 sm:gap-2">
                            <span
                                class="bg-info text-info-content text-[10px] sm:text-xs font-black uppercase italic px-2 py-1 rounded w-fit">Night
                                Session</span>
                            <h2 class="text-white text-2xl sm:text-4xl font-black italic uppercase leading-none">
                                Midnight<br>Match</h2>
                            <p
                                class="text-white/80 text-[10px] sm:text-sm max-w-50 sm:max-w-md font-medium leading-relaxed">
                                Main malam lebih seru dengan fasilitas lampu standar internasional dan harga lebih
                                hemat.</p>
                        </div>
                    </div>

                    <!-- Banner 4 -->
                    <div id="banner4" class="carousel-item relative w-full overflow-hidden">
                        <img src="{{ asset('assets/images/landing-pages/banners/gb-4.jpg') }}"
                            class="w-full h-full object-cover" alt="Special Promo 4" />
                        <div class="absolute inset-0 bg-linear-to-r from-black/80 via-black/40 to-transparent"></div>
                        <div class="absolute inset-0 flex flex-col justify-center px-6 sm:px-12 gap-1 sm:gap-2">
                            <span
                                class="bg-info text-info-content text-[10px] sm:text-xs font-black uppercase italic px-2 py-1 rounded w-fit">Facility</span>
                            <h2 class="text-white text-2xl sm:text-4xl font-black italic uppercase leading-none">
                                Professional<br>Standard</h2>
                            <p
                                class="text-white/80 text-[10px] sm:text-sm max-w-50 sm:max-w-md font-medium leading-relaxed">
                                Nikmati pengalaman bermain di arena dengan standar kompetisi dan fasilitas lengkap.</p>
                        </div>
                    </div>
                </div>

                <!-- Indicators -->
                <div class="flex justify-center w-full py-3 gap-2 absolute bottom-2 sm:bottom-4 z-20">
                    <a href="#banner1"
                        class="w-2 sm:w-8 h-1 sm:h-1.5 rounded-full bg-white/30 hover:bg-info transition-all active:bg-info"></a>
                    <a href="#banner2"
                        class="w-2 sm:w-8 h-1 sm:h-1.5 rounded-full bg-white/30 hover:bg-info transition-all active:bg-info"></a>
                    <a href="#banner3"
                        class="w-2 sm:w-8 h-1 sm:h-1.5 rounded-full bg-white/30 hover:bg-info transition-all active:bg-info"></a>
                    <a href="#banner4"
                        class="w-2 sm:w-8 h-1 sm:h-1.5 rounded-full bg-white/30 hover:bg-info transition-all active:bg-info"></a>
                </div>

                <!-- Navigation Buttons (Desktop only) -->
                <div
                    class="hidden sm:flex absolute inset-y-0 left-4 right-4 items-center justify-between pointer-events-none opacity-0 group-hover:opacity-100 transition-opacity">
                    <button
                        class="btn btn-circle btn-sm bg-black/20 border-none text-white pointer-events-auto hover:bg-info"
                        onclick="document.querySelector('.carousel').scrollBy({left: -window.innerWidth, behavior: 'smooth'})">❮</button>
                    <button
                        class="btn btn-circle btn-sm bg-black/20 border-none text-white pointer-events-auto hover:bg-info"
                        onclick="document.querySelector('.carousel').scrollBy({left: window.innerWidth, behavior: 'smooth'})">❯</button>
                </div>
            </div>
        </div>
    @else
        <!-- Skeleton Loading -->
        <div class="flex flex-col gap-4 sm:gap-6 animate-pulse">
            <div class="px-2">
                <div class="h-6 sm:h-8 bg-base-300 w-32 sm:w-48 rounded-lg"></div>
                <div class="h-3 bg-base-300 w-48 sm:w-64 mt-2 rounded-lg"></div>
            </div>
            <div class="w-full aspect-video sm:aspect-21/9 bg-base-300 rounded-2xl sm:rounded-3xl"></div>
        </div>
    @endif
</div>
