<div id="hero-carousel-root" class="mt-4 sm:mt-8" wire:init="load">
    @if ($ready)
        <div class="flex flex-col gap-4 sm:gap-6" x-transition>
            <!-- Section Header -->
            <div class="flex items-end justify-between px-2">
                <div>
                    <h3 class="text-xl sm:text-2xl font-black italic uppercase tracking-tighter text-base-content">
                        Arena <span class="text-info">Tersedia</span>
                    </h3>
                    <p
                        class="text-[10px] sm:text-xs font-medium text-base-content/60 uppercase tracking-widest mt-0.5 sm:mt-1">
                        Siap untuk bertanding?</p>
                </div>
                <a wire:navigate href="{{ route('lapangan') }}"
                    class="text-[10px] sm:text-xs font-bold uppercase italic text-info hover:underline transition-all">Lihat
                    Semua</a>
            </div>

            <div wire:ignore
                class="carousel carousel-center w-full bg-base-200/30 rounded-2xl sm:rounded-3xl space-x-3 sm:space-x-4 p-3 sm:p-4 scroll-smooth">
                @foreach ($lapangan as $lp)
                    <div class="carousel-item w-55 sm:w-72 flex flex-col gap-2 sm:gap-3 group">
                        <div
                            class="relative overflow-hidden rounded-xl sm:rounded-2xl aspect-3/4 sm:aspect-4/5 shadow-xl transition-transform group-hover:scale-[1.02]">
                            <img src="{{ $lp['cover_url'] }}"
                                class="w-full h-full object-cover -skew-x-2 scale-110 group-hover:skew-x-0 group-hover:scale-100 transition-all duration-500"
                                alt="{{ $lp['nama_lapangan'] }}" />
                            @if (($lp['status'] ?? '') === 'coming_soon')
                                <div
                                    class="absolute inset-0 rounded-xl sm:rounded-2xl bg-black/60 backdrop-blur-[2px] z-10 flex items-center justify-center">
                                    <span
                                        class="text-warning text-sm sm:text-2xl font-black italic uppercase tracking-widest -skew-x-12 border-2 border-warning px-4 py-1">
                                        {{ $lp['status_label'] ?: 'Segera Dibuka' }}
                                    </span>
                                </div>
                            @endif
                            <div
                                class="absolute inset-0 bg-linear-to-t from-black/80 via-transparent to-transparent opacity-60">
                            </div>
                            <div class="absolute bottom-3 sm:bottom-4 left-3 sm:left-4 right-3 sm:right-4">
                                <div
                                    class="bg-info text-info-content text-[9px] sm:text-[10px] font-black uppercase italic px-1.5 sm:px-2 py-0.5 rounded w-fit mb-1">
                                    {{ $lp['status_label'] ?? '' }}
                                </div>
                                <h4 class="text-white text-lg sm:text-xl font-black italic uppercase leading-none">
                                    {{ $lp['nama_lapangan'] }}
                                </h4>
                            </div>
                        </div>
                        <div class="px-1 sm:px-2">
                            <p class="text-[10px] sm:text-[11px] text-base-content/70 leading-relaxed line-clamp-2">
                                {{ $lp['deskripsi'] }}
                            </p>
                            @if (($lp['status'] ?? '') === 'open')
                                <a href="/booking?lapangan={{ \Illuminate\Support\Str::slug($lp['nama_lapangan'] ?? '') }}"
                                    wire:navigate wire:navigate
                                    class="btn btn-info btn-xs sm:btn-sm w-full mt-2 sm:mt-3 italic font-black uppercase -skew-x-12">
                                    <span class="skew-x-12">Pesan Sekarang</span>
                                </a>
                            @else
                                <button disabled
                                    class="btn btn-neutral btn-xs sm:btn-sm w-full mt-2 sm:mt-3 italic font-black uppercase -skew-x-12 opacity-80 cursor-not-allowed">
                                    <span class="skew-x-12">{{ $lp['status_label'] ?: 'Segera Dibuka' }}</span>
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
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
                @for ($i = 0; $i < 5; $i++)
                    <div class="carousel-item w-55 sm:w-72 flex flex-col gap-2 sm:gap-3">
                        <div class="w-full h-72.5 sm:h-90 bg-base-300 rounded-xl sm:rounded-2xl"></div>
                        <div class="px-1 sm:px-2 space-y-2">
                            <div class="h-3 bg-base-300 w-full rounded"></div>
                            <div class="h-3 bg-base-300 w-2/3 rounded"></div>
                            <div class="h-6 sm:h-8 bg-base-300 w-full mt-2 rounded-lg -skew-x-12"></div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    @endif
</div>
