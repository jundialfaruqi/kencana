<div id="lapangan-update-root" wire:init="load">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold">Update Lapangan</h1>
            <p class="text-sm text-base-content/60 mt-1">Ubah data lapangan</p>
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
                            <span class="label-text">Nama Lapangan</span>
                        </div>
                        <input type="text" class="input input-bordered w-full mt-1.5" placeholder="Contoh: Arena A"
                            wire:model.live="nama_lapangan" />
                        @error('nama_lapangan')
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
                    <label class="form-control w-full md:col-span-2">
                        <div class="label">
                            <span class="label-text">Alamat</span>
                        </div>
                        <input type="text" class="input input-bordered w-full mt-1.5" placeholder="Alamat lengkap"
                            wire:model.live="alamat" />
                        @error('alamat')
                            <p class="text-warning italic text-xs mt-1">*{{ $message }}</p>
                        @enderror
                    </label>
                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text">Link Google Maps</span>
                        </div>
                        <input type="url" class="input input-bordered w-full mt-1.5"
                            placeholder="https://maps.google.com/..." wire:model.live="gmap" />
                        @error('gmap')
                            <p class="text-warning italic text-xs mt-1">*{{ $message }}</p>
                        @enderror
                    </label>
                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text">No. Telepon</span>
                        </div>
                        <input type="tel" class="input input-bordered w-full mt-1.5" placeholder="08123456789"
                            wire:model.live="np_telp" />
                        @error('np_telp')
                            <p class="text-warning italic text-xs mt-1">*{{ $message }}</p>
                        @enderror
                    </label>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:col-span-2">
                        <label class="form-control w-full">
                            <div class="label">
                                <span class="label-text">Status</span>
                            </div>
                            <select class="select select-bordered w-full mt-1.5" wire:model.live="status">
                                <option value="open">Open</option>
                                <option value="coming_soon">Coming Soon</option>
                            </select>
                            @error('status')
                                <p class="text-warning italic text-xs mt-1">*{{ $message }}</p>
                            @enderror
                        </label>
                        <label class="form-control w-full">
                            <div class="label">
                                <span class="label-text">Latitude</span>
                            </div>
                            <input type="number" step="any" class="input input-bordered w-full mt-1.5"
                                placeholder="-0.12345" wire:model.live="latitude" />
                            @error('latitude')
                                <p class="text-warning italic text-xs mt-1">*{{ $message }}</p>
                            @enderror
                        </label>
                        <label class="form-control w-full">
                            <div class="label">
                                <span class="label-text">Longitude</span>
                            </div>
                            <input type="number" step="any" class="input input-bordered w-full mt-1.5"
                                placeholder="101.12345" wire:model.live="longitude" />
                            @error('longitude')
                                <p class="text-warning italic text-xs mt-1">*{{ $message }}</p>
                            @enderror
                        </label>
                    </div>
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
                            <span class="label-text">Cover</span>
                        </div>
                        <input type="file" accept="image/png,image/jpeg"
                            class="file-input file-input-bordered w-full mt-1.5" wire:model.live="image_cover" />
                        @error('image_cover')
                            <p class="text-warning italic text-xs mt-1">*{{ $message }}</p>
                        @enderror
                        <div class="mt-2 rounded-xl overflow-hidden bg-base-200 aspect-video border border-base-300">
                            @if ($image_cover instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile)
                                <img src="{{ $image_cover->temporaryUrl() }}" class="w-full h-full object-cover"
                                    alt="Preview Cover">
                            @elseif (!empty($coverUrl))
                                <img src="{{ $coverUrl }}" class="w-full h-full object-cover" alt="Cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <span class="text-base-content/60 text-sm">no-image</span>
                                </div>
                            @endif
                        </div>
                        <p class="text-[11px] text-base-content/60 mt-1">Format: PNG, JPG, JPEG • Maks. 2MB</p>
                    </div>
                    <div class="form-control w-full">
                        <div class="label mb-2">
                            <span class="label-text">Galeri</span>
                            @if (count($images) < 4)
                                <button type="button" class="btn btn-xs btn-primary ml-auto"
                                    wire:click="addImageField" wire:loading.attr="disabled"
                                    wire:target="addImageField">
                                    <span class="inline-flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" class="size-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 4.5v15m7.5-7.5h-15" />
                                        </svg>
                                        <span>Tambah Gambar</span>
                                    </span>
                                </button>
                            @else
                                <span class="ml-auto text-[11px] text-base-content/70">Maksimal 4 gambar</span>
                            @endif
                        </div>
                        <p class="text-[11px] text-warning italic mb-2">Saat update Gambar galeri baru, semua data
                            gambar galeri sebelumnya akan di hapus</p>
                        @if (count($galleryUrls) > 0)
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-2 mb-3">
                                @foreach ($galleryUrls as $gurl)
                                    <img src="{{ $gurl }}"
                                        class="w-full h-24 object-cover rounded-lg border border-base-300"
                                        alt="Galeri">
                                @endforeach
                            </div>
                        @endif
                        <div class="space-y-3">
                            @foreach ($images as $idx => $file)
                                <div class="p-3 bg-base-200 border border-base-300 rounded-xl">
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 items-center">
                                        <div class="md:col-span-2">
                                            <input type="file" accept="image/png,image/jpeg"
                                                class="file-input file-input-bordered w-full"
                                                wire:model.live="images.{{ $idx }}" />
                                            @error('images.' . $idx)
                                                <p class="text-warning italic text-xs mt-1">*{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="flex items-center justify-end gap-2">
                                            @if ($file instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile)
                                                <img src="{{ $file->temporaryUrl() }}"
                                                    class="w-16 h-16 object-cover rounded-lg border border-base-300"
                                                    alt="Preview">
                                            @endif
                                            <button type="button" class="btn btn-error btn-xs"
                                                wire:click="removeImage({{ $idx }})"
                                                wire:loading.attr="disabled"
                                                wire:target="removeImage({{ $idx }})">
                                                Hapus
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <p class="text-[11px] text-base-content/60 mt-1">Format: PNG, JPG, JPEG • Maks. 2MB</p>
                        @error('images')
                            <p class="text-warning italic text-xs mt-1">*{{ $message }}</p>
                        @enderror
                        @error('images.*')
                            <p class="text-warning italic text-xs mt-1">*{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
