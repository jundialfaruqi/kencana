<div id="location-card-root" class="mt-8 sm:mt-12" wire:init="load">
    @if (!$readyToLoad)
        <div class="flex flex-col gap-4 sm:gap-6 animate-pulse">
            <!-- Skeleton Header -->
            <div class="px-2">
                <div class="h-6 sm:h-8 bg-base-300 w-32 sm:w-48 rounded-lg mb-2"></div>
                <div class="h-3 sm:h-4 bg-base-300 w-48 sm:w-64 rounded-lg"></div>
            </div>

            <!-- Skeleton Map Container -->
            <div class="relative w-full">
                <div class="w-full bg-base-300 rounded-2xl sm:rounded-3xl aspect-video sm:aspect-21/9 shadow-2xl"></div>
            </div>
        </div>
    @else
        <div class="flex flex-col gap-4 sm:gap-6" x-data x-transition>
            <!-- Section Header -->
            <div class="px-2 flex justify-between items-end">
                <div>
                    <h3 class="text-xl sm:text-2xl font-black italic uppercase tracking-tighter text-base-content">
                        Lokasi <span class="text-info">Kencana</span>
                    </h3>
                    <p
                        class="text-[10px] sm:text-xs font-medium text-base-content/60 uppercase tracking-widest mt-0.5 sm:mt-1">
                        Kunjungi Kencana Mini Soccer sekarang
                    </p>
                </div>
                <a href="https://www.google.com/maps/place/Kencana+Mini+Soccer/@0.5242589,101.4347965,965m/data=!3m1!1e3!4m14!1m7!3m6!1s0x31d5ad00091e7017:0x790745bee1b2b012!2sKencana+Mini+Soccer!8m2!3d0.5242589!4d101.4347965!16s%2Fg%2F11ywd6vjz7!3m5!1s0x31d5ad00091e7017:0x790745bee1b2b012!8m2!3d0.5242589!4d101.4347965!16s%2Fg%2F11ywd6vjz7?entry=ttu"
                    target="_blank"
                    class="btn btn-info -skew-x-12 btn-sm text-[10px] sm:text-xs font-black uppercase tracking-widest shadow-lg group">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-4 mr-1 transition-transform group-hover:scale-110">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                    </svg>
                    Google Maps
                </a>
            </div>

            <!-- Map Container -->
            <div class="relative w-full group">
                <div class="relative overflow-hidden rounded-2xl sm:rounded-3xl shadow-2xl border border-white/5 bg-base-200 aspect-video sm:aspect-21/9"
                    wire:ignore>
                    <!-- Map Element -->
                    <div id="leaflet-map" class="w-full h-full z-0"></div>

                    <!-- Address Overlay (Desktop Only) -->
                    <div
                        class="hidden sm:block absolute top-6 left-6 z-10 max-w-xs bg-base-100/90 backdrop-blur-md p-4 rounded-xl border border-white/10 shadow-xl pointer-events-none">
                        <div class="flex items-start gap-3">
                            <div class="bg-info/10 p-2 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" class="size-5 text-info">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-black italic uppercase tracking-wider text-xs text-info">Kencana Mini
                                    Soccer</h4>
                                <p class="text-[10px] font-bold text-base-content/70 mt-1 leading-relaxed">
                                    Jl. Dahlia, Kedungsari, Kec. Sukajadi, Kota Pekanbaru, Riau 28156
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
