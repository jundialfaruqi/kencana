<div wire:init="loadDetailLapangan" class="mt-4 sm:mt-8" x-data>
    @if ($isLoading)
        <div class="mb-8 px-2 flex items-center gap-4 animate-pulse">
            <div class="size-8 sm:size-12 rounded-full bg-base-300"></div>
            <div>
                <div class="h-6 sm:h-8 bg-base-300 w-48 sm:w-64 rounded-lg"></div>
                <div class="h-3 sm:h-4 bg-base-300 w-32 sm:w-48 mt-2 rounded-lg"></div>
            </div>
        </div>
    @else
        <div class="mb-8 px-2 flex items-center gap-4">
            <div class="flex-1 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <a href="{{ route('lapangan') }}" wire:navigate
                        class="btn btn-circle btn-ghost btn-sm sm:btn-md border-2 border-base-300 hover:border-info hover:text-info transition-all"
                        aria-label="Kembali">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                            stroke="currentColor" class="size-5 sm:size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
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
    @endif
    @if ($isLoading)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-start">
            <div class="card bg-base-100 animate-pulse">
                <figure>
                    <div class="w-full overflow-hidden aspect-video bg-base-300"></div>
                </figure>
                <div class="card-body">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <div class="h-3 bg-base-300 w-24 rounded"></div>
                            <div class="h-6 bg-base-300 w-48 rounded mt-1"></div>
                            <div class="h-4 bg-base-300 w-64 rounded mt-1"></div>
                        </div>
                        <div class="h-5 bg-base-300 w-20 rounded-md -skew-x-12"></div>
                    </div>
                    <div class="mt-4 space-y-2 text-sm">
                        <div class="flex items-center gap-2 p-3 rounded-xl bg-base-200 border border-base-200">
                            <div class="w-6 h-6 rounded-md bg-base-300"></div>
                            <div class="flex-1 min-w-0">
                                <div class="h-3 bg-base-300 w-24 rounded"></div>
                                <div class="h-3 bg-base-300 w-2/3 rounded mt-2"></div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 mb-1">
                        <div class="grid grid-cols-4 md:grid-cols-6 lg:grid-cols-6 gap-3 justify-center">
                            @for ($i = 0; $i < 6; $i++)
                                <div class="aspect-square bg-base-300 rounded-xl"></div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>

            <div class="card bg-base-100 animate-pulse">
                <figure class="rounded-b-2xl">
                    <div class="w-full overflow-hidden aspect-video bg-base-300"></div>
                </figure>
                <div class="card-body p-4">
                    <div class="flex items-center gap-2 justify-start">
                        <div class="h-8 bg-base-300 w-40 rounded-xl"></div>
                        <div class="h-8 bg-base-300 w-32 rounded-xl"></div>
                    </div>
                </div>
            </div>
        </div>
    @else
        @if ($error)
            <div class="alert alert-error">
                <span>{{ $error }}</span>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-start">
                <div class="card bg-base-100">
                    <figure>
                        @if ($coverUrl)
                            <div class="w-full overflow-hidden aspect-video bg-base-200">
                                <img src="{{ $coverUrl }}" class="w-full h-full object-cover"
                                    alt="Cover Lapangan" />
                            </div>
                        @else
                            <div
                                class="w-full overflow-hidden aspect-video bg-base-200 flex items-center justify-center">
                                <span class="text-base-content/60 text-sm">no-image</span>
                            </div>
                        @endif
                    </figure>
                    <div class="card-body">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-xs font-semibold text-base-content/60">Nama Arena</p>
                                <h2 class="card-title">{{ data_get($lapangan, 'nama_lapangan', '-') }}</h2>
                                <p class="text-sm text-base-content/70 mt-1">
                                    @if ((data_get($lapangan, 'status') ?? '') === 'open')
                                        {{ data_get($lapangan, 'deskripsi', '-') }}
                                    @else
                                        {{ data_get($lapangan, 'status_label', ucfirst(data_get($lapangan, 'status', '-'))) }}
                                    @endif
                                </p>
                            </div>
                            <span
                                class="{{ data_get($lapangan, 'status') === 'open' ? 'bg-success text-success-content' : 'bg-warning text-warning-content' }} rounded-md text-center uppercase italic font-bold text-[10px] px-2 py-1 -skew-x-12">
                                {{ data_get($lapangan, 'status_label', ucfirst(data_get($lapangan, 'status', '-'))) }}
                            </span>
                        </div>
                        <div class="mt-4 space-y-2 text-sm">
                            <div class="flex items-center gap-2 p-3 rounded-xl bg-base-200 border border-base-200">
                                <div class="bg-success p-1.5 rounded-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-5 text-white">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-semibold text-base-content/60">Alamat</p>
                                    <p class="text-sm font-medium text-base-content">
                                        @if ((data_get($lapangan, 'status') ?? '') === 'open')
                                            {{ data_get($lapangan, 'alamat', '-') }}
                                        @else
                                            {{ data_get($lapangan, 'status_label', ucfirst(data_get($lapangan, 'status', '-'))) }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 mb-1">
                            @if (!empty($galleryUrls))
                                <div class="grid grid-cols-4 md:grid-cols-6 lg:grid-cols-6 gap-3 justify-center">
                                    @foreach ($galleryUrls as $imgUrl)
                                        <div class="rounded-xl overflow-hidden bg-base-200 aspect-square">
                                            <img src="{{ $imgUrl }}" class="w-full h-full object-cover"
                                                alt="Foto Lapangan" data-gallery-image="{{ $imgUrl }}" />
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="rounded-xl bg-base-200 flex items-center justify-center h-24">
                                    <span class="text-base-content/60 text-sm">no-image</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card bg-base-200 shadow" data-animate-detail>
                    <figure class="rounded-b-2xl">
                        @php $gmap = data_get($lapangan, 'gmap'); @endphp
                        <div class="w-full overflow-hidden aspect-video bg-base-200"
                            data-lat="{{ data_get($lapangan, 'latitude', '') }}"
                            data-lng="{{ data_get($lapangan, 'longitude', '') }}"
                            data-name="{{ data_get($lapangan, 'nama_lapangan', '-') }}"
                            data-alamat="{{ data_get($lapangan, 'alamat', '-') }}"
                            data-status="{{ data_get($lapangan, 'status_label', ucfirst(data_get($lapangan, 'status', '-'))) }}">
                            <div id="lapangan-map" class="w-full h-full z-0" wire:ignore></div>
                        </div>
                    </figure>
                    <div class="card-body p-4">
                        @if ((data_get($lapangan, 'status') ?? '') === 'open')
                            <div class="flex items-center gap-2 justify-start">
                                @if (!empty($gmap))
                                    <a href="{{ $gmap }}" target="_blank" rel="noopener"
                                        class="btn btn-sm btn-warning border-base-300 -skew-x-12">
                                        Buka Google Maps
                                    </a>
                                @endif
                                @if ((data_get($lapangan, 'status') ?? '') === 'open')
                                    <a href="/booking?lapangan={{ \Illuminate\Support\Str::slug(data_get($lapangan, 'nama_lapangan', '')) }}"
                                        wire:navigate class="btn btn-sm btn-info border-base-300 -skew-x-12">
                                        <span>Pesan Sekarang</span>
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    @endif

    <div id="gallery-lightbox"
        class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-9999 hidden">
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
