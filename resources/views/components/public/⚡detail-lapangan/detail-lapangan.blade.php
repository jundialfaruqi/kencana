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
                <div class="card-body">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex-1">
                            <div class="h-6 bg-base-300 w-1/2 rounded"></div>
                            <div class="h-4 bg-base-300 w-3/4 rounded mt-2"></div>
                        </div>
                        <div class="h-5 bg-base-300 w-20 rounded"></div>
                    </div>
                    <div class="mt-4 space-y-3">
                        <div class="flex items-center gap-2 p-3 rounded-xl bg-base-200 border border-base-200">
                            <div class="w-6 h-6 rounded-md bg-base-300"></div>
                            <div class="flex-1 min-w-0">
                                <div class="h-3 bg-base-300 w-24 rounded"></div>
                                <div class="h-3 bg-base-300 w-2/3 rounded mt-2"></div>
                                <div class="flex gap-4 mt-2">
                                    <div class="h-3 bg-base-300 w-16 rounded"></div>
                                    <div class="h-3 bg-base-300 w-16 rounded"></div>
                                </div>
                            </div>
                        </div>
                        <div class="w-full rounded-2xl overflow-hidden aspect-video bg-base-300"></div>
                        <div class="flex items-center gap-2">
                            <div class="h-8 bg-base-300 w-40 rounded-xl"></div>
                            <div class="h-8 bg-base-300 w-32 rounded-xl"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card bg-base-100 animate-pulse">
                <figure>
                    <div class="w-full overflow-hidden aspect-video bg-base-300"></div>
                </figure>
                <div class="card-body">
                    <div class="h-4 bg-base-300 w-32 rounded mb-3"></div>
                    <div class="grid grid-cols-3 gap-3">
                        @for ($i = 0; $i < 6; $i++)
                            <div class="aspect-square bg-base-300 rounded-xl"></div>
                        @endfor
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
                            @php $gmap = data_get($lapangan, 'gmap'); @endphp
                            <div class="mt-4">
                                {{-- <h3 class="text-sm text-center font-semibold mb-2">Maps</h3> --}}
                                <div class="w-full rounded-2xl overflow-hidden aspect-video bg-base-200"
                                    data-lat="{{ data_get($lapangan, 'latitude', '') }}"
                                    data-lng="{{ data_get($lapangan, 'longitude', '') }}"
                                    data-name="{{ data_get($lapangan, 'nama_lapangan', '-') }}"
                                    data-alamat="{{ data_get($lapangan, 'alamat', '-') }}"
                                    data-status="{{ data_get($lapangan, 'status_label', ucfirst(data_get($lapangan, 'status', '-'))) }}">
                                    <div id="lapangan-map" class="w-full h-full z-0" wire:ignore></div>
                                </div>
                            </div>
                            @if ((data_get($lapangan, 'status') ?? '') === 'open')
                                <div class="flex items-center gap-2">
                                    @if (!empty($gmap))
                                        <a href="{{ $gmap }}" target="_blank" rel="noopener"
                                            class="btn btn-sm btn-warning border-base-300 -skew-x-12">
                                            Lihat di Google Maps
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
                <div class="card bg-base-100 shadow" data-animate-detail>
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
                        <div>
                            <h3 class="text-sm font-semibold mb-2">Galeri Lapangan</h3>
                            @if (!empty($galleryUrls))
                                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                                    @foreach ($galleryUrls as $imgUrl)
                                        <div class="rounded-xl overflow-hidden bg-base-200 aspect-square">
                                            <img src="{{ $imgUrl }}" class="w-full h-full object-cover"
                                                alt="Foto Lapangan" />
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
            </div>
        @endif
    @endif
</div>
