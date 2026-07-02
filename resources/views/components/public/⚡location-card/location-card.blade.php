<div id="location-card-root" class="mt-8 sm:mt-12">
    <div class="flex flex-col gap-0" x-data x-transition>
        
        <!-- Tab Folder -->
        <div class="relative inline-flex h-12 sm:h-14 z-20 self-start">
            <!-- Main Tab Rectangle -->
            <div class="bg-white h-full flex flex-col justify-center pl-5 sm:pl-7 pr-3 rounded-tl-2xl sm:rounded-tl-3xl relative z-20 border-t-4 border-l-4 border-white">
                <h3 class="text-xs sm:text-base font-black italic uppercase tracking-tighter text-slate-900 leading-none">
                    Lokasi <span class="text-info">ARENA</span>
                </h3>
                <p class="text-[8px] sm:text-[10px] font-bold text-slate-500 uppercase tracking-wider mt-1 leading-none">
                    Lihat Daftar Lokasi disini
                </p>
            </div>
            
            <!-- S-Curve Right Edge -->
            <div class="relative h-12 sm:h-14 w-12 sm:w-16 shrink-0 -ml-px z-20">
                <svg 
                    viewBox="0 0 40 56" 
                    class="w-full h-full" 
                    preserveAspectRatio="none"
                >
                    <!-- Fill Background -->
                    <path 
                        d="M0,0 C15,0 20,56 40,56 L0,56 Z" 
                        class="fill-white"
                    />
                    <!-- Top/Right Border -->
                    <path 
                        d="M0,2 C15,2 20,54 40,54" 
                        class="stroke-white"
                        stroke-width="4"
                        fill="none"
                    />
                </svg>
            </div>
        </div>

        <!-- Card Lokasi (Menyatu dengan Tab) -->
        <div class="w-full overflow-hidden rounded-3xl rounded-tl-none border-8 border-white bg-white relative z-10 -mt-1 aspect-video sm:aspect-21/9"
            wire:ignore data-api-url="{{ rtrim($apiBase, '/') }}/v1/lokasi">
            <!-- Map Element -->
            <div id="leaflet-map" class="w-full h-full z-0"></div>

            <!-- Google Maps Button Overlay (Top Right) -->
            <div class="absolute top-4 right-4 sm:top-6 sm:right-6 z-10">
                <a href="https://maps.app.goo.gl/xmVpF14sPhjzm5EW9" target="_blank" rel="noopener"
                    class="btn btn-info -skew-x-12 btn-xs sm:btn-sm text-[8px] sm:text-xs font-black uppercase tracking-widest shadow-lg group">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-3.5 mr-1 transition-transform group-hover:scale-110">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                    </svg>
                    Google Maps
                </a>
            </div>

            <!-- Address Overlay (Desktop Only) -->
            <div
                class="hidden sm:block absolute top-6 left-6 z-10 max-w-xs bg-base-100/90 backdrop-blur-md p-4 rounded-xl border border-white/10 shadow-xl pointer-events-none">
                <div class="flex items-start gap-3">
                    <div class="bg-info/10 p-2 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="size-5 text-info">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-black uppercase text-xs text-base-content">
                            <span>Lokasi KENCANA ARENA</span>
                        </h4>
                        <div>
                            <span class="text-[10px] font-bold text-base-content/70">Cek lokasi Kencana Arena
                                disini</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
