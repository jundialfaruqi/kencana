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
        <div class="card bg-base-100 border-2 border-dashed border-base-300 md:col-span-3">
            <div class="card-body">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text">Judul</span>
                        </div>
                        <input type="text" class="input input-bordered w-full mt-1.5" placeholder="Judul banner"
                            wire:model.live="judul" />
                        @error('judul')
                            <p class="text-warning italic text-xs mt-1">*{{ $message }}</p>
                        @enderror
                    </label>
                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text">Kategori</span>
                        </div>
                        <input type="text" class="input input-bordered w-full mt-1.5" placeholder="Kategori banner"
                            wire:model.live="kategori" />
                        @error('kategori')
                            <p class="text-warning italic text-xs mt-1">*{{ $message }}</p>
                        @enderror
                    </label>
                    <label class="form-control w-full md:col-span-2">
                        <div class="label">
                            <span class="label-text">Deskripsi</span>
                        </div>
                        <textarea class="textarea textarea-bordered w-full mt-1.5" rows="4" placeholder="Deskripsi singkat"
                            wire:model.live="deskripsi"></textarea>
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
                    <button class="btn btn-primary" wire:click="submit" wire:loading.attr="disabled"
                        wire:target="submit">
                        <span wire:loading.remove wire:target="submit">Simpan</span>
                        <span class="loading loading-spinner loading-xs" wire:loading wire:target="submit"></span>
                    </button>
                </div>
            </div>
        </div>

        <div class="card bg-base-100 border-2 border-dashed border-base-300 md:col-span-2">
            <div class="card-body">
                <div class="grid grid-cols-1 gap-4">
                    <div class="form-control w-full">
                        <div class="label">
                            <span class="label-text">Gambar Banner</span>
                        </div>
                        <input type="file" accept="image/png,image/jpeg"
                            class="file-input file-input-bordered w-full mt-1.5" wire:model.live="image" />
                        @error('image')
                            <p class="text-warning italic text-xs mt-1">*{{ $message }}</p>
                        @enderror
                        <div class="mt-2 rounded-xl overflow-hidden bg-base-200 aspect-video border border-base-300">
                            @if ($image instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile)
                                <img src="{{ $image->temporaryUrl() }}" class="w-full h-full object-cover"
                                    alt="Preview Banner">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <span class="text-base-content/60 text-sm">no-image</span>
                                </div>
                            @endif
                        </div>
                        <p class="text-[11px] text-base-content/60 mt-1">Format: PNG, JPG, JPEG • Maks. 2MB</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
