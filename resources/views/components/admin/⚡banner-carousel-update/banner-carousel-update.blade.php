<div>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold">Update Banner Berita</h1>
            <p class="text-sm text-base-content/60 mt-1">Perbarui data banner</p>
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
                                <span class="label-text font-medium">Pilih Kategori yang Sudah Ada</span>
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
                                <span class="label-text font-medium text-base-content">Atau Ketik Kategori Banner
                                    Baru</span>
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
                            id="banner-update-slot" onclick="document.getElementById('banner-update-input').click()">

                            <!-- Hidden input -->
                            <input type="file" id="banner-update-input" class="hidden" accept="image/*"
                                onchange="handleBannerUpdateUpload(this)">

                            <!-- Empty State -->
                            <div class="flex flex-col items-center justify-center text-center p-4"
                                id="banner-update-empty"
                                style="{{ ($image || $imageUrl) ? 'display: none;' : '' }}">
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
                                    class="w-full h-full object-cover absolute inset-0" id="banner-update-preview">
                            @elseif ($imageUrl)
                                <img src="{{ $imageUrl }}" class="w-full h-full object-cover absolute inset-0"
                                    id="banner-update-preview" alt="Banner Image">
                            @else
                                <img class="w-full h-full object-cover absolute inset-0 hidden"
                                    id="banner-update-preview">
                            @endif

                            <!-- Loading State -->
                            <div class="absolute inset-0 bg-base-300/80 flex flex-col items-center justify-center p-4 hidden"
                                id="banner-update-loading">
                                <span class="loading loading-spinner loading-md text-accent"></span>
                                <span
                                    class="text-xs font-bold uppercase tracking-wider text-base-content/70 mt-2 text-center"
                                    id="banner-update-status">Mengompresi</span>
                                <div class="w-full bg-base-100 rounded-full h-1.5 mt-2 overflow-hidden">
                                    <div class="bg-accent h-full transition-all duration-300"
                                        id="banner-update-bar" style="width: 0%"></div>
                                </div>
                            </div>

                            <!-- Close Button -->
                            <button type="button"
                                class="btn btn-circle btn-xs btn-error text-white absolute top-2 right-2 z-10 {{ ($image || $imageUrl) ? '' : 'hidden' }}"
                                id="banner-update-close"
                                onclick="event.stopPropagation(); removeBannerUpdateImage()">
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

    <!-- FE JPEG Image Compression and Upload Script -->
    <script>
        (function() {
            function compressAndUploadBannerUpdate(file, fieldName, statusEl, progressBar, onComplete, onError) {
                const maxSizeBytes = 100 * 1024;
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
                        const minQuality = 0.05;

                        function attemptCompress() {
                            canvas.toBlob(function(blob) {
                                if (!blob) { onError('Gagal kompresi canvas'); return; }

                                if (blob.size <= maxSizeBytes || quality <= minQuality) {
                                    progressBar.style.width = '80%';
                                    if (statusEl) statusEl.textContent = 'Mengunggah...';

                                    const newName = file.name.substring(0, file.name.lastIndexOf('.')) + '.jpg';
                                    const compressedFile = new File([blob], newName, {
                                        type: 'image/jpeg',
                                        lastModified: Date.now()
                                    });

                                    const root = document.querySelector('[wire\\:id]');
                                    const componentId = root.getAttribute('wire:id');
                                    const component = window.Livewire.find(componentId);

                                    component.upload(
                                        fieldName,
                                        compressedFile,
                                        function() {
                                            progressBar.style.width = '100%';
                                            if (statusEl) statusEl.textContent = 'Selesai!';
                                            onComplete(compressedFile);
                                        },
                                        function(err) { onError('Gagal upload: ' + (err || 'Koneksi error')); },
                                        function(progressEvent) {
                                            const p = Math.round(80 + (progressEvent.detail.progress / 100) * 20);
                                            progressBar.style.width = p + '%';
                                        }
                                    );
                                } else {
                                    quality -= 0.05;
                                    attemptCompress();
                                }
                            }, 'image/jpeg', quality);
                        }
                        attemptCompress();
                    };
                    img.onerror = function() { onError('Format gambar rusak'); };
                };
                reader.onerror = function() { onError('Gagal membaca file'); };
            }

            window.handleBannerUpdateUpload = function(input) {
                const file = input.files[0];
                if (!file) return;

                const emptyWrap = document.getElementById('banner-update-empty');
                const previewImg = document.getElementById('banner-update-preview');
                const loadingWrap = document.getElementById('banner-update-loading');
                const statusText = document.getElementById('banner-update-status');
                const progressBar = document.getElementById('banner-update-bar');
                const closeBtn = document.getElementById('banner-update-close');

                emptyWrap.style.display = 'none';
                previewImg.classList.add('hidden');
                loadingWrap.classList.remove('hidden');
                progressBar.style.width = '0%';
                closeBtn.classList.add('hidden');

                compressAndUploadBannerUpdate(file, 'image', statusText, progressBar,
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

            window.removeBannerUpdateImage = function() {
                const emptyWrap = document.getElementById('banner-update-empty');
                const previewImg = document.getElementById('banner-update-preview');
                const closeBtn = document.getElementById('banner-update-close');
                const input = document.getElementById('banner-update-input');

                input.value = '';
                previewImg.src = '';
                previewImg.classList.add('hidden');
                emptyWrap.style.display = 'flex';
                closeBtn.classList.add('hidden');

                const root = document.querySelector('[wire\\:id]');
                const componentId = root.getAttribute('wire:id');
                window.Livewire.find(componentId).set('image', null);
            };
        })();
    </script>
</div>
