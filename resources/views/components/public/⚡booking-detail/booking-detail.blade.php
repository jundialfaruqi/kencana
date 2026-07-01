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
                    <div style="-webkit-mask-image: radial-gradient(circle 10px at calc(100% - var(--cut-pos)) 0, transparent 10px, black 10.5px), radial-gradient(circle 10px at calc(100% - var(--cut-pos)) 100%, transparent 10px, black 10.5px); -webkit-mask-size: 100% 51%; -webkit-mask-position: top, bottom; -webkit-mask-repeat: no-repeat; mask-image: radial-gradient(circle 10px at calc(100% - var(--cut-pos)) 0, transparent 10px, black 10.5px), radial-gradient(circle 10px at calc(100% - var(--cut-pos)) 100%, transparent 10px, black 10.5px); mask-size: 100% 51%; mask-position: top, bottom; mask-repeat: no-repeat;"
                        class="w-full bg-base-100 rounded-2xl border-2 border-base-200 shadow-lg flex flex-row relative overflow-hidden [--cut-pos:6.75rem] sm:[--cut-pos:10.75rem]"
                        id="detail-card">
                        
                        <!-- Left Section -->
                        <div class="flex-1 p-3 sm:p-6 flex flex-col min-w-0">
                            <!-- Status & Header -->
                            <div class="flex items-center justify-between">
                                <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-[10px] sm:text-xs font-black uppercase tracking-wider {{ ($detail['status'] ?? '') === 'dipesan' ? 'bg-info/10 text-info' : (($detail['status'] ?? '') === 'dibatalkan' ? 'bg-error/10 text-error' : 'bg-success/10 text-success') }}">
                                    {{ data_get($detail, 'status') ?? '-' }}
                                </div>
                                <div class="text-[10px] sm:text-xs font-medium text-base-content/50 uppercase">
                                    {{ $dpFmt ?? (data_get($detail, 'dibuat_pada') ?? '-') }}
                                </div>
                            </div>
                            
                            <h4 class="text-base sm:text-3xl font-black italic uppercase text-base-content mt-3 sm:mt-4 leading-none">
                                {{ data_get($detail, 'lapangan.nama') ?? '-' }}
                            </h4>

                            <!-- Time Grid -->
                            <div class="mt-4 grid grid-cols-3 gap-2 sm:gap-4 items-start">
                                <div class="text-center">
                                    <div class="text-lg sm:text-3xl font-black tracking-tight text-warning">
                                        {{ $mulai ?? '-' }}</div>
                                    <div class="text-[9px] sm:text-[10px] font-bold uppercase text-base-content/60 mt-0.5 sm:mt-1">
                                        {{ $tglFmt ?? ($tgl ?? '-') }}</div>
                                </div>
                                <div class="flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 sm:w-6 sm:h-6 text-base-300">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                    </svg>
                                </div>
                                <div class="text-center">
                                    <div class="text-lg sm:text-3xl font-black tracking-tight text-warning">
                                        {{ $selesai ?? '-' }}</div>
                                    <div class="text-[9px] sm:text-[10px] font-bold uppercase text-base-content/60 mt-0.5 sm:mt-1">
                                        {{ $tglFmt ?? ($tgl ?? '-') }}</div>
                                </div>
                            </div>

                            <!-- Details Grid -->
                            <div class="mt-4">
                                <div class="text-[10px] font-bold uppercase text-base-content/50">Tim / Nama</div>
                                <div class="mt-1 flex flex-col">
                                    @php
                                        $sessionName = data_get(Session::get('user_data'), 'name');
                                        $apiTeam = data_get($detail, 'nama_komunitas') ?? data_get($detail, 'pemesan.nama_komunitas');
                                        $apiName = data_get($detail, 'user.name') ?? data_get($detail, 'pemesan.user.name');
                                        $pemesanNama = data_get($detail, 'pemesan.nama');

                                        $team = null;
                                        $name = null;

                                        if (filled($apiTeam)) {
                                            $team = $apiTeam;
                                        }
                                        if (filled($apiName)) {
                                            $name = $apiName;
                                        }

                                        if (filled($pemesanNama)) {
                                            if (filled($name)) {
                                                if (blank($team)) {
                                                    $team = $pemesanNama;
                                                }
                                            } else {
                                                if (filled($sessionName) && strcasecmp(trim((string)$pemesanNama), trim((string)$sessionName)) !== 0) {
                                                    $team = $pemesanNama;
                                                    $name = $sessionName;
                                                } else {
                                                    $name = $pemesanNama;
                                                }
                                            }
                                        }

                                        if (blank($name)) {
                                            $name = $sessionName;
                                        }
                                    @endphp
                                    <span class="font-black italic uppercase text-xs sm:text-sm text-warning">
                                        {{ $team ?: '-' }}
                                    </span>
                                    <span class="text-[10px] sm:text-xs text-base-content/60 font-semibold uppercase mt-0.5">
                                        {{ $name ?: '-' }}
                                    </span>
                                </div>
                                <div class="mt-3 grid grid-cols-3 gap-2 sm:gap-3">
                                    <div>
                                        <div class="text-[9px] sm:text-[10px] font-bold uppercase text-base-content/50">Pemain</div>
                                        <div class="mt-0.5 sm:mt-1 font-black italic uppercase text-xs sm:text-sm">
                                            {{ data_get($detail, 'pemesan.jumlah_pemain') ?? '-' }}</div>
                                    </div>
                                    <div>
                                        <div class="text-[9px] sm:text-[10px] font-bold uppercase text-base-content/50">Kategori</div>
                                        <div class="mt-0.5 sm:mt-1 font-black italic uppercase text-xs sm:text-sm">
                                            {{ data_get($detail, 'pemesan.kategori') ?? '-' }}</div>
                                    </div>
                                    <div>
                                        <div class="text-[9px] sm:text-[10px] font-bold uppercase text-base-content/50">Jenis</div>
                                        <div class="mt-0.5 sm:mt-1 font-black italic uppercase text-xs sm:text-sm">
                                            {{ $jenisAlias ?: '-' }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- No keterangan here, moved outside -->
                        </div>

                        <!-- Perforated Line -->
                        <div class="flex flex-col justify-center items-center relative w-6 shrink-0">
                            <div class="border-l-2 border-dashed border-base-300 w-px flex-grow my-4 sm:my-6"></div>
                        </div>

                        <!-- Right Section (ID) -->
                        <div class="w-24 sm:w-40 p-2 sm:p-4 shrink-0 flex flex-col justify-center items-center bg-base-100/50">
                            @if ($detail['kode_booking'] ?? $kode_booking)
                                <div class="p-1 sm:p-2 bg-white shadow-sm border border-base-200 mb-2 sm:mb-4">
                                    <img src="data:image/png;base64,{{ DNS2D::getBarcodePNG($detail['kode_booking'] ?? $kode_booking, 'QRCODE', 4, 4) }}"
                                        alt="QR Code" class="w-14 h-14 sm:w-28 sm:h-28" style="image-rendering: pixelated;" />
                                </div>
                            @endif
                            <div class="text-[8px] sm:text-xs font-medium uppercase tracking-widest text-base-content text-center">
                                {{ $detail['kode_booking'] ?? $kode_booking }}
                            </div>
                        </div>
                    </div>

                    @if (!empty(data_get($detail, 'keterangan')))
                        <div class="mt-4 rounded-2xl border-2 border-base-200 bg-base-100 shadow-sm p-4">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-warning">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                </svg>
                                <h4 class="text-xs sm:text-sm font-bold uppercase text-base-content/60">Catatan Booking</h4>
                            </div>
                            <div class="mt-2 text-sm italic font-medium text-base-content leading-relaxed">
                                "{{ data_get($detail, 'keterangan') }}"
                            </div>
                        </div>
                    @endif
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
                    <div style="-webkit-mask-image: radial-gradient(circle 10px at calc(100% - var(--cut-pos)) 0, transparent 10px, black 10.5px), radial-gradient(circle 10px at calc(100% - var(--cut-pos)) 100%, transparent 10px, black 10.5px); -webkit-mask-size: 100% 51%; -webkit-mask-position: top, bottom; -webkit-mask-repeat: no-repeat; mask-image: radial-gradient(circle 10px at calc(100% - var(--cut-pos)) 0, transparent 10px, black 10.5px), radial-gradient(circle 10px at calc(100% - var(--cut-pos)) 100%, transparent 10px, black 10.5px); mask-size: 100% 51%; mask-position: top, bottom; mask-repeat: no-repeat;"
                        class="w-full bg-base-200 rounded-2xl border-2 border-base-300/30 flex flex-row relative overflow-hidden [--cut-pos:6.75rem] sm:[--cut-pos:10.75rem]">
                        
                        <!-- Left Section -->
                        <div class="flex-1 p-3 sm:p-6 flex flex-col min-w-0">
                            <!-- Status & Header -->
                            <div class="flex items-center justify-between mb-3 sm:mb-4">
                                <div class="h-5 sm:h-8 w-20 sm:w-24 bg-base-300 rounded-xl"></div>
                                <div class="h-3 sm:h-4 w-16 sm:w-20 bg-base-300 rounded"></div>
                            </div>
                            
                            <div class="h-6 sm:h-10 w-40 sm:w-64 bg-base-300 rounded mt-3 sm:mt-4"></div>

                            <!-- Time Grid -->
                            <div class="mt-4 grid grid-cols-3 gap-2 sm:gap-4 items-center">
                                <div class="flex flex-col items-center">
                                    <div class="h-6 sm:h-10 w-16 sm:w-20 bg-base-300 rounded"></div>
                                    <div class="h-2 sm:h-3 w-12 sm:w-16 bg-base-300 rounded mt-1 sm:mt-2"></div>
                                </div>
                                <div class="flex justify-center">
                                    <div class="h-4 w-4 sm:h-6 sm:w-6 rounded-full bg-base-300"></div>
                                </div>
                                <div class="flex flex-col items-center">
                                    <div class="h-6 sm:h-10 w-16 sm:w-20 bg-base-300 rounded"></div>
                                    <div class="h-2 sm:h-3 w-12 sm:w-16 bg-base-300 rounded mt-1 sm:mt-2"></div>
                                </div>
                            </div>

                            <!-- Details Grid -->
                            <div class="mt-4">
                                <div class="h-2 sm:h-3 w-12 sm:w-16 bg-base-300 rounded"></div>
                                <div class="h-4 sm:h-5 w-24 sm:w-32 bg-base-300 rounded mt-1 sm:mt-2"></div>
                                <div class="h-2 sm:h-3 w-16 sm:w-24 bg-base-300 rounded mt-1"></div>
                                
                                <div class="mt-3 grid grid-cols-3 gap-2 sm:gap-3">
                                    <div>
                                        <div class="h-2 sm:h-3 w-10 sm:w-12 bg-base-300 rounded"></div>
                                        <div class="h-4 sm:h-5 w-12 sm:w-16 bg-base-300 rounded mt-1"></div>
                                    </div>
                                    <div>
                                        <div class="h-2 sm:h-3 w-10 sm:w-12 bg-base-300 rounded"></div>
                                        <div class="h-4 sm:h-5 w-16 sm:w-20 bg-base-300 rounded mt-1"></div>
                                    </div>
                                    <div>
                                        <div class="h-2 sm:h-3 w-10 sm:w-12 bg-base-300 rounded"></div>
                                        <div class="h-4 sm:h-5 w-20 sm:w-24 bg-base-300 rounded mt-1"></div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Perforated Line -->
                        <div class="flex flex-col justify-center items-center relative w-6 shrink-0">
                            <div class="border-l-2 border-dashed border-base-300/50 w-px flex-grow my-4 sm:my-6"></div>
                        </div>

                        <!-- Right Section -->
                        <div class="w-24 sm:w-40 p-2 sm:p-4 shrink-0 flex flex-col justify-center items-center bg-base-300/30">
                            <div class="w-14 h-14 sm:w-28 sm:h-28 bg-base-300 rounded-xl mb-2 sm:mb-4"></div>
                            <div class="w-16 sm:w-28 h-3 sm:h-5 bg-base-300 rounded"></div>
                        </div>
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
