<div id="lapangan-update-root">
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
        <div class="card bg-base-100 md:col-span-3">
            <div class="card-body">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <label class="form-control w-full md:col-span-2">
                        <div class="label">
                            <span class="label-text">Nama Lapangan</span>
                        </div>
                        <input type="text" class="input input-bordered w-full mt-1.5" placeholder="Contoh: Arena A"
                            wire:model.blur="nama_lapangan" />
                        @error('nama_lapangan')
                            <p class="text-warning italic text-xs mt-1">*{{ $message }}</p>
                        @enderror
                    </label>
                    <label class="form-control w-full md:col-span-2">
                        <div class="label">
                            <span class="label-text">Deskripsi</span>
                        </div>
                        <textarea class="textarea textarea-bordered w-full mt-1.5" rows="4" placeholder="Deskripsi singkat"
                            wire:model.blur="deskripsi"></textarea>
                        @error('deskripsi')
                            <p class="text-warning italic text-xs mt-1">*{{ $message }}</p>
                        @enderror
                    </label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:col-span-2">
                        <label class="form-control w-full">
                            <div class="label">
                                <span class="label-text">No. Telepon</span>
                            </div>
                            <input type="tel" class="input input-bordered w-full mt-1.5" placeholder="08123456789"
                                wire:model.blur="no_tlp" />
                            @error('no_tlp')
                                <p class="text-warning italic text-xs mt-1">*{{ $message }}</p>
                            @enderror
                        </label>
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
                    </div>

                    <div class="md:col-span-2 bg-base-200/50 border border-base-300 rounded-xl p-4 space-y-4">
                        <div class="flex items-center justify-between">
                            <h3 class="font-bold text-base">Informasi Lokasi</h3>
                            <button type="button" onclick="window.__mapPicker && window.__mapPicker.open()"
                                class="btn btn-sm btn-secondary">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                </svg>
                                Pilih Maps
                            </button>
                        </div>

                        <label class="form-control w-full">
                            <div class="label"><span class="label-text">Alamat</span></div>
                            <input type="text" class="input input-bordered w-full mt-1.5"
                                placeholder="Alamat lengkap" wire:model="alamat" />
                            @error('alamat')
                                <p class="text-warning italic text-xs mt-1">*{{ $message }}</p>
                            @enderror
                        </label>

                        <label class="form-control w-full">
                            <div class="label"><span class="label-text">Link Google Maps</span></div>
                            <input type="url" class="input input-bordered w-full mt-1.5"
                                placeholder="https://maps.google.com/..." wire:model="gmap" />
                            @error('gmap')
                                <p class="text-warning italic text-xs mt-1">*{{ $message }}</p>
                            @enderror
                        </label>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <label class="form-control w-full">
                                <div class="label"><span class="label-text">Latitude</span></div>
                                <input type="number" step="any" class="input input-bordered w-full mt-1.5"
                                    placeholder="-0.12345" wire:model="latitude" />
                                @error('latitude')
                                    <p class="text-warning italic text-xs mt-1">*{{ $message }}</p>
                                @enderror
                            </label>
                            <label class="form-control w-full">
                                <div class="label"><span class="label-text">Longitude</span></div>
                                <input type="number" step="any" class="input input-bordered w-full mt-1.5"
                                    placeholder="101.12345" wire:model="longitude" />
                                @error('longitude')
                                    <p class="text-warning italic text-xs mt-1">*{{ $message }}</p>
                                @enderror
                            </label>
                        </div>
                    </div>
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
                    <!-- Cover Upload Slot -->
                    <div class="form-control w-full">
                        <div class="label">
                            <span class="label-text">Cover</span>
                        </div>
                        <div class="relative group aspect-video w-full rounded-2xl border-2 border-dashed border-base-300 bg-base-200 hover:border-accent overflow-hidden flex flex-col items-center justify-center cursor-pointer transition-all"
                            id="cover-slot" onclick="document.getElementById('cover-input').click()">

                            <!-- Hidden input -->
                            <input type="file" id="cover-input" class="hidden" accept="image/*"
                                onchange="handleCoverUpload(this)">

                            <!-- Empty State -->
                            <div class="mt-2 flex flex-col items-center justify-center text-center p-4"
                                id="cover-empty"
                                style="{{ $image_cover || !empty($coverUrl) ? 'display: none;' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor"
                                    class="w-8 h-8 text-base-content/40 mb-1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                <span class="text-xs font-semibold text-base-content/60">Tambah Cover</span>
                            </div>

                            <!-- Preview State -->
                            @if ($image_cover instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile)
                                <img src="{{ $image_cover->temporaryUrl() }}"
                                    class="w-full h-full object-cover absolute inset-0" id="cover-preview">
                            @elseif (!empty($coverUrl))
                                <img src="{{ $coverUrl }}" class="w-full h-full object-cover absolute inset-0"
                                    id="cover-preview">
                            @else
                                <img class="w-full h-full object-cover absolute inset-0 hidden" id="cover-preview">
                            @endif

                            <!-- Loading State -->
                            <div class="absolute inset-0 bg-base-300/80 flex flex-col items-center justify-center p-4 hidden"
                                id="cover-loading">
                                <span class="loading loading-spinner loading-md text-accent"></span>
                                <span
                                    class="text-xs font-bold uppercase tracking-wider text-base-content/70 mt-2 text-center"
                                    id="cover-status">Mengompresi</span>
                                <div class="w-full bg-base-100 rounded-full h-1.5 mt-2 overflow-hidden">
                                    <div class="bg-accent h-full transition-all duration-300" id="cover-bar"
                                        style="width: 0%"></div>
                                </div>
                            </div>

                            <!-- Close Button -->
                            <button type="button"
                                class="btn btn-circle btn-xs btn-error text-white absolute top-2 right-2 z-10 {{ $image_cover || !empty($coverUrl) ? '' : 'hidden' }}"
                                id="cover-close" onclick="event.stopPropagation(); removeCoverImage()">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <p class="text-[11px] text-base-content/60 mt-2">Format: PNG, JPG, JPEG • Maks. 90KB setelah
                            kompresi otomatis</p>
                        @error('image_cover')
                            <p class="text-warning italic text-xs mt-1">*{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Gallery Upload Slots (1 Row, 4 Columns) -->
                    <div class="form-control w-full">
                        <div class="label mb-2">
                            <span class="label-text">Galeri</span>
                            <span class="text-[11px] text-base-content/50">Maks. 4 gambar</span>
                        </div>
                        <p class="text-[11px] text-warning italic mb-2">Saat update Gambar galeri baru, semua data
                            gambar galeri sebelumnya akan di hapus</p>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 w-full">
                            @foreach ($images as $idx => $file)
                                @php
                                    $existingUrl = $galleryUrls[$idx] ?? null;
                                @endphp
                                <div class="relative group aspect-square rounded-2xl border-2 border-dashed border-base-300 bg-base-200 hover:border-secondary overflow-hidden flex flex-col items-center justify-center cursor-pointer transition-all"
                                    id="gallery-slot-{{ $idx }}"
                                    onclick="document.getElementById('gallery-input-{{ $idx }}').click()">

                                    <!-- Hidden input -->
                                    <input type="file" id="gallery-input-{{ $idx }}" class="hidden"
                                        accept="image/*" onchange="handleGalleryUpload(this, {{ $idx }})">

                                    <!-- Empty State -->
                                    <div class="flex flex-col items-center justify-center text-center p-2"
                                        id="gallery-empty-{{ $idx }}"
                                        style="{{ $file || !empty($existingUrl) ? 'display: none;' : '' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="2" stroke="currentColor"
                                            class="w-6 h-6 text-base-content/40 mb-1">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 4.5v15m7.5-7.5h-15" />
                                        </svg>
                                        <span class="text-[10px] font-semibold text-base-content/60">Tambah Foto</span>
                                    </div>

                                    <!-- Preview State -->
                                    @if ($file instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile)
                                        <img src="{{ $file->temporaryUrl() }}"
                                            class="w-full h-full object-cover absolute inset-0"
                                            id="gallery-preview-{{ $idx }}">
                                    @elseif (!empty($existingUrl))
                                        <img src="{{ $existingUrl }}"
                                            class="w-full h-full object-cover absolute inset-0"
                                            id="gallery-preview-{{ $idx }}">
                                    @else
                                        <img class="w-full h-full object-cover absolute inset-0 hidden"
                                            id="gallery-preview-{{ $idx }}">
                                    @endif

                                    <!-- Loading State -->
                                    <div class="absolute inset-0 bg-base-300/80 flex flex-col items-center justify-center p-3 hidden"
                                        id="gallery-loading-{{ $idx }}">
                                        <span class="loading loading-spinner loading-sm text-secondary"></span>
                                        <span
                                            class="text-[9px] font-bold uppercase tracking-wider text-base-content/70 mt-1 text-center"
                                            id="gallery-status-{{ $idx }}">Mengompresi</span>
                                        <div class="w-full bg-base-100 rounded-full h-1 mt-1.5 overflow-hidden">
                                            <div class="bg-secondary h-full transition-all duration-300"
                                                id="gallery-bar-{{ $idx }}" style="width: 0%"></div>
                                        </div>
                                    </div>

                                    <!-- Close Button -->
                                    <button type="button"
                                        class="btn btn-circle btn-xs btn-error text-white absolute top-2 right-2 z-10 {{ $file || !empty($existingUrl) ? '' : 'hidden' }}"
                                        id="gallery-close-{{ $idx }}"
                                        onclick="event.stopPropagation(); removeGalleryImage({{ $idx }})">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M6 18 18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                        <p class="text-[11px] text-base-content/60 mt-2.5">Setiap slot maks. 90KB setelah kompresi
                            otomatis</p>
                        @error('images')
                            <p class="text-warning italic text-xs mt-1">*{{ $message }}</p>
                        @enderror
                        @foreach (range(0, 3) as $i)
                            @error('images.' . $i)
                                <p class="text-warning italic text-xs mt-1">*Slot {{ $i + 1 }}:
                                    {{ $message }}</p>
                            @enderror
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Map Picker Modal -->
    <x-map-picker-modal />

    <!-- FE WebP Image Compression and Upload Script -->
    <script>
        (function() {
            function compressAndUpload(file, fieldName, statusEl, progressBar, onComplete, onError) {
                const maxSizeBytes = 90 * 1024; // 90KB limit
                progressBar.style.width = '10%';
                if (statusEl) statusEl.textContent = 'Membaca...';

                const reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = function(event) {
                    progressBar.style.width = '25%';
                    if (statusEl) statusEl.textContent = 'Memuat...';

                    const img = new Image();
                    img.src = event.target.result;
                    img.onload = function() {
                        progressBar.style.width = '40%';
                        if (statusEl) statusEl.textContent = 'Menyalin...';

                        const canvas = document.createElement('canvas');
                        let width = img.width;
                        let height = img.height;

                        const maxDim = 1000;
                        if (width > maxDim || height > maxDim) {
                            if (width > height) {
                                height = Math.round((height * maxDim) / width);
                                width = maxDim;
                            } else {
                                width = Math.round((width * maxDim) / height);
                                height = maxDim;
                            }
                        }
                        canvas.width = width;
                        canvas.height = height;

                        const ctx = canvas.getContext('2d');
                        ctx.drawImage(img, 0, 0, width, height);

                        progressBar.style.width = '60%';
                        if (statusEl) statusEl.textContent = 'Kompresi...';

                        let quality = 0.85;
                        let minQuality = 0.05;

                        function attemptCompress() {
                            canvas.toBlob(function(blob) {
                                if (!blob) {
                                    onError('Gagal kompresi canvas');
                                    return;
                                }

                                if (blob.size <= maxSizeBytes || quality <= minQuality) {
                                    progressBar.style.width = '80%';
                                    if (statusEl) statusEl.textContent = 'Mengunggah...';

                                    const newName = file.name.substring(0, file.name.lastIndexOf('.')) +
                                        '.webp';
                                    const compressedFile = new File([blob], newName, {
                                        type: 'image/webp',
                                        lastModified: Date.now()
                                    });

                                    const root = document.getElementById('lapangan-update-root');
                                    const componentId = root.closest('[wire\\:id]').getAttribute(
                                        'wire:id');
                                    const component = window.Livewire.find(componentId);

                                    component.upload(
                                        fieldName,
                                        compressedFile,
                                        function(uploadedVal) {
                                            progressBar.style.width = '100%';
                                            if (statusEl) statusEl.textContent = 'Selesai!';
                                            onComplete(compressedFile);
                                        },
                                        function(err) {
                                            onError('Gagal upload: ' + (err || 'Koneksi error'));
                                        },
                                        function(progressEvent) {
                                            const p = Math.round(80 + (progressEvent.detail
                                                .progress / 100) * 20);
                                            progressBar.style.width = p + '%';
                                        }
                                    );
                                } else {
                                    quality -= 0.05;
                                    attemptCompress();
                                }
                            }, 'image/webp', quality);
                        }
                        attemptCompress();
                    };
                    img.onerror = function() {
                        onError('Format gambar rusak');
                    };
                };
                reader.onerror = function() {
                    onError('Gagal membaca file');
                };
            }

            window.handleCoverUpload = function(input) {
                const file = input.files[0];
                if (!file) return;

                const emptyWrap = document.getElementById('cover-empty');
                const previewImg = document.getElementById('cover-preview');
                const loadingWrap = document.getElementById('cover-loading');
                const statusText = document.getElementById('cover-status');
                const progressBar = document.getElementById('cover-bar');
                const closeBtn = document.getElementById('cover-close');

                emptyWrap.style.display = 'none';
                previewImg.classList.add('hidden');
                loadingWrap.classList.remove('hidden');
                progressBar.style.width = '0%';
                closeBtn.classList.add('hidden');

                compressAndUpload(file, 'image_cover', statusText, progressBar,
                    function(compFile) {
                        loadingWrap.classList.add('hidden');
                        const url = URL.createObjectURL(compFile);
                        previewImg.src = url;
                        previewImg.classList.remove('hidden');
                        closeBtn.classList.remove('hidden');
                    },
                    function(err) {
                        loadingWrap.classList.add('hidden');
                        emptyWrap.style.display = 'flex';
                        alert(err);
                    }
                );
            };

            window.removeCoverImage = function() {
                const emptyWrap = document.getElementById('cover-empty');
                const previewImg = document.getElementById('cover-preview');
                const closeBtn = document.getElementById('cover-close');
                const input = document.getElementById('cover-input');

                input.value = '';
                previewImg.src = '';
                previewImg.classList.add('hidden');
                emptyWrap.style.display = 'flex';
                closeBtn.classList.add('hidden');

                const root = document.getElementById('lapangan-update-root');
                const componentId = root.closest('[wire\\:id]').getAttribute('wire:id');
                const component = window.Livewire.find(componentId);
                component.set('image_cover', null);
                component.set('coverUrl', null);
            };

            window.handleGalleryUpload = function(input, index) {
                const file = input.files[0];
                if (!file) return;

                const emptyWrap = document.getElementById('gallery-empty-' + index);
                const previewImg = document.getElementById('gallery-preview-' + index);
                const loadingWrap = document.getElementById('gallery-loading-' + index);
                const statusText = document.getElementById('gallery-status-' + index);
                const progressBar = document.getElementById('gallery-bar-' + index);
                const closeBtn = document.getElementById('gallery-close-' + index);

                emptyWrap.style.display = 'none';
                previewImg.classList.add('hidden');
                loadingWrap.classList.remove('hidden');
                progressBar.style.width = '0%';
                closeBtn.classList.add('hidden');

                compressAndUpload(file, 'images.' + index, statusText, progressBar,
                    function(compFile) {
                        loadingWrap.classList.add('hidden');
                        const url = URL.createObjectURL(compFile);
                        previewImg.src = url;
                        previewImg.classList.remove('hidden');
                        closeBtn.classList.remove('hidden');
                    },
                    function(err) {
                        loadingWrap.classList.add('hidden');
                        emptyWrap.style.display = 'flex';
                        alert(err);
                    }
                );
            };

            window.removeGalleryImage = function(index) {
                const emptyWrap = document.getElementById('gallery-empty-' + index);
                const previewImg = document.getElementById('gallery-preview-' + index);
                const closeBtn = document.getElementById('gallery-close-' + index);
                const input = document.getElementById('gallery-input-' + index);

                input.value = '';
                previewImg.src = '';
                previewImg.classList.add('hidden');
                emptyWrap.style.display = 'flex';
                closeBtn.classList.add('hidden');

                const root = document.getElementById('lapangan-update-root');
                const componentId = root.closest('[wire\\:id]').getAttribute('wire:id');
                const component = window.Livewire.find(componentId);
                component.call('removeImage', index);
                component.call('removeGalleryUrl', index);
            };
        })();
    </script>

    <!-- Map Picker Modal -->
    <x-map-picker-modal />
</div>
