<div id="map-picker-wrapper">
    <dialog id="map_picker_modal" class="modal">
        <div class="modal-box w-11/12 max-w-5xl">
            <h3 class="font-bold text-lg mb-4">Pilih Lokasi Lapangan</h3>

            <div class="relative mb-4">
                <div class="flex gap-2">
                    <input type="text" id="map-search-input"
                        placeholder="Cari nama jalan, daerah, atau tempat..."
                        class="input input-bordered w-full" />
                    <button type="button" id="map-search-btn" class="btn btn-secondary">
                        <span id="map-search-text">Cari</span>
                        <span id="map-search-spinner" class="loading loading-spinner loading-xs hidden"></span>
                    </button>
                </div>

                <!-- Dropdown Live Search Results -->
                <ul id="map-search-results"
                    class="menu bg-base-100 border border-base-300 w-full rounded-box absolute top-full left-0 mt-1 z-[100] max-h-60 overflow-y-auto shadow-2xl hidden">
                </ul>
            </div>

            <div id="map-picker-container"
                class="w-full h-[50vh] bg-base-200 rounded-xl z-0 mb-4 border border-base-300 relative">
                <div id="map-spinner" class="absolute inset-0 flex items-center justify-center">
                    <span class="loading loading-spinner loading-md"></span>
                </div>
            </div>

            <div
                class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm mb-4 bg-base-200 p-4 rounded-xl border border-base-300">
                <div>
                    <span class="font-bold text-base-content/70 block mb-1">Koordinat Terpilih:</span>
                    <span id="map-coords-display">-</span>
                </div>
                <div>
                    <span class="font-bold text-base-content/70 block mb-1">Alamat Terpilih:</span>
                    <span id="map-address-display">-</span>
                </div>
            </div>

            <div class="modal-action">
                <button type="button" class="btn btn-ghost" onclick="window.__mapPicker.close()">Batal</button>
                <button type="button" id="map-save-btn" class="btn btn-accent" disabled
                    onclick="window.__mapPicker.save()">Simpan Lokasi</button>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button type="button" onclick="window.__mapPicker.close()">close</button>
        </form>
    </dialog>
</div>

