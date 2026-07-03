<div id="hero-carousel-root" class="mt-8 sm:mt-12">
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
            class="carousel carousel-center w-full rounded-2xl sm:rounded-3xl space-x-3 sm:space-x-4 p-3 sm:p-1 scroll-smooth">
            @foreach ($lapangan as $lp)
                <div class="carousel-item w-55 sm:w-72 flex flex-col gap-2 sm:gap-3 group">
                    <div
                        class="relative overflow-hidden rounded-xl sm:rounded-2xl aspect-3/4 sm:aspect-4/5 shadow-xl transition-transform group-hover:scale-[1.02]">
                        <img src="{{ $lp['cover_url'] }}"
                            class="w-full h-full object-cover -skew-x-2 scale-110 group-hover:skew-x-0 group-hover:scale-100 transition-all duration-500"
                            alt="{{ $lp['nama_lapangan'] }}" />
                        @if (($lp['status'] ?? '') === 'coming_soon')
                            <div
                                class="absolute inset-0 rounded-xl sm:rounded-2xl bg-black/60 z-10 flex items-center justify-center">
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
                    <div class="px-1 sm:px-2 flex flex-col flex-1 justify-between">
                        <p class="text-[10px] sm:text-[11px] text-base-content/70 leading-relaxed line-clamp-2">
                            {{ $lp['alamat'] }}
                        </p>
                        <div class="mt-auto pt-2 sm:pt-3">
                            @if (($lp['status'] ?? '') === 'open')
                                <a href="/booking?lapangan={{ \Illuminate\Support\Str::slug($lp['nama_lapangan'] ?? '') }}"
                                    wire:navigate
                                    class="btn btn-info btn-xs sm:btn-sm w-full italic font-black uppercase -skew-x-12">
                                    <span class="skew-x-12">Pesan Sekarang</span>
                                </a>
                            @else
                                <button disabled
                                    class="btn btn-neutral btn-xs sm:btn-sm w-full italic font-black uppercase -skew-x-12 opacity-80 cursor-not-allowed">
                                    <span class="skew-x-12">{{ $lp['status_label'] ?: 'Segera Dibuka' }}</span>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
