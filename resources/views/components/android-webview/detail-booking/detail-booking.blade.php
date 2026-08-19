<div class="flex-1 flex flex-col min-h-0 overflow-hidden bg-white">

    {{-- ══════════════════════════════════════════════════════════════════
         TOP BAR (Pinned Top)
    ══════════════════════════════════════════════════════════════════ --}}
    <div class="sticky top-0 z-30 bg-white border-b border-gray-200 shrink-0">
        <div class="flex items-center gap-3 px-4 h-16">
            <div class="flex-1 min-w-0">
                <div class="text-[11px] text-gray-400 font-semibold uppercase tracking-widest leading-none mb-1">
                    Detail Booking
                </div>
                <div class="text-sm font-black text-gray-900 truncate">
                    #{{ $kode_booking }}
                </div>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════════════
         SCROLLABLE CONTENT
    ══════════════════════════════════════════════════════════════════ --}}
    <div class="flex-1 overflow-y-auto px-4 py-4 space-y-4 min-h-0">

        @if ($error)
            <div class="p-4 rounded-2xl bg-red-50 border border-red-100 text-sm text-red-500 font-semibold text-center">
                {{ $error }}
                <div class="mt-3">
                    <a href="{{ route('webview.histori') }}" wire:navigate
                        class="inline-block px-4 py-2 rounded-xl bg-red-600 text-white font-bold text-xs">
                        Kembali ke Histori
                    </a>
                </div>
            </div>
        @elseif (empty($detail))
            {{-- Skeleton Loading --}}
            <div class="p-6 bg-white rounded-3xl border border-gray-100 shadow-sm animate-pulse space-y-4 text-center">
                <div class="w-36 h-36 bg-gray-200 rounded-2xl mx-auto"></div>
                <div class="h-4 bg-gray-200 rounded w-1/2 mx-auto"></div>
                <div class="h-3 bg-gray-100 rounded w-1/3 mx-auto"></div>
            </div>
        @else
            @php
                $status = $this->bookingStatus;
                $stBadge = match ($status) {
                    'dipesan'    => ['bg' => 'bg-blue-100',  'text' => 'text-blue-700',  'label' => 'Aktif / Dipesan'],
                    'dibatalkan' => ['bg' => 'bg-red-100',   'text' => 'text-red-700',   'label' => 'Dibatalkan'],
                    'selesai'    => ['bg' => 'bg-green-100', 'text' => 'text-green-700', 'label' => 'Selesai'],
                    default      => ['bg' => 'bg-gray-100',  'text' => 'text-gray-700',  'label' => ucfirst($status ?: '-')],
                };
            @endphp

            {{-- ── 1. QR Code Section (Cardless) ── --}}
            <div class="flex flex-col items-center justify-center text-center space-y-4 pt-2 pb-5 border-b border-gray-100">
                {{-- Status Badge --}}
                <div class="inline-flex items-center justify-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-black uppercase {{ $stBadge['bg'] }} {{ $stBadge['text'] }}">
                    <span class="w-2 h-2 rounded-full {{ $status === 'dipesan' ? 'bg-blue-600 animate-pulse' : ($status === 'selesai' ? 'bg-green-600' : 'bg-red-600') }}"></span>
                    <span>{{ $stBadge['label'] }}</span>
                </div>

                {{-- QR Code Image --}}
                @if ($kode_booking)
                    <div class="p-3 bg-white border border-gray-200 rounded-3xl inline-flex items-center justify-center shadow-xs">
                        <img src="data:image/png;base64,{{ DNS2D::getBarcodePNG($kode_booking, 'QRCODE', 6, 6) }}"
                            alt="QR Code #{{ $kode_booking }}" class="w-44 h-44 block"
                            style="image-rendering: pixelated;" />
                    </div>
                @endif

                {{-- Booking Code Text --}}
                <div class="w-full text-center">
                    <div class="text-[11px] text-gray-400 font-bold uppercase tracking-widest">Kode Booking</div>
                    <div class="text-2xl font-mono font-black text-gray-900 tracking-wider mt-0.5">
                        {{ $kode_booking }}
                    </div>
                </div>

                {{-- Screenshot Advisory --}}
                <div class="w-full flex items-start gap-2.5 p-3.5 rounded-2xl bg-amber-50 border border-amber-100 text-left mt-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#f59e0b"
                        stroke-width="2" class="w-4 h-4 shrink-0 mt-0.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                    </svg>
                    <span class="text-xs text-amber-800 font-semibold leading-relaxed">
                        Screenshot halaman ini dan tunjukkan kode QR kepada petugas saat tiba di lapangan.
                    </span>
                </div>
            </div>

            {{-- ── 2. Informasi Booking (Cardless) ── --}}
            <div class="space-y-1 pb-5 border-b border-gray-100">
                <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Informasi Pemesanan</h3>

                {{-- Arena --}}
                <div class="flex justify-between items-center py-2.5 border-b border-gray-50">
                    <span class="text-xs text-gray-500 font-semibold">Arena</span>
                    <span class="text-xs font-black text-gray-900 text-right uppercase">
                        {{ $this->namaLapangan }}
                    </span>
                </div>

                {{-- Tanggal Bermain --}}
                <div class="flex justify-between items-center py-2.5 border-b border-gray-50">
                    <span class="text-xs text-gray-500 font-semibold">Tanggal Bermain</span>
                    <span class="text-xs font-black text-gray-900 text-right">
                        {{ $this->tanggalFmt }}
                    </span>
                </div>

                {{-- Jam Bermain --}}
                <div class="flex justify-between items-center py-2.5 border-b border-gray-50">
                    <span class="text-xs text-gray-500 font-semibold">Jam Bermain</span>
                    <span class="text-xs font-black text-blue-600 text-right">
                        {{ $this->jamFmt }}
                    </span>
                </div>

                {{-- Nama Komunitas --}}
                <div class="flex justify-between items-center py-2.5 border-b border-gray-50">
                    <span class="text-xs text-gray-500 font-semibold">Komunitas / Tim</span>
                    <span class="text-xs font-black text-gray-900 text-right">
                        {{ $this->komunitas }}
                    </span>
                </div>

                {{-- Jumlah Pemain --}}
                <div class="flex justify-between items-center py-2.5 border-b border-gray-50">
                    <span class="text-xs text-gray-500 font-semibold">Jumlah Pemain</span>
                    <span class="text-xs font-black text-gray-900 text-right">
                        {{ $this->jumlahPemain }}
                    </span>
                </div>

                {{-- Kategori Pemain --}}
                <div class="flex justify-between items-center py-2.5 border-b border-gray-50">
                    <span class="text-xs text-gray-500 font-semibold">Kategori</span>
                    <span class="text-xs font-black text-gray-900 text-right">
                        {{ $this->kategori }}
                    </span>
                </div>

                {{-- Jenis Permainan --}}
                <div class="flex justify-between items-center py-2.5 border-b border-gray-50">
                    <span class="text-xs text-gray-500 font-semibold">Jenis Permainan</span>
                    <span class="text-xs font-black text-gray-900 text-right">
                        {{ $this->jenis }}
                    </span>
                </div>

                {{-- Biaya --}}
                <div class="flex justify-between items-center py-2.5 border-b border-gray-50">
                    <span class="text-xs text-gray-500 font-semibold">Total Biaya</span>
                    <span class="text-sm font-black text-emerald-600 text-right">
                        GRATIS
                    </span>
                </div>

                {{-- Dibuat Pada --}}
                <div class="flex justify-between items-center pt-2">
                    <span class="text-xs text-gray-400 font-semibold">Waktu Pemesanan</span>
                    <span class="text-xs font-semibold text-gray-500 text-right">
                        {{ $this->dibuatPada }}
                    </span>
                </div>
            </div>

            {{-- ── 3. Syarat & Catatan Lapangan (Cardless) ── --}}
            @if (!empty($catatan))
                <div class="space-y-3 pb-4">
                    <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Catatan & Aturan Arena</h3>

                    <div class="space-y-4">
                        @foreach ($catatan as $group)
                            <div>
                                <div class="text-xs font-black text-gray-800 uppercase mb-2">
                                    {{ $group['kategori_catatan'] ?? 'Catatan' }}
                                </div>
                                <ul class="space-y-2">
                                    @foreach ($group['items'] ?? [] as $item)
                                        <li class="flex items-start gap-2.5">
                                            <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-blue-500 shrink-0"></span>
                                            <span class="text-xs text-gray-600 leading-relaxed">{{ $item['catatan'] ?? '' }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- ── 4. Batalkan Booking Button (Hanya jika status 'dipesan') ── --}}
            @if ($status === 'dipesan')
                <div class="pt-2 pb-2">
                    <button type="button" wire:click="openCancelConfirm"
                        class="w-full py-3.5 rounded-2xl border-2 border-red-200 bg-red-50 text-red-600 font-black text-xs uppercase tracking-wide active:scale-95 transition-all flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                        <span>Batalkan Booking</span>
                    </button>
                </div>
            @endif

        @endif

        <div class="pb-4"></div>
    </div>

    {{-- ══════════════════════════════════════════════════════════════════
         FOOTER ACTIONS (Pinned Bottom — Seperti Halaman Pesan)
    ══════════════════════════════════════════════════════════════════ --}}
    <div class="px-4 py-4 border-t border-gray-100 grid grid-cols-2 gap-3 shrink-0 bg-white">
        <a href="{{ route('webview.histori') }}" wire:navigate
            class="py-4 rounded-2xl bg-gray-100 text-gray-700 font-black text-sm active:scale-[0.98] transition-transform flex items-center justify-center gap-2 text-center">
            <span>Kembali</span>
        </a>
        <a href="{{ route('webview.menu') }}" wire:navigate
            class="py-4 rounded-2xl bg-blue-600 text-white font-black text-sm uppercase tracking-wide active:scale-[0.98] transition-transform shadow-lg shadow-blue-200 flex items-center justify-center gap-2 text-center">
            <span>Beranda</span>
        </a>
    </div>

    {{-- ══════════════════════════════════════════════════════════════════
         MODAL: Konfirmasi Batalkan Booking
    ══════════════════════════════════════════════════════════════════ --}}
    @if ($showCancelConfirm)
        <div class="fixed inset-0 z-50 flex items-end sm:items-center justify-center p-0 sm:p-4"
            wire:key="cancel-confirm-modal">
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" wire:click="closeCancelConfirm"></div>
            <div class="relative w-full max-w-sm bg-white rounded-t-3xl sm:rounded-3xl shadow-2xl p-6 text-center animate-in fade-in slide-in-from-bottom duration-200">
                <div class="w-16 h-16 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-4 text-red-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-8 h-8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                    </svg>
                </div>
                <div class="text-base font-black text-gray-900 mb-1.5">Batalkan Booking Ini?</div>
                <p class="text-xs text-gray-500 leading-relaxed mb-6">
                    Slot bermain yang telah Anda pesan akan dibatalkan dan dapat dipesan oleh pengguna lain. Tindakan ini tidak dapat dibatalkan.
                </p>
                <div class="grid grid-cols-2 gap-3">
                    <button type="button" wire:click="closeCancelConfirm"
                        class="py-3 rounded-2xl bg-gray-100 text-gray-700 font-black text-xs">
                        Kembali
                    </button>
                    <button type="button" wire:click="cancelBooking" wire:loading.attr="disabled"
                        wire:target="cancelBooking"
                        class="py-3 rounded-2xl bg-red-600 text-white font-black text-xs shadow-md shadow-red-200 flex items-center justify-center gap-1.5">
                        <span wire:loading wire:target="cancelBooking"
                            class="w-3.5 h-3.5 border-2 border-white border-t-transparent rounded-full animate-spin"></span>
                        <span>Ya, Batalkan</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>
