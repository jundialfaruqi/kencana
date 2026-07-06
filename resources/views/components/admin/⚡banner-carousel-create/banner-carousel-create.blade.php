<div id="banner-create-root">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold">Buat Banner Berita</h1>
            <p class="text-sm text-base-content/60 mt-1">Tambah data banner baru</p>
        </div>
        <div>
            <button type="button" wire:click="cancel" class="text-sm text-base-content/60">
                <span class="inline-flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                    </svg>
                    <span>Kembali</span>
                </span>
            </button>
        </div>
    </div>

    @if ($error)
        <div class="alert alert-error mb-4">
            <span>{{ $error }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-start">
        <div class="card bg-base-100 md:col-span-3">
            <div class="card-body">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <label class="form-control w-full md:col-span-2">
                        <div class="label">
                            <span class="label-text">Judul</span>
                        </div>
                        <input type="text" class="input input-bordered w-full mt-1.5" placeholder="Judul banner"
                            wire:model.live="judul" />
                        @error('judul')
                            <p class="text-warning italic text-xs mt-1">*{{ $message }}</p>
                        @enderror
                    </label>
                    <div class="card md:col-span-2 p-4 bg-base-200 text-base-content mt-1">
                        <div class="form-control w-full md:col-span-2 mb-4">
                            <div>
                                <span class="label-text font-bold">Pilih Kategori yang Sudah Ada</span>
                            </div>
                            <div class="flex flex-wrap gap-2 mt-1.5" wire:ignore.self>
                                @foreach ($availableKategoriBanner as $kategori)
                                    <button type="button" wire:key="{{ $kategori }}"
                                        class="btn btn-sm {{ $selectedKategoriBanner === $kategori ? 'btn-secondary' : 'btn-outline' }}"
                                        wire:click="selectKategoriBanner('{{ $kategori }}')">
                                        {{ $kategori }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                        <label class="form-control w-full md:col-span-2">
                            <div class="label">
                                <span class="label-text font-semibold">Atau Ketik Kategori Banner Baru</span>
                            </div>
                            <label class="input input-bordered flex items-center w-full gap-2 mt-1.5">
                                <input type="text"
                                    class="grow text-gray-600 disabled:text-success disabled:font-bold"
                                    placeholder="Tulis kategori banner..." wire:model.live="kategori"
                                    x-data="{}" x-bind:disabled="$wire.selectedKategoriBanner !== null">
                                <span x-show="$wire.selectedKategoriBanner !== null">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6 text-success">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m4.5 12.75 6 6 9-13.5" />
                                    </svg>
                                </span>
                            </label>
                            @error('kategori')
                                <p class="text-[10px] text-warning italic mt-1 font-bold uppercase">*{{ $message }}
                                </p>
                            @enderror
                        </label>
                    </div>
                    <label class="form-control w-full md:col-span-2">
                        <div class="label">
                            <span class="label-text">Deskripsi</span>
                        </div>
                        <textarea class="textarea textarea-bordered w-full mt-1.5 min-h-36 resize-none overflow-hidden" rows="20" placeholder="Deskripsi singkat"
                            wire:model.blur="deskripsi" wire:ignore></textarea>
                        @error('deskripsi')
                            <p class="text-warning italic text-xs mt-1">*{{ $message }}</p>
                        @enderror
                    </label>
                </div>
            </div>
            <div class="card-footer p-4 rounded-b-xl">
                <div class="flex items-center justify-end gap-2">
                    <button class="btn btn-ghost" wire:click="cancel" wire:loading.attr="disabled"
                        wire:loading.class="btn-disabled pointer-events-none opacity-50"
                        wire:target="cancel">Kembali</button>
                    <button class="btn btn-accent" wire:click="submit" wire:loading.attr="disabled"
                        wire:target="submit">
                        <span wire:loading.remove wire:target="submit">Simpan</span>
                        <span class="loading loading-spinner loading-xs" wire:loading wire:target="submit"></span>
                    </button>
                </div>
            </div>
        </div>

        <div class="card bg-base-100 md:col-span-2">
            <div class="card-body">
                <div class="grid grid-cols-1 gap-4">
                    <!-- Banner Image Upload Slot -->
                    <div class="form-control w-full">
                        <div class="label">
                            <span class="label-text">Gambar Banner</span>
                        </div>
                        <div class="mt-2 relative group aspect-video w-full rounded-2xl border-2 border-dashed border-base-300 bg-base-200 hover:border-accent overflow-hidden flex flex-col items-center justify-center cursor-pointer transition-all"
                            id="banner-create-slot" onclick="document.getElementById('banner-create-input').click()">

                            <!-- Hidden input -->
                            <input type="file" id="banner-create-input" class="hidden" accept="image/*"
                                onchange="handleBannerCreateUpload(this)">

                            <!-- Empty State -->
                            <div class="flex flex-col items-center justify-center text-center p-4"
                                id="banner-create-empty"
                                style="{{ $image ? 'display: none;' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor"
                                    class="w-8 h-8 text-base-content/40 mb-1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                <span class="text-xs font-semibold text-base-content/60">Tambah Gambar Banner</span>
                            </div>

                            <!-- Preview State -->
                            @if ($image instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile)
                                <img src="{{ $image->temporaryUrl() }}"
                                    class="w-full h-full object-cover absolute inset-0" id="banner-create-preview">
                            @else
                                <img class="w-full h-full object-cover absolute inset-0 hidden"
                                    id="banner-create-preview">
                            @endif

                            <!-- Loading State -->
                            <div class="absolute inset-0 bg-base-300/80 flex flex-col items-center justify-center p-4 hidden"
                                id="banner-create-loading">
                                <span class="loading loading-spinner loading-md text-accent"></span>
                                <span
                                    class="text-xs font-bold uppercase tracking-wider text-base-content/70 mt-2 text-center"
                                    id="banner-create-status">Mengompresi</span>
                                <div class="w-full bg-base-100 rounded-full h-1.5 mt-2 overflow-hidden">
                                    <div class="bg-accent h-full transition-all duration-300"
                                        id="banner-create-bar" style="width: 0%"></div>
                                </div>
                            </div>

                            <!-- Close Button -->
                            <button type="button"
                                class="btn btn-circle btn-xs btn-error text-white absolute top-2 right-2 z-10 {{ $image ? '' : 'hidden' }}"
                                id="banner-create-close"
                                onclick="event.stopPropagation(); removeBannerCreateImage()">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <p class="text-[11px] text-base-content/60 mt-2">Format: PNG, JPG, JPEG • Maks. 100KB setelah
                            kompresi otomatis</p>
                        @error('image')
                            <p class="text-warning italic text-xs mt-1">*{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
