<div id="location-card-root" class="mt-8 sm:mt-12">
    <div class="flex flex-col gap-0" x-data x-transition>

        <!-- Tab Folder -->
        <div class="relative inline-flex h-12 sm:h-14 z-20 self-start">
            <!-- Main Tab Rectangle -->
            <div
                class="bg-white h-full flex flex-col justify-center pl-5 sm:pl-7 pr-3 rounded-tl-2xl sm:rounded-tl-3xl relative z-20 border-t-4 border-l-4 border-white">
                <h3
                    class="text-xs sm:text-base font-black italic uppercase tracking-tighter text-slate-900 leading-none">
                    Lokasi <span class="text-info">ARENA</span>
                </h3>
                <p class="text-[8px] sm:text-[10px] font-bold text-slate-500 uppercase tracking-wider mt-1 leading-none">
                    Lihat Daftar Lokasi disini
                </p>
            </div>

            <!-- S-Curve Right Edge -->
            <div class="relative h-12 sm:h-14 w-12 sm:w-16 shrink-0 -ml-px z-20">
                <svg viewBox="0 0 40 56" class="w-full h-full" preserveAspectRatio="none">
                    <!-- Fill Background -->
                    <path d="M0,0 C15,0 20,56 40,56 L0,56 Z" class="fill-white" />
                    <!-- Top/Right Border -->
                    <path d="M0,2 C15,2 20,54 40,54" class="stroke-white" stroke-width="4" fill="none" />
                </svg>
            </div>
        </div>

        <!-- Card Lokasi (Menyatu dengan Tab) -->
        <div class="w-full overflow-hidden rounded-3xl rounded-tl-none border-8 border-white bg-white relative z-10 -mt-1 aspect-square sm:aspect-21/9"
            wire:ignore data-api-url="{{ rtrim($apiBase, '/') }}/v1/lokasi">
            <!-- Map Element -->
            <div id="leaflet-map" class="w-full h-full z-0"></div>
        </div>

    </div>
</div>
