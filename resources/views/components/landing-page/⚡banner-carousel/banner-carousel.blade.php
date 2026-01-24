<div id="banner-carousel-root" class="mt-8 sm:mt-12" wire:init="load" wire:transition>
    @if (!$readyToLoad)
        <div class="flex flex-col gap-4 sm:gap-6 animate-pulse">
            <!-- Skeleton Header -->
            <div class="px-2">
                <div class="h-6 sm:h-8 bg-base-300 w-32 sm:w-48 rounded-lg mb-2"></div>
                <div class="h-3 sm:h-4 bg-base-300 w-48 sm:w-64 rounded-lg"></div>
            </div>

            <!-- Skeleton Carousel -->
            <div class="relative w-full">
                <div class="w-full bg-base-300 rounded-2xl sm:rounded-3xl aspect-video sm:aspect-21/9 shadow-2xl"></div>

                <!-- Skeleton Indicators -->
                <div class="flex justify-center w-full py-3 gap-2 absolute bottom-2 sm:bottom-4">
                    <div class="w-2 sm:w-8 h-1 sm:h-1.5 rounded-full bg-base-200/50"></div>
                    <div class="w-2 sm:w-8 h-1 sm:h-1.5 rounded-full bg-base-200/50"></div>
                    <div class="w-2 sm:w-8 h-1 sm:h-1.5 rounded-full bg-base-200/50"></div>
                    <div class="w-2 sm:w-8 h-1 sm:h-1.5 rounded-full bg-base-200/50"></div>
                </div>
            </div>
        </div>
    @else
        <div class="flex flex-col gap-4 sm:gap-6">
            <!-- Section Header -->
            <div class="px-2">
                <h3 class="text-xl sm:text-2xl font-black italic uppercase tracking-tighter text-base-content">
                    Update <span class="text-info">Terbaru</span>
                </h3>
                <p
                    class="text-[10px] sm:text-xs font-medium text-base-content/60 uppercase tracking-widest mt-0.5 sm:mt-1">
                    Informasi seputar fasilitas & kegiatan kencana mini soccer
                </p>
            </div>

            <!-- Banner Carousel with Indicators -->
            <div class="relative w-full group">
                <div
                    class="carousel w-full rounded-2xl sm:rounded-3xl shadow-2xl aspect-video sm:aspect-21/9 scroll-smooth">
                    <!-- Banner 1: Peresmian -->
                    <div class="carousel-item relative w-full overflow-hidden">
                        <img src="{{ asset('assets/images/landing-pages/banners/gb-1.jpg') }}"
                            class="w-full h-full object-cover" alt="Peresmian Kencana Mini Soccer" />
                        <div class="absolute inset-0 bg-linear-to-r from-black/80 via-black/40 to-transparent"></div>
                        <div class="absolute inset-0 flex flex-col justify-center px-6 sm:px-12 gap-1 sm:gap-2">
                            <span
                                class="bg-info text-info-content text-[10px] sm:text-xs font-black uppercase italic px-2 py-1 rounded w-fit">New
                                Facility</span>
                            <h2 class="text-white text-2xl sm:text-4xl font-black italic uppercase leading-none">
                                Kencana<br>Mini Soccer</h2>
                            <p
                                class="text-white/80 text-[10px] sm:text-sm max-w-50 sm:max-w-md font-medium leading-relaxed">
                                Resmi dibuka oleh Wali Kota Pekanbaru sebagai sarana olahraga modern untuk masyarakat
                                Sukajadi dan sekitarnya.</p>
                        </div>
                    </div>

                    <!-- Banner 2: Gratis -->
                    <div class="carousel-item relative w-full overflow-hidden">
                        <img src="{{ asset('assets/images/landing-pages/banners/gb-2.jpg') }}"
                            class="w-full h-full object-cover" alt="Gratis Untuk Umum" />
                        <div class="absolute inset-0 bg-linear-to-r from-black/80 via-black/40 to-transparent"></div>
                        <div class="absolute inset-0 flex flex-col justify-center px-6 sm:px-12 gap-1 sm:gap-2">
                            <span
                                class="bg-info text-info-content text-[10px] sm:text-xs font-black uppercase italic px-2 py-1 rounded w-fit">Public
                                Service</span>
                            <h2 class="text-white text-2xl sm:text-4xl font-black italic uppercase leading-none">
                                Gratis<br>Untuk
                                Warga</h2>
                            <p
                                class="text-white/80 text-[10px] sm:text-sm max-w-50 sm:max-w-md font-medium leading-relaxed">
                                Fasilitas olahraga publik yang dapat digunakan secara gratis. Mari jaga kebersihan dan
                                kenyamanan bersama.</p>
                        </div>
                    </div>

                    <!-- Banner 3: Lokasi -->
                    <div class="carousel-item relative w-full overflow-hidden">
                        <img src="{{ asset('assets/images/landing-pages/banners/gb-3.jpg') }}"
                            class="w-full h-full object-cover" alt="Lokasi Strategis" />
                        <div class="absolute inset-0 bg-linear-to-r from-black/80 via-black/40 to-transparent"></div>
                        <div class="absolute inset-0 flex flex-col justify-center px-6 sm:px-12 gap-1 sm:gap-2">
                            <span
                                class="bg-info text-info-content text-[10px] sm:text-xs font-black uppercase italic px-2 py-1 rounded w-fit">Location</span>
                            <h2 class="text-white text-2xl sm:text-4xl font-black italic uppercase leading-none">
                                Simpang<br>Melur</h2>
                            <p
                                class="text-white/80 text-[10px] sm:text-sm max-w-50 sm:max-w-md font-medium leading-relaxed">
                                Terletak di kawasan strategis eks Kantor Dinkes Pekanbaru, Sukajadi. Ruang interaksi
                                positif warga kota.</p>
                        </div>
                    </div>

                    <!-- Banner 4: Gaya Hidup Sehat -->
                    <div class="carousel-item relative w-full overflow-hidden">
                        <img src="{{ asset('assets/images/landing-pages/banners/gb-4.jpg') }}"
                            class="w-full h-full object-cover" alt="Healthy Lifestyle" />
                        <div class="absolute inset-0 bg-linear-to-r from-black/80 via-black/40 to-transparent"></div>
                        <div class="absolute inset-0 flex flex-col justify-center px-6 sm:px-12 gap-1 sm:gap-2">
                            <span
                                class="bg-info text-info-content text-[10px] sm:text-xs font-black uppercase italic px-2 py-1 rounded w-fit">Healthy</span>
                            <h2 class="text-white text-2xl sm:text-4xl font-black italic uppercase leading-none">
                                Gaya Hidup<br>Sehat</h2>
                            <p
                                class="text-white/80 text-[10px] sm:text-sm max-w-50 sm:max-w-md font-medium leading-relaxed">
                                Komitmen Pemko Pekanbaru menyediakan fasilitas olahraga berkualitas untuk meningkatkan
                                kesehatan masyarakat.</p>
                        </div>
                    </div>
                </div>

                <!-- Indicators -->
                <div class="flex justify-center w-full py-3 gap-2 absolute bottom-2 sm:bottom-4 z-10">
                    <button
                        class="indicator-dot w-2 sm:w-8 h-1 sm:h-1.5 rounded-full bg-white/30 hover:bg-info transition-all"></button>
                    <button
                        class="indicator-dot w-2 sm:w-8 h-1 sm:h-1.5 rounded-full bg-white/30 hover:bg-info transition-all"></button>
                    <button
                        class="indicator-dot w-2 sm:w-8 h-1 sm:h-1.5 rounded-full bg-white/30 hover:bg-info transition-all"></button>
                    <button
                        class="indicator-dot w-2 sm:w-8 h-1 sm:h-1.5 rounded-full bg-white/30 hover:bg-info transition-all"></button>
                </div>

                <!-- Navigation Buttons (Desktop only) -->
                <div
                    class="hidden sm:flex absolute inset-y-0 left-4 right-4 items-center justify-between pointer-events-none opacity-0 group-hover:opacity-100 transition-opacity">
                    <button
                        class="btn-prev btn btn-circle btn-sm bg-black/20 border-none text-white pointer-events-auto hover:bg-info">❮</button>
                    <button
                        class="btn-next btn btn-circle btn-sm bg-black/20 border-none text-white pointer-events-auto hover:bg-info">❯</button>
                </div>
            </div>
        </div>
    @endif
</div>
