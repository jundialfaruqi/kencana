(function () {
    function compressAndUploadBannerCreate(file, fieldName, statusEl, progressBar, onComplete, onError) {
        const maxSizeBytes = 100 * 1024;
        progressBar.style.width = '10%';
        if (statusEl) statusEl.textContent = 'Membaca...';

        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = function (event) {
            progressBar.style.width = '25%';
            if (statusEl) statusEl.textContent = 'Memuat...';

            const img = new Image();
            img.src = event.target.result;
            img.onload = function () {
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
                    canvas.toBlob(function (blob) {
                        if (!blob) {
                            onError('Gagal kompresi canvas');
                            return;
                        }

                        if (blob.size <= maxSizeBytes || quality <= minQuality) {
                            progressBar.style.width = '80%';
                            if (statusEl) statusEl.textContent = 'Mengunggah...';

                            const newName = file.name.substring(0, file.name.lastIndexOf('.')) + '.jpg';
                            const compressedFile = new File([blob], newName, {
                                type: 'image/jpeg',
                                lastModified: Date.now(),
                            });

                            const root = document.getElementById('banner-create-root');
                            const componentId = root.closest('[wire\\:id]').getAttribute('wire:id');
                            const component = window.Livewire.find(componentId);

                            component.upload(
                                fieldName,
                                compressedFile,
                                function () {
                                    progressBar.style.width = '100%';
                                    if (statusEl) statusEl.textContent = 'Selesai!';
                                    onComplete(compressedFile);
                                },
                                function (err) {
                                    onError('Gagal upload: ' + (err || 'Koneksi error'));
                                },
                                function (progressEvent) {
                                    const p = Math.round(80 + (progressEvent.detail.progress / 100) * 20);
                                    progressBar.style.width = p + '%';
                                },
                            );
                        } else {
                            quality -= 0.05;
                            attemptCompress();
                        }
                    }, 'image/jpeg', quality);
                }
                attemptCompress();
            };
            img.onerror = function () {
                onError('Format gambar rusak');
            };
        };
        reader.onerror = function () {
            onError('Gagal membaca file');
        };
    }

    window.handleBannerCreateUpload = function (input) {
        const file = input.files[0];
        if (!file) return;

        const emptyWrap = document.getElementById('banner-create-empty');
        const previewImg = document.getElementById('banner-create-preview');
        const loadingWrap = document.getElementById('banner-create-loading');
        const statusText = document.getElementById('banner-create-status');
        const progressBar = document.getElementById('banner-create-bar');
        const closeBtn = document.getElementById('banner-create-close');

        emptyWrap.style.display = 'none';
        previewImg.classList.add('hidden');
        loadingWrap.classList.remove('hidden');
        progressBar.style.width = '0%';
        closeBtn.classList.add('hidden');

        compressAndUploadBannerCreate(file, 'image', statusText, progressBar,
            function (compFile) {
                loadingWrap.classList.add('hidden');
                const url = URL.createObjectURL(compFile);
                previewImg.src = url;
                previewImg.classList.remove('hidden');
                closeBtn.classList.remove('hidden');
            },
            function (err) {
                loadingWrap.classList.add('hidden');
                emptyWrap.style.display = 'flex';
                alert(err);
            },
        );
    };

    window.removeBannerCreateImage = function () {
        const emptyWrap = document.getElementById('banner-create-empty');
        const previewImg = document.getElementById('banner-create-preview');
        const closeBtn = document.getElementById('banner-create-close');
        const input = document.getElementById('banner-create-input');

        input.value = '';
        previewImg.src = '';
        previewImg.classList.add('hidden');
        emptyWrap.style.display = 'flex';
        closeBtn.classList.add('hidden');

        const root = document.getElementById('banner-create-root');
        const componentId = root.closest('[wire\\:id]').getAttribute('wire:id');
        window.Livewire.find(componentId).set('image', null);
    };
})();