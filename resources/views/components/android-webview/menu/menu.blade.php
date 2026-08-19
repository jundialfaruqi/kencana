<div class="flex-1 flex flex-col min-h-0 overflow-hidden bg-white">

    {{-- ── Hero / Greeting (Pinned Top) ── --}}
    <div class="px-4 pt-4 pb-3 shrink-0">
        <div class="text-xl font-black text-gray-900 leading-snug">
            Selamat Datang
        </div>
        <div class="text-xs text-gray-400 mt-1 font-medium">
            Pilih layanan yang ingin Anda gunakan
        </div>
    </div>

    {{-- ── Scrollable Body: Banner Carousel + Menu Cards ── --}}
    <div class="px-4 flex-1 space-y-4 overflow-y-auto min-h-0 pb-4">

        {{-- ── Banner Carousel Slider ── --}}
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

                            {{-- Content --}}
                            <div class="absolute inset-x-0 bottom-0 p-4 sm:p-7 md:p-8 flex flex-col justify-end gap-1 sm:gap-2 text-left">
                                @if (!empty($banner['kategori']))
                                    <span class="bg-blue-600 text-white text-[10px] sm:text-xs md:text-sm font-black uppercase tracking-wider px-2 sm:px-3 py-0.5 sm:py-1 rounded-md sm:rounded-lg w-fit shadow">
                                        {{ $banner['kategori'] }}
                                    </span>
                                @endif
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

        {{-- ── Menu Cards ── --}}
        <div class="space-y-3">
            <div class="text-[11px] text-gray-400 font-bold uppercase tracking-wider">Menu Layanan</div>

            {{-- Pesan Lapangan --}}
            <a href="{{ route('webview.pesan') }}" wire:navigate
                class="group flex items-center gap-4 p-4 rounded-2xl bg-white shadow-md shadow-gray-200/60 active:scale-[0.98] transition-all duration-150 cursor-pointer">
                <div class="shrink-0 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="#165dfc" class="w-7 h-7">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-gray-900 font-black text-base leading-tight">Pesan Lapangan</div>
                    <div class="text-gray-400 text-xs font-medium mt-1">Booking arena olahraga Kencana</div>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                    stroke="#9ca3af"
                    class="w-4 h-4 shrink-0 group-hover:text-gray-900 group-hover:translate-x-0.5 transition-all">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            </a>

            {{-- Histori Booking --}}
            <a href="{{ route('webview.histori') }}" wire:navigate
                class="group flex items-center gap-4 p-4 rounded-2xl bg-white shadow-md shadow-gray-200/60 active:scale-[0.98] transition-all duration-150 cursor-pointer">
                <div class="shrink-0 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="#165dfc" class="w-7 h-7">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-gray-900 font-black text-base leading-tight">Histori Booking</div>
                    <div class="text-gray-400 text-xs font-medium mt-1">Riwayat pemesanan Anda</div>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                    stroke="#9ca3af"
                    class="w-4 h-4 shrink-0 group-hover:text-gray-700 group-hover:translate-x-0.5 transition-all">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            </a>
        </div>
    </div>

    {{-- ── Footer (Pinned Bottom) ── --}}
    <div class="px-4 py-4 text-center shrink-0">
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
