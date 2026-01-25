(function() {
    let map = null;

    const initMap = () => {
        const mapContainer = document.getElementById('leaflet-map');
        if (!mapContainer || mapContainer.children.length > 0) return;

        const lat = 0.5242589;
        const lng = 101.4347965;

        // Initialize map
        map = new L.Map('leaflet-map', {
            center: [lat, lng],
            zoom: 16,
            zoomControl: false,
            scrollWheelZoom: false
        });

        // Add Tile Layer (using a clean Voyager style from CartoDB)
        new L.TileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
            subdomains: 'abcd',
            maxZoom: 20
        }).addTo(map);

        // Add Custom Marker
        const customIcon = new L.DivIcon({
            className: 'custom-marker',
            html: `<div class="relative w-10 h-10">
                    <div class="absolute inset-0 bg-info rounded-full opacity-30 animate-ping"></div>
                    <div class="absolute inset-2 bg-info rounded-full border-2 border-white shadow-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4 text-white">
                            <path fill-rule="evenodd" d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                        </svg>
                    </div>
                   </div>`,
            iconSize: [40, 40],
            iconAnchor: [20, 40]
        });

        const marker = new L.Marker([lat, lng], { icon: customIcon }).addTo(map);

        // Popup Content
        const popupContent = `
            <div class="popup-sporty-wrapper">
                <div class="popup-sporty-content font-sans min-w-37.5">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="w-2 h-2 rounded-full bg-info animate-pulse"></span>
                        <h4 class="font-black italic uppercase tracking-tighter text-info text-xs">Kencana Mini Soccer</h4>
                    </div>
                    <p class="text-[10px] font-bold opacity-70 leading-tight">
                        Jl. Dahlia, Kedungsari, Sukajadi, Pekanbaru.
                    </p>
                    <div class="mt-2 pt-2 border-t border-base-300 flex justify-between items-center">
                        <span class="text-[8px] font-black uppercase italic text-warning">Open Now</span>
                        <span class="text-[8px] font-bold opacity-50">06:00 - 00:00</span>
                    </div>
                </div>
            </div>
        `;

        // Bind Popup (Click)
        marker.bindPopup(new L.Popup({
            offset: [0, -35],
            className: 'sporty-map-popup'
        }).setContent(popupContent));

        // Bind Tooltip (Hover)
        marker.bindTooltip('<div class="tooltip-content">Kencana Mini Soccer</div>', {
            direction: 'top',
            offset: [0, -45],
            className: 'sporty-map-tooltip'
        });

        // Add Zoom Control at bottom right
        new L.Control.Zoom({
            position: 'bottomright'
        }).addTo(map);

        // Invalidate size to fix rendering issues in containers
        setTimeout(() => {
            map.invalidateSize();
        }, 100);
    };

    // Listen for Livewire custom event
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

    // Initial check
    if (document.getElementById('leaflet-map')) {
        initMap();
    }
})();
