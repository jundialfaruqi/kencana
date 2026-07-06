<div id="banner-carousel-root" class="mt-0 sm:mt-8">
    <div class="flex flex-col gap-4 sm:gap-6">
        <!-- Banner Carousel with Indicators -->
        <div class="relative w-full group">
            <div class="carousel w-full rounded-2xl sm:rounded-3xl shadow-2xl aspect-video sm:aspect-21/9 scroll-smooth">
                @foreach ($banners ?? [] as $banner)
                    <div class="carousel-item relative w-full overflow-hidden">
                        <a href="{{ route('info.slug', ['slug' => \Illuminate\Support\Str::slug($banner['judul'] ?? 'info')]) }}"
                            wire:navigate class="relative w-full h-full block group/banner">
                            <img src="{{ $banner['image'] ?? '' }}"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover/banner:scale-105"
                                alt="{{ $banner['judul'] ?? 'Banner' }}" />
                            <div
                                class="absolute inset-0 bg-linear-to-r from-black/80 via-black/40 to-transparent group-hover/banner:from-black/90 transition-all duration-300">
                            </div>
                            <div
                                class="absolute inset-0 flex flex-col justify-end px-6 sm:px-12 py-6 sm:py-12 gap-1 sm:gap-2">
                                <span
                                    class="bg-info text-info-content text-[8px] sm:text-xs font-black uppercase italic px-2 py-1 rounded w-fit shadow-lg">{{ $banner['kategori'] ?? '' }}</span>
                                <h2
                                    class="text-white text-md sm:text-4xl italic uppercase leading-none group-hover/banner:text-info transition-colors duration-300 drop-shadow-lg">
                                    {{ \Illuminate\Support\Str::words($banner['judul'] ?? '', 4, '') }}</h2>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <!-- Indicators -->
            <div class="flex justify-center w-full pt-4 gap-2">
                @foreach ($banners ?? [] as $_)
                    <button
                        class="indicator-dot w-2 sm:w-8 h-1 sm:h-1.5 rounded-full bg-base-content/20 hover:bg-info transition-all"></button>
                @endforeach
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
</div>
