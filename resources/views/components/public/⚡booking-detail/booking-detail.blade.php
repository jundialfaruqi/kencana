<div class="mt-4 sm:mt-8" wire:init="load">
    @if ($ready)
        <div class="w-full" x-transition>
            <div class="mb-8 px-2 flex items-center gap-4">
                <a href="/booking-history" wire:navigate
                    class="btn btn-circle btn-ghost btn-sm sm:btn-md border-2 border-base-300 hover:border-info hover:text-info transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                        stroke="currentColor" class="size-5 sm:size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                </a>
                <div>
                    <h2 class="text-xl sm:text-2xl font-black italic uppercase tracking-tighter text-base-content">
                        Detail <span class="text-info">Booking</span>
                    </h2>
                    <p
                        class="text-[10px] sm:text-xs font-medium text-base-content/60 uppercase tracking-widest mt-0.5 sm:mt-1">
                        Informasi booking
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <div class="boarding-pass border-2 border-base-200 border-dashed bg-base-100 rounded-2xl overflow-hidden shadow-lg"
                        id="detail-card">
                        <div class="bp-header bg-info text-warning-content px-4 py-3 sm:px-6 sm:py-4">
                            <div class="flex items-center justify-between">
                                <div class="text-[10px] font-bold uppercase opacity-80">Kode Booking</div>
                                <div class="text-[10px] font-bold uppercase opacity-80">
                                    {{ data_get($detail, 'status') ?? '-' }}</div>
                            </div>
                            <div class="text-2xl sm:text-3xl font-black italic uppercase tracking-widest">
                                {{ $detail['kode_booking'] ?? $kode_booking }}
                            </div>
                        </div>
                        <div class="bp-body p-4 sm:p-6">
                            <div class="flex items-center justify-between">
                                <h4 class="text-base sm:text-lg font-black italic uppercase">
                                    {{ data_get($detail, 'lapangan.nama') ?? '-' }}</h4>
                            </div>
                            <div class="mt-4 grid grid-cols-3 gap-4 items-start">
                                <div>
                                    <div class="text-2xl sm:text-3xl font-black tracking-tight text-warning">
                                        {{ $mulai ?? '-' }}</div>
                                    <div class="text-[10px] font-bold uppercase text-base-content/60 mt-1">
                                        {{ $tglFmt ?? ($tgl ?? '-') }}</div>
                                </div>
                                <div class="flex items-center justify-center">
                                    <div class="h-8 sm:h-10 border-l-2 border-dashed border-base-300"></div>
                                </div>
                                <div class="text-right">
                                    <div class="text-2xl sm:text-3xl font-black tracking-tight text-warning">
                                        {{ $selesai ?? '-' }}</div>
                                    <div class="text-[10px] font-bold uppercase text-base-content/60 mt-1">
                                        {{ $tglFmt ?? ($tgl ?? '-') }}</div>
                                </div>
                            </div>
                            <div class="bp-divider my-4"></div>
                            <div class="grid grid-cols-3 gap-2">
                                <div class="col-span-2">
                                    <div class="text-[10px] font-bold uppercase text-base-content/50">Tim / Nama</div>
                                    <div class="mt-1 font-black italic uppercase">
                                        {{ data_get($detail, 'pemesan.nama') ?? '-' }}
                                    </div>
                                    <div class="mt-3 grid grid-cols-3 gap-3">
                                        <div>
                                            <div class="text-[10px] font-bold uppercase text-base-content/50">Pemain
                                            </div>
                                            <div class="mt-1 font-black italic uppercase text-sm">
                                                {{ data_get($detail, 'pemesan.jumlah_pemain') ?? '-' }}</div>
                                        </div>
                                        <div>
                                            <div class="text-[10px] font-bold uppercase text-base-content/50">Kategori
                                            </div>
                                            <div class="mt-1 font-black italic uppercase text-sm">
                                                {{ data_get($detail, 'pemesan.kategori') ?? '-' }}</div>
                                        </div>
                                        <div>
                                            <div class="text-[10px] font-bold uppercase text-base-content/50">Jenis
                                            </div>
                                            <div class="mt-1 font-black italic uppercase text-sm">
                                                {{ $jenisAlias ?: '-' }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-span-1 flex items-center justify-center">
                                    <div
                                        class="relative w-12 h-12 sm:w-23 sm:h-23 rounded-full bg-info/10 flex items-center justify-center">

                                        <!-- LOGO -->
                                        <img src="{{ asset('assets/images/logo/amanarena-logo.webp') }}"
                                            alt="Logo Aman Arena"
                                            class="w-full h-full object-contain p-1.5 sm:p-3 opacity-20 grayscale" />

                                        <!-- OVERLAY VERIFIED (1 BARIS) -->
                                        <div class="absolute flex items-center justify-between">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="2" stroke="currentColor"
                                                class="size-4 sm:size-7 text-white">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                                            </svg>
                                            <div
                                                class="text-info font-black uppercase italic tracking-widest text-[10px] sm:text-[20px] text-center leading-none shadow-md">
                                                Verified
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bp-divider my-4"></div>
                            <div class="grid grid-cols-3 gap-3">
                                <div>
                                    <div class="text-[10px] font-bold uppercase text-base-content/50">Dibuat</div>
                                    <div class="mt-1 text-xs">
                                        {{ $dpFmt ?? (data_get($detail, 'dibuat_pada') ?? '-') }}
                                    </div>
                                </div>
                                <div>
                                    <div class="text-[10px] font-bold uppercase text-base-content/50">Status</div>
                                    <div
                                        class="mt-1 text-xs font-black italic uppercase {{ (data_get($detail, 'status') ?? '') === 'dipesan' ? 'text-info' : 'text-warning' }}">
                                        {{ data_get($detail, 'status') ?? '-' }}
                                    </div>
                                </div>
                                <div>
                                    <div class="text-[10px] font-bold uppercase text-base-content/50">Kode</div>
                                    <div class="mt-1 text-xs font-black italic uppercase">
                                        {{ $detail['kode_booking'] ?? $kode_booking }}</div>
                                </div>
                            </div>
                            <div class="mt-4 rounded-xl bg-base-200 border border-dashed border-base-300 p-3">
                                <div class="text-[10px] font-bold uppercase text-base-content/50">Keterangan</div>
                                <div class="mt-1 text-sm italic">{{ data_get($detail, 'keterangan') ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="bp-footer bg-info text-info-content px-4 py-3 sm:px-6">
                            <div class="text-center text-[10px] sm:text-xs font-black italic uppercase tracking-widest">
                                {{ data_get($detail, 'lapangan.nama') ?? '-' }}
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="rounded-2xl border-2 border-base-200 bg-base-100 shadow-lg p-4 sm:p-6">
                        <div class="flex items-center gap-2 sm:gap-3">
                            <div>
                                <h4 class="text-error font-black italic uppercase tracking-tighter text-lg sm:text-xl">
                                    Syarat dan Ketentuan
                                </h4>
                                <div class="text-[9px] sm:text-[10px] font-bold uppercase text-base-content/60">
                                    Mohon Dibaca dan Dipahami Bersama
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 space-y-2">
                            @if (!empty($catatan))
                                @foreach ($catatan as $cat)
                                    <div class="text-[13px] font-bold uppercase text-base-content/60">
                                        {{ $cat['kategori_catatan'] ?? '-' }}
                                    </div>
                                    <ul class="space-y-2 mt-2">
                                        @foreach ((array) ($cat['items'] ?? []) as $ci)
                                            <li class="flex items-center">
                                                <span class="flex-none w-6 text-xs font-bold">
                                                    {{ intval($ci['urutan'] ?? 0) }}.
                                                </span>
                                                <span class="text-xs sm:text-sm leading-relaxed">
                                                    {{ $ci['catatan'] ?? '-' }}
                                                </span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endforeach
                            @else
                                <div class="text-xs text-base-content/60">Catatan belum tersedia.</div>
                            @endif
                        </div>
                        <div class="mt-4">
                        </div>
                        <div class="mt-4">
                            <button class="btn btn-error w-full" wire:click="openCancelConfirm"
                                wire:loading.attr="disabled" @disabled((data_get($detail, 'status') ?? '') !== 'dipesan')>
                                <span>Batalkan Booking</span>
                                <span class="loading loading-dots loading-xs ml-2" wire:loading
                                    wire:target="cancelBooking">
                                </span>
                            </button>
                            @if ($cancelMessage)
                                <div class="alert alert-success mt-3"><span>{{ $cancelMessage }}</span></div>
                            @endif
                            @if ($cancelError)
                                <div class="alert alert-error mt-3"><span>{{ $cancelError }}</span></div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            @if ($showCancelConfirm)
                <div class="fixed inset-0 z-50 grid place-items-center p-4">
                    <div class="absolute inset-0 bg-base-100/80 backdrop-blur-sm"></div>
                    <div
                        class="relative w-full max-w-sm sm:max-w-md mx-4 sm:mx-0 rounded-2xl sm:rounded-3xl border-2 border-error bg-base-100 shadow-2xl overflow-hidden">
                        <div class="bg-error p-4 sm:p-6">
                            <div class="flex items-center gap-2 sm:gap-3">
                                <div
                                    class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl bg-error/20 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="size-5 sm:size-6 text-error-content">
                                        <path fill-rule="evenodd"
                                            d="M12 2.25c5.385 0 9.75 4.365 9.75 9.75s-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12 6.615 2.25 12 2.25ZM12 8.25a.75.75 0 0 1 .75.75v5.25a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <h4
                                        class="text-error-content font-black italic uppercase tracking-tighter text-lg sm:text-xl">
                                        Konfirmasi Batalkan Booking
                                    </h4>
                                    <div class="text-[9px] sm:text-[10px] font-bold uppercase text-error-content/70">
                                        Pastikan Anda telah membaca syarat dan ketentuan
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 sm:p-6 space-y-3 sm:space-y-4">
                            <div class="text-sm font-bold uppercase text-base-content/60">
                                Tindakan ini akan membatalkan booking Anda.
                            </div>
                            <div class="mt-2 grid grid-cols-1 sm:grid-cols-2 gap-2">
                                <button type="button" class="btn btn-ghost w-full"
                                    wire:click="$set('showCancelConfirm', false)">
                                    Tutup
                                </button>
                                <button type="button" class="btn btn-error w-full" wire:click="cancelBooking"
                                    wire:loading.attr="disabled" wire:target="cancelBooking">
                                    Ya, Batalkan Booking
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div wire:loading wire:target="cancelBooking" class="fixed inset-0 z-50 bg-base-100/80 backdrop-blur-sm">
                <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 text-center">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-info/10">
                        <span class="loading loading-dots loading-lg text-info"></span>
                    </div>
                    <div class="mt-4 text-sm font-black uppercase italic tracking-widest text-base-content/70">
                        Membatalkan Booking...
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="w-full animate-pulse">
            <div class="mb-8 px-2 flex items-center gap-4">
                <div class="size-8 sm:size-12 rounded-full bg-base-300"></div>
                <div>
                    <div class="h-6 sm:h-8 bg-base-300 w-48 sm:w-64 rounded-lg"></div>
                    <div class="h-3 sm:h-4 bg-base-300 w-32 sm:w-48 mt-2 rounded-lg"></div>
                </div>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <div
                        class="boarding-pass border-2 border-base-200 border-dashed bg-base-100 rounded-2xl overflow-hidden shadow-lg">
                        <div class="bp-header px-4 py-3 sm:px-6 sm:py-4">
                            <div class="flex items-center justify-between">
                                <div class="h-3 w-24 bg-base-300 rounded"></div>
                                <div class="h-3 w-20 bg-base-300 rounded"></div>
                            </div>
                            <div class="h-7 sm:h-9 w-44 sm:w-60 bg-base-300 rounded mt-2"></div>
                        </div>
                        <div class="bp-body p-4 sm:p-6">
                            <div class="h-4 w-40 bg-base-300 rounded"></div>
                            <div class="mt-4 grid grid-cols-3 gap-4 items-start">
                                <div>
                                    <div class="h-8 sm:h-10 w-24 sm:w-32 bg-base-300 rounded"></div>
                                    <div class="h-3 w-28 bg-base-300 rounded mt-2"></div>
                                </div>
                                <div class="flex items-center justify-center">
                                    <div class="h-8 sm:h-10 border-l-2 border-dashed border-base-300"></div>
                                </div>
                                <div class="text-right">
                                    <div class="h-8 sm:h-10 w-24 sm:w-32 bg-base-300 rounded ml-auto"></div>
                                    <div class="h-3 w-28 bg-base-300 rounded mt-2 ml-auto"></div>
                                </div>
                            </div>
                            <div class="bp-divider my-4"></div>
                            <div class="grid grid-cols-3 gap-4">
                                <div class="col-span-2">
                                    <div class="h-3 w-20 bg-base-300 rounded"></div>
                                    <div class="h-4 w-36 bg-base-300 rounded mt-1"></div>
                                    <div class="mt-3 grid grid-cols-3 gap-3">
                                        <div>
                                            <div class="h-3 w-16 bg-base-300 rounded"></div>
                                            <div class="h-4 w-20 bg-base-300 rounded mt-1"></div>
                                        </div>
                                        <div>
                                            <div class="h-3 w-16 bg-base-300 rounded"></div>
                                            <div class="h-4 w-20 bg-base-300 rounded mt-1"></div>
                                        </div>
                                        <div>
                                            <div class="h-3 w-12 bg-base-300 rounded"></div>
                                            <div class="h-4 w-20 bg-base-300 rounded mt-1"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-span-1 flex items-center justify-center">
                                    <div
                                        class="w-15 h-15 sm:w-28 sm:h-28 rounded-full border-2 border-base-300 overflow-hidden flex items-center justify-end bg-base-100">
                                        <div class="w-full h-full bg-base-300"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="bp-divider my-4"></div>
                            <div class="grid grid-cols-3 gap-3">
                                <div>
                                    <div class="h-3 w-16 bg-base-300 rounded"></div>
                                    <div class="h-3 w-24 bg-base-300 rounded mt-1"></div>
                                </div>
                                <div>
                                    <div class="h-3 w-16 bg-base-300 rounded"></div>
                                    <div class="h-3 w-20 bg-base-300 rounded mt-1"></div>
                                </div>
                                <div>
                                    <div class="h-3 w-16 bg-base-300 rounded"></div>
                                    <div class="h-3 w-20 bg-base-300 rounded mt-1"></div>
                                </div>
                            </div>
                            <div class="mt-4 rounded-xl border border-dashed border-base-300 p-3">
                                <div class="h-3 w-20 bg-base-300 rounded"></div>
                                <div class="h-4 w-full bg-base-300 rounded mt-2"></div>
                            </div>
                        </div>
                        <div class="bp-footer px-4 py-3 sm:px-6"></div>
                    </div>
                </div>
                <div>
                    <div class="rounded-2xl border-2 border-base-200 bg-base-100 shadow-lg p-4 sm:p-6">
                        <div class="flex items-center gap-2 sm:gap-3">
                            <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-3xl bg-base-300"></div>
                            <div>
                                <div class="h-5 sm:h-6 w-40 sm:w-52 bg-base-300 rounded"></div>
                                <div class="h-3 w-32 bg-base-300 rounded mt-1"></div>
                            </div>
                        </div>
                        <div class="mt-4 space-y-2">
                            <ul class="space-y-2">
                                <li>
                                    <div class="h-4 w-full bg-base-300 rounded"></div>
                                </li>
                                <li>
                                    <div class="h-4 w-full bg-base-300 rounded"></div>
                                </li>
                                <li>
                                    <div class="h-4 w-full bg-base-300 rounded"></div>
                                </li>
                                <li>
                                    <div class="h-4 w-full bg-base-300 rounded"></div>
                                </li>
                                <li>
                                    <div class="h-4 w-full bg-base-300 rounded"></div>
                                </li>
                                <li>
                                    <div class="h-4 w-full bg-base-300 rounded"></div>
                                </li>
                                <li>
                                    <div class="h-4 w-full bg-base-300 rounded"></div>
                                </li>
                            </ul>
                        </div>
                        <div class="mt-4">
                            <div class="h-10 w-full bg-base-300 rounded"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
