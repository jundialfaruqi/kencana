(function () {
  function init() {
    var cards = document.querySelectorAll('[data-animate-detail]');
    var i = 0;
    cards.forEach(function (el) {
      setTimeout(function () {
        el.classList.remove('opacity-0', 'translate-y-2');
      }, i * 40);
      i++;
    });
    scheduleInit();
    initGalleryLightbox();
  }

  function initGalleryLightbox() {
    const lightbox = document.getElementById('gallery-lightbox');
    const mainImage = document.getElementById('lightbox-main-image');
    const thumbnailsContainer = document.getElementById('lightbox-thumbnails');
    const closeButton = document.getElementById('lightbox-close');
    const prevButton = document.getElementById('lightbox-prev');
    const nextButton = document.getElementById('lightbox-next');
    const galleryImages = Array.from(document.querySelectorAll('[data-gallery-image]'));

    let currentImageIndex = 0;

    if (!lightbox || galleryImages.length === 0) return;

    function openLightbox(index) {
      currentImageIndex = index;
      updateLightboxContent();
      lightbox.classList.remove('hidden');
      document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
      lightbox.classList.add('hidden');
      document.body.style.overflow = '';
    }

    function updateLightboxContent() {
      if (galleryImages.length === 0) return;
      mainImage.src = galleryImages[currentImageIndex].src;

      // Update thumbnails
      thumbnailsContainer.innerHTML = '';
      galleryImages.forEach((img, index) => {
        const thumbnail = document.createElement('img');
        thumbnail.src = img.src;
        thumbnail.classList.add('w-16', 'h-16', 'object-cover', 'cursor-pointer', 'rounded-md');
        if (index === currentImageIndex) {
          thumbnail.classList.add('border-2', 'border-info');
        } else {
          thumbnail.classList.add('opacity-70');
        }
        thumbnail.addEventListener('click', () => openLightbox(index));
        thumbnailsContainer.appendChild(thumbnail);
      });
    }

    galleryImages.forEach((img, index) => {
      img.style.cursor = 'pointer';
      img.addEventListener('click', () => openLightbox(index));
    });

    closeButton.addEventListener('click', closeLightbox);
    prevButton.addEventListener('click', () => {
      currentImageIndex = (currentImageIndex - 1 + galleryImages.length) % galleryImages.length;
      updateLightboxContent();
    });
    nextButton.addEventListener('click', () => {
      currentImageIndex = (currentImageIndex + 1) % galleryImages.length;
      updateLightboxContent();
    });

    // Close on escape key
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && !lightbox.classList.contains('hidden')) {
        closeLightbox();
      }
    });
  }
  function scheduleInit(retry) {
    if (retry === void 0) retry = 0;
    var el = document.getElementById('lapangan-map');
    if (!el) return;
    if (window.L) {
      initLapanganMap();
      return;
    }
    if (retry < 20) {
      setTimeout(function () { scheduleInit(retry + 1); }, 150);
    }
  }
  function initLapanganMap() {
    var el = document.getElementById('lapangan-map');
    if (!el || !window.L) return;
    var container = el.parentElement;
    var lat = parseFloat((container && container.getAttribute('data-lat')) || '');
    var lng = parseFloat((container && container.getAttribute('data-lng')) || '');
    var name = (container && container.getAttribute('data-name')) || '';
    var alamat = (container && container.getAttribute('data-alamat')) || '';
    var status = (container && container.getAttribute('data-status')) || '';
    if (isNaN(lat) || isNaN(lng)) return;
    if (el.__map) {
      setTimeout(function () { el.__map.invalidateSize(); }, 100);
      return;
    }
    var map = new L.Map('lapangan-map', {
      center: [lat, lng],
      zoom: 16,
      zoomControl: false,
      scrollWheelZoom: false
    });
    el.__map = map;
    new L.TileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
      attribution: '&copy; OpenStreetMap contributors &copy; CARTO',
      subdomains: 'abcd',
      maxZoom: 20
    }).addTo(map);
    var customIcon = new L.DivIcon({
      className: 'custom-marker',
      html: '<div class="relative w-10 h-10"><div class="absolute inset-0 bg-info rounded-full opacity-30 animate-ping"></div><div class="absolute inset-2 bg-info rounded-full border-2 border-white shadow-lg flex items-center justify-center"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4 text-white"><path fill-rule="evenodd" d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" /></svg></div></div>',
      iconSize: [40, 40],
      iconAnchor: [20, 40]
    });
    var marker = new L.Marker([lat, lng], { icon: customIcon }).addTo(map);
    var popup = new L.Popup({
      offset: [0, -35],
      className: 'sporty-map-popup'
    }).setContent('<div class="popup-sporty-wrapper"><div class="popup-sporty-content font-sans min-w-37.5"><div class="flex items-center gap-2 mb-1"><span class="w-2 h-2 rounded-full bg-info animate-pulse"></span><h4 class="font-black italic uppercase tracking-tighter text-info text-xs">' + name + '</h4></div><p class="text-[10px] font-bold opacity-70 leading-tight">' + alamat + '</p><div class="mt-2 pt-2 border-t border-base-300 flex justify-between items-center"><span class="text-[8px] font-black uppercase italic text-warning">' + status + '</span><span class="text-[8px] font-bold opacity-50">' + lat.toFixed(5) + ', ' + lng.toFixed(5) + '</span></div></div></div>');
    marker.bindPopup(popup);
    marker.bindTooltip('<div class="tooltip-content">' + name + '</div>', {
      direction: 'top',
      offset: [0, -45],
      className: 'sporty-map-tooltip'
    });
    new L.Control.Zoom({ position: 'bottomright' }).addTo(map);
    map.setView([lat, lng], 16);
    setTimeout(function () { map.invalidateSize(); }, 150);
  }
  document.addEventListener('DOMContentLoaded', init);
  document.addEventListener('livewire:navigated', init);
  document.addEventListener('detail-lapangan-loaded', init);
  if (document.readyState !== 'loading') init();
})();
