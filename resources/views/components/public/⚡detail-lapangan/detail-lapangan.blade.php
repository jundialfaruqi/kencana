<div class="mt-4 sm:mt-8" x-data>
    <div class="mb-8 px-2 flex items-center gap-4">
        <div class="flex-1 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('lapangan') }}" wire:navigate
                    class="btn btn-circle btn-ghost btn-sm sm:btn-md border-2 border-base-300 hover:border-info hover:text-info transition-all"
                    aria-label="Kembali">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                        stroke="currentColor" class="size-5 sm:size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                </a>
                <div>
                    <h2 class="text-xl sm:text-2xl font-black italic uppercase tracking-tighter text-base-content">
                        {{ data_get($lapangan, 'nama_lapangan', '-') }}
                    </h2>
                    <p
                        class="text-[10px] sm:text-xs font-medium text-base-content/60 uppercase tracking-widest mt-0.5 sm:mt-1">
                        Detail Lapangan
                    </p>
                </div>
            </div>
        </div>
    </div>
    @if ($error)
        <div class="alert alert-error">
            <span>{{ $error }}</span>
        </div>
    @else
        <div class="card bg-base-200 border border-base-200 overflow-hidden">
            <!-- Cover Header Besar -->
            <figure class="relative w-full h-64 sm:h-80 lg:h-96 bg-base-200 rounded-b-3xl overflow-hidden shadow-sm">
                @if ($coverUrl)
                    <img src="{{ $coverUrl }}" class="w-full h-full object-cover" alt="Cover Lapangan" />
                @else
                    <div class="w-full h-full flex flex-col items-center justify-center text-base-content/40">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-12 h-12 mb-2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                        </svg>
                        <span class="text-sm font-semibold tracking-widest uppercase">No Image</span>
                    </div>
                @endif

                <!-- Gradien Overlay & Judul -->
                <div class="absolute inset-0 bg-linear-to-t from-black/80 via-black/20 to-transparent"></div>

                <div class="absolute bottom-6 left-6 right-6 flex items-end justify-between gap-4">
                    <div class="text-white">
                        <p
                            class="text-xs sm:text-sm font-bold text-white/70 uppercase tracking-widest mb-1 drop-shadow-md">
                            Nama Arena</p>
                        <h2 class="text-3xl sm:text-5xl font-black italic tracking-tighter drop-shadow-lg">
                            {{ data_get($lapangan, 'nama_lapangan', '-') }}</h2>
                    </div>
                    <span
                        class="{{ data_get($lapangan, 'status') === 'open' ? 'bg-success text-success-content' : 'bg-warning text-warning-content' }} rounded-lg text-center uppercase italic font-black tracking-widest text-xs sm:text-sm px-4 py-2 -skew-x-12 shadow-xl backdrop-blur-md">
                        {{ data_get($lapangan, 'status_label', ucfirst(data_get($lapangan, 'status', '-'))) }}
                    </span>
                </div>
            </figure>

            <div class="card-body p-6 sm:p-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

                    <!-- Kolom Kiri: Deskripsi & Peta Terpadu -->
                    <div class="lg:col-span-7 xl:col-span-8 flex flex-col gap-8">

                        <!-- Deskripsi -->
                        <div>
                            <h3
                                class="text-lg font-black italic uppercase tracking-tight text-base-content/80 mb-3 pb-2 inline-block">
                                Tentang Arena</h3>
                            <p class="text-sm sm:text-base text-base-content/80 leading-relaxed font-medium">
                                @if ((data_get($lapangan, 'status') ?? '') === 'open')
                                    {!! str_replace('. ', '.<br><br>', e(data_get($lapangan, 'deskripsi', '-'))) !!}
                                @else
                                    {{ data_get($lapangan, 'status_label', ucfirst(data_get($lapangan, 'status', '-'))) }}
                                @endif
                            </p>
                        </div>

                        <!-- Peta & Alamat Terintegrasi -->
                        <div class="bg-base-200 rounded-3xl overflow-hidden border border-base-300 shadow-inner flex flex-col"
                            data-animate-detail>
                            @php $gmap = data_get($lapangan, 'gmap'); @endphp
                            <div class="w-full aspect-[21/9] bg-base-300 relative"
                                data-lat="{{ data_get($lapangan, 'latitude', '') }}"
                                data-lng="{{ data_get($lapangan, 'longitude', '') }}"
                                data-name="{{ data_get($lapangan, 'nama_lapangan', '-') }}"
                                data-alamat="{{ data_get($lapangan, 'alamat', '-') }}"
                                data-status="{{ data_get($lapangan, 'status_label', ucfirst(data_get($lapangan, 'status', '-'))) }}">
                                <div id="lapangan-map" class="absolute inset-0 z-0" wire:ignore></div>
                            </div>

                            <div
                                class="p-5 sm:p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 z-10">
                                <div class="flex items-start gap-4 flex-1">
                                    <div>
                                        <p class="text-xs font-bold text-base-content/50 uppercase mb-1">Lokasi Lapangan
                                        </p>
                                        <p class="text-sm font-semibold text-base-content leading-tight">
                                            @if ((data_get($lapangan, 'status') ?? '') === 'open')
                                                {{ data_get($lapangan, 'alamat', '-') }}
                                            @else
                                                {{ data_get($lapangan, 'status_label', ucfirst(data_get($lapangan, 'status', '-'))) }}
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                @if ((data_get($lapangan, 'status') ?? '') === 'open')
                                    <div class="flex flex-wrap gap-2 shrink-0">
                                        @if (!empty($gmap))
                                            <a href="{{ $gmap }}" target="_blank" rel="noopener"
                                                class="btn btn-warning btn-sm shadow-md -skew-x-12 px-6">
                                                <span class="italic font-bold text-white">Google Maps</span>
                                            </a>
                                        @endif
                                        <a href="/booking?lapangan={{ \Illuminate\Support\Str::slug(data_get($lapangan, 'nama_lapangan', '')) }}"
                                            wire:navigate class="btn btn-info btn-sm shadow-md -skew-x-12 px-6">
                                            <span class="italic font-bold text-white">Pesan Arena</span>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>

                    </div>

                    <!-- Kolom Kanan: Galeri Susunan Bento -->
                    <div class="lg:col-span-5 xl:col-span-4">
                        <h3
                            class="text-lg font-black italic uppercase tracking-tight text-base-content/80 mb-4 pb-2 inline-block">
                            Galeri Foto</h3>

                        @if (!empty($galleryUrls) && count($galleryUrls) > 0)
                            <div class="grid grid-cols-2 gap-3 auto-rows-[100px] sm:auto-rows-[120px]">
                                @foreach ($galleryUrls as $index => $imgUrl)
                                    @php
                                        $total = count($galleryUrls);
                                        $classes = 'col-span-1 row-span-1';
                                        if ($total == 1) {
                                            $classes = 'col-span-2 row-span-3'; // 1 gambar besar memanjang
                                        } elseif ($total == 2) {
                                            $classes = 'col-span-1 row-span-2'; // 2 gambar berdampingan memanjang
                                        } elseif ($total == 3) {
                                            if ($index == 0) {
                                                $classes = 'col-span-2 row-span-2';
                                            }
                                            // Gambar 1 besar atas
                                            else {
                                                $classes = 'col-span-1 row-span-1';
                                            } // Gambar 2 & 3 kecil bawah
                                        } elseif ($total >= 4) {
                                            if ($index == 0) {
                                                $classes = 'col-span-2 row-span-2';
                                            }
                                            // Gambar 1 besar atas
                                            elseif ($index == 1) {
                                                $classes = 'col-span-1 row-span-2';
                                            }
                                            // Gambar 2 panjang kiri bawah
                                            else {
                                                $classes = 'col-span-1 row-span-1';
                                            } // Gambar 3 & 4 tumpuk di kanan bawah
                                        }
                                    @endphp
                                    <div
                                        class="rounded-2xl overflow-hidden bg-base-200 relative group shadow-sm {{ $classes }}">
                                        <img src="{{ $imgUrl }}"
                                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105 cursor-pointer"
                                            alt="Foto Lapangan" data-gallery-image="{{ $imgUrl }}" />
                                        <div
                                            class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors duration-300 pointer-events-none">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div
                                class="rounded-3xl bg-base-200 border-2 border-dashed border-base-300 flex flex-col items-center justify-center p-10 text-base-content/40 h-64">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-10 mb-3">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                </svg>
                                <span class="text-sm font-bold uppercase tracking-widest">Tidak ada foto</span>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    @endif

    <div id="gallery-lightbox" class="fixed inset-0 bg-black bg-opacity-75 items-center justify-center z-9999 hidden">
        <div class="relative w-11/12 max-w-5xl p-4">
            <button id="lightbox-close"
                class="btn btn-sm btn-circle bg-gray-600/50 border-0 absolute right-5 top-5 sm:right-2 sm:top-2 z-10 text-white">✕</button>
            <!-- WRAPPER KHUSUS GAMBAR -->
            <div class="relative flex justify-center">
                <img id="lightbox-main-image" src="" class="max-h-[80vh] w-auto object-contain rounded-xl"
                    alt="Lightbox Image" />
                <!-- PREV -->
                <button id="lightbox-prev"
                    class="absolute left-2 top-1/2 -translate-y-1/2 btn btn-circle btn-ghost text-white/50 text-2xl">
                    ❮
                </button>

                <!-- NEXT -->
                <button id="lightbox-next"
                    class="absolute right-2 top-1/2 -translate-y-1/2 btn btn-circle btn-ghost text-white/50 text-2xl">
                    ❯
                </button>
            </div>
            <div id="lightbox-thumbnails" class="py-4 flex justify-center gap-2 overflow-x-auto">
                <!-- Thumbnails will be injected here by JS -->
            </div>
        </div>
    </div>
</div>
