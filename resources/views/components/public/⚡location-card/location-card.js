(function() {
    let map = null;

    const initMap = () => {
        const mapContainer = document.getElementById('leaflet-map');
        if (!mapContainer || mapContainer.children.length > 0) return;

        map = new L.Map('leaflet-map', {
            center: [0, 0],
            zoom: 14,
            zoomControl: false,
            scrollWheelZoom: false
        });

        new L.TileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
            subdomains: 'abcd',
            maxZoom: 20
        }).addTo(map);

        var apiContainer = mapContainer.closest('[data-api-url]') || mapContainer.parentElement;
        var apiUrl = (apiContainer && apiContainer.getAttribute('data-api-url')) || '/v1/lokasi';
        fetch(apiUrl)
            .then(function (r) { return r.json(); })
            .then(function (res) {
                var items = Array.isArray(res && res.data) ? res.data : [];
                var bounds = new L.LatLngBounds();
                var overlayNama = document.getElementById('overlay-nama');
                var overlayStatus = document.getElementById('overlay-status');

                items.forEach(function (item) {
                    var lat = parseFloat(item.lat);
                    var lng = parseFloat(item.lng);
                    if (isNaN(lat) || isNaN(lng)) return;

                    var customIcon = new L.DivIcon({
                        className: 'custom-marker',
                        html: '<div class="relative w-10 h-10">' +
                              '<div class="absolute inset-0 bg-info rounded-full opacity-30 animate-ping"></div>' +
                              '<div class="absolute inset-2 bg-info rounded-full border-2 border-white shadow-lg flex items-center justify-center">' +
                              '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4 text-white">' +
                              '<path fill-rule="evenodd" d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />' +
                              '</svg>' +
                              '</div>' +
                              '</div>',
                        iconSize: [40, 40],
                        iconAnchor: [20, 40]
                    });

                    var statusText = item.status === 'open' ? 'Open Now' : 'Coming Soon';
                    var popupContent = '<div class="popup-sporty-wrapper">' +
                        '<div class="popup-sporty-content font-sans min-w-37.5">' +
                        '<div class="flex items-center gap-2 mb-1">' +
                        '<span class="w-2 h-2 rounded-full bg-info animate-pulse"></span>' +
                        '<h4 class="font-black italic uppercase tracking-tighter text-info text-xs">' + (item.nama || '-') + '</h4>' +
                        '</div>' +
                        '<div class="mt-2 pt-2 border-t border-base-300 flex justify-between items-center">' +
                        '<span class="text-[8px] font-black uppercase italic ' + (item.status === 'open' ? 'text-success' : 'text-warning') + '">' + statusText + '</span>' +
                        '<span class="text-[8px] font-bold opacity-50">' + lat.toFixed(6) + ', ' + lng.toFixed(6) + '</span>' +
                        '</div>' +
                        '</div>' +
                        '</div>';

                    var marker = new L.Marker([lat, lng], { icon: customIcon }).addTo(map);
                    marker.bindPopup(new L.Popup({ offset: [0, -35], className: 'sporty-map-popup' }).setContent(popupContent));
                    marker.bindTooltip('<div class="tooltip-content">' + (item.nama || '-') + '</div>', {
                        direction: 'top',
                        offset: [0, -45],
                        className: 'sporty-map-tooltip'
                    });
                    bounds.extend([lat, lng]);
                });

                if (items.length > 0) {
                    map.fitBounds(bounds, { padding: [20, 20] });
                    if (overlayNama) overlayNama.textContent = items[0].nama || '-';
                    if (overlayStatus) overlayStatus.textContent = items[0].status === 'open' ? 'Open Now' : 'Coming Soon';
                }
            })
            .catch(function () {});

        new L.Control.Zoom({
            position: 'bottomright'
        }).addTo(map);

        setTimeout(function () {
            map.invalidateSize();
        }, 100);
    };

    window.addEventListener('map-ready', () => {
        setTimeout(initMap, 100);
    });

    document.addEventListener('livewire:navigated', () => {
        if (document.getElementById('leaflet-map')) {
            setTimeout(initMap, 100);
        }
    });

    document.addEventListener('livewire:init', () => {
        Livewire.hook('commit', ({ succeed }) => {
            succeed(() => {
                if (document.getElementById('leaflet-map')) {
                    setTimeout(initMap, 100);
                }
            });
        });
    });

    if (document.getElementById('leaflet-map')) {
        initMap();
    }
})();
