<div wire:init="load">
    <div wire:loading.flex wire:target="load" class="items-center justify-center p-10">
        <span class="loading loading-spinner loading-md"></span>
    </div>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold capitalize">{{ $banner['judul'] ?? '' }}</h1>
            <p class="text-sm text-base-content/60 mt-1">{{ $banner['kategori'] ?? '' }}</p>
        </div>
        <div>
            <a wire:navigate href="{{ route('banner-carousel') }}" class="text-sm text-base-content/60">
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

    <div class="card">
        <div wire:loading.remove wire:target="load">
            @if ($error)
                <div
                    class="alert bg-warning/20 border border-warning text-white shadow-lg py-2 text-xs font-bold italic uppercase tracking-wider">
                    <span>{{ $error }}</span>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-start">
                    <div class="card border-2 border-dashed border-base-300 bg-base-100">
                        <div class="card-body">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-sm font-bold mt-1">
                                        Deskripsi
                                    </p>
                                    <p class="text-sm text-base-content/70 mt-1">
                                        {{ $banner['deskripsi'] ?? '' }}
                                    </p>
                                </div>
                                <span
                                    class="{{ $banner['is_active'] ?? false ? 'bg-success text-success-content' : 'bg-warning text-warning-content' }} rounded-md text-center text-md md:text-sm px-2 md:px-3 py-1 md:py-1">
                                    {{ $banner['is_active'] ?? false ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </div>
                            <div class="mt-4 space-y-2 text-sm">
                                <div class="flex items-start gap-3 p-3 rounded-xl bg-base-200 border border-base-300">
                                    <div class="bg-secondary p-2 rounded-3xl">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-5 text-white">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-semibold text-base-content/60">Urutan</p>
                                        <p class="text-sm font-medium font-mono text-base-content truncate">
                                            <span class="font-mono text-xs">
                                                NOMOR SLIDE: {{ $banner['urutan'] ?? '-' }}
                                                ID: {{ $banner['id'] ?? '-' }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-2 border-dashed border-base-300 bg-base-100">
                        <figure>
                            @if ($imageUrl)
                                <div class="w-full overflow-hidden aspect-video bg-base-200" wire:ignore>
                                    <img src="{{ $imageUrl }}" class="w-full h-full object-cover"
                                        alt="Banner Image" />
                                </div>
                            @else
                                <div
                                    class="w-full overflow-hidden aspect-video bg-base-200 flex items-center justify-center">
                                    <span class="text-base-content/60 text-sm">no-image</span>
                                </div>
                            @endif
                        </figure>
                        <div class="card-body">
                            <div class="flex flex-col sm:flex-row justify-between text-xs text-base-content/60">
                                <span>Dibuat: {{ $createdAtFormatted ?? '-' }}</span>
                                <span>Diperbarui: {{ $updatedAtFormatted ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
