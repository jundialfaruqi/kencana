<div class="mt-4 sm:mt-8" wire:init="load">
    @if ($ready)
        <div class="w-full" x-transition>
            <!-- Header Section -->
            <div class="mb-8 px-2 flex items-center gap-4">
                <button type="button" wire:click="handleBack"
                    class="btn btn-circle btn-ghost btn-sm sm:btn-md border-2 border-base-300 hover:border-info hover:text-info transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                        stroke="currentColor" class="size-5 sm:size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                </button>
                <div>
                    <h2 class="text-xl sm:text-2xl font-black italic uppercase tracking-tighter text-base-content">
                        Pesan <span class="text-info">Arena</span>
                    </h2>
                    <p
                        class="text-[10px] sm:text-xs font-medium text-base-content/60 uppercase tracking-widest mt-0.5 sm:mt-1">
                        {{ $this->getStepTitle() }}
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

            <ul class="steps w-full mb-8 max-w-3xl mx-auto flex justify-center">
                <li class="step step-info text-[10px] sm:text-xs font-bold uppercase">
                    {{ $currentStep === 1 ? 'Tanggal' : '' }}</li>
                <li class="step {{ $currentStep >= 2 ? 'step-info' : '' }} text-[10px] sm:text-xs font-bold uppercase">
                    {{ $currentStep === 2 ? 'Arena & Jam' : '' }}</li>
                <li class="step {{ $currentStep >= 3 ? 'step-info' : '' }} text-[10px] sm:text-xs font-bold uppercase">
                    {{ $currentStep === 3 ? 'Konfirmasi' : '' }}</li>
            </ul>

            <div class="grid grid-cols-1 {{ $currentStep === 3 ? '' : 'lg:grid-cols-3' }} gap-8">
                <!-- Main Booking Form -->
                @if ($currentStep < 3)
                    <div class="lg:col-span-2 space-y-10">

                        <!-- 1. Select Date -->
                        @if ($currentStep === 1)
                            <section x-data x-init="window.scrollTo({ top: 0, behavior: 'smooth' })">
                                <div class="flex items-center justify-between mb-4 px-2">
                                    <div class="flex items-center gap-1">
                                        <div class="w-8 h-8 rounded-lg flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="2" stroke="currentColor" class="size-5 text-info">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                            </svg>
                                        </div>
                                        <h3 class="text-xl font-black italic uppercase tracking-tight">1. Pilih Tanggal
                                        </h3>
                                    </div>
                                    <div class="relative" x-data="{ open: false, idx: 0 }"
                                        data-cal-selected="{{ $tanggal }}"
                                        data-cal-curr-month="{{ $calCurrMonth }}"
                                        data-cal-next-month="{{ $calNextMonth }}">
                                        <button class="btn btn-base-300 btn-sm" @click="open = !open" type="button"
                                            data-cal-trigger>
                                            <span class="inline-flex items-center gap-2">
                                                <span class="w-4 h-4 inline-flex items-center justify-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                        class="size-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                                    </svg>
                                                </span>
                                                <span>Kalender</span>
                                            </span>
                                        </button>
                                        <div @click.outside="open=false" id="select-date-calendar" wire:ignore.self
                                            class="absolute right-0 mt-2 w-80 p-3 rounded-xl border border-base-300 bg-base-100 shadow-xl z-20 hidden">
                                            <div class="flex items-center justify-between mb-2">
                                                <button type="button" class="btn btn-ghost btn-xs"
                                                    data-cal-prev>&lsaquo;</button>
                                                <div class="text-sm font-black italic uppercase">
                                                    <span data-cal-label="curr">{{ $calCurrLabel }}</span>
                                                    <span data-cal-label="next"
                                                        class="hidden">{{ $calNextLabel }}</span>
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
                                                        <button
                                                            wire:click="selectDate('{{ sprintf('%s-%02d', $calCurrMonth, $d) }}')"
                                                            wire:loading.attr="disabled"
                                                            wire:target="selectDate('{{ sprintf('%s-%02d', $calCurrMonth, $d) }}')"
                                                            data-cal-date="{{ sprintf('%s-%02d', $calCurrMonth, $d) }}"
                                                            class="h-8 rounded-md text-xs font-bold transition-all
                                                    {{ sprintf('%s-%02d', $calCurrMonth, $d) === $tanggal ? 'bg-info text-info-content' : 'bg-base-100 hover:bg-base-200' }}
                                                    {{ sprintf('%s-%02d', $calCurrMonth, $d) < $todayDate ? 'opacity-40 cursor-not-allowed pointer-events-none' : '' }}"
                                                            {{ sprintf('%s-%02d', $calCurrMonth, $d) < $todayDate ? 'disabled aria-disabled=true' : '' }}>
                                                            <span wire:loading.remove
                                                                wire:target="selectDate('{{ sprintf('%s-%02d', $calCurrMonth, $d) }}')">{{ $d }}</span>
                                                            <span class="loading loading-dots loading-xs" wire:loading
                                                                wire:target="selectDate('{{ sprintf('%s-%02d', $calCurrMonth, $d) }}')"></span>
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
                                                        <button
                                                            wire:click="selectDate('{{ sprintf('%s-%02d', $calNextMonth, $d) }}')"
                                                            wire:loading.attr="disabled"
                                                            wire:target="selectDate('{{ sprintf('%s-%02d', $calNextMonth, $d) }}')"
                                                            data-cal-date="{{ sprintf('%s-%02d', $calNextMonth, $d) }}"
                                                            class="h-8 rounded-md text-xs font-bold transition-all
                                                    {{ sprintf('%s-%02d', $calNextMonth, $d) === $tanggal ? 'bg-info text-info-content' : 'bg-base-100 hover:bg-base-200' }}">
                                                            <span wire:loading.remove
                                                                wire:target="selectDate('{{ sprintf('%s-%02d', $calNextMonth, $d) }}')">{{ $d }}</span>
                                                            <span class="loading loading-dots loading-xs" wire:loading
                                                                wire:target="selectDate('{{ sprintf('%s-%02d', $calNextMonth, $d) }}')"></span>
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
                                            <button wire:click="selectDate('{{ $dateStr }}')"
                                                wire:loading.attr="disabled"
                                                wire:target="selectDate('{{ $dateStr }}')"
                                                data-date="{{ $dateStr }}"
                                                class="flex flex-col items-center justify-center w-16 h-20 rounded-xl transition-all {{ $dateStr === $tanggal ? 'bg-info text-info-content shadow-lg shadow-info/20' : 'bg-base-100 hover:bg-base-200 text-base-content/70' }}">
                                                <span wire:loading.remove
                                                    wire:target="selectDate('{{ $dateStr }}')"
                                                    class="text-[10px] font-bold uppercase">{{ \Carbon\Carbon::parse($dateStr)->locale('id')->translatedFormat('D') }}</span>
                                                <span wire:loading.remove
                                                    wire:target="selectDate('{{ $dateStr }}')"
                                                    class="text-xl font-black italic">{{ \Carbon\Carbon::parse($dateStr)->format('d') }}</span>
                                                <span wire:loading.remove
                                                    wire:target="selectDate('{{ $dateStr }}')"
                                                    class="text-[9px] font-bold uppercase">{{ \Carbon\Carbon::parse($dateStr)->locale('id')->translatedFormat('M') }}</span>
                                                <span wire:loading wire:target="selectDate('{{ $dateStr }}')"
                                                    class="loading loading-dots loading-xs"></span>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="mt-8 flex justify-end">
                                    <button type="button" wire:click="nextStep"
                                        class="btn btn-info w-full sm:w-auto -skew-x-12 italic font-black uppercase shadow-lg shadow-info/20">
                                        <span class="skew-x-12">Lanjut Pilih Arena</span>
                                    </button>
                                </div>
                            </section>
                        @endif

                        <!-- 2. Arena & Time -->
                        @if ($currentStep === 2)
                            <section x-data x-init="window.scrollTo({ top: 0, behavior: 'smooth' })">
                                <div class="flex items-center gap-1 mb-4 px-2">
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="2" stroke="currentColor" class="size-5 text-info">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-black italic uppercase tracking-tight">2. Pilih Arena & Jam
                                    </h3>
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
                                                    <h4
                                                        class="text-base font-black italic uppercase mt-1 leading-none">
                                                        {{ $namaLapangan }}
                                                    </h4>
                                                </div>
                                                <div class="text-right flex flex-col items-end gap-2">
                                                    <span class="text-xs font-black italic text-info">GRATIS</span>
                                                    <button type="button" wire:click="resetArena"
                                                        wire:loading.attr="disabled" wire:target="resetArena"
                                                        class="btn btn-xs btn-outline btn-error text-[10px] uppercase font-bold px-2">
                                                        <span wire:loading.remove wire:target="resetArena">Ganti
                                                            Arena</span>
                                                        <span wire:loading wire:target="resetArena"
                                                            class="loading loading-spinner loading-xs"></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="relative bg-base-200/40 rounded-2xl p-4 border border-base-200/50 mt-4"
                                            wire:loading.class="opacity-50 pointer-events-none"
                                            wire:target="selectDate">
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
                                                        <span
                                                            class="block text-[10px] font-bold uppercase text-warning">
                                                            {{ $this->getSlotDisplayStatus($slot) }}
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
                                            <div
                                                class="w-full p-4 rounded-2xl bg-base-100 border-2 border-info shadow-lg">
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
                                                            <button
                                                                {{ $this->arenaIsComing($arena) ? 'disabled' : '' }}
                                                                class="p-4 rounded-xl border transition-all text-left
                                                {{ $this->arenaIsComing($arena)
                                                    ? 'bg-base-300/50 text-base-content/10 cursor-not-allowed line-through border-base-300'
                                                    : ($this->arenaIsSelected($arena)
                                                        ? 'bg-info text-info-content border-info shadow-lg shadow-info/20'
                                                        : 'bg-base-100 border-base-300 hover:border-info/40 hover:bg-info/5') }}"
                                                                wire:click="selectArena('{{ $arena['id'] ?? '' }}','{{ $arena['nama_lapangan'] ?? 'Arena' }}')"
                                                                wire:loading.attr="disabled"
                                                                wire:target="selectArena('{{ $arena['id'] ?? '' }}','{{ $arena['nama_lapangan'] ?? 'Arena' }}')">
                                                                <div class="flex items-center justify-between">
                                                                    <div>
                                                                        <div
                                                                            class="text-xs font-black uppercase italic {{ $this->arenaIsSelected($arena) ? 'text-info-content' : 'text-info' }}">
                                                                            Arena
                                                                        </div>
                                                                        <div
                                                                            class="text-sm font-black italic uppercase">
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
                                                                <div wire:loading
                                                                    wire:target="selectArena('{{ $arena['id'] ?? '' }}','{{ $arena['nama_lapangan'] ?? 'Arena' }}')"
                                                                    class="mt-2">
                                                                    <span
                                                                        class="loading loading-dots loading-xs"></span>
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

                                <div class="mt-8 flex flex-col-reverse sm:flex-row justify-between gap-4">
                                    <button type="button" wire:click="prevStep"
                                        class="btn btn-ghost w-full sm:w-auto font-black uppercase">
                                        Kembali
                                    </button>
                                    <button type="button" wire:click="nextStep"
                                        class="btn btn-info w-full sm:w-auto -skew-x-12 italic font-black uppercase shadow-lg shadow-info/20">
                                        <span class="skew-x-12">Lanjut ke Form</span>
                                    </button>
                                </div>
                            </section>
                        @endif
                    </div>

                    <!-- Sidebar Summary Preview (Step 1 & 2) -->
                    <div class="lg:col-span-1 hidden lg:block opacity-60 pointer-events-none grayscale">
                        <div class="space-y-6">
                            <div class="bg-base-100 rounded-3xl border-2 border-base-200 overflow-hidden shadow-sm">
                                <div class="bg-info p-6">
                                    <h4 class="text-info-content font-black italic uppercase tracking-tighter text-xl">
                                        Booking Summary
                                    </h4>
                                </div>
                                <div class="p-6 space-y-4">
                                    <div
                                        class="flex justify-between items-center py-2 border-b border-base-200 border-dashed">
                                        <span class="text-xs font-bold uppercase text-base-content/50">Arena</span>
                                        <span class="font-black italic uppercase text-sm">
                                            <span wire:loading.remove wire:target="selectArena">
                                                {{ $namaLapangan ?: '-' }}
                                            </span>
                                            <span wire:loading wire:target="selectArena"
                                                class="loading loading-dots loading-xs"></span>
                                        </span>
                                    </div>
                                    <div
                                        class="flex justify-between items-center py-2 border-b border-base-200 border-dashed">
                                        <span class="text-xs font-bold uppercase text-base-content/50">Tanggal</span>
                                        <span class="font-black italic uppercase text-sm">
                                            <span wire:loading.remove wire:target="selectDate">
                                                {{ \Carbon\Carbon::parse($tanggal)->locale('id')->translatedFormat('l, d F Y') }}
                                            </span>
                                            <span class="loading loading-dots loading-xs" wire:loading
                                                wire:target="selectDate">
                                            </span>
                                        </span>
                                    </div>
                                    <div
                                        class="flex justify-between items-center py-2 border-b border-base-200 border-dashed">
                                        <span class="text-xs font-bold uppercase text-base-content/50">Jam</span>
                                        <span class="font-black italic uppercase text-sm">
                                            <span wire:loading.remove wire:target="selectTime">
                                                {{ $selectedSlot ? ($selectedSlot['mulai'] ?? '') . ' - ' . ($selectedSlot['selesai'] ?? '') : '-' }}
                                            </span>
                                            <span class="loading loading-dots loading-xs" wire:loading
                                                wire:target="selectTime"></span>
                                        </span>
                                    </div>

                                    <div class="pt-4">
                                        <div class="flex justify-between items-end">
                                            <span class="text-xs font-bold uppercase text-base-content/50">Total
                                                Biaya</span>
                                            <span
                                                class="text-2xl font-black italic text-info leading-none">GRATIS</span>
                                        </div>
                                    </div>

                                    <div class="mt-6 space-y-4">
                                        <div class="grid grid-cols-2 gap-3">
                                            <div>
                                                <label
                                                    class="text-[10px] font-bold uppercase text-base-content/50">Nama
                                                    Komunitas</label>
                                                <input type="text"
                                                    class="input input-bordered input-sm w-full mt-1 text-white focus-within:outline-none focus-within:ring-0 border-0 bg-base-200 placeholder:text-base-content/30"
                                                    placeholder="Nama tim (opsional)" wire:model="namaKomunitas">
                                                @error('namaKomunitas')
                                                    <p class="text-[10px] text-error mt-1 font-bold uppercase">
                                                        {{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div>
                                                <label
                                                    class="text-[10px] font-bold uppercase text-base-content/50">Jumlah
                                                    Pemain</label>
                                                <input type="number" min="1"
                                                    class="input input-bordered input-sm w-full mt-1 text-white focus-within:outline-none focus-within:ring-0 border-0 bg-base-200 placeholder:text-base-content/30"
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
                                                        class="input input-bordered input-sm w-full mt-1 text-left cursor-pointer text-white focus-within:outline-none focus-within:ring-0 border-0 bg-base-200">
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
                                                <label
                                                    class="text-[10px] font-bold uppercase text-base-content/50">Jenis
                                                    Permainan</label>
                                                <div x-data="{ open: false }" class="relative">
                                                    <button type="button" @click="open = !open"
                                                        class="input input-bordered input-sm w-full mt-1 text-left cursor-pointer text-white focus-within:outline-none focus-within:ring-0 border-0 bg-base-200">
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
                                            wire:target="confirmBooking" @disabled(($listJadwalStatus ?? '') === 'libur')
                                            aria-disabled="{{ ($listJadwalStatus ?? '') === 'libur' ? 'true' : 'false' }}">
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
                @endif

                @if ($currentStep === 3)
                    <div class="w-full max-w-xl mx-auto" x-data x-init="window.scrollTo({ top: 0, behavior: 'smooth' })">
                        <div class="flex justify-start mb-4">
                            <button type="button" wire:click="prevStep"
                                class="btn btn-ghost btn-sm font-black uppercase">
                                &larr; Kembali
                            </button>
                        </div>

                        <div class="space-y-6">
                            <div class="bg-base-100 rounded-3xl border-2 border-info overflow-hidden shadow-2xl">
                                <div class="bg-info p-6 flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-info-content/20 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="2" stroke="currentColor" class="size-6 text-info-content">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                                        </svg>
                                    </div>
                                    <h4 class="text-info-content font-black italic uppercase tracking-tighter text-xl">
                                        Booking Summary
                                    </h4>
                                </div>
                                <div class="p-6 space-y-4">
                                    <!-- Summary Info -->
                                    <div
                                        class="flex justify-between items-center py-2 border-b border-base-200 border-dashed">
                                        <span class="text-xs font-bold uppercase text-base-content/50">Arena</span>
                                        <span class="font-black italic uppercase text-sm">
                                            {{ $namaLapangan ?: '-' }}
                                        </span>
                                    </div>
                                    <div
                                        class="flex justify-between items-center py-2 border-b border-base-200 border-dashed">
                                        <span class="text-xs font-bold uppercase text-base-content/50">Tanggal</span>
                                        <span class="font-black italic uppercase text-sm">
                                            {{ \Carbon\Carbon::parse($tanggal)->locale('id')->translatedFormat('l, d F Y') }}
                                        </span>
                                    </div>
                                    <div
                                        class="flex justify-between items-center py-2 border-b border-base-200 border-dashed">
                                        <span class="text-xs font-bold uppercase text-base-content/50">Jam</span>
                                        <span class="font-black italic uppercase text-sm">
                                            {{ $selectedSlot ? ($selectedSlot['mulai'] ?? '') . ' - ' . ($selectedSlot['selesai'] ?? '') : '-' }}
                                        </span>
                                    </div>
                                    <div class="pt-4">
                                        <div class="flex justify-between items-end">
                                            <span class="text-xs font-bold uppercase text-base-content/50">Total
                                                Biaya</span>
                                            <span
                                                class="text-2xl font-black italic text-info leading-none">GRATIS</span>
                                        </div>
                                    </div>

                                    <!-- Form Inputs -->
                                    <div class="mt-8 pt-6 border-t border-base-200">
                                        <h5 class="text-sm font-black italic uppercase text-base-content/70 mb-4">
                                            Lengkapi Data Pemesanan</h5>
                                        <div class="grid grid-cols-2 gap-3">
                                            <div>
                                                <label
                                                    class="text-[10px] font-bold uppercase text-base-content/50">Nama
                                                    Komunitas</label>
                                                <input type="text"
                                                    class="input input-bordered input-sm w-full mt-1 text-white focus-within:outline-none focus-within:ring-0 border-0 bg-base-200 placeholder:text-base-content/30"
                                                    placeholder="Nama tim (opsional)" wire:model="namaKomunitas">
                                                @error('namaKomunitas')
                                                    <p class="text-[10px] text-error mt-1 font-bold uppercase">
                                                        {{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div>
                                                <label
                                                    class="text-[10px] font-bold uppercase text-base-content/50">Jumlah
                                                    Pemain</label>
                                                <input type="number" min="1"
                                                    class="input input-bordered input-sm w-full mt-1 text-white focus-within:outline-none focus-within:ring-0 border-0 bg-base-200 placeholder:text-base-content/30"
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
                                                <select wire:model.live="kategoriPemain"
                                                    class="select select-bordered select-sm w-full mt-1 bg-base-200 text-white font-bold uppercase text-[11px] focus:outline-none focus:ring-0 border-0">
                                                    <option value="">PILIH KATEGORI</option>
                                                    <option value="anak-anak">ANAK-ANAK</option>
                                                    <option value="remaja">REMAJA</option>
                                                    <option value="dewasa">DEWASA</option>
                                                </select>
                                                @error('kategoriPemain')
                                                    <p class="text-[10px] text-error mt-1 font-bold uppercase">
                                                        {{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div>
                                                <label
                                                    class="text-[10px] font-bold uppercase text-base-content/50">Jenis
                                                    Permainan</label>
                                                <select wire:model.live="jenisPermainan"
                                                    class="select select-bordered select-sm w-full mt-1 bg-base-200 text-white font-bold uppercase text-[11px] focus:outline-none focus:ring-0 border-0">
                                                    <option value="">PILIH JENIS</option>
                                                    <option value="fun_match">FUN MATCH</option>
                                                    <option value="latihan">LATIHAN</option>
                                                    <option value="turnamen_kecil">TURNAMEN KECIL</option>
                                                </select>
                                                @error('jenisPermainan')
                                                    <p class="text-[10px] text-error mt-1 font-bold uppercase">
                                                        {{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <button
                                            class="btn btn-info w-full mt-8 -skew-x-12 italic font-black uppercase text-sm sm:text-lg h-12 sm:h-14 shadow-lg shadow-info/20"
                                            x-on:click="window.__bookingSuppressScroll = true; window.__bookingNoScrollUntil = Date.now() + 3000;"
                                            wire:click="confirmBooking" wire:loading.attr="disabled"
                                            wire:target="confirmBooking" @disabled(($listJadwalStatus ?? '') === 'libur')
                                            aria-disabled="{{ ($listJadwalStatus ?? '') === 'libur' ? 'true' : 'false' }}">
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
                @endif
            </div>

            <div wire:loading wire:target="confirmBooking" class="fixed inset-0 z-50 bg-base-100/80 backdrop-blur-sm">
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
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="size-5 sm:size-6 text-warning-content">
                                        <path fill-rule="evenodd"
                                            d="M12 2.25c5.385 0 9.75 4.365 9.75 9.75s-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12 6.615 2.25 12 2.25ZM12 8.25a.75.75 0 0 1 .75.75v5.25a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <h4
                                        class="text-warning-content font-black italic uppercase tracking-tighter text-lg sm:text-xl">
                                        syarat dan ketentuan
                                    </h4>
                                    <div class="text-[9px] sm:text-[10px] font-bold uppercase text-warning-content/70">
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
                                        class="label-text text-xs sm:text-sm font-bold uppercase leading-snug text-base-content/60">Setuju
                                        dengan syarat dan
                                        ketentuan</span>
                                </label>
                            </div>
                            <div class="mt-2 grid grid-cols-1 sm:grid-cols-2 gap-2">
                                <button type="button" class="btn btn-ghost w-full"
                                    wire:click="$set('showTermsModal', false)">
                                    Tutup
                                </button>
                                <button type="button" class="btn btn-warning w-full" wire:click="finalizeBooking"
                                    wire:loading.attr="disabled" wire:target="finalizeBooking">
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
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="size-5 sm:size-6 text-info-content">
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
                                    <div class="text-[9px] sm:text-[10px] font-bold uppercase text-info-content/70">
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
                                    {{ $successNamaLapangan ?: '-' }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold uppercase text-base-content/50">Tanggal</span>
                                <span class="font-black italic uppercase text-sm">
                                    {{ $successTanggal ? \Carbon\Carbon::parse($successTanggal)->locale('id')->translatedFormat('l, d F Y') : '-' }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold uppercase text-base-content/50">
                                    Waktu
                                </span>
                                <span class="font-black italic uppercase text-sm">
                                    {{ $successSelectedSlot ? ($successSelectedSlot['mulai'] ?? '') . ' - ' . ($successSelectedSlot['selesai'] ?? '') : '-' }}
                                </span>
                            </div>

                            @if ($bookingCode)
                                <div
                                    class="mt-4 flex flex-col items-center justify-center p-4 bg-white rounded-xl shadow-inner border border-base-300">
                                    <!-- QR Code -->
                                    <div class="p-1 bg-white rounded-xl">
                                        <img src="data:image/png;base64,{{ DNS2D::getBarcodePNG($bookingCode, 'QRCODE', 4, 4) }}"
                                            alt="QR Code" class="w-24 h-24" style="image-rendering: pixelated;" />
                                    </div>
                                    <div class="mt-2 text-xs font-mono font-bold tracking-widest text-black">
                                        {{ $bookingCode }}
                                    </div>
                                </div>
                            @endif

                            <div class="pt-2 text-center">
                                <div class="text-[10px] font-bold uppercase text-base-content/50">
                                    {{ $bookingMessage }}
                                </div>
                            </div>
                            <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-2">
                                <a href="/booking-history" wire:navigate class="btn btn-ghost w-full">Tutup</a>
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
                        @if ($lapanganParam || $lapanganSlug)
                            <div class="w-full pb-6 px-2">
                                <div class="w-full p-4 rounded-2xl bg-base-100 border-2 border-base-300/30 shadow-lg">
                                    <div class="flex justify-between items-start">
                                        <div class="space-y-2">
                                            <div class="h-3 bg-base-300 w-12 rounded"></div>
                                            <div class="h-5 bg-base-300 w-40 rounded"></div>
                                        </div>
                                        <div class="h-4 bg-base-300 w-16 rounded"></div>
                                    </div>
                                </div>
                                <div class="bg-base-200/40 rounded-2xl p-4 border border-base-200/50 mt-4">
                                    <div class="grid grid-cols-3 lg:grid-cols-9 gap-2">
                                        @for ($j = 0; $j < 9; $j++)
                                            <div class="py-2 h-16 bg-base-300 rounded-lg"></div>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="w-full pb-6 px-2">
                                <div class="w-full p-4 rounded-2xl bg-base-100 border-2 border-base-300/30 shadow-lg">
                                    <div class="flex items-center justify-between">
                                        <div class="h-5 bg-base-300 w-24 rounded"></div>
                                        <div class="h-3 bg-base-300 w-16 rounded"></div>
                                    </div>
                                </div>
                                <div class="relative mt-4">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                        @for ($i = 0; $i < 6; $i++)
                                            <div class="p-4 rounded-xl border bg-base-100 border-base-300/30">
                                                <div class="flex items-center justify-between">
                                                    <div class="space-y-2">
                                                        <div class="h-3 bg-base-300 w-10 rounded"></div>
                                                        <div class="h-5 bg-base-300 w-32 rounded"></div>
                                                    </div>
                                                    <div class="h-3 bg-base-300 w-20 rounded"></div>
                                                </div>
                                            </div>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        @endif
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

@if ($showCancelConfirm)
    <div class="fixed inset-0 z-[9999] grid place-items-center p-4" wire:key="cancel-confirm-modal">
        <div class="absolute inset-0 bg-base-100/80 backdrop-blur-sm" wire:click="closeCancelConfirm"></div>
        <div
            class="relative w-full max-w-sm mx-4 rounded-2xl sm:rounded-3xl border-2 border-error bg-base-100 shadow-2xl overflow-hidden">
            <div class="bg-error p-4 sm:p-6 text-error-content">
                <div class="flex items-center gap-2 sm:gap-3">
                    <div
                        class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl bg-error-content/20 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="size-5 sm:size-6 text-error-content">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-black italic uppercase tracking-tighter text-lg sm:text-xl">
                            Batalkan Pesanan?
                        </h4>
                        <div class="text-[9px] sm:text-[10px] font-bold uppercase text-error-content/70">
                            Sesi Booking Akan Dihapus
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-4 sm:p-6 space-y-4">
                <p class="text-sm font-medium text-base-content/75 leading-relaxed">
                    Apakah Anda yakin ingin membatalkan pesanan? Seluruh data tanggal, arena, dan jam yang telah Anda
                    pilih akan disetel ulang (reset).
                </p>
                <div class="mt-4 grid grid-cols-2 gap-2">
                    <button type="button" class="btn btn-ghost w-full font-black uppercase text-xs"
                        wire:click="closeCancelConfirm">
                        Tidak
                    </button>
                    <button type="button" class="btn btn-error w-full font-black uppercase text-xs text-white"
                        wire:click="cancelBooking">
                        Ya, Batalkan
                    </button>
                </div>
            </div>
        </div>
    </div>
@endif
</div>
