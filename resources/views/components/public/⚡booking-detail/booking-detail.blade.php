<div class="mt-4 sm:mt-8">
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

            <style>
                .detail-ticket-mask {
                    mask-image: radial-gradient(circle 10px at 0 calc(100% - var(--cut-pos)), transparent 10px, black 10.5px),
                                radial-gradient(circle 10px at 100% calc(100% - var(--cut-pos)), transparent 10px, black 10.5px);
                    mask-size: 51% 100%;
                    mask-position: left, right;
                    mask-repeat: no-repeat;
                    -webkit-mask-image: radial-gradient(circle 10px at 0 calc(100% - var(--cut-pos)), transparent 10px, black 10.5px),
                                        radial-gradient(circle 10px at 100% calc(100% - var(--cut-pos)), transparent 10px, black 10.5px);
                    -webkit-mask-size: 51% 100%;
                    -webkit-mask-position: left, right;
                    -webkit-mask-repeat: no-repeat;
                }
                @media (min-width: 640px) {
                    .detail-ticket-mask {
                        mask-image: radial-gradient(circle 10px at calc(100% - var(--cut-pos)) 0, transparent 10px, black 10.5px),
                                    radial-gradient(circle 10px at calc(100% - var(--cut-pos)) 100%, transparent 10px, black 10.5px);
                        mask-size: 100% 51%;
                        mask-position: top, bottom;
                        -webkit-mask-image: radial-gradient(circle 10px at calc(100% - var(--cut-pos)) 0, transparent 10px, black 10.5px),
                                            radial-gradient(circle 10px at calc(100% - var(--cut-pos)) 100%, transparent 10px, black 10.5px);
                        -webkit-mask-size: 100% 51%;
                        -webkit-mask-position: top, bottom;
                    }
                }
            </style>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <div class="w-full bg-base-100 rounded-2xl border-2 border-base-200 shadow-lg flex flex-col sm:flex-row relative overflow-hidden detail-ticket-mask [--cut-pos:14.25rem] sm:[--cut-pos:10.75rem]"
                        id="detail-card">
                        
                        <!-- Left Section (Main Details) -->
                        <div class="flex-1 p-4 sm:p-6 flex flex-col justify-between min-w-0">
                            <!-- Header -->
                            <div class="flex flex-row justify-between items-center mb-2 sm:mb-4 gap-2">
                                <!-- Status Badge -->
                                <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-[10px] sm:text-xs font-black uppercase tracking-wider {{ ($detail['status'] ?? '') === 'dipesan' ? 'bg-info/10 text-info' : (($detail['status'] ?? '') === 'dibatalkan' ? 'bg-error/10 text-error' : 'bg-success/10 text-success') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-13a.75.75 0 00-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 000-1.5h-3.25V5z" clip-rule="evenodd" />
                                    </svg>
                                    {{ data_get($detail, 'status') ?? '-' }}
                                </div>

                                <!-- Created Date -->
                                <span class="text-[10px] sm:text-xs font-medium text-base-content/50">
                                    {{ $dpFmt ?? (data_get($detail, 'dibuat_pada') ?? '-') }}
                                </span>
                            </div>

                            <!-- Title -->
                            <h4 class="text-sm sm:text-xl font-extrabold text-base-content mb-4 sm:mb-6 leading-tight truncate">
                                {{ data_get($detail, 'lapangan.nama') ?? '-' }}
                            </h4>

                            <!-- Details Grid -->
                            <div class="grid grid-cols-2 gap-y-3 gap-x-3 sm:gap-y-4 sm:gap-x-4">
                                <!-- Date -->
                                <div>
                                    <div class="text-[9px] sm:text-[10px] font-bold uppercase text-base-content/50 mb-1 sm:mb-1.5">Tanggal</div>
                                    <div class="flex items-center gap-1.5 sm:gap-2 text-base-content/70">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 sm:w-5 sm:h-5 opacity-70">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                        </svg>
                                        <span class="text-xs sm:text-sm font-medium leading-none">{{ $tglFmt ?? ($tgl ?? '-') }}</span>
                                    </div>
                                </div>

                                <!-- Time -->
                                <div>
                                    <div class="text-[9px] sm:text-[10px] font-bold uppercase text-base-content/50 mb-1 sm:mb-1.5">Jam</div>
                                    <div class="flex items-center gap-1.5 sm:gap-2 text-base-content/70">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 sm:w-5 sm:h-5 opacity-70">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="text-xs sm:text-sm font-medium leading-none">{{ $mulai ?? '-' }} - {{ $selesai ?? '-' }}</span>
                                    </div>
                                </div>

                                <!-- Tim/Nama -->
                                <div class="col-span-2">
                                    <div class="text-[9px] sm:text-[10px] font-bold uppercase text-base-content/50 mb-1 sm:mb-1.5">Tim / Pemesan</div>
                                    <div class="flex items-center gap-1.5 sm:gap-2 text-base-content/70">
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
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 sm:w-5 sm:h-5 opacity-70">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                        </svg>
                                        <span class="text-xs sm:text-sm font-medium uppercase leading-none">{{ $team ?: '-' }} <span class="text-[10px] sm:text-xs font-normal opacity-80 capitalize">({{ $name ?: '-' }})</span></span>
                                    </div>
                                </div>

                                <!-- 3-Column Info -->
                                <div class="col-span-2 grid grid-cols-3 gap-2 sm:gap-4">
                                    <!-- Pemain -->
                                    <div>
                                        <div class="text-[9px] sm:text-[10px] font-bold uppercase text-base-content/50 mb-1 sm:mb-1.5">Pemain</div>
                                        <div class="flex items-center gap-1.5 sm:gap-2 text-base-content/70">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 sm:w-5 sm:h-5 opacity-70">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                            </svg>
                                            <span class="text-[10px] sm:text-sm font-medium leading-none">{{ data_get($detail, 'pemesan.jumlah_pemain') ?? '-' }}</span>
                                        </div>
                                    </div>

                                    <!-- Kategori -->
                                    <div>
                                        <div class="text-[9px] sm:text-[10px] font-bold uppercase text-base-content/50 mb-1 sm:mb-1.5">Kategori</div>
                                        <div class="flex items-center gap-1.5 sm:gap-2 text-base-content/70">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 sm:w-5 sm:h-5 opacity-70">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                                            </svg>
                                            <span class="text-[10px] sm:text-sm font-medium capitalize leading-none">{{ strtolower(data_get($detail, 'pemesan.kategori') ?? '-') }}</span>
                                        </div>
                                    </div>

                                    <!-- Jenis -->
                                    <div>
                                        <div class="text-[9px] sm:text-[10px] font-bold uppercase text-base-content/50 mb-1 sm:mb-1.5">Jenis</div>
                                        <div class="flex items-center gap-1.5 sm:gap-2 text-base-content/70">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 sm:w-5 sm:h-5 opacity-70">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                                            </svg>
                                            <span class="text-[10px] sm:text-sm font-medium capitalize leading-none">{{ strtolower($jenisAlias ?: '-') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- No keterangan here, moved outside -->
                        </div>

                        <!-- Perforated Line -->
                        <div class="flex sm:flex-col justify-center items-center relative h-6 sm:h-auto w-full sm:w-6 shrink-0">
                            <div class="border-t-2 sm:border-t-0 sm:border-l-2 border-dashed border-base-300 h-px sm:h-auto w-full sm:w-px flex-grow mx-4 my-2 sm:mx-0 sm:my-6"></div>
                        </div>

                        <!-- Right Section (ID) -->
                        <div class="w-full sm:w-40 h-[13.5rem] sm:h-auto p-4 sm:p-4 shrink-0 flex flex-col justify-center items-center bg-base-100/50">
                            @if ($detail['kode_booking'] ?? $kode_booking)
                                <div class="p-2 sm:p-2 bg-white shadow-sm border border-base-200 mb-2 sm:mb-4">
                                    <img src="data:image/png;base64,{{ DNS2D::getBarcodePNG($detail['kode_booking'] ?? $kode_booking, 'QRCODE', 4, 4) }}"
                                        alt="QR Code" class="w-36 h-36 sm:w-28 sm:h-28" style="image-rendering: pixelated;" />
                                </div>
                            @endif
                            <div class="text-[10px] sm:text-xs font-medium uppercase tracking-widest text-base-content text-center">
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
        </div>
</div>
