<div class="flex-1 flex flex-col min-h-0 overflow-hidden bg-white">

    {{-- ── Hero / Greeting (Pinned Top) ── --}}
    <div class="px-4 pt-4 pb-3 shrink-0 border-b border-gray-100/60 bg-white">
        <div class="text-xl font-black text-gray-900 leading-snug">
            Selamat Datang
        </div>
        <div class="text-xs text-gray-400 font-medium mt-0.5">
            Pilih arena olahraga Kencana
        </div>
    </div>

    {{-- ── Scrollable Body: Banners + Arena Cards Carousel ── --}}
    <div class="px-4 flex-1 space-y-5 overflow-y-auto min-h-0 py-4">

        {{-- ── 1. Banner Informasi Carousel (Tanpa Badge Kategori) ── --}}
        @if (!empty($banners))
            <div x-data="webviewBannerSlider({{ count($banners) }})" @mouseenter="stopAutoPlay()" @mouseleave="startAutoPlay()" class="relative w-full">

                {{-- Carousel Track --}}
                <div x-ref="slider" @scroll.debounce.50ms="onScroll($event)"
                    class="flex overflow-x-auto snap-x snap-mandatory scroll-smooth rounded-2xl sm:rounded-3xl shadow-md shadow-gray-200/60 aspect-[16/9] sm:aspect-[21/9] w-full"
                    style="scrollbar-width: none; -ms-overflow-style: none;">
                    @foreach ($banners as $idx => $banner)
                        <div class="snap-start shrink-0 w-full h-full relative overflow-hidden bg-gray-100">
                            <img src="{{ $banner['image'] ?? '' }}"
                                class="w-full h-full object-cover"
                                alt="{{ $banner['judul'] ?? 'Banner' }}" />

                            {{-- Gradient Overlay --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent"></div>

                            {{-- Content (Tanpa Badge Kategori) --}}
                            <div class="absolute inset-x-0 bottom-0 p-4 sm:p-7 md:p-8 flex flex-col justify-end gap-1 sm:gap-2 text-left">
                                <h3 class="text-white font-black text-base sm:text-2xl md:text-3xl line-clamp-2 leading-snug drop-shadow-md">
                                    {{ $banner['judul'] ?? '' }}
                                </h3>
                                @if (!empty($banner['deskripsi']))
                                    <p class="text-gray-200 text-xs sm:text-sm md:text-base line-clamp-2 opacity-90 leading-relaxed max-w-2xl">
                                        {{ $banner['deskripsi'] }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Dots Indicator --}}
                @if (count($banners) > 1)
                    <div class="flex justify-center items-center gap-1.5 sm:gap-2 mt-2.5 sm:mt-3.5">
                        @foreach ($banners as $idx => $_)
                            <button type="button" @click="goTo({{ $idx }})"
                                class="h-1.5 sm:h-2 rounded-full transition-all duration-300"
                                :class="activeSlide === {{ $idx }} ? 'w-5 sm:w-8 bg-blue-600' : 'w-1.5 sm:w-2 bg-gray-200'"></button>
                        @endforeach
                    </div>
                @endif
            </div>
        @endif

        {{-- ── 2. Carousel Daftar Lapangan (Pilih Lapangan) ── --}}
        <div>
            {{-- Section Title & Header --}}
            <div class="mb-3">
                <h2 class="text-sm font-black text-gray-900 uppercase tracking-wider">Pilih Lapangan</h2>
                <p class="text-[11px] text-gray-400 font-medium">Geser untuk melihat semua lapangan</p>
            </div>

            @if ($arenaError)
                <div class="p-4 rounded-2xl bg-red-50 border border-red-100 text-xs text-red-500 font-semibold">
                    {{ $arenaError }}
                </div>
            @elseif (empty($arenas))
                {{-- Skeleton Loader --}}
                <div class="flex gap-3 overflow-x-auto pb-2" style="scrollbar-width: none;">
                    @for ($i = 0; $i < 2; $i++)
                        <div class="w-[86%] sm:w-[360px] shrink-0 rounded-3xl bg-white border border-gray-100 shadow-sm p-4 space-y-3 animate-pulse">
                            <div class="w-full aspect-[16/10] bg-gray-200 rounded-2xl"></div>
                            <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                            <div class="h-3 bg-gray-100 rounded w-1/2"></div>
                            <div class="grid grid-cols-2 gap-2 pt-2">
                                <div class="h-10 bg-gray-100 rounded-2xl"></div>
                                <div class="h-10 bg-gray-200 rounded-2xl"></div>
                            </div>
                        </div>
                    @endfor
                </div>
            @else
                {{-- Arena Cards Carousel Slider --}}
                <div x-data="webviewArenaSlider({{ count($arenas) }})" class="relative w-full">
                    <div x-ref="arenaSlider" @scroll.debounce.50ms="onScroll($event)"
                        class="flex gap-3.5 overflow-x-auto snap-x snap-mandatory scroll-smooth pb-2 pt-1"
                        style="scrollbar-width: none; -ms-overflow-style: none;">
                        @foreach ($arenas as $index => $arena)
                            @php
                                $isOpen = $this->isArenaAvailable($arena);
                                $rawStatus = strtolower((string) ($arena['status'] ?? ''));
                                $cover = $this->getCoverUrl($arena['image_cover'] ?? ($arena['cover'] ?? null));
                                $nama = $arena['nama'] ?? ($arena['nama_lapangan'] ?? 'Arena');
                                $alamat = $arena['alamat'] ?? ($arena['lokasi'] ?? ($arena['deskripsi'] ?? 'Fasilitas olahraga Kencana'));
                            @endphp

                            <div class="w-[88%] sm:w-[380px] shrink-0 snap-start bg-white rounded-3xl border border-gray-100 shadow-lg shadow-gray-200/50 overflow-hidden flex flex-col">
                                {{-- Card Image Container --}}
                                <div class="relative w-full aspect-[16/10] bg-gray-100 overflow-hidden">
                                    @if ($cover)
                                        <img src="{{ $cover }}" class="w-full h-full object-cover" alt="{{ $nama }}" />
                                    @else
                                        <div class="w-full h-full flex flex-col items-center justify-center text-gray-300 bg-gray-50">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-12 h-12">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25" />
                                            </svg>
                                        </div>
                                    @endif

                                    {{-- Gradient for Image Depth --}}
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-black/20 pointer-events-none"></div>
                                </div>

                                {{-- Card Details --}}
                                <div class="p-4 flex-1 flex flex-col justify-between">
                                    <div>
                                        {{-- Status Badge (di atas nama lapangan, tanpa border) --}}
                                        <div class="mb-1.5">
                                            @if ($isOpen)
                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-emerald-50 text-emerald-700">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                                    <span>Buka</span>
                                                </span>
                                            @elseif ($rawStatus === 'coming_soon')
                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-amber-50 text-amber-700">
                                                    <span>Segera Dibuka</span>
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-red-50 text-red-700">
                                                    <span>Tutup</span>
                                                </span>
                                            @endif
                                        </div>

                                        <h3 class="font-black text-gray-900 text-base sm:text-lg leading-snug line-clamp-1">
                                            {{ $nama }}
                                        </h3>
                                        <p class="text-xs text-gray-500 font-medium line-clamp-2 mt-1 leading-relaxed flex items-start gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3.5 h-3.5 shrink-0 text-gray-400 mt-0.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                            </svg>
                                            <span>{{ $alamat ?: '-' }}</span>
                                        </p>
                                    </div>

                                    {{-- Tombol Pesan Lapangan (Langsung ke Pilih Tanggal) --}}
                                    <div class="mt-4 pt-3 border-t border-gray-100">
                                        @if ($isOpen)
                                            <a href="{{ route('webview.pesan', ['lapangan_id' => $arena['id']]) }}" wire:navigate
                                                class="w-full block py-3 rounded-2xl bg-blue-600 text-white font-black text-xs uppercase tracking-wide shadow-md shadow-blue-200 hover:bg-blue-700 active:scale-95 transition-all text-center flex items-center justify-center gap-1.5">
                                                <span>Pesan Lapangan</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                                </svg>
                                            </a>
                                        @else
                                            <button type="button" disabled
                                                class="w-full py-3 rounded-2xl bg-gray-100 text-gray-400 font-bold text-xs uppercase tracking-wide cursor-not-allowed text-center">
                                                Tidak Tersedia
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>


                </div>
            @endif
        </div>

        {{-- ── 3. Histori Booking Terbaru ── --}}
        <div>
            {{-- Section Title & "Lihat Semua" Link --}}
            <div class="flex items-center justify-between mb-3">
                <div>
                    <h2 class="text-sm font-black text-gray-900 uppercase tracking-wider">Histori Booking</h2>
                    <p class="text-[11px] text-gray-400 font-medium">Aktivitas pemesanan terakhir Anda</p>
                </div>
                <a href="{{ route('webview.histori') }}" wire:navigate
                    class="text-xs font-bold text-blue-600 flex items-center gap-1 hover:underline active:scale-95 transition-transform">
                    <span>Lihat Semua</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                        stroke="currentColor" class="w-3.5 h-3.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </a>
            </div>

            @if (empty($recentBookings))
                <div class="p-6 rounded-2xl bg-gray-50 border border-gray-100 text-center">
                    <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-2 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                    <div class="text-xs font-black text-gray-700">Belum Ada Histori Booking</div>
                    <div class="text-[11px] text-gray-400 mt-0.5">Pemesanan yang Anda buat akan muncul di sini</div>
                </div>
            @else
                <div class="space-y-3">
                    @foreach ($recentBookings as $booking)
                        @php
                            $status = strtolower((string) ($booking['status'] ?? ''));
                            $stColor = match($status) {
                                'dipesan'    => ['bg' => 'bg-blue-100',  'text' => 'text-blue-700',  'label' => 'Aktif'],
                                'dibatalkan' => ['bg' => 'bg-red-100',   'text' => 'text-red-700',   'label' => 'Dibatalkan'],
                                'selesai'    => ['bg' => 'bg-green-100', 'text' => 'text-green-700', 'label' => 'Selesai'],
                                default      => ['bg' => 'bg-gray-100',  'text' => 'text-gray-700',  'label' => ucfirst($status ?: '-')],
                            };
                            $kode = $booking['kode_booking'] ?? '-';
                            $namaArena = $booking['nama_lapangan'] ?? ($booking['lapangan'] ?? 'Arena');
                            
                            $tglRaw = (string) ($booking['tanggal'] ?? '');
                            $tglFmt = $tglRaw;
                            if (preg_match('/^\d{4}-\d{2}-\d{2}/', $tglRaw)) {
                                try {
                                    $tglFmt = \Carbon\Carbon::parse($tglRaw)->locale('id')->translatedFormat('d M Y');
                                } catch (\Throwable) {
                                    $tglFmt = $tglRaw;
                                }
                            }

                            $jamPlay = (string) ($booking['jam'] ?? '');
                            if (empty($jamPlay) && (!empty($booking['jam_mulai']) || !empty($booking['jam_selesai']))) {
                                $jamPlay = ($booking['jam_mulai'] ?? '') . ' - ' . ($booking['jam_selesai'] ?? '');
                            }
                        @endphp

                        <a href="{{ route('webview.detail-booking', ['kode_booking' => $kode]) }}" wire:navigate
                            class="block p-3.5 rounded-2xl bg-white border border-gray-100 shadow-sm hover:border-blue-200 active:scale-[0.99] transition-all">
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-mono font-bold text-[11px] text-gray-500 tracking-wider">
                                    #{{ $kode }}
                                </span>
                                <span class="px-2 py-0.5 rounded-full text-[9px] font-black uppercase {{ $stColor['bg'] }} {{ $stColor['text'] }}">
                                    {{ $stColor['label'] }}
                                </span>
                            </div>

                            <div class="font-black text-gray-900 text-sm truncate mb-2">
                                {{ $namaArena }}
                            </div>

                            <div class="grid grid-cols-2 gap-2 text-[11px] text-gray-500 pt-2 border-t border-gray-100/80">
                                <div class="flex items-center gap-1.5 truncate">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor" class="w-3.5 h-3.5 text-gray-400 shrink-0">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                    </svg>
                                    <span class="truncate">
                                        {{ $tglFmt ?: '-' }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-1.5 truncate justify-end">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor" class="w-3.5 h-3.5 text-gray-400 shrink-0">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                    <span class="truncate">{{ $jamPlay ?: '-' }}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

    </div>

    {{-- ── Footer (Pinned Bottom) ── --}}
    <div class="px-4 py-3 text-center shrink-0 border-t border-gray-50 bg-white">
        <div class="text-[11px] text-gray-300 font-medium">
            Kencana Arena &bull; Dispora Kota Pekanbaru
        </div>
    </div>





    {{-- ══════════════════════════════════════════════════════════════════
         MODAL: Syarat & Ketentuan Layanan (Dispora Kota Pekanbaru)
    ══════════════════════════════════════════════════════════════════ --}}
    @if ($showTermsModal)
        <div class="fixed inset-0 z-50 flex items-end sm:items-center justify-center p-0 sm:p-4"
            wire:key="menu-terms-modal">
            {{-- Backdrop --}}
            <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>

            {{-- Dialog Content --}}
            <div
                class="relative w-full max-w-lg bg-white rounded-t-3xl sm:rounded-3xl shadow-2xl overflow-hidden flex flex-col max-h-[85vh] sm:max-h-[80vh] animate-in fade-in slide-in-from-bottom duration-200">

                {{-- Header --}}
                <div class="px-5 pt-5 pb-4 border-b border-gray-100 shrink-0">
                    <div class="w-10 h-1 bg-gray-200 rounded-full mx-auto mb-4 sm:hidden"></div>
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v3.75m0-10.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.75c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.75h-.002A11.959 11.959 0 0 1 12 2.714Zm0 13.036h.008v.008H12v-.008Z" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-base font-black text-gray-900 leading-tight">Syarat & Ketentuan</div>
                            <div class="text-xs text-blue-600 font-bold mt-0.5">Dispora Kota Pekanbaru</div>
                        </div>
                    </div>
                </div>

                {{-- Scrollable Body --}}
                <div class="overflow-y-auto px-5 py-4 space-y-4 text-xs text-gray-600 leading-relaxed flex-1">
                    <div
                        class="p-3.5 rounded-2xl bg-blue-50/70 border border-blue-100 text-blue-900 font-semibold text-xs leading-relaxed">
                        Layanan pemesanan arena olahraga <strong>Kencana Arena</strong> ini merupakan fasilitas resmi
                        yang dimiliki dan dikelola oleh <strong>Dinas Pemuda dan Olahraga (Dispora) Kota
                            Pekanbaru</strong>.
                    </div>

                    <div class="space-y-2.5 pt-1">
                        <div class="font-black text-gray-800 uppercase text-[11px] tracking-wider">Ketentuan
                            Penggunaan:</div>
                        <ul class="space-y-2">
                            <li class="flex items-start gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mt-1.5 shrink-0"></span>
                                <span>Fasilitas ini disediakan untuk mendukung kegiatan olahraga dan pembinaan
                                    pemuda/masyarakat Kota Pekanbaru.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mt-1.5 shrink-0"></span>
                                <span>Pengguna wajib menjaga kebersihan, ketertiban, dan seluruh fasilitas/aset di area
                                    arena selama waktu penggunaan.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mt-1.5 shrink-0"></span>
                                <span>Jadwal pemesanan yang telah terverifikasi tidak dapat diperjualbelikan atau
                                    dialihkan kepada pihak lain.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mt-1.5 shrink-0"></span>
                                <span>Dispora Kota Pekanbaru berhak melakukan penyesuaian atau pembatalan jadwal
                                    sewaktu-waktu apabila terdapat kegiatan kedinasan/pemerintah yang mendesak.</span>
                            </li>
                        </ul>
                    </div>

                    {{-- Checkbox Setuju --}}
                    <label
                        class="flex items-start gap-3 p-3.5 rounded-2xl bg-gray-50 border border-gray-200 cursor-pointer mt-3 transition-colors hover:bg-blue-50/50">
                        <input type="checkbox" wire:model.live="termsAgreed"
                            class="mt-0.5 w-4 h-4 accent-blue-600 rounded shrink-0">
                        <span class="text-xs font-semibold text-gray-700 leading-relaxed select-none">
                            Saya telah membaca, memahami, dan <strong>setuju</strong> dengan seluruh syarat & ketentuan
                            layanan Dispora Kota Pekanbaru.
                        </span>
                    </label>
                </div>

                {{-- Action Button --}}
                <div class="px-5 py-4 border-t border-gray-100 bg-white shrink-0">
                    <button type="button" wire:click="acceptTerms" wire:loading.attr="disabled"
                        wire:target="acceptTerms" @disabled(!$termsAgreed)
                        class="w-full py-4 rounded-2xl font-black text-sm uppercase tracking-wide transition-all duration-150 disabled:opacity-40 flex items-center justify-center gap-2
                        {{ $termsAgreed ? 'bg-blue-600 text-white shadow-lg shadow-blue-200 active:scale-[0.98]' : 'bg-gray-200 text-gray-400 cursor-not-allowed' }}">
                        <span wire:loading wire:target="acceptTerms"
                            class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></span>
                        <span>Setuju dan Lanjutkan</span>
                    </button>
                </div>

            </div>
        </div>
    @endif

</div>
