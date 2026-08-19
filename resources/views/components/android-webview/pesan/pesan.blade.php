<div class="flex-1 flex flex-col min-h-0 overflow-hidden bg-white" id="pesan-root" data-step="{{ $currentStep }}">

    {{-- ══════════════════════════════════════════════════════════════════
         TOP BAR
    ══════════════════════════════════════════════════════════════════ --}}
    <div class="sticky top-0 z-30 bg-white border-b border-gray-200 shrink-0 relative">
        <div class="flex items-center gap-3 px-4 h-16">
            <div class="flex-1 min-w-0">
                <div class="text-[11px] text-gray-400 font-semibold uppercase tracking-widest leading-none mb-1">
                    @if ($currentStep === 0)
                        Langkah 1 dari 3
                    @elseif($currentStep === 1)
                        Langkah 2 dari 3
                    @else
                        Langkah 3 dari 3
                    @endif
                </div>
                <div class="text-sm font-black text-gray-900 truncate">
                    @if ($currentStep === 0)
                        Pilih Tanggal
                    @elseif($currentStep === 1)
                        Pilih Jam
                    @else
                        Konfirmasi Booking
                    @endif
                </div>
            </div>

            {{-- Step Dots --}}
            <div class="flex items-center gap-1 shrink-0">
                @foreach ([0, 1, 2] as $s)
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
         STEP 0 — PILIH TANGGAL (Client-Side Alpine.js)
    ══════════════════════════════════════════════════════════════════ --}}
    @if ($currentStep === 0)
        <div class="flex-1 flex flex-col min-h-0 overflow-hidden"
            x-data="{ selectedDate: '{{ $tanggal }}' }">
            {{-- Arena terpilih (Flat / Tanpa Card) --}}
            <div class="px-4 pt-3 pb-3 shrink-0 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3 min-w-0">
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
                    <div class="min-w-0">
                        <span
                            class="text-[10px] text-gray-400 font-bold uppercase tracking-wider block leading-tight">Arena terpilih</span>
                        <span
                            class="text-sm font-black text-gray-900 truncate block leading-tight mt-0.5">{{ $namaLapangan ?: 'Arena' }}</span>
                    </div>
                </div>

                {{-- Tombol Ubah Lapangan --}}
                <button type="button" wire:click="openChangeArenaModal"
                    class="text-xs font-bold text-blue-600 bg-blue-50 px-2.5 py-1.5 rounded-xl active:scale-95 transition-transform shrink-0 flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-3.5 h-3.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                    <span>Ubah</span>
                </button>
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

            {{-- Footer: Batal & Selanjutnya --}}
            <div class="px-4 py-4 border-t border-gray-100 grid grid-cols-2 gap-3 shrink-0 bg-white">
                <button type="button" wire:click="prevStep"
                    class="py-4 rounded-2xl bg-gray-100 text-gray-700 font-black text-sm active:scale-[0.98] transition-transform flex items-center justify-center gap-2">
                    <span>Batal</span>
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
         STEP 1 — PILIH JAM (Client-Side Alpine.js)
    ══════════════════════════════════════════════════════════════════ --}}
    @if ($currentStep === 1)
        <div class="flex-1 flex flex-col min-h-0 overflow-hidden"
            x-data="{ selectedSlot: '{{ $selectedSlot ? $selectedSlot['mulai'] . '-' . $selectedSlot['selesai'] : '' }}' }">
            {{-- Summary Arena & Tanggal (Flat / Tanpa Card) --}}
            <div class="px-4 pt-3 pb-3 shrink-0 space-y-2.5">
                <div class="flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3 min-w-0">
                        @php $cover = $this->coverUrl; @endphp
                        <div class="w-10 h-10 rounded-xl overflow-hidden bg-gray-100 shrink-0 flex items-center justify-center">
                            @if ($cover)
                                <img src="{{ $cover }}" class="w-full h-full object-cover"
                                    alt="{{ $namaLapangan }}" />
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#9ca3af"
                                    stroke-width="2" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25" />
                                </svg>
                            @endif
                        </div>
                        <div class="min-w-0">
                            <span
                                class="text-[10px] text-gray-400 font-bold uppercase tracking-wider block leading-tight">Arena terpilih</span>
                            <span
                                class="text-sm font-black text-gray-900 truncate block leading-tight mt-0.5">{{ $namaLapangan ?: '-' }}</span>
                        </div>
                    </div>

                    {{-- Tombol Ubah Lapangan --}}
                    <button type="button" wire:click="openChangeArenaModal"
                        class="text-xs font-bold text-blue-600 bg-blue-50 px-2.5 py-1.5 rounded-xl active:scale-95 transition-transform shrink-0 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-3.5 h-3.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>
                        <span>Ubah</span>
                    </button>
                </div>

                <div class="flex justify-between items-center pt-2 pb-2.5 border-t border-b border-gray-100">
                    <div class="min-w-0">
                        <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider block leading-tight">Tanggal</span>
                        <span class="text-xs font-black text-gray-800 block leading-tight mt-0.5 truncate">
                            {{ \Carbon\Carbon::parse($tanggal)->locale('id')->translatedFormat('l, d F Y') }}
                        </span>
                    </div>

                    {{-- Tombol Ubah Tanggal --}}
                    <button type="button" wire:click="openChangeDateModal"
                        class="text-xs font-bold text-blue-600 bg-blue-50 px-2.5 py-1.5 rounded-xl active:scale-95 transition-transform shrink-0 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-3.5 h-3.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                        </svg>
                        <span>Ubah</span>
                    </button>
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
         STEP 2 — KONFIRMASI FORM
    ══════════════════════════════════════════════════════════════════ --}}
    @if ($currentStep === 2)
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
         MODAL: Syarat & Ketentuan (Client-Side Alpine.js)
    ══════════════════════════════════════════════════════════════════ --}}
    @if ($showTermsModal)
        <div class="fixed inset-0 z-50 flex items-end justify-center" wire:key="terms-modal"
            x-data="{ agreed: false }">
            <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" wire:click="$set('showTermsModal', false)">
            </div>
            <div class="relative w-full max-w-lg bg-white rounded-t-3xl shadow-2xl overflow-hidden">
                <div class="px-5 pt-5 pb-4 border-b border-gray-100">
                    <div class="w-10 h-1 bg-gray-200 rounded-full mx-auto mb-4"></div>
                    <div class="text-base font-black text-gray-900">Syarat & Ketentuan</div>
                    <div class="text-xs text-gray-400 font-medium mt-0.5">Mohon dibaca sebelum konfirmasi</div>
                </div>

                <div class="overflow-y-auto max-h-[60vh] px-5 py-4 space-y-4">
                    {{-- Ringkasan Booking & Form --}}
                    <div class="p-3.5 rounded-2xl bg-gray-50 border border-gray-100 space-y-2">
                        <div class="text-[10px] font-black text-gray-400 uppercase tracking-wider mb-1">Ringkasan Pemesanan</div>

                        <div class="flex justify-between items-center text-xs">
                            <span class="text-gray-400 font-medium">Arena</span>
                            <span class="font-bold text-gray-900 text-right uppercase">{{ $namaLapangan ?: '-' }}</span>
                        </div>

                        <div class="flex justify-between items-center text-xs">
                            <span class="text-gray-400 font-medium">Tanggal</span>
                            <span class="font-bold text-gray-900 text-right">
                                {{ $tanggal ? \Carbon\Carbon::parse($tanggal)->locale('id')->translatedFormat('l, d F Y') : '-' }}
                            </span>
                        </div>

                        <div class="flex justify-between items-center text-xs">
                            <span class="text-gray-400 font-medium">Jam</span>
                            <span class="font-black text-blue-600 text-right">
                                {{ ($selectedSlot['mulai'] ?? '') . ' - ' . ($selectedSlot['selesai'] ?? '') }}
                            </span>
                        </div>

                        <div class="flex justify-between items-center text-xs">
                            <span class="text-gray-400 font-medium">Komunitas / Tim</span>
                            <span class="font-bold text-gray-900 text-right">{{ $namaKomunitas ?: '-' }}</span>
                        </div>

                        <div class="flex justify-between items-center text-xs">
                            <span class="text-gray-400 font-medium">Pemain & Kategori</span>
                            <span class="font-bold text-gray-900 text-right">
                                {{ ($jumlahPemain ? $jumlahPemain . ' Orang' : '-') }} • 
                                {{ match($kategoriPemain) { 'anak-anak' => 'Anak-anak', 'remaja' => 'Remaja', 'dewasa' => 'Dewasa', default => ucfirst($kategoriPemain ?: '-') } }}
                            </span>
                        </div>

                        <div class="flex justify-between items-center text-xs">
                            <span class="text-gray-400 font-medium">Jenis Permainan</span>
                            <span class="font-bold text-gray-900 text-right">
                                {{ match($jenisPermainan) { 'fun_match' => 'Fun Match', 'latihan' => 'Latihan', 'turnamen_kecil' => 'Turnamen Kecil', default => ucwords(str_replace('_', ' ', $jenisPermainan ?: '-')) } }}
                            </span>
                        </div>

                        <div class="flex justify-between items-center text-xs pt-1.5 border-t border-gray-200/70">
                            <span class="text-gray-500 font-semibold">Total Biaya</span>
                            <span class="font-black text-emerald-600">GRATIS</span>
                        </div>
                    </div>

                    {{-- Syarat & Catatan Lapangan --}}
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
                        <input type="checkbox" x-model="agreed"
                            class="mt-0.5 w-4 h-4 accent-blue-600 rounded cursor-pointer">
                        <span class="text-xs font-semibold text-gray-700 leading-relaxed select-none">
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
                    <button type="button" wire:click="finalizeBooking"
                        wire:loading.attr="disabled"
                        wire:target="finalizeBooking"
                        :disabled="!agreed"
                        class="py-3.5 rounded-2xl font-black text-sm transition-all disabled:opacity-40 flex items-center justify-center gap-2"
                        :class="agreed ? 'bg-blue-600 text-white shadow-lg shadow-blue-200 cursor-pointer active:scale-[0.98]' : 'bg-gray-200 text-gray-400 cursor-not-allowed'">
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
                    <button type="button" wire:click="cancelBooking"
                        x-data="{ cancelling: false }"
                        @click="cancelling = true"
                        :disabled="cancelling"
                        wire:loading.attr="disabled"
                        wire:target="cancelBooking"
                        class="py-3.5 rounded-2xl bg-red-500 text-white font-black text-sm flex items-center justify-center gap-2 disabled:opacity-75 active:scale-[0.98] transition-all">
                        <span x-show="cancelling"
                            class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></span>
                        <span x-text="cancelling ? 'Membatalkan...' : 'Ya, Batalkan'"></span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- ══════════════════════════════════════════════════════════════════
         MODAL: Ubah / Pilih Lapangan
    ══════════════════════════════════════════════════════════════════ --}}
    @if ($showChangeArenaModal)
        <div class="fixed inset-0 z-50 flex items-end sm:items-center justify-center p-0 sm:p-4"
            wire:key="modal-change-arena">
            {{-- Backdrop --}}
            <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" wire:click="closeChangeArenaModal"></div>

            {{-- Modal Dialog --}}
            <div
                class="relative w-full max-w-lg bg-white rounded-t-3xl sm:rounded-3xl shadow-2xl overflow-hidden flex flex-col max-h-[85vh] animate-in fade-in slide-in-from-bottom duration-200">

                {{-- Modal Header --}}
                <div class="px-5 pt-5 pb-4 border-b border-gray-100 shrink-0 flex items-center justify-between bg-white">
                    <div>
                        <h3 class="text-base font-black text-gray-900 leading-tight">Ubah Lapangan</h3>
                        <p class="text-xs text-gray-400 font-medium mt-0.5">Pilih arena olahraga yang ingin digunakan</p>
                    </div>
                    <button type="button" wire:click="closeChangeArenaModal"
                        class="w-9 h-9 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 hover:bg-gray-200 active:scale-95 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                            stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Modal Scrollable Arena List --}}
                <div class="overflow-y-auto px-5 py-4 space-y-3 flex-1">
                    @forelse ($arenas as $item)
                        @php
                            $isAvail = in_array(strtolower((string) ($item['status'] ?? '')), ['open', 'buka', 'aktif']);
                            $itemStatus = strtolower((string) ($item['status'] ?? ''));
                            $itemCover = $item['image_cover'] ?? null;
                            if ($itemCover && !preg_match('/^https?:\/\//', $itemCover)) {
                                $itemCover = rtrim(config('services.api.image_base_url'), '/') . '/' . ltrim($itemCover, '/');
                            }
                            $itemNama = $item['nama'] ?? ($item['nama_lapangan'] ?? 'Arena');
                            $isSelected = (string)($item['id'] ?? '') === (string)$lapanganId;
                        @endphp

                        <div class="p-3.5 rounded-2xl bg-white border {{ $isSelected ? 'border-blue-500 ring-2 ring-blue-100 bg-blue-50/20' : 'border-gray-100' }} shadow-sm flex items-center gap-3.5 transition-all">
                            {{-- Cover Thumbnail --}}
                            <div class="w-16 h-16 rounded-xl bg-gray-100 overflow-hidden shrink-0 relative">
                                @if ($itemCover)
                                    <img src="{{ $itemCover }}" class="w-full h-full object-cover" alt="{{ $itemNama }}" />
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25" />
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            {{-- Arena Info --}}
                            <div class="flex-1 min-w-0">
                                {{-- Status Badge (di atas nama lapangan, tanpa border) --}}
                                <div class="mb-1">
                                    @if ($isAvail)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[9px] font-black uppercase bg-emerald-50 text-emerald-700">
                                            <span class="w-1 h-1 rounded-full bg-emerald-500 animate-pulse"></span>
                                            <span>Buka</span>
                                        </span>
                                    @elseif ($itemStatus === 'coming_soon')
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[9px] font-black uppercase bg-amber-50 text-amber-700">
                                            <span>Segera Dibuka</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[9px] font-black uppercase bg-red-50 text-red-700">
                                            <span>Tutup</span>
                                        </span>
                                    @endif
                                </div>
                                <h4 class="font-black text-gray-900 text-sm truncate leading-tight">
                                    {{ $itemNama }}
                                </h4>
                                <p class="text-[11px] text-gray-500 line-clamp-1 mt-0.5 font-medium flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3 shrink-0 text-gray-400">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                    </svg>
                                    <span class="truncate">{{ $item['alamat'] ?? ($item['lokasi'] ?? ($item['deskripsi'] ?? 'Fasilitas olahraga Kencana')) }}</span>
                                </p>
                            </div>

                            {{-- Action Button --}}
                            <div class="shrink-0">
                                @if ($isSelected)
                                    <span class="px-3 py-1.5 rounded-xl bg-blue-50 text-blue-600 font-black text-xs uppercase border border-blue-200">
                                        Aktif
                                    </span>
                                @elseif ($isAvail)
                                    <button type="button" wire:click="selectNewArena('{{ $item['id'] }}', '{{ addslashes($itemNama) }}', '{{ $item['image_cover'] ?? '' }}')"
                                        class="px-3.5 py-2 rounded-xl bg-blue-600 text-white font-black text-xs uppercase tracking-wide active:scale-95 transition-transform shadow-md shadow-blue-200">
                                        Pilih
                                    </button>
                                @else
                                    <button type="button" disabled
                                        class="px-3 py-2 rounded-xl bg-gray-100 text-gray-400 font-bold text-xs cursor-not-allowed">
                                        Tutup
                                    </button>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="py-12 text-center text-gray-400 text-xs font-semibold">
                            Tidak ada lapangan tersedia
                        </div>
                    @endforelse
                </div>

                {{-- Modal Footer --}}
                <div class="px-5 py-3.5 border-t border-gray-100 bg-gray-50 shrink-0 text-center">
                    <button type="button" wire:click="closeChangeArenaModal"
                        class="text-xs font-bold text-gray-500 hover:text-gray-700 py-1">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    @endif


    {{-- ══════════════════════════════════════════════════════════════════
         MODAL: Ubah / Pilih Ulang Tanggal
    ══════════════════════════════════════════════════════════════════ --}}
    @if ($showChangeDateModal)
        <div class="fixed inset-0 z-50 flex items-end sm:items-center justify-center p-0 sm:p-4"
            wire:key="modal-change-date">
            {{-- Backdrop --}}
            <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" wire:click="closeChangeDateModal"></div>

            {{-- Modal Dialog --}}
            <div
                class="relative w-full max-w-lg bg-white rounded-t-3xl sm:rounded-3xl shadow-2xl overflow-hidden flex flex-col max-h-[85vh] animate-in fade-in slide-in-from-bottom duration-200">

                {{-- Modal Header --}}
                <div class="px-5 pt-5 pb-4 border-b border-gray-100 shrink-0 flex items-center justify-between bg-white">
                    <div>
                        <h3 class="text-base font-black text-gray-900 leading-tight">Ubah Tanggal Bermain</h3>
                        <p class="text-xs text-gray-400 font-medium mt-0.5">Pilih tanggal bermain yang Anda inginkan</p>
                    </div>
                    <button type="button" wire:click="closeChangeDateModal"
                        class="w-9 h-9 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 hover:bg-gray-200 active:scale-95 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                            stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Modal Scrollable Date Grid --}}
                <div class="overflow-y-auto px-5 py-4 flex-1">
                    <div class="grid grid-cols-4 gap-2.5">
                        @foreach ($carouselDates as $dateStr)
                            @php
                                $isPast = $dateStr < $todayDate;
                                $dt = \Carbon\Carbon::parse($dateStr)->locale('id');
                                $isCurrentSelected = $dateStr === $tanggal;
                            @endphp
                            @if ($isPast)
                                <button type="button" disabled
                                    class="flex flex-col items-center justify-center py-2.5 px-2 rounded-2xl text-center bg-gray-50 text-gray-300 cursor-not-allowed opacity-50">
                                    <span class="text-[10px] font-bold uppercase leading-none">{{ $dt->translatedFormat('D') }}</span>
                                    <span class="text-lg font-black leading-tight my-1">{{ $dt->format('d') }}</span>
                                    <span class="text-[9px] font-semibold uppercase leading-none opacity-80">{{ $dt->translatedFormat('M') }}</span>
                                </button>
                            @else
                                <button type="button" wire:click="selectNewDate('{{ $dateStr }}')"
                                    class="flex flex-col items-center justify-center py-2.5 px-2 rounded-2xl transition-all active:scale-95 text-center {{ $isCurrentSelected ? 'bg-blue-600 text-white shadow-md shadow-blue-200' : 'bg-gray-50 text-gray-700 hover:bg-blue-50 hover:text-blue-600 border border-gray-100' }}">
                                    <span class="text-[10px] font-bold uppercase leading-none {{ $isCurrentSelected ? 'text-blue-100' : 'text-gray-400' }}">{{ $dt->translatedFormat('D') }}</span>
                                    <span class="text-lg font-black leading-tight my-1">{{ $dt->format('d') }}</span>
                                    <span class="text-[9px] font-semibold uppercase leading-none {{ $isCurrentSelected ? 'text-blue-200' : 'text-gray-400' }}">{{ $dt->translatedFormat('M') }}</span>
                                </button>
                            @endif
                        @endforeach
                    </div>
                </div>

                {{-- Modal Footer --}}
                <div class="px-5 py-3.5 border-t border-gray-100 bg-gray-50 shrink-0 text-center">
                    <button type="button" wire:click="closeChangeDateModal"
                        class="text-xs font-bold text-gray-500 hover:text-gray-700 py-1">
                        Tutup
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
