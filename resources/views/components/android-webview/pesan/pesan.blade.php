<div class="flex-1 flex flex-col min-h-0 overflow-hidden bg-white" id="pesan-root" data-step="{{ $currentStep }}">

    {{-- ══════════════════════════════════════════════════════════════════
         TOP BAR
    ══════════════════════════════════════════════════════════════════ --}}
    <div class="sticky top-0 z-30 bg-white border-b border-gray-200 shrink-0 relative">
        <div class="flex items-center gap-3 px-4 h-16">
            {{-- Back Button — hanya step 0 pakai icon, step lain tidak tampil di sini --}}
            @if ($currentStep === 0)
                <button type="button" wire:click="prevStep"
                    class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center shrink-0 active:scale-95 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                        stroke="#374151" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                </button>
            @endif

            <div class="flex-1 min-w-0">
                <div class="text-[11px] text-gray-400 font-semibold uppercase tracking-widest leading-none mb-1">
                    @if ($currentStep === 0)
                        Langkah 1 dari 4
                    @elseif($currentStep === 1)
                        Langkah 2 dari 4
                    @elseif($currentStep === 2)
                        Langkah 3 dari 4
                    @else
                        Langkah 4 dari 4
                    @endif
                </div>
                <div class="text-sm font-black text-gray-900 truncate">
                    @if ($currentStep === 0)
                        Pilih Lapangan
                    @elseif($currentStep === 1)
                        Pilih Tanggal
                    @elseif($currentStep === 2)
                        Pilih Jam
                    @else
                        Konfirmasi Booking
                    @endif
                </div>
            </div>

            {{-- Step Dots --}}
            <div class="flex items-center gap-1 shrink-0">
                @foreach ([0, 1, 2, 3] as $s)
                    <div
                        class="rounded-full transition-all duration-300 {{ $currentStep >= $s ? 'w-6 h-2 bg-blue-600' : 'w-2 h-2 bg-gray-200' }}">
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Loading overlay --}}
    <div wire:loading wire:target="finalizeBooking"
        class="fixed inset-0 z-50 bg-white/80 backdrop-blur-sm flex items-center justify-center">
        <div class="text-center">
            <div class="w-16 h-16 rounded-2xl bg-blue-50 flex items-center justify-center mx-auto mb-3">
                <div class="w-8 h-8 border-2 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
            </div>
            <div class="text-xs font-bold text-gray-500 uppercase tracking-widest">Memproses...</div>
        </div>
    </div>


    {{-- ══════════════════════════════════════════════════════════════════
         STEP 0 — PILIH LAPANGAN
    ══════════════════════════════════════════════════════════════════ --}}
    @if ($currentStep === 0)
        <div class="flex-1 flex flex-col px-4 py-4 min-h-0 overflow-hidden">
            <p class="text-xs text-gray-400 font-semibold uppercase tracking-widest mb-3 shrink-0">Arena Tersedia</p>

            @if ($error && count($arenas) === 0)
                <div class="p-4 rounded-2xl bg-red-50 border border-red-100 text-sm text-red-500 font-semibold mb-3">
                    {{ $error }}</div>
            @endif

            {{-- SKELETON LOADER: Hanya untuk konten arena --}}
            <div wire:loading wire:target="fetchArenas" class="flex-1 overflow-y-auto space-y-3 pr-0.5">
                @for ($i = 0; $i < 4; $i++)
                    <div
                        class="p-4 rounded-2xl bg-white border border-gray-100 shadow-sm flex items-center gap-3 animate-pulse">
                        <div class="w-12 h-12 rounded-xl bg-gray-200 shrink-0"></div>
                        <div class="flex-1 min-w-0 space-y-2">
                            <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                            <div class="h-3 bg-gray-100 rounded w-1/2"></div>
                        </div>
                    </div>
                @endfor
            </div>

            {{-- DAFTAR ARENA REAL --}}
            <div wire:loading.remove wire:target="fetchArenas" class="flex-1 overflow-y-auto space-y-3 pr-0.5">
                @foreach ($arenas as $arena)
                    @php
                        $status = strtolower((string) ($arena['status'] ?? ''));
                        $isOpen = in_array($status, ['open', 'buka', 'aktif']);
                        $isComing = $status === 'coming_soon';
                        $cover = $arena['image_cover'] ?? null;
                        if ($cover && !preg_match('/^https?:\/\//', $cover)) {
                            $cover = rtrim(config('services.api.image_base_url'), '/') . '/' . ltrim($cover, '/');
                        }
                    @endphp
                    <button type="button"
                        @if ($isOpen) wire:click="selectArena('{{ $arena['id'] }}', '{{ addslashes($arena['nama_lapangan']) }}', '{{ $arena['image_cover'] ?? '' }}')" @endif
                        {{ !$isOpen ? 'disabled' : '' }}
                        class="w-full text-left p-4 rounded-2xl border transition-all duration-150 flex items-center gap-3 group
                        {{ $isOpen
                            ? 'bg-white border-gray-100 shadow-sm active:scale-[0.98] hover:border-blue-200 hover:shadow-md cursor-pointer'
                            : 'bg-gray-50 border-gray-100 opacity-60 cursor-not-allowed' }}">

                        <div
                            class="w-12 h-12 rounded-xl overflow-hidden bg-gray-100 shrink-0 flex items-center justify-center">
                            @if ($cover)
                                <img src="{{ $cover }}" class="w-full h-full object-cover"
                                    alt="{{ $arena['nama_lapangan'] }}" />
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="#9ca3af" stroke-width="2" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25" />
                                </svg>
                            @endif
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-black text-gray-900 truncate">
                                {{ $arena['nama_lapangan'] ?? 'Arena' }}
                            </div>
                            <div class="flex items-center gap-2 mt-1">
                                <span
                                    class="text-[10px] font-black uppercase tracking-wider px-2 py-0.5 rounded-md whitespace-nowrap shrink-0
                                {{ $isOpen ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                                    {{ $arena['status_label'] ?? ucfirst($arena['status'] ?? '-') }}
                                </span>
                                @if (!empty($arena['alamat']))
                                    <span class="text-xs text-gray-400 truncate min-w-0">{{ $arena['alamat'] }}</span>
                                @endif
                            </div>
                        </div>

                        @if ($isOpen)
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="2.5" stroke="#9ca3af"
                                class="w-4 h-4 shrink-0 group-hover:text-blue-600 group-hover:translate-x-0.5 transition-all">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                            </svg>
                        @endif
                    </button>
                @endforeach
            </div>
        </div>
    @endif


    {{-- ══════════════════════════════════════════════════════════════════
         STEP 1 — PILIH TANGGAL (Client-Side Alpine.js untuk performa instan tanpa glitch)
    ══════════════════════════════════════════════════════════════════ --}}
    @if ($currentStep === 1)
        <div class="flex-1 flex flex-col min-h-0 overflow-hidden"
            x-data="{ selectedDate: '{{ $tanggal }}' }">
            {{-- Arena terpilih card (Pinned Top) --}}
            <div class="px-4 pt-4 pb-3 shrink-0">
                <div class="flex items-center gap-3 bg-transparent">
                    @php $cover = $this->coverUrl; @endphp
                    <div class="w-10 h-10 rounded-xl overflow-hidden bg-gray-100 shrink-0 flex items-center justify-center">
                        @if ($cover)
                            <img src="{{ $cover }}" class="w-full h-full object-cover" alt="{{ $namaLapangan }}" />
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#9ca3af"
                                stroke-width="2" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25" />
                            </svg>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <span
                            class="text-[10px] text-gray-400 font-bold uppercase tracking-wider block leading-tight">Arena</span>
                        <span
                            class="text-sm font-black text-gray-900 truncate block leading-tight mt-0.5">{{ $namaLapangan ?: 'Arena' }}</span>
                    </div>
                </div>
            </div>

            {{-- Grid Tanggal (Only this area scrolls, filling remaining height) --}}
            <div class="flex-1 flex flex-col min-h-0 px-4 pb-2">
                <p class="text-xs text-gray-400 font-semibold uppercase tracking-widest mb-3 shrink-0">Pilih Tanggal Bermain</p>
                <div class="flex-1 overflow-y-auto pr-0.5 grid grid-cols-4 gap-2 min-h-0 content-start" id="date-scroll-container">
                    @foreach ($carouselDates as $dateStr)
                        @php
                            $isPast = $dateStr < $todayDate;
                            $dt = \Carbon\Carbon::parse($dateStr)->locale('id');
                        @endphp
                        @if ($isPast)
                            <button type="button" disabled
                                class="flex flex-col items-center justify-center py-2.5 px-2 rounded-xl text-center bg-gray-50 text-gray-300 cursor-not-allowed opacity-60">
                                <span
                                    class="text-[10px] font-bold uppercase leading-none">{{ $dt->translatedFormat('D') }}</span>
                                <span class="text-lg font-black leading-tight my-1">{{ $dt->format('d') }}</span>
                                <span
                                    class="text-[9px] font-semibold uppercase leading-none opacity-80">{{ $dt->translatedFormat('M') }}</span>
                            </button>
                        @else
                            <button type="button"
                                @click="selectedDate = '{{ $dateStr }}'"
                                class="flex flex-col items-center justify-center py-2.5 px-2 rounded-xl transition-all active:scale-95 text-center"
                                :class="selectedDate === '{{ $dateStr }}' ? 'bg-blue-600 text-white' : 'bg-gray-50 text-gray-700 hover:bg-blue-50 hover:text-blue-600'">
                                <span
                                    class="text-[10px] font-bold uppercase leading-none">{{ $dt->translatedFormat('D') }}</span>
                                <span class="text-lg font-black leading-tight my-1">{{ $dt->format('d') }}</span>
                                <span
                                    class="text-[9px] font-semibold uppercase leading-none opacity-80">{{ $dt->translatedFormat('M') }}</span>
                            </button>
                        @endif
                    @endforeach
                </div>
            </div>

            {{-- Tombol Kembali & Selanjutnya (Pinned Bottom) --}}
            <div class="px-4 py-4 border-t border-gray-100 grid grid-cols-2 gap-3 shrink-0 bg-white">
                <button type="button" wire:click="prevStep" wire:loading.attr="disabled" wire:target="prevStep"
                    class="py-4 rounded-2xl bg-gray-100 text-gray-700 font-black text-sm active:scale-[0.98] transition-transform disabled:opacity-60 flex items-center justify-center gap-2">
                    <span wire:loading wire:target="prevStep"
                        class="w-4 h-4 border-2 border-gray-600 border-t-transparent rounded-full animate-spin"></span>
                    <span>Kembali</span>
                </button>
                <button type="button"
                    @click="$wire.proceedToTimeSlots(selectedDate)"
                    wire:loading.attr="disabled" wire:target="proceedToTimeSlots,nextStep"
                    :disabled="!selectedDate"
                    class="py-4 rounded-2xl font-black text-sm uppercase tracking-wide active:scale-[0.98] transition-transform disabled:opacity-60 flex items-center justify-center gap-2"
                    :class="selectedDate ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'bg-gray-200 text-gray-400 cursor-not-allowed'">
                    <span wire:loading wire:target="proceedToTimeSlots,nextStep"
                        class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></span>
                    <span>Selanjutnya</span>
                </button>
            </div>
        </div>
    @endif


    {{-- ══════════════════════════════════════════════════════════════════
         STEP 2 — PILIH JAM (Client-Side Alpine.js untuk performa instan tanpa glitch)
    ══════════════════════════════════════════════════════════════════ --}}
    @if ($currentStep === 2)
        <div class="flex-1 flex flex-col min-h-0 overflow-hidden"
            x-data="{ selectedSlot: '{{ $selectedSlot ? $selectedSlot['mulai'] . '-' . $selectedSlot['selesai'] : '' }}' }">
            {{-- Summary card (Pinned Top) --}}
            <div class="px-4 pt-4 pb-3 shrink-0 space-y-3">
                <div class="flex items-center gap-3">
                    @php $cover = $this->coverUrl; @endphp
                    @if ($cover)
                        <div class="w-10 h-10 rounded-xl overflow-hidden shrink-0 bg-gray-100">
                            <img src="{{ $cover }}" class="w-full h-full object-cover"
                                alt="{{ $namaLapangan }}" />
                        </div>
                    @endif
                    <div class="flex-1 min-w-0">
                        <span
                            class="text-[10px] text-gray-400 font-bold uppercase tracking-wider block leading-tight">Arena</span>
                        <span
                            class="text-sm font-black text-gray-900 truncate block leading-tight mt-0.5">{{ $namaLapangan ?: '-' }}</span>
                    </div>
                </div>
                <div class="flex justify-between items-center pt-2 border-t border-gray-200">
                    <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Tanggal</span>
                    <span class="text-xs font-black text-gray-800">
                        {{ \Carbon\Carbon::parse($tanggal)->locale('id')->translatedFormat('l, d F Y') }}
                    </span>
                </div>
            </div>

            {{-- Grid Jam (Only this area scrolls, filling remaining height) --}}
            <div class="flex-1 flex flex-col min-h-0 px-4 pb-2">
                <p class="text-xs text-gray-400 font-semibold uppercase tracking-widest mb-3 shrink-0">Pilih Jam Bermain</p>

                @if ($listJadwalStatus === 'loading')
                    <div class="grid grid-cols-3 gap-2 flex-1 overflow-y-auto pr-0.5 min-h-0 animate-pulse">
                        @for ($j = 0; $j < 12; $j++)
                            <div
                                class="flex flex-col items-center justify-center py-3 rounded-2xl bg-gray-50 border border-gray-100/80 space-y-1.5">
                                <div class="h-3.5 w-12 bg-gray-200 rounded-md"></div>
                                <div class="h-2 w-5 bg-gray-200/60 rounded"></div>
                                <div class="h-3.5 w-12 bg-gray-200 rounded-md"></div>
                            </div>
                        @endfor
                    </div>
                @elseif($listJadwalStatus === 'libur')
                    <div class="flex-1 flex flex-col items-center justify-center py-8 text-center">
                        <div class="text-4xl mb-3">🚫</div>
                        <div class="text-sm font-black text-gray-700">Hari Ini Libur</div>
                        <div class="text-xs text-gray-400 mt-1">Arena tidak beroperasi pada tanggal ini</div>
                    </div>
                @elseif($error && count($timeSlots) === 0)
                    <div class="p-4 rounded-2xl bg-red-50 border border-red-100 text-sm text-red-500 font-semibold">
                        {{ $error }}</div>
                @elseif(count($timeSlots) === 0)
                    <div class="flex-1 flex flex-col items-center justify-center py-8 text-center">
                        <div class="text-4xl mb-3">📅</div>
                        <div class="text-sm font-black text-gray-700">Tidak Ada Jadwal</div>
                        <div class="text-xs text-gray-400 mt-1">Coba pilih tanggal lain</div>
                    </div>
                @else
                    {{-- Grid jam dengan scroll internal dan pemilihan client-side instan --}}
                    <div class="grid grid-cols-3 gap-2 flex-1 overflow-y-auto pr-0.5 min-h-0 content-start">
                        @foreach ($timeSlots as $slot)
                            @php
                                $available = $this->slotIsAvailable($slot);
                                $slotKey = ($slot['mulai'] ?? '') . '-' . ($slot['selesai'] ?? '');
                            @endphp
                            @if ($available)
                                <button type="button" @click="selectedSlot = '{{ $slotKey }}'"
                                    class="flex flex-col items-center justify-center py-3 rounded-2xl font-black text-[13px] transition-all duration-150 active:scale-95"
                                    :class="selectedSlot === '{{ $slotKey }}' ? 'bg-blue-600 text-white' :
                                        'bg-gray-50 text-gray-700 hover:bg-blue-50 hover:text-blue-600'">
                                    <span>{{ $slot['mulai'] }}</span>
                                    <span class="text-[9px] opacity-70 font-semibold my-0.5">s/d</span>
                                    <span>{{ $slot['selesai'] }}</span>
                                </button>
                            @else
                                <button type="button" disabled
                                    class="flex flex-col items-center justify-center py-3 rounded-2xl font-black text-[13px] bg-gray-50 text-gray-300 cursor-not-allowed line-through">
                                    <span>{{ $slot['mulai'] }}</span>
                                    <span class="text-[9px] opacity-70 font-semibold my-0.5">s/d</span>
                                    <span>{{ $slot['selesai'] }}</span>
                                    <span
                                        class="text-[8px] mt-0.5 opacity-60 uppercase font-bold not-italic">Dipesan</span>
                                </button>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Tombol Kembali & Selanjutnya (Pinned Bottom) --}}
            <div class="px-4 py-4 border-t border-gray-100 grid grid-cols-2 gap-3 shrink-0 bg-white">
                <button type="button" wire:click="prevStep" wire:loading.attr="disabled" wire:target="prevStep"
                    class="py-4 rounded-2xl bg-gray-100 text-gray-700 font-black text-sm active:scale-[0.98] transition-transform disabled:opacity-60 flex items-center justify-center gap-2">
                    <span wire:loading wire:target="prevStep"
                        class="w-4 h-4 border-2 border-gray-600 border-t-transparent rounded-full animate-spin"></span>
                    <span>Kembali</span>
                </button>
                <button type="button" @click="$wire.proceedToConfirmation(selectedSlot)"
                    wire:loading.attr="disabled" wire:target="proceedToConfirmation" :disabled="!selectedSlot"
                    class="py-4 rounded-2xl font-black text-sm uppercase tracking-wide active:scale-[0.98] transition-transform disabled:opacity-40 flex items-center justify-center gap-2"
                    :class="selectedSlot ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-400 cursor-not-allowed'">
                    <span wire:loading wire:target="proceedToConfirmation"
                        class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></span>
                    <span>Selanjutnya</span>
                </button>
            </div>
        </div>
    @endif


    {{-- ══════════════════════════════════════════════════════════════════
         STEP 3 — KONFIRMASI FORM
    ══════════════════════════════════════════════════════════════════ --}}
    @if ($currentStep === 3)
        <div class="flex-1 flex flex-col min-h-0 overflow-hidden">
            <div class="flex-1 overflow-y-auto px-4 py-5 space-y-5 min-h-0">
                {{-- Booking summary card --}}
                <div class="p-4 rounded-2xl bg-blue-600 text-white space-y-2 shadow-lg shadow-blue-200">
                    <div class="text-[10px] font-bold uppercase tracking-widest opacity-70 mb-2">Ringkasan Booking
                    </div>
                    <div class="flex justify-between items-center py-1.5 border-b border-white/10">
                        <span class="text-xs opacity-70 font-semibold">Arena</span>
                        <span class="text-xs font-black uppercase">{{ $namaLapangan ?: '-' }}</span>
                    </div>
                    <div class="flex justify-between items-center py-1.5 border-b border-white/10">
                        <span class="text-xs opacity-70 font-semibold">Tanggal</span>
                        <span class="text-xs font-black">
                            {{ \Carbon\Carbon::parse($tanggal)->locale('id')->translatedFormat('l, d F Y') }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center py-1.5 border-b border-white/10">
                        <span class="text-xs opacity-70 font-semibold">Jam</span>
                        <span class="text-xs font-black">
                            {{ $selectedSlot ? ($selectedSlot['mulai'] ?? '') . ' — ' . ($selectedSlot['selesai'] ?? '') : '-' }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center pt-1">
                        <span class="text-xs opacity-70 font-semibold">Total Biaya</span>
                        <span class="text-lg font-black">GRATIS</span>
                    </div>
                </div>

                {{-- Form data pemesanan --}}
                <div class="space-y-4">
                    <p class="text-xs text-gray-400 font-semibold uppercase tracking-widest">Data Pemesanan</p>

                    {{-- Nama Komunitas --}}
                    <div>
                        <label class="text-xs font-bold text-gray-700 block mb-1.5">Nama Komunitas / Tim <span
                                class="text-gray-400 font-normal">(opsional)</span></label>
                        <input type="text" wire:model="namaKomunitas" placeholder="Contoh: Tim Futsal Garuda"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm font-semibold text-gray-800 placeholder:text-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        @error('namaKomunitas')
                            <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Jumlah Pemain --}}
                    <div>
                        <label class="text-xs font-bold text-gray-700 block mb-1.5">Jumlah Pemain <span
                                class="text-red-500">*</span></label>
                        <input type="number" min="1" wire:model.live="jumlahPemain"
                            placeholder="Masukkan jumlah pemain"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm font-semibold text-gray-800 placeholder:text-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        @error('jumlahPemain')
                            <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Kategori & Jenis --}}
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-xs font-bold text-gray-700 block mb-1.5">Kategori <span
                                    class="text-red-500">*</span></label>
                            <select wire:model.live="kategoriPemain"
                                class="w-full px-3 py-3 rounded-xl border border-gray-200 bg-gray-50 text-xs font-bold text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent appearance-none">
                                <option value="">Pilih</option>
                                <option value="anak-anak">Anak-anak</option>
                                <option value="remaja">Remaja</option>
                                <option value="dewasa">Dewasa</option>
                            </select>
                            @error('kategoriPemain')
                                <p class="text-[10px] text-red-500 mt-1 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-700 block mb-1.5">Jenis Permainan <span
                                    class="text-red-500">*</span></label>
                            <select wire:model.live="jenisPermainan"
                                class="w-full px-3 py-3 rounded-xl border border-gray-200 bg-gray-50 text-xs font-bold text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent appearance-none">
                                <option value="">Pilih</option>
                                <option value="fun_match">Fun Match</option>
                                <option value="latihan">Latihan</option>
                                <option value="turnamen_kecil">Turnamen Kecil</option>
                            </select>
                            @error('jenisPermainan')
                                <p class="text-[10px] text-red-500 mt-1 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                @if ($error)
                    <div class="p-3 rounded-xl bg-red-50 border border-red-100 text-sm text-red-500 font-semibold">
                        {{ $error }}</div>
                @endif
            </div>

            {{-- Tombol Kembali & Pesan (TETAP DI BAWAH) --}}
            <div class="px-4 py-4 border-t border-gray-100 grid grid-cols-2 gap-3 shrink-0 bg-white">
                <button type="button" wire:click="prevStep" wire:loading.attr="disabled" wire:target="prevStep"
                    class="py-4 rounded-2xl bg-gray-100 text-gray-700 font-black text-sm active:scale-[0.98] transition-transform disabled:opacity-60 flex items-center justify-center gap-2">
                    <span wire:loading wire:target="prevStep"
                        class="w-4 h-4 border-2 border-gray-600 border-t-transparent rounded-full animate-spin"></span>
                    <span>Kembali</span>
                </button>
                <button type="button" wire:click="confirmBooking" wire:loading.attr="disabled"
                    wire:target="confirmBooking" @disabled(($listJadwalStatus ?? '') === 'libur')
                    class="py-4 rounded-2xl bg-blue-600 text-white font-black text-sm uppercase tracking-wide active:scale-[0.98] transition-transform shadow-lg shadow-blue-200 disabled:opacity-60 flex items-center justify-center gap-2">
                    <span wire:loading wire:target="confirmBooking"
                        class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></span>
                    <span>Pesan</span>
                </button>
            </div>
        </div>
    @endif


    {{-- ══════════════════════════════════════════════════════════════════
         MODAL: Syarat & Ketentuan
    ══════════════════════════════════════════════════════════════════ --}}
    @if ($showTermsModal)
        <div class="fixed inset-0 z-50 flex items-end justify-center" wire:key="terms-modal">
            <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" wire:click="$set('showTermsModal', false)">
            </div>
            <div class="relative w-full max-w-lg bg-white rounded-t-3xl shadow-2xl overflow-hidden">
                <div class="px-5 pt-5 pb-4 border-b border-gray-100">
                    <div class="w-10 h-1 bg-gray-200 rounded-full mx-auto mb-4"></div>
                    <div class="text-base font-black text-gray-900">Syarat & Ketentuan</div>
                    <div class="text-xs text-gray-400 font-medium mt-0.5">Mohon dibaca sebelum konfirmasi</div>
                </div>

                <div class="overflow-y-auto max-h-[45vh] px-5 py-4 space-y-4">
                    @forelse($catatan as $group)
                        <div>
                            <div class="text-xs font-black text-gray-800 uppercase mb-2">
                                {{ $group['kategori_catatan'] ?? 'Catatan' }}</div>
                            <ul class="space-y-1.5">
                                @foreach ($group['items'] ?? [] as $item)
                                    <li class="flex items-start gap-2">
                                        <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-blue-400 shrink-0"></span>
                                        <span
                                            class="text-xs text-gray-600 leading-relaxed">{{ $item['catatan'] ?? '' }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 font-semibold">Silakan ceklist untuk melanjutkan booking.</p>
                    @endforelse

                    <label class="flex items-start gap-3 p-3 rounded-xl bg-blue-50 cursor-pointer mt-2">
                        <input type="checkbox" wire:model.live="termsAgreed"
                            class="mt-0.5 w-4 h-4 accent-blue-600 rounded">
                        <span class="text-xs font-semibold text-gray-700 leading-relaxed">
                            Saya telah membaca dan <strong>setuju</strong> dengan seluruh syarat dan ketentuan yang
                            berlaku.
                        </span>
                    </label>
                </div>

                <div class="px-5 py-4 grid grid-cols-2 gap-3 border-t border-gray-100">
                    <button type="button" wire:click="$set('showTermsModal', false)"
                        class="py-3.5 rounded-2xl bg-gray-100 text-gray-700 font-black text-sm">
                        Batal
                    </button>
                    <button type="button" wire:click="finalizeBooking" wire:loading.attr="disabled"
                        wire:target="finalizeBooking" @disabled(!$termsAgreed)
                        class="py-3.5 rounded-2xl font-black text-sm transition-all disabled:opacity-40
                        {{ $termsAgreed ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'bg-gray-200 text-gray-400 cursor-not-allowed' }}
                        flex items-center justify-center gap-2">
                        <span wire:loading wire:target="finalizeBooking"
                            class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></span>
                        <span>Konfirmasi</span>
                    </button>
                </div>
            </div>
        </div>
    @endif


    {{-- ══════════════════════════════════════════════════════════════════
         MODAL: Booking Berhasil
    ══════════════════════════════════════════════════════════════════ --}}
    @if ($showSuccessModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4" wire:key="success-modal">
            <div class="absolute inset-0 bg-white"></div>
            <div class="relative w-full max-w-sm text-center">
                {{-- Checkmark animation --}}
                <div class="w-20 h-20 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-5">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#16a34a"
                        stroke-width="2.5" class="w-10 h-10">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                    </svg>
                </div>

                <div class="text-xl font-black text-gray-900 mb-1">Booking Berhasil!</div>
                <div class="text-xs text-gray-400 font-semibold mb-6">Tunjukkan kode QR berikut kepada petugas</div>

                {{-- Detail card --}}
                <div class="bg-gray-50 rounded-2xl p-4 text-left space-y-2 mb-4">
                    <div class="flex justify-between">
                        <span class="text-xs text-gray-400 font-semibold">Arena</span>
                        <span class="text-xs font-black text-gray-800">{{ $successNamaLapangan ?: '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-xs text-gray-400 font-semibold">Tanggal</span>
                        <span class="text-xs font-black text-gray-800">
                            {{ $successTanggal ? \Carbon\Carbon::parse($successTanggal)->locale('id')->translatedFormat('l, d F Y') : '-' }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-xs text-gray-400 font-semibold">Jam</span>
                        <span class="text-xs font-black text-gray-800">
                            {{ $successSelectedSlot ? ($successSelectedSlot['mulai'] ?? '') . ' — ' . ($successSelectedSlot['selesai'] ?? '') : '-' }}
                        </span>
                    </div>
                </div>

                {{-- QR Code --}}
                @if ($bookingCode)
                    <div
                        class="bg-white border-2 border-gray-100 rounded-2xl p-4 flex flex-col items-center gap-3 mb-4">
                        <img src="data:image/png;base64,{{ DNS2D::getBarcodePNG($bookingCode, 'QRCODE', 5, 5) }}"
                            alt="QR Code" class="w-28 h-28" style="image-rendering: pixelated;" />
                        <div class="text-sm font-mono font-black text-gray-800 tracking-widest">{{ $bookingCode }}
                        </div>
                    </div>
                    <div
                        class="flex items-start gap-2 p-3 rounded-xl bg-amber-50 border border-amber-100 text-left mb-5">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#f59e0b"
                            stroke-width="2" class="w-4 h-4 shrink-0 mt-0.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                        </svg>
                        <span class="text-xs text-amber-700 font-semibold leading-relaxed">Screenshot halaman ini untuk
                            ditunjukkan kepada petugas di lapangan.</span>
                    </div>
                @endif

                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('webview.histori') }}" wire:navigate
                        class="py-3.5 rounded-2xl bg-gray-100 text-gray-700 font-black text-sm text-center">
                        Lihat Histori
                    </a>
                    <a href="{{ route('webview.menu') }}" wire:navigate
                        class="py-3.5 rounded-2xl bg-blue-600 text-white font-black text-sm text-center shadow-lg shadow-blue-200">
                        Menu Utama
                    </a>
                </div>
            </div>
        </div>
    @endif


    {{-- ══════════════════════════════════════════════════════════════════
         MODAL: Booking Gagal
    ══════════════════════════════════════════════════════════════════ --}}
    @if ($showErrorModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4" wire:key="error-modal">
            <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>
            <div class="relative w-full max-w-sm bg-white rounded-3xl shadow-2xl p-6 text-center">
                <div class="w-16 h-16 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#ef4444"
                        stroke-width="2" class="w-8 h-8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div class="text-lg font-black text-gray-900 mb-2">Booking Gagal</div>
                <p class="text-sm text-gray-500 font-medium leading-relaxed mb-6">
                    {{ $error ?? 'Terjadi kesalahan saat memproses booking.' }}</p>
                <button type="button" wire:click="handleErrorClose" wire:loading.attr="disabled"
                    class="w-full py-3.5 rounded-2xl bg-red-500 text-white font-black text-sm flex items-center justify-center gap-2">
                    <span wire:loading wire:target="handleErrorClose"
                        class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></span>
                    <span>Tutup & Kembali</span>
                </button>
            </div>
        </div>
    @endif


    {{-- ══════════════════════════════════════════════════════════════════
         MODAL: Konfirmasi Batal
    ══════════════════════════════════════════════════════════════════ --}}
    @if ($showCancelConfirm)
        <div class="fixed inset-0 z-50 flex items-end justify-center" wire:key="cancel-modal">
            <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" wire:click="closeCancelConfirm"></div>
            <div class="relative w-full max-w-lg bg-white rounded-t-3xl shadow-2xl p-6">
                <div class="w-10 h-1 bg-gray-200 rounded-full mx-auto mb-5"></div>
                <div class="text-base font-black text-gray-900 mb-2">Batalkan Pesanan?</div>
                <p class="text-sm text-gray-500 font-medium leading-relaxed mb-5">Semua pilihan Anda akan direset dan
                    Anda akan kembali ke menu utama.</p>
                <div class="grid grid-cols-2 gap-3">
                    <button type="button" wire:click="closeCancelConfirm"
                        class="py-3.5 rounded-2xl bg-gray-100 text-gray-700 font-black text-sm">Tidak, Lanjut</button>
                    <button type="button" wire:click="cancelBooking" wire:loading.attr="disabled"
                        class="py-3.5 rounded-2xl bg-red-500 text-white font-black text-sm flex items-center justify-center gap-2">
                        <span wire:loading wire:target="cancelBooking"
                            class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></span>
                        <span>Ya, Batalkan</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>

@push('scripts')
    <script>
        (function() {
            function scrollToSelectedDate() {
                var sel = document.getElementById('date-selected');
                if (sel) {
                    setTimeout(function() {
                        sel.scrollIntoView({
                            behavior: 'smooth',
                            block: 'nearest'
                        });
                    }, 80);
                }
            }
            document.addEventListener('livewire:navigated', scrollToSelectedDate);
            document.addEventListener('livewire:updated', scrollToSelectedDate);
            scrollToSelectedDate();
        })();
    </script>
@endpush
