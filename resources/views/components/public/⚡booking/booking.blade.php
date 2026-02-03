<div class="mt-4 sm:mt-8" wire:init="load">
    @if ($ready)
        <div class="w-full" x-transition>
            <!-- Header Section -->
            <div class="mb-8 px-2 flex items-center gap-4">
                <a href="/" wire:navigate
                    class="btn btn-circle btn-ghost btn-sm sm:btn-md border-2 border-base-300 hover:border-info hover:text-info transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                        stroke="currentColor" class="size-5 sm:size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                </a>
                <div>
                    <h2 class="text-xl sm:text-2xl font-black italic uppercase tracking-tighter text-base-content">
                        Pesan <span class="text-info">Arena</span>
                    </h2>
                    <p
                        class="text-[10px] sm:text-xs font-medium text-base-content/60 uppercase tracking-widest mt-0.5 sm:mt-1">
                        Pilih tanggal, arena dan jam
                    </p>
                </div>
                <div wire:loading wire:target="finalizeBooking"
                    class="fixed inset-0 z-60 bg-base-100/80 backdrop-blur-sm">
                    <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 text-center">
                        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-info/10">
                            <span class="loading loading-dots loading-lg text-info"></span>
                        </div>
                        <div class="mt-4 text-sm font-black uppercase italic tracking-widest text-base-content/70">
                            Memproses Booking...
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Booking Form -->
                <div class="lg:col-span-2 space-y-10">

                    <!-- 1. Select Date -->
                    <section>
                        <div class="flex items-center justify-between mb-4 px-2">
                            <div class="flex items-center gap-1">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="size-5 text-info">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-black italic uppercase tracking-tight">1. Pilih Tanggal</h3>
                            </div>
                            <div class="relative" x-data="{ open: false, idx: 0 }" data-cal-selected="{{ $tanggal }}"
                                data-cal-curr-month="{{ $calCurrMonth }}" data-cal-next-month="{{ $calNextMonth }}">
                                <button class="btn btn-base-300 btn-sm" @click="open = !open" type="button"
                                    data-cal-trigger>
                                    <span class="inline-flex items-center gap-2">
                                        <span class="w-4 h-4 inline-flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="2" stroke="currentColor" class="size-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                            </svg>
                                        </span>
                                        <span>Kalender</span>
                                    </span>
                                </button>
                                <div @click.outside="open=false" id="select-date-calendar" wire:ignore
                                    class="absolute right-0 mt-2 w-80 p-3 rounded-xl border border-base-300 bg-base-100 shadow-xl z-20 hidden">
                                    <div class="flex items-center justify-between mb-2">
                                        <button type="button" class="btn btn-ghost btn-xs"
                                            data-cal-prev>&lsaquo;</button>
                                        <div class="text-sm font-black italic uppercase">
                                            <span data-cal-label="curr">{{ $calCurrLabel }}</span>
                                            <span data-cal-label="next" class="hidden">{{ $calNextLabel }}</span>
                                        </div>
                                        <button type="button" class="btn btn-ghost btn-xs"
                                            data-cal-next>&rsaquo;</button>
                                    </div>
                                    <div
                                        class="grid grid-cols-7 gap-1 text-[10px] font-bold uppercase text-base-content/60 mb-1">
                                        <div>Min</div>
                                        <div>Sen</div>
                                        <div>Sel</div>
                                        <div>Rab</div>
                                        <div>Kam</div>
                                        <div>Jum</div>
                                        <div>Sab</div>
                                    </div>
                                    <div data-cal-panel>
                                        <div class="grid grid-cols-7 gap-1">
                                            @for ($i = 0; $i < $calCurrStartDow; $i++)
                                                <div class="h-8"></div>
                                            @endfor
                                            @for ($d = 1; $d <= $calCurrDays; $d++)
                                                <button @click="open=false"
                                                    wire:click="selectDate('{{ sprintf('%s-%02d', $calCurrMonth, $d) }}')"
                                                    wire:loading.attr="disabled" wire:target="selectDate"
                                                    data-cal-date="{{ sprintf('%s-%02d', $calCurrMonth, $d) }}"
                                                    class="h-8 rounded-md text-xs font-bold transition-all
                                                    {{ sprintf('%s-%02d', $calCurrMonth, $d) === $tanggal ? 'bg-info text-info-content' : 'bg-base-100 hover:bg-base-200' }}
                                                    {{ sprintf('%s-%02d', $calCurrMonth, $d) < $todayDate ? 'opacity-40 cursor-not-allowed pointer-events-none' : '' }}"
                                                    {{ sprintf('%s-%02d', $calCurrMonth, $d) < $todayDate ? 'disabled aria-disabled=true' : '' }}>
                                                    {{ $d }}
                                                </button>
                                            @endfor
                                        </div>
                                        <div class="mt-2 flex justify-end">
                                            <button type="button" class="btn btn-ghost btn-xs"
                                                data-cal-close>Tutup</button>
                                        </div>
                                    </div>
                                    <div data-cal-panel class="hidden">
                                        <div class="grid grid-cols-7 gap-1">
                                            @for ($i = 0; $i < $calNextStartDow; $i++)
                                                <div class="h-8"></div>
                                            @endfor
                                            @for ($d = 1; $d <= $calNextDays; $d++)
                                                <button @click="open=false"
                                                    wire:click="selectDate('{{ sprintf('%s-%02d', $calNextMonth, $d) }}')"
                                                    wire:loading.attr="disabled" wire:target="selectDate"
                                                    data-cal-date="{{ sprintf('%s-%02d', $calNextMonth, $d) }}"
                                                    class="h-8 rounded-md text-xs font-bold transition-all
                                                    {{ sprintf('%s-%02d', $calNextMonth, $d) === $tanggal ? 'bg-info text-info-content' : 'bg-base-100 hover:bg-base-200' }}">
                                                    {{ $d }}
                                                </button>
                                            @endfor
                                        </div>
                                        <div class="mt-2 flex justify-end">
                                            <button type="button" class="btn btn-ghost btn-xs"
                                                data-cal-close>Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="carousel carousel-center w-full bg-base-200/30 rounded-2xl p-4 space-x-3">
                            @foreach ($carouselDates as $dateStr)
                                <div class="carousel-item">
                                    <button wire:click="selectDate('{{ $dateStr }}')" wire:loading.attr="disabled"
                                        wire:target="selectDate" data-date="{{ $dateStr }}"
                                        class="flex flex-col items-center justify-center w-16 h-20 rounded-xl transition-all {{ $dateStr === $tanggal ? 'bg-info text-info-content shadow-lg shadow-info/20' : 'bg-base-100 hover:bg-base-200 text-base-content/70' }}">
                                        <span wire:loading.remove wire:target="selectDate"
                                            class="text-[10px] font-bold uppercase">{{ \Carbon\Carbon::parse($dateStr)->locale('id')->translatedFormat('D') }}</span>
                                        <span wire:loading.remove wire:target="selectDate"
                                            class="text-xl font-black italic">{{ \Carbon\Carbon::parse($dateStr)->format('d') }}</span>
                                        <span wire:loading.remove wire:target="selectDate"
                                            class="text-[9px] font-bold uppercase">{{ \Carbon\Carbon::parse($dateStr)->locale('id')->translatedFormat('M') }}</span>
                                        <span wire:loading wire:target="selectDate"
                                            class="loading loading-dots loading-xs"></span>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </section>

                    <!-- 2. Arena & Time -->
                    <section>
                        <div class="flex items-center gap-1 mb-4 px-2">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" class="size-5 text-info">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-black italic uppercase tracking-tight">2. Pilih Arena & Jam</h3>
                        </div>

                        <div class="w-full pb-6 px-2">
                            @if ($lapanganId)
                                <div
                                    class="w-full p-4 rounded-2xl bg-base-100 border-2 border-info shadow-lg transition-all">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <span
                                                class="text-[9px] font-black uppercase italic px-1.5 py-0.5 rounded bg-info text-info-content">
                                                Arena
                                            </span>
                                            <h4 class="text-base font-black italic uppercase mt-1 leading-none">
                                                {{ $namaLapangan }}
                                            </h4>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-xs font-black italic text-info">GRATIS</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="relative bg-base-200/40 rounded-2xl p-4 border border-base-200/50 mt-4"
                                    wire:loading.class="opacity-50 pointer-events-none" wire:target="selectDate">
                                    <div class="grid grid-cols-3 lg:grid-cols-9 gap-2">
                                        @foreach ($timeSlots as $slot)
                                            <button {{ $this->slotIsAvailable($slot) ? '' : 'disabled' }}
                                                data-time-slot
                                                wire:click="selectTime('{{ $slot['mulai'] ?? '' }}','{{ $slot['selesai'] ?? '' }}')"
                                                wire:loading.attr="disabled" wire:target="selectTime"
                                                class="py-2 rounded-lg font-black italic text-[16px] md:text-[17px] transition-all
                                                {{ !$this->slotIsAvailable($slot)
                                                    ? 'bg-base-300/50 text-base-content/10 cursor-not-allowed line-through'
                                                    : ($this->slotIsSelected($slot)
                                                        ? 'bg-info text-info-content border border-info/50 shadow-lg shadow-info/20'
                                                        : 'bg-base-100 hover:bg-info/10 hover:text-info border border-transparent hover:border-info/20') }}">
                                                <span class="block">{{ $slot['mulai'] }}</span>
                                                <span class="block">{{ $slot['selesai'] }}</span>
                                                <span class="block text-[10px] font-bold uppercase text-warning">
                                                    {{ $slot['status'] ?? '' }}
                                                </span>
                                            </button>
                                        @endforeach
                                    </div>
                                    <div wire:loading wire:target="selectDate"
                                        class="absolute inset-0 z-10 bg-base-100/40"></div>
                                    <div wire:loading wire:target="selectTime"
                                        class="absolute inset-0 rounded-2xl z-30 bg-base-100/80 backdrop-blur-sm">
                                        <div
                                            class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 text-center">
                                            <div
                                                class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-info/10">
                                                <span class="loading loading-dots loading-lg text-info"></span>
                                            </div>
                                            <div
                                                class="mt-2 text-[10px] sm:text-xs font-black uppercase italic tracking-widest text-base-content/70">
                                                Memilih Waktu...
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="w-full p-4 rounded-2xl bg-base-100 border-2 border-info shadow-lg">
                                        <div class="flex items-center justify-between">
                                            <h4 class="text-base font-black italic uppercase leading-none">
                                                Pilih Arena
                                            </h4>
                                            <span class="text-[10px] font-bold uppercase text-warning">
                                                {{ count(array_filter($arenas, fn($a) => ($a['status'] ?? '') === 'open')) }}
                                                tersedia
                                            </span>
                                        </div>
                                    </div>
                                    @if (count($arenas) === 0)
                                        <div class="mt-4 p-4 rounded-xl bg-base-200 border border-base-300/50">
                                            <div class="text-sm font-bold uppercase text-base-content/60">
                                                Belum ada arena tersedia
                                            </div>
                                            <div class="text-xs font-medium text-base-content/50 mt-1">
                                                Silakan kembali ke beranda untuk melihat informasi terbaru.
                                            </div>
                                            <div class="mt-3">
                                                <a href="/" wire:navigate class="btn btn-sm btn-ghost">
                                                    Kembali ke Beranda
                                                </a>
                                            </div>
                                        </div>
                                    @elseif ($error && !$this->isValidationErr($error))
                                        <div class="alert alert-error mt-4">
                                            <span>{{ $error }}</span>
                                        </div>
                                    @else
                                        <div class="relative mt-4">
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                                @foreach ($arenas as $arena)
                                                    <button {{ $this->arenaIsComing($arena) ? 'disabled' : '' }}
                                                        class="p-4 rounded-xl border transition-all text-left
                                                {{ $this->arenaIsComing($arena)
                                                    ? 'bg-base-300/50 text-base-content/10 cursor-not-allowed line-through border-base-300'
                                                    : ($this->arenaIsSelected($arena)
                                                        ? 'bg-info text-info-content border-info shadow-lg shadow-info/20'
                                                        : 'bg-base-100 border-base-300 hover:border-info/40 hover:bg-info/5') }}"
                                                        wire:click="selectArena('{{ $arena['id'] ?? '' }}','{{ $arena['nama_lapangan'] ?? 'Arena' }}')"
                                                        wire:loading.attr="disabled" wire:target="selectArena">
                                                        <div class="flex items-center justify-between">
                                                            <div>
                                                                <div
                                                                    class="text-xs font-black uppercase italic {{ $this->arenaIsSelected($arena) ? 'text-info-content' : 'text-info' }}">
                                                                    Arena
                                                                </div>
                                                                <div class="text-sm font-black italic uppercase">
                                                                    {{ $arena['nama_lapangan'] ?? 'Arena' }}
                                                                </div>
                                                            </div>
                                                            <div class="text-right">
                                                                <span
                                                                    class="text-[10px] font-bold uppercase text-warning {{ $this->arenaIsSelected($arena) ? 'text-info-content/70' : 'text-base-content/50' }}">
                                                                    {{ $arena['status_label'] ?? '' }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div wire:loading wire:target="selectArena" class="mt-2">
                                                            <span class="loading loading-dots loading-xs"></span>
                                                        </div>
                                                    </button>
                                                @endforeach
                                            </div>
                                            <div wire:loading wire:target="selectArena"
                                                class="absolute inset-0 z-10 bg-base-100/40"></div>
                                        </div>
                                    @endif
                            @endif
                        </div>
                        <!-- Legend -->
                        <div
                            class="mt-4 flex flex-wrap gap-x-4 gap-y-2 text-[9px] font-bold uppercase tracking-widest text-base-content/50 px-4">
                            <div class="flex items-center gap-1.5">
                                <div class="w-2.5 h-2.5 rounded bg-base-100 border border-base-300"></div>
                                Tersedia
                            </div>
                            <div class="flex items-center gap-1.5">
                                <div class="w-2.5 h-2.5 rounded bg-info"></div>
                                Dipilih
                            </div>
                            <div class="flex items-center gap-1.5">
                                <div class="w-2.5 h-2.5 rounded bg-base-300/50 line-through"></div>
                                Dipesan
                            </div>
                        </div>
                    </section>
                </div>

                <!-- Sidebar / Summary -->
                <div class="lg:col-span-1">
                    <div class="space-y-6">
                        <div class="bg-base-100 rounded-3xl border-2 border-base-200 overflow-hidden shadow-xl">
                            <div class="bg-info p-6">
                                <h4 class="text-info-content font-black italic uppercase tracking-tighter text-xl">
                                    Booking
                                    Summary</h4>
                            </div>
                            <div class="p-6 space-y-4">
                                <div
                                    class="flex justify-between items-center py-2 border-b border-base-200 border-dashed">
                                    <span class="text-xs font-bold uppercase text-base-content/50">Arena</span>
                                    <span class="font-black italic uppercase text-sm">
                                        {{ $namaLapangan ?: '-' }}
                                        <span wire:loading wire:target="selectArena"
                                            class="loading loading-dots loading-xs ml-2"></span>
                                    </span>
                                </div>
                                <div
                                    class="flex justify-between items-center py-2 border-b border-base-200 border-dashed">
                                    <span class="text-xs font-bold uppercase text-base-content/50">Tanggal</span>
                                    <span class="font-black italic uppercase text-sm">
                                        {{ \Carbon\Carbon::parse($tanggal)->locale('id')->translatedFormat('l, d F Y') }}
                                        <span wire:loading wire:target="selectDate"
                                            class="loading loading-dots loading-xs ml-2"></span>
                                    </span>
                                </div>
                                <div
                                    class="flex justify-between items-center py-2 border-b border-base-200 border-dashed">
                                    <span class="text-xs font-bold uppercase text-base-content/50">Jam</span>
                                    <span class="font-black italic uppercase text-sm">
                                        {{ $selectedSlot ? ($selectedSlot['mulai'] ?? '') . ' - ' . ($selectedSlot['selesai'] ?? '') : '-' }}
                                        <span wire:loading wire:target="selectTime"
                                            class="loading loading-dots loading-xs ml-2"></span>
                                    </span>
                                </div>

                                <div class="pt-4">
                                    <div class="flex justify-between items-end">
                                        <span class="text-xs font-bold uppercase text-base-content/50">Total
                                            Biaya</span>
                                        <span class="text-2xl font-black italic text-info leading-none">GRATIS</span>
                                    </div>
                                </div>

                                <div class="mt-6 space-y-4">
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <label class="text-[10px] font-bold uppercase text-base-content/50">Nama
                                                Komunitas</label>
                                            <input type="text" class="input input-bordered input-sm w-full mt-1"
                                                placeholder="Nama tim (opsional)" wire:model="namaKomunitas">
                                            @error('namaKomunitas')
                                                <p class="text-[10px] text-error mt-1 font-bold uppercase">
                                                    {{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="text-[10px] font-bold uppercase text-base-content/50">Jumlah
                                                Pemain</label>
                                            <input type="number" min="1"
                                                class="input input-bordered input-sm w-full mt-1"
                                                placeholder="Masukkan jumlah" wire:model="jumlahPemain">
                                            @error('jumlahPemain')
                                                <p class="text-[10px] text-error mt-1 font-bold uppercase">
                                                    {{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-3 mt-3">
                                        <div>
                                            <label
                                                class="text-[10px] font-bold uppercase text-base-content/50">Kategori
                                                Pemain</label>
                                            <div x-data="{ open: false }" class="relative">
                                                <button type="button" @click="open = !open"
                                                    class="input input-bordered input-sm w-full mt-1 text-left cursor-pointer">
                                                    <span class="font-bold uppercase text-[11px]">
                                                        {{ $kategoriPemain ?: 'Pilih kategori' }}
                                                    </span>
                                                </button>
                                                <div x-show="open" @click.outside="open = false"
                                                    class="absolute left-0 right-0 mt-1 rounded-xl border border-base-300 bg-base-100 shadow-xl z-50">
                                                    <ul class="menu menu-sm w-full">
                                                        <li>
                                                            <button type="button" class="uppercase"
                                                                wire:click="$set('kategoriPemain', 'anak-anak')"
                                                                @click="open = false">anak-anak</button>
                                                        </li>
                                                        <li>
                                                            <button type="button" class="uppercase"
                                                                wire:click="$set('kategoriPemain', 'remaja')"
                                                                @click="open = false">remaja</button>
                                                        </li>
                                                        <li>
                                                            <button type="button" class="uppercase"
                                                                wire:click="$set('kategoriPemain', 'dewasa')"
                                                                @click="open = false">dewasa</button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            @error('kategoriPemain')
                                                <p class="text-[10px] text-error mt-1 font-bold uppercase">
                                                    {{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="text-[10px] font-bold uppercase text-base-content/50">Jenis
                                                Permainan</label>
                                            <div x-data="{ open: false }" class="relative">
                                                <button type="button" @click="open = !open"
                                                    class="input input-bordered input-sm w-full mt-1 text-left cursor-pointer">
                                                    <span class="font-bold uppercase text-[11px]">
                                                        {{ $this->jenisLabel() }}
                                                    </span>
                                                </button>
                                                <div x-show="open" @click.outside="open = false"
                                                    class="absolute left-0 right-0 mt-1 rounded-xl border border-base-300 bg-base-100 shadow-xl z-50">
                                                    <ul class="menu menu-sm w-full">
                                                        <li>
                                                            <button type="button" class="uppercase"
                                                                wire:click="$set('jenisPermainan', 'fun_match')"
                                                                @click="open = false">FUN MATCH</button>
                                                        </li>
                                                        <li>
                                                            <button type="button" class="uppercase"
                                                                wire:click="$set('jenisPermainan', 'latihan')"
                                                                @click="open = false">LATIHAN</button>
                                                        </li>
                                                        <li>
                                                            <button type="button" class="uppercase"
                                                                wire:click="$set('jenisPermainan', 'turnamen_kecil')"
                                                                @click="open = false">TURNAMEN KECIL</button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            @error('jenisPermainan')
                                                <p class="text-[10px] text-error mt-1 font-bold uppercase">
                                                    {{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <button
                                        class="btn btn-info w-full mt-6 -skew-x-12 italic font-black uppercase text-sm sm:text-lg h-12 sm:h-14 shadow-lg shadow-info/20"
                                        x-on:click="window.__bookingSuppressScroll = true; window.__bookingNoScrollUntil = Date.now() + 3000;"
                                        wire:click="confirmBooking" wire:loading.attr="disabled"
                                        wire:target="confirmBooking">
                                        <span class="sm:skew-x-12">Konfirmasi Booking</span>
                                        <span class="loading loading-dots loading-xs ml-2" wire:loading
                                            wire:target="confirmBooking"></span>
                                    </button>
                                    @if ($error)
                                        <div class="alert alert-error mt-3">
                                            <span>{{ $error }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div wire:loading wire:target="confirmBooking"
                    class="fixed inset-0 z-50 bg-base-100/80 backdrop-blur-sm">
                    <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 text-center">
                        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-info/10">
                            <span class="loading loading-dots loading-lg text-info"></span>
                        </div>
                        <div class="mt-4 text-sm font-black uppercase italic tracking-widest text-base-content/70">
                            Memproses Booking...
                        </div>
                    </div>
                </div>

                @if ($showTermsModal)
                    <div class="fixed inset-0 z-50 grid place-items-center p-4">
                        <div class="absolute inset-0 bg-base-100/80 backdrop-blur-sm"></div>
                        <div
                            class="relative w-full max-w-sm sm:max-w-md mx-4 sm:mx-0 rounded-2xl sm:rounded-3xl border-2 border-warning bg-base-100 shadow-2xl overflow-hidden">
                            <div class="bg-warning p-4 sm:p-6">
                                <div class="flex items-center gap-2 sm:gap-3">
                                    <div
                                        class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl bg-warning-content/20 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                            fill="currentColor" class="size-5 sm:size-6 text-warning-content">
                                            <path fill-rule="evenodd"
                                                d="M12 2.25c5.385 0 9.75 4.365 9.75 9.75s-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12 6.615 2.25 12 2.25ZM12 8.25a.75.75 0 0 1 .75.75v5.25a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4
                                            class="text-warning-content font-black italic uppercase tracking-tighter text-lg sm:text-xl">
                                            Baca syarat dan ketentuan
                                        </h4>
                                        <div
                                            class="text-[9px] sm:text-[10px] font-bold uppercase text-warning-content/70">
                                            Mohon dibaca sebelum konfirmasi
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-4 sm:p-6 space-y-4 overflow-y-auto max-h-[70vh]">
                                @forelse ($catatan as $group)
                                    <div class="space-y-2">
                                        <div class="text-xs font-black italic uppercase text-base-content/70">
                                            {{ $group['kategori_catatan'] ?? 'Catatan' }}
                                        </div>
                                        <ul class="space-y-1">
                                            @foreach ($group['items'] ?? [] as $item)
                                                <li class="flex items-center gap-3">
                                                    <span class="flex-none w-2 h-2 rounded-full bg-warning"></span>
                                                    <span
                                                        class="text-xs sm:text-sm leading-relaxed wrap-break-word">{{ $item['catatan'] ?? '' }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @empty
                                    <div class="text-sm font-bold uppercase text-base-content/60">
                                        Checklist Setuju dengan syarat dan ketentuan.
                                    </div>
                                @endforelse
                                <div class="form-control">
                                    <label class="label cursor-pointer justify-start gap-3 px-1.5 sm:px-0">
                                        <input type="checkbox"
                                            class="checkbox checkbox-warning checkbox-sm sm:checkbox-md"
                                            wire:model="termsAgreed">
                                        <span
                                            class="label-text text-xs sm:text-sm font-bold uppercase leading-snug">Setuju
                                            dengan syarat dan
                                            ketentuan</span>
                                    </label>
                                </div>
                                <div class="mt-2 grid grid-cols-1 sm:grid-cols-2 gap-2">
                                    <button type="button" class="btn btn-ghost w-full"
                                        wire:click="$set('showTermsModal', false)">
                                        Tutup
                                    </button>
                                    <button type="button" class="btn btn-warning w-full"
                                        wire:click="finalizeBooking" wire:loading.attr="disabled"
                                        wire:target="finalizeBooking">
                                        Setuju dan Konfirmasi
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if ($showSuccessModal)
                    <div class="fixed inset-0 z-50 grid place-items-center p-4">
                        <div class="absolute inset-0 bg-base-100/80 backdrop-blur-sm"></div>
                        <div
                            class="relative w-full max-w-sm sm:max-w-md mx-4 sm:mx-0 rounded-2xl sm:rounded-3xl border-2 border-info bg-base-100 shadow-2xl overflow-hidden">
                            <div class="bg-info p-4 sm:p-6">
                                <div class="flex items-center gap-2 sm:gap-3">
                                    <div
                                        class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl bg-info-content/20 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                            fill="currentColor" class="size-5 sm:size-6 text-info-content">
                                            <path fill-rule="evenodd"
                                                d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.94a.75.75 0 1 0-1.22-.86l-3.864 5.497-2.064-2.064a.75.75 0 1 0-1.06 1.06l2.667 2.667a.75.75 0 0 0 1.177-.127l4.427-6.173Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4
                                            class="text-info-content font-black italic uppercase tracking-tighter text-lg sm:text-xl">
                                            Booking Berhasil
                                        </h4>
                                        <div
                                            class="text-[9px] sm:text-[10px] font-bold uppercase text-info-content/70">
                                            Keep the code for your match
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-4 sm:p-6 space-y-3 sm:space-y-4 overflow-y-auto max-h-[70vh]">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-bold uppercase text-base-content/50">Kode
                                        Booking</span>
                                    <span
                                        class="px-3 py-1 rounded-lg bg-info/10 text-info font-black italic uppercase tracking-wide">
                                        {{ $bookingCode ?: '-' }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-bold uppercase text-base-content/50">Arena</span>
                                    <span class="font-black italic uppercase text-sm">
                                        {{ $namaLapangan ?: '-' }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-bold uppercase text-base-content/50">Tanggal</span>
                                    <span class="font-black italic uppercase text-sm">
                                        {{ \Carbon\Carbon::parse($tanggal)->locale('id')->translatedFormat('l, d F Y') }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-bold uppercase text-base-content/50">
                                        Waktu
                                    </span>
                                    <span class="font-black italic uppercase text-sm">
                                        {{ $selectedSlot ? ($selectedSlot['mulai'] ?? '') . ' - ' . ($selectedSlot['selesai'] ?? '') : '-' }}
                                    </span>
                                </div>
                                <div class="pt-2 text-center">
                                    <div class="text-[10px] font-bold uppercase text-base-content/50">
                                        {{ $bookingMessage }}
                                    </div>
                                </div>
                                <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-2">
                                    <a href="/booking" wire:navigate class="btn btn-ghost w-full">Tutup</a>
                                    <a href="/" wire:navigate class="btn btn-info w-full">
                                        <span>Kembali ke Beranda</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @else
            <!-- Skeleton Loading -->
            <div class="w-full animate-pulse">
                <!-- Header Skeleton -->
                <div class="mb-8 px-2 flex items-center gap-4">
                    <div class="size-8 sm:size-12 rounded-full bg-base-300"></div>
                    <div>
                        <div class="h-6 sm:h-8 bg-base-300 w-48 sm:w-64 rounded-lg"></div>
                        <div class="h-3 sm:h-4 bg-base-300 w-32 sm:w-48 mt-2 rounded-lg"></div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Main Form Skeleton -->
                    <div class="lg:col-span-2 space-y-10">
                        <!-- Date Skeleton -->
                        <section>
                            <div class="flex items-center gap-3 mb-4 px-2">
                                <div class="w-8 h-8 rounded-lg bg-base-300"></div>
                                <div class="h-6 bg-base-300 w-32 rounded"></div>
                            </div>
                            <div class="carousel carousel-center w-full bg-base-200/30 rounded-2xl p-4 space-x-3">
                                @for ($i = 0; $i < 7; $i++)
                                    <div class="carousel-item">
                                        <div class="w-16 h-20 bg-base-300 rounded-xl"></div>
                                    </div>
                                @endfor
                            </div>
                        </section>

                        <!-- Arena & Time Skeleton -->
                        <section>
                            <div class="flex items-center gap-3 mb-4 px-2">
                                <div class="w-8 h-8 rounded-lg bg-base-300"></div>
                                <div class="h-6 bg-base-300 w-48 rounded"></div>
                            </div>
                            <div
                                class="carousel carousel-start w-full gap-4 pb-6 px-2 lg:grid lg:grid-cols-2 lg:carousel-none">
                                @for ($i = 0; $i < 2; $i++)
                                    <div class="carousel-item w-[85%] sm:w-95 lg:w-full flex-col gap-3">
                                        <!-- Header Card Skeleton -->
                                        <div
                                            class="w-full p-4 rounded-2xl bg-base-200 border-2 border-base-300/30 h-20">
                                            <div class="flex justify-between items-start">
                                                <div class="space-y-2">
                                                    <div class="h-3 bg-base-300 w-16 rounded"></div>
                                                    <div class="h-5 bg-base-300 w-32 rounded"></div>
                                                </div>
                                                <div class="h-4 bg-base-300 w-20 rounded"></div>
                                            </div>
                                        </div>
                                        <!-- Time Grid Skeleton -->
                                        <div class="bg-base-200/40 rounded-2xl p-4 border border-base-200/50">
                                            <div class="grid grid-cols-4 gap-2">
                                                @for ($j = 0; $j < 12; $j++)
                                                    <div class="h-8 bg-base-300 rounded-lg"></div>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </section>
                    </div>

                    <!-- Sidebar Skeleton -->
                    <div class="lg:col-span-1">
                        <div class="sticky top-6 space-y-6">
                            <div class="bg-base-100 rounded-3xl border-2 border-base-200 overflow-hidden shadow-xl">
                                <div class="h-16 bg-base-300"></div>
                                <div class="p-6 space-y-6">
                                    @for ($i = 0; $i < 3; $i++)
                                        <div class="flex justify-between">
                                            <div class="h-4 bg-base-300 w-16 rounded"></div>
                                            <div class="h-4 bg-base-300 w-24 rounded"></div>
                                        </div>
                                    @endfor
                                    <div class="pt-4">
                                        <div class="flex justify-between items-end">
                                            <div class="h-3 bg-base-300 w-20 rounded"></div>
                                            <div class="h-8 bg-base-300 w-24 rounded"></div>
                                        </div>
                                    </div>
                                    <div class="h-14 bg-base-300 rounded-xl mt-6"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
