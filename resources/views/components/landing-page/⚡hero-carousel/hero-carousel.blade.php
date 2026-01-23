<div class="mt-4 sm:mt-8" wire:init="load">
    @if ($ready)
        <div class="flex flex-col gap-4 sm:gap-6" x-transition>
            <!-- Section Header -->
            <div class="flex items-end justify-between px-2">
                <div>
                    <h3 class="text-xl sm:text-2xl font-black italic uppercase tracking-tighter text-base-content">
                        Our <span class="text-info">Arenas</span>
                    </h3>
                    <p
                        class="text-[10px] sm:text-xs font-medium text-base-content/60 uppercase tracking-widest mt-0.5 sm:mt-1">
                        Ready for your
                        next
                        match?</p>
                </div>
                <a href="#"
                    class="text-[10px] sm:text-xs font-bold uppercase italic text-info hover:underline transition-all">View
                    All</a>
            </div>

            <!-- Sporty Carousel -->
            <div
                class="carousel carousel-center w-full bg-base-200/30 rounded-2xl sm:rounded-3xl space-x-3 sm:space-x-4 p-3 sm:p-4 scroll-smooth">
                <!-- Badminton -->
                <div class="carousel-item w-55 sm:w-72 flex flex-col gap-2 sm:gap-3 group">
                    <div
                        class="relative overflow-hidden rounded-xl sm:rounded-2xl aspect-3/4 sm:aspect-4/5 shadow-xl transition-transform group-hover:scale-[1.02]">
                        <img src="{{ asset('assets/images/landing-pages/badminton.webp') }}"
                            class="w-full h-full object-cover -skew-x-2 scale-110 group-hover:skew-x-0 group-hover:scale-100 transition-all duration-500"
                            alt="Badminton Arena" />
                        <div
                            class="absolute inset-0 bg-linear-to-t from-black/80 via-transparent to-transparent opacity-60">
                        </div>
                        <div class="absolute bottom-3 sm:bottom-4 left-3 sm:left-4 right-3 sm:right-4">
                            <div
                                class="bg-info text-info-content text-[9px] sm:text-[10px] font-black uppercase italic px-1.5 sm:px-2 py-0.5 rounded w-fit mb-1">
                                Indoor</div>
                            <h4 class="text-white text-lg sm:text-xl font-black italic uppercase leading-none">Badminton
                                Court</h4>
                        </div>
                    </div>
                    <div class="px-1 sm:px-2">
                        <p class="text-[10px] sm:text-[11px] text-base-content/70 leading-relaxed line-clamp-2">Premium
                            vinyl flooring
                            with
                            international standard lighting for the best smash experience.</p>
                        <button
                            class="btn btn-info btn-xs sm:btn-sm w-full mt-2 sm:mt-3 italic font-black uppercase -skew-x-12">
                            <span class="skew-x-12">Book Now</span>
                        </button>
                    </div>
                </div>

                <!-- Basket Ball -->
                <div class="carousel-item w-55 sm:w-72 flex flex-col gap-2 sm:gap-3 group">
                    <div
                        class="relative overflow-hidden rounded-xl sm:rounded-2xl aspect-3/4 sm:aspect-4/5 shadow-xl transition-transform group-hover:scale-[1.02]">
                        <img src="{{ asset('assets/images/landing-pages/basket-ball.webp') }}"
                            class="w-full h-full object-cover -skew-x-2 scale-110 group-hover:skew-x-0 group-hover:scale-100 transition-all duration-500"
                            alt="Basketball Court" />
                        <div
                            class="absolute inset-0 bg-linear-to-t from-black/80 via-transparent to-transparent opacity-60">
                        </div>
                        <div class="absolute bottom-3 sm:bottom-4 left-3 sm:left-4 right-3 sm:right-4">
                            <div
                                class="bg-info text-info-content text-[9px] sm:text-[10px] font-black uppercase italic px-1.5 sm:px-2 py-0.5 rounded w-fit mb-1">
                                Premium</div>
                            <h4 class="text-white text-lg sm:text-xl font-black italic uppercase leading-none">
                                Basketball Arena
                            </h4>
                        </div>
                    </div>
                    <div class="px-1 sm:px-2">
                        <p class="text-[10px] sm:text-[11px] text-base-content/70 leading-relaxed line-clamp-2">
                            High-quality wood
                            parquet
                            flooring and professional rims for your ultimate game.</p>
                        <button
                            class="btn btn-info btn-xs sm:btn-sm w-full mt-2 sm:mt-3 italic font-black uppercase -skew-x-12">
                            <span class="skew-x-12">Book Now</span>
                        </button>
                    </div>
                </div>

                <!-- Mini Soccer -->
                <div class="carousel-item w-55 sm:w-72 flex flex-col gap-2 sm:gap-3 group">
                    <div
                        class="relative overflow-hidden rounded-xl sm:rounded-2xl aspect-3/4 sm:aspect-4/5 shadow-xl transition-transform group-hover:scale-[1.02]">
                        <img src="{{ asset('assets/images/landing-pages/mini-soccer.webp') }}"
                            class="w-full h-full object-cover -skew-x-2 scale-110 group-hover:skew-x-0 group-hover:scale-100 transition-all duration-500"
                            alt="Mini Soccer Field" />
                        <div
                            class="absolute inset-0 bg-linear-to-t from-black/80 via-transparent to-transparent opacity-60">
                        </div>
                        <div class="absolute bottom-3 sm:bottom-4 left-3 sm:left-4 right-3 sm:right-4">
                            <div
                                class="bg-info text-info-content text-[9px] sm:text-[10px] font-black uppercase italic px-1.5 sm:px-2 py-0.5 rounded w-fit mb-1">
                                Outdoor</div>
                            <h4 class="text-white text-lg sm:text-xl font-black italic uppercase leading-none">Mini
                                Soccer</h4>
                        </div>
                    </div>
                    <div class="px-1 sm:px-2">
                        <p class="text-[10px] sm:text-[11px] text-base-content/70 leading-relaxed line-clamp-2">
                            High-grade synthetic
                            grass
                            with excellent drainage system for all-weather play.</p>
                        <button
                            class="btn btn-info btn-xs sm:btn-sm w-full mt-2 sm:mt-3 italic font-black uppercase -skew-x-12">
                            <span class="skew-x-12">Book Now</span>
                        </button>
                    </div>
                </div>

                <!-- Skates -->
                <div class="carousel-item w-55 sm:w-72 flex flex-col gap-2 sm:gap-3 group">
                    <div
                        class="relative overflow-hidden rounded-xl sm:rounded-2xl aspect-3/4 sm:aspect-4/5 shadow-xl transition-transform group-hover:scale-[1.02]">
                        <img src="{{ asset('assets/images/landing-pages/skates.webp') }}"
                            class="w-full h-full object-cover -skew-x-2 scale-110 group-hover:skew-x-0 group-hover:scale-100 transition-all duration-500"
                            alt="Skate Park" />
                        <div
                            class="absolute inset-0 bg-linear-to-t from-black/80 via-transparent to-transparent opacity-60">
                        </div>
                        <div class="absolute bottom-3 sm:bottom-4 left-3 sm:left-4 right-3 sm:right-4">
                            <div
                                class="bg-info text-info-content text-[9px] sm:text-[10px] font-black uppercase italic px-1.5 sm:px-2 py-0.5 rounded w-fit mb-1">
                                Extreme</div>
                            <h4 class="text-white text-lg sm:text-xl font-black italic uppercase leading-none">Skate
                                Park</h4>
                        </div>
                    </div>
                    <div class="px-1 sm:px-2">
                        <p class="text-[10px] sm:text-[11px] text-base-content/70 leading-relaxed line-clamp-2">Smooth
                            concrete surface
                            with various obstacles for beginners and pros alike.</p>
                        <button
                            class="btn btn-info btn-xs sm:btn-sm w-full mt-2 sm:mt-3 italic font-black uppercase -skew-x-12">
                            <span class="skew-x-12">Book Now</span>
                        </button>
                    </div>
                </div>

                <!-- Volleyball -->
                <div class="carousel-item w-55 sm:w-72 flex flex-col gap-2 sm:gap-3 group">
                    <div
                        class="relative overflow-hidden rounded-xl sm:rounded-2xl aspect-3/4 sm:aspect-4/5 shadow-xl transition-transform group-hover:scale-[1.02]">
                        <img src="{{ asset('assets/images/landing-pages/volleyball.webp') }}"
                            class="w-full h-full object-cover -skew-x-2 scale-110 group-hover:skew-x-0 group-hover:scale-100 transition-all duration-500"
                            alt="Volleyball Court" />
                        <div
                            class="absolute inset-0 bg-linear-to-t from-black/80 via-transparent to-transparent opacity-60">
                        </div>
                        <div class="absolute bottom-3 sm:bottom-4 left-3 sm:left-4 right-3 sm:right-4">
                            <div
                                class="bg-info text-info-content text-[9px] sm:text-[10px] font-black uppercase italic px-1.5 sm:px-2 py-0.5 rounded w-fit mb-1">
                                Team</div>
                            <h4 class="text-white text-lg sm:text-xl font-black italic uppercase leading-none">
                                Volleyball Arena
                            </h4>
                        </div>
                    </div>
                    <div class="px-1 sm:px-2">
                        <p class="text-[10px] sm:text-[11px] text-base-content/70 leading-relaxed line-clamp-2">Standard
                            sized court
                            with
                            high-tension nets for competitive team play.</p>
                        <button
                            class="btn btn-info btn-xs sm:btn-sm w-full mt-2 sm:mt-3 italic font-black uppercase -skew-x-12">
                            <span class="skew-x-12">Book Now</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Skeleton Loading -->
        <div class="flex flex-col gap-4 sm:gap-6 animate-pulse">
            <div class="flex items-end justify-between px-2">
                <div class="h-6 sm:h-8 bg-base-300 w-32 sm:w-48 rounded-lg"></div>
                <div class="h-3 sm:h-4 bg-base-300 w-12 sm:w-16 rounded-lg"></div>
            </div>
            <div
                class="carousel carousel-center w-full bg-base-200/30 rounded-2xl sm:rounded-3xl space-x-3 sm:space-x-4 p-3 sm:p-4">
                @for ($i = 0; $i < 3; $i++)
                    <div class="carousel-item w-55 sm:w-72 flex flex-col gap-2 sm:gap-3">
                        <div class="w-full h-72.5 sm:h-90 bg-base-300 rounded-xl sm:rounded-2xl"></div>
                        <div class="px-1 sm:px-2 space-y-2">
                            <div class="h-3 bg-base-300 w-full rounded"></div>
                            <div class="h-3 bg-base-300 w-2/3 rounded"></div>
                            <div class="h-6 sm:h-8 bg-base-300 w-full mt-2 rounded-lg"></div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    @endif
</div>