<script>
    (function () {
        // Tear down previous instance if navigating back
        if (window.__mapPicker) {
            try { window.__mapPicker._teardown(); } catch (e) {}
        }

        var map = null;
        var marker = null;
        var selectedLat = '';
        var selectedLng = '';
        var selectedAddress = '';
        var searchDebounce = null;

        // ── Helpers ──────────────────────────────────────────
        function getDialog() { return document.getElementById('map_picker_modal'); }

        function updateDisplay() {
            var coordsEl = document.getElementById('map-coords-display');
            var addrEl = document.getElementById('map-address-display');
            if (coordsEl) coordsEl.textContent = (selectedLat && selectedLng) ? selectedLat + ', ' + selectedLng : '-';
            if (addrEl) addrEl.textContent = selectedAddress || '-';
        }

        function updateSaveBtn() {
            var btn = document.getElementById('map-save-btn');
            if (btn) btn.disabled = !(selectedLat && selectedLng);
        }

        // ── Open / Close ─────────────────────────────────────
        function openModal() {
            var dialog = getDialog();
            if (!dialog) return;
            dialog.classList.add('modal-open');

            // Read existing Livewire input values
            var latInput = document.querySelector('[wire\\:model\\.live="latitude"]');
            var lngInput = document.querySelector('[wire\\:model\\.live="longitude"]');
            var addrInput = document.querySelector('[wire\\:model\\.live="alamat"]');

            var initialLat = latInput && latInput.value ? parseFloat(latInput.value) : 0.507068;
            var initialLng = lngInput && lngInput.value ? parseFloat(lngInput.value) : 101.445107;

            selectedLat = latInput ? latInput.value : '';
            selectedLng = lngInput ? lngInput.value : '';
            selectedAddress = addrInput ? addrInput.value : '';

            updateDisplay();
            updateSaveBtn();

            // Wait for DOM to be ready (dialog visible) then init map
            requestAnimationFrame(function () {
                setTimeout(function () { initMap(initialLat, initialLng); }, 200);
            });
        }

        function closeModal() {
            var dialog = getDialog();
            if (dialog) dialog.classList.remove('modal-open');
            destroyMap();
            // Clear search
            var si = document.getElementById('map-search-input');
            var sr = document.getElementById('map-search-results');
            if (si) si.value = '';
            if (sr) { sr.innerHTML = ''; sr.classList.add('hidden'); }
        }

        function destroyMap() {
            if (map) {
                try { map.off(); map.remove(); } catch (e) {}
                map = null;
                marker = null;
            }
        }

        // ── Leaflet Map ──────────────────────────────────────
        function initMap(lat, lng) {
            var container = document.getElementById('map-picker-container');
            if (!container || !container.parentNode) return;

            // If the container has a stale Leaflet instance, clone to get a fresh node
            if (container._leaflet_id) {
                var fresh = container.cloneNode(false);
                container.parentNode.replaceChild(fresh, container);
                container = fresh;
                map = null;
                marker = null;
            }

            map = new L.Map(container).setView([lat, lng], 13);
            new L.TileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors',
                maxZoom: 19
            }).addTo(map);

            marker = new L.Marker([lat, lng], { draggable: true }).addTo(map);

            marker.on('dragend', function () {
                var pos = marker.getLatLng();
                updatePosition(pos.lat, pos.lng);
            });

            map.on('click', function (e) {
                marker.setLatLng(e.latlng);
                updatePosition(e.latlng.lat, e.latlng.lng);
            });

            // Hide spinner
            var spinner = document.getElementById('map-spinner');
            if (spinner) spinner.classList.add('hidden');
        }

        function updatePosition(lat, lng) {
            selectedLat = lat.toFixed(6);
            selectedLng = lng.toFixed(6);
            // Address will be resolved once via server proxy when user saves
            selectedAddress = '';
            updateDisplay();
            updateSaveBtn();
        }

        // ── Geocode (server-side proxy – no CORS / rate-limit) ────────────
        function reverseGeocode(lat, lng) {
            return fetch('/api/geocode/reverse?lat=' + lat + '&lng=' + lng)
                .then(function (r) { return r.json(); })
                .then(function (data) {
                    if (data && data.display_name) {
                        selectedAddress = data.display_name;
                        updateDisplay();
                    }
                    return selectedAddress;
                })
                .catch(function (err) {
                    console.warn('Reverse geocode error:', err);
                    return '';
                });
        }

        // ── Search ───────────────────────────────────────────
        function searchLocation() {
            var input = document.getElementById('map-search-input');
            var query = input ? input.value.trim() : '';
            if (!query) return;

            setSearchLoading(true);
            fetch('/api/geocode/search?q=' + encodeURIComponent(query) + '&limit=1')
                .then(function (r) { return r.json(); })
                .then(function (data) {
                    if (data && data.length > 0) {
                        selectResult(data[0]);
                    } else {
                        alert('Lokasi tidak ditemukan');
                    }
                })
                .catch(function () {
                    alert('Terjadi kesalahan saat mencari lokasi');
                })
                .finally(function () { setSearchLoading(false); });
        }

        function liveSearch() {
            var input = document.getElementById('map-search-input');
            var query = input ? input.value.trim() : '';
            var resultsList = document.getElementById('map-search-results');

            if (query.length < 3) {
                if (resultsList) { resultsList.innerHTML = ''; resultsList.classList.add('hidden'); }
                return;
            }

            if (searchDebounce) clearTimeout(searchDebounce);
            searchDebounce = setTimeout(function () {
                fetch('/api/geocode/search?q=' + encodeURIComponent(query) + '&limit=5')
                    .then(function (r) { return r.json(); })
                    .then(function (data) {
                        renderResults(data || []);
                    })
                    .catch(function () {
                        if (resultsList) { resultsList.innerHTML = ''; resultsList.classList.add('hidden'); }
                    });
            }, 500);
        }

        function renderResults(results) {
            var list = document.getElementById('map-search-results');
            if (!list) return;
            list.innerHTML = '';

            if (results.length === 0) {
                list.classList.add('hidden');
                return;
            }

            results.forEach(function (r) {
                var li = document.createElement('li');
                var btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'text-left py-2 hover:bg-base-200 block w-full whitespace-normal';
                btn.innerHTML = '<span class="block font-bold text-sm">' + (r.name || r.display_name.split(',')[0]) + '</span>'
                    + '<span class="block text-xs text-base-content/60">' + r.display_name + '</span>';
                btn.addEventListener('click', function () { selectResult(r); });
                li.appendChild(btn);
                list.appendChild(li);
            });
            list.classList.remove('hidden');
        }

        function selectResult(result) {
            var lat = parseFloat(result.lat);
            var lng = parseFloat(result.lon);

            if (map) map.setView([lat, lng], 15);
            if (marker) marker.setLatLng([lat, lng]);

            selectedLat = lat.toFixed(6);
            selectedLng = lng.toFixed(6);
            selectedAddress = result.display_name;
            updateDisplay();
            updateSaveBtn();

            // Clear search results
            var list = document.getElementById('map-search-results');
            if (list) { list.innerHTML = ''; list.classList.add('hidden'); }
            var si = document.getElementById('map-search-input');
            if (si) si.value = result.name || result.display_name.split(',')[0];
        }

        function setSearchLoading(loading) {
            var txt = document.getElementById('map-search-text');
            var spin = document.getElementById('map-search-spinner');
            var btn = document.getElementById('map-search-btn');
            if (txt) txt.classList.toggle('hidden', loading);
            if (spin) spin.classList.toggle('hidden', !loading);
            if (btn) btn.disabled = loading;
        }

        // ── Save ─────────────────────────────────────────────
        function saveLocation() {
            var btn = document.getElementById('map-save-btn');
            if (btn) { btn.disabled = true; btn.textContent = 'Menyimpan...'; }

            var doSave = function (address) {
                var gmapUrl = 'https://maps.google.com/?q=' + selectedLat + ',' + selectedLng;

                // Find the active Livewire component (lapangan-create or lapangan-update)
                var wireEl = document.querySelector('[wire\\:id]');
                if (wireEl && window.Livewire) {
                    var cid = wireEl.getAttribute('wire:id');
                    var component = window.Livewire.find(cid);
                    if (component) {
                        component.set('latitude', selectedLat);
                        component.set('longitude', selectedLng);
                        component.set('alamat', address);
                        component.set('gmap', gmapUrl);
                    }
                }

                closeModal();
            };

            // If address already known (user searched), save immediately
            if (selectedAddress) {
                doSave(selectedAddress);
                return;
            }

            // Otherwise fetch address once via server proxy, then save
            reverseGeocode(parseFloat(selectedLat), parseFloat(selectedLng))
                .then(function (address) { doSave(address); });
        }

        // ── Event Bindings ───────────────────────────────────
        function onOpenEvent() { openModal(); }

        function onNavigating() {
            destroyMap();
            // Remove the dialog to prevent orphans
            var dialog = getDialog();
            if (dialog) dialog.classList.remove('modal-open');
        }

        function onSearchInput(e) {
            if (e.key === 'Enter') { e.preventDefault(); searchLocation(); return; }
            liveSearch();
        }

        function onSearchBtnClick() { searchLocation(); }

        function onClickOutsideResults(e) {
            var list = document.getElementById('map-search-results');
            if (list && !list.contains(e.target) && e.target.id !== 'map-search-input') {
                list.innerHTML = '';
                list.classList.add('hidden');
            }
        }

        // Register listeners
        window.addEventListener('open-map-picker', onOpenEvent);
        document.addEventListener('livewire:navigating', onNavigating);
        document.addEventListener('click', onClickOutsideResults);

        var searchInput = document.getElementById('map-search-input');
        if (searchInput) {
            searchInput.addEventListener('keyup', onSearchInput);
        }

        var searchBtn = document.getElementById('map-search-btn');
        if (searchBtn) {
            searchBtn.addEventListener('click', onSearchBtnClick);
        }

        // ── Teardown (called before re-init on navigate) ────
        function teardown() {
            destroyMap();
            window.removeEventListener('open-map-picker', onOpenEvent);
            document.removeEventListener('livewire:navigating', onNavigating);
            document.removeEventListener('click', onClickOutsideResults);
            if (searchInput) searchInput.removeEventListener('keyup', onSearchInput);
            if (searchBtn) searchBtn.removeEventListener('click', onSearchBtnClick);
        }

        // ── Public API (used by onclick handlers in HTML) ────
        window.__mapPicker = {
            open: openModal,
            close: closeModal,
            save: saveLocation,
            _teardown: teardown
        };
    })();
</script>
