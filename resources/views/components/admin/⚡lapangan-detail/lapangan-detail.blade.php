<div>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold">Lapangan Detail</h1>
            <p class="text-sm text-base-content/60 mt-1">Informasi lengkap lapangan</p>
        </div>
        <div>
            <a wire:navigate href="/manajemen-lapangan" class="text-sm text-base-content/60">
                <span class="inline-flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                    </svg>
                    <span>Kembali</span>
                </span>
            </a>
        </div>
    </div>

    <div class="card" wire:init="load">
        <div wire:loading.flex wire:target="load" class="items-center justify-center p-10">
            <span class="loading loading-spinner loading-md"></span>
        </div>
        <div wire:loading.remove wire:target="load">
            @if ($error)
                <div class="alert alert-error mb-4">
                    <span>{{ $error }}</span>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-start">
                    <div class="card border-2 border-dashed border-base-300 bg-base-100">
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

                    <div class="card border-2 border-dashed border-base-300 bg-base-100">
                        <div class="card-body">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <h2 class="card-title">{{ data_get($lapangan, 'nama_lapangan', '-') }}</h2>
                                    <p class="text-sm text-base-content/70 mt-1">
                                        {{ data_get($lapangan, 'deskripsi', '-') }}
                                    </p>
                                </div>
                                <span
                                    class="{{ data_get($lapangan, 'status') === 'open' ? 'bg-success text-success-content' : 'bg-warning text-warning-content' }} rounded-md text-center text-md md:text-sm px-2 md:px-3 py-1 md:py-1">
                                    {{ data_get($lapangan, 'status_label', ucfirst(data_get($lapangan, 'status', '-'))) }}
                                </span>
                            </div>
                            <div class="mt-4 space-y-2 text-sm">
                                <div class="flex items-start gap-3 p-3 rounded-xl bg-base-200 border border-base-200">
                                    <div class="bg-secondary p-2 rounded-3xl">
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
                                        <p class="text-sm font-medium text-base-content truncate">
                                            {{ data_get($lapangan, 'alamat', '-') }}
                                        </p>
                                        <div class="mt-1 flex flex-wrap items-center gap-x-4 gap-y-1">
                                            <span class="font-mono text-xs">Lat:
                                                {{ data_get($lapangan, 'latitude', '-') }}</span>
                                            <span class="font-mono text-xs">Lng:
                                                {{ data_get($lapangan, 'longitude', '-') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <h3 class="text-sm text-center font-semibold mb-2">Maps</h3>
                                    <div class="w-full rounded-2xl overflow-hidden aspect-video bg-base-200"
                                        data-lat="{{ data_get($lapangan, 'latitude', '') }}"
                                        data-lng="{{ data_get($lapangan, 'longitude', '') }}"
                                        data-name="{{ data_get($lapangan, 'nama_lapangan', '-') }}"
                                        data-alamat="{{ data_get($lapangan, 'alamat', '-') }}"
                                        data-status="{{ data_get($lapangan, 'status_label', ucfirst(data_get($lapangan, 'status', '-'))) }}">
                                        <div id="lapangan-map" class="w-full h-full z-0" wire:ignore></div>
                                    </div>
                                </div>
                                <div class="text-xs text-center text-base-content/60 mt-2">
                                    <span>Admin: {{ data_get($lapangan, 'admin.name', '-') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer p-3 bg-base-200 border-t border-base-200 rounded-b-xl">
                            <div class="flex items-center justify-end gap-2">
                                <a wire:navigate href="/lapangan-update?id={{ $id }}"
                                    class="btn btn-sm btn-secondary text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="1.5" class="w-4 h-4 mr-1">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                    <span>Edit Lapangan</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
