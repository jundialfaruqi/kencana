<div x-data="mapPickerHandler()" @open-map-picker.window="openModal()" class="relative z-50">

    <template x-teleport="body">
        <dialog id="map_picker_modal" class="modal" :class="{ 'modal-open': isOpen }">
            <div class="modal-box w-11/12 max-w-5xl">
                <h3 class="font-bold text-lg mb-4">Pilih Lokasi Lapangan</h3>

                <div class="relative mb-4">
                    <div class="flex gap-2">
                        <input type="text" x-model="searchQuery" @input.debounce.500ms="liveSearch"
                            @keydown.enter.prevent="searchLocation"
                            placeholder="Cari nama jalan, daerah, atau tempat..." class="input input-bordered w-full" />
                        <button type="button" @click="searchLocation" class="btn btn-primary" :disabled="isSearching">
                            <span x-show="!isSearching">Cari</span>
                            <span x-show="isSearching" class="loading loading-spinner loading-xs"></span>
                        </button>
                    </div>

                    <!-- Dropdown Live Search Results -->
                    <ul x-show="searchResults.length > 0" x-transition @click.outside="searchResults = []"
                        class="menu bg-base-100 border border-base-300 w-full rounded-box absolute top-full left-0 mt-1 z-100 max-h-60 overflow-y-auto shadow-2xl"
                        style="display: none;">
                        <template x-for="result in searchResults" :key="result.place_id">
                            <li>
                                <button type="button" @click="selectSearchResult(result)"
                                    class="text-left py-2 hover:bg-base-200 block w-full whitespace-normal">
                                    <span class="block font-bold text-sm"
                                        x-text="result.name || result.display_name.split(',')[0]"></span>
                                    <span class="block text-xs text-base-content/60"
                                        x-text="result.display_name"></span>
                                </button>
                            </li>
                        </template>
                    </ul>
                </div>

                <div id="map-picker-container"
                    class="w-full h-[50vh] bg-base-200 rounded-xl z-0 mb-4 border border-base-300 relative">
                    <div x-show="!map" class="absolute inset-0 flex items-center justify-center">
                        <span class="loading loading-spinner loading-md"></span>
                    </div>
                </div>

                <div
                    class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm mb-4 bg-base-200 p-4 rounded-xl border border-base-300">
                    <div>
                        <span class="font-bold text-base-content/70 block mb-1">Koordinat Terpilih:</span>
                        <span x-text="(selectedLat && selectedLng) ? selectedLat + ', ' + selectedLng : '-'"></span>
                    </div>
                    <div>
                        <span class="font-bold text-base-content/70 block mb-1">Alamat Terpilih:</span>
                        <span x-text="selectedAddress || '-'"></span>
                    </div>
                </div>

                <div class="modal-action">
                    <button type="button" class="btn btn-ghost" @click="closeModal">Batal</button>
                    <button type="button" class="btn btn-primary" @click="saveLocation"
                        :disabled="!selectedLat || !selectedLng">Simpan Lokasi</button>
                </div>
            </div>
            <form method="dialog" class="modal-backdrop">
                <button type="button" @click="closeModal">close</button>
            </form>
        </dialog>
    </template>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('mapPickerHandler', () => ({
                isOpen: false,
                map: null,
                marker: null,
                searchQuery: '',
                isSearching: false,
                searchResults: [],
                selectedLat: '',
                selectedLng: '',
                selectedAddress: '',

                openModal() {
                    this.isOpen = true;

                    let latInput = document.querySelector('[wire\\:model\\.live="latitude"]');
                    let lngInput = document.querySelector('[wire\\:model\\.live="longitude"]');
                    let addrInput = document.querySelector('[wire\\:model\\.live="alamat"]');

                    let initialLat = latInput && latInput.value ? parseFloat(latInput.value) : -
                    6.200000;
                    let initialLng = lngInput && lngInput.value ? parseFloat(lngInput.value) :
                        106.816666;

                    this.selectedLat = latInput ? latInput.value : '';
                    this.selectedLng = lngInput ? lngInput.value : '';
                    this.selectedAddress = addrInput ? addrInput.value : '';

                    setTimeout(() => {
                        this.initMap(initialLat, initialLng);
                    }, 100);
                },

                closeModal() {
                    this.isOpen = false;
                },

                initMap(lat, lng) {
                    if (!this.map) {
                        this.map = new L.Map('map-picker-container').setView([lat, lng], 13);
                        new L.TileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '© OpenStreetMap contributors',
                            maxZoom: 19
                        }).addTo(this.map);

                        this.marker = new L.Marker([lat, lng], {
                            draggable: true
                        }).addTo(this.map);

                        this.marker.on('dragend', (e) => {
                            const position = this.marker.getLatLng();
                            this.updatePosition(position.lat, position.lng);
                        });

                        this.map.on('click', (e) => {
                            this.marker.setLatLng(e.latlng);
                            this.updatePosition(e.latlng.lat, e.latlng.lng);
                        });
                    } else {
                        this.map.invalidateSize();
                        if (this.selectedLat && this.selectedLng) {
                            this.map.setView([this.selectedLat, this.selectedLng], 15);
                            this.marker.setLatLng([this.selectedLat, this.selectedLng]);
                        } else {
                            this.map.setView([lat, lng], 13);
                            this.marker.setLatLng([lat, lng]);
                        }
                    }
                },

                updatePosition(lat, lng) {
                    this.selectedLat = lat.toFixed(6);
                    this.selectedLng = lng.toFixed(6);
                    this.reverseGeocode(lat, lng);
                },

                async reverseGeocode(lat, lng) {
                    try {
                        const response = await fetch(
                            `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`
                            );
                        const data = await response.json();
                        if (data && data.display_name) {
                            this.selectedAddress = data.display_name;
                        }
                    } catch (error) {
                        console.error('Error fetching address:', error);
                    }
                },

                async searchLocation() {
                    if (!this.searchQuery) return;

                    this.isSearching = true;
                    try {
                        const response = await fetch(
                            `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(this.searchQuery)}`
                            );
                        const data = await response.json();

                        if (data && data.length > 0) {
                            const result = data[0];
                            this.selectSearchResult(result);
                        } else {
                            alert('Lokasi tidak ditemukan');
                        }
                    } catch (error) {
                        console.error('Search error:', error);
                        alert('Terjadi kesalahan saat mencari lokasi');
                    } finally {
                        this.isSearching = false;
                    }
                },

                liveSearch() {
                    if (!this.searchQuery || this.searchQuery.trim().length < 3) {
                        this.searchResults = [];
                        return;
                    }
                    this.isSearching = true;
                    fetch(
                            `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(this.searchQuery)}&limit=5`)
                        .then(res => res.json())
                        .then(data => {
                            this.searchResults = data || [];
                        })
                        .catch(err => {
                            console.error('Live search error:', err);
                            this.searchResults = [];
                        })
                        .finally(() => {
                            this.isSearching = false;
                        });
                },

                selectSearchResult(result) {
                    const lat = parseFloat(result.lat);
                    const lng = parseFloat(result.lon);

                    this.map.setView([lat, lng], 15);
                    this.marker.setLatLng([lat, lng]);

                    this.selectedLat = lat.toFixed(6);
                    this.selectedLng = lng.toFixed(6);
                    this.selectedAddress = result.display_name;

                    this.searchResults = [];
                    this.searchQuery = result.name || result.display_name.split(',')[0];
                },

                saveLocation() {
                    const gmapUrl =
                    `https://maps.google.com/?q=${this.selectedLat},${this.selectedLng}`;

                    this.$wire.set('latitude', this.selectedLat);
                    this.$wire.set('longitude', this.selectedLng);
                    this.$wire.set('alamat', this.selectedAddress);
                    this.$wire.set('gmap', gmapUrl);

                    this.closeModal();
                }
            }));
        });
    </script>
</div>
