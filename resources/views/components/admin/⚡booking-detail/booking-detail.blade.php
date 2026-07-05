<div>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold">Booking Detail</h1>
            <p class="text-sm text-base-content/60 mt-1">Informasi detail booking</p>
        </div>
        <div>
            <a wire:navigate href="/booking-master" class="text-sm text-base-content/60">
                <span class="inline-flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                    </svg>
                    <span>Kembali</span>
                </span>
            </a>
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

    <div class="w-full max-w-4xl mx-auto">
        @if ($error)
            <div class="alert alert-error mb-4">
                <span>{{ $error }}</span>
            </div>
        @else
            <div class="w-full bg-base-100 rounded-3xl border border-base-300 shadow-xl flex flex-col sm:flex-row relative overflow-hidden detail-ticket-mask [--cut-pos:14.25rem] sm:[--cut-pos:12.75rem]"
                id="detail-card">

                <!-- Left Section (Main Details) -->
                <div class="flex-1 p-6 sm:p-8 flex flex-col justify-between min-w-0">
                    <!-- Header Row -->
                    <div class="flex flex-row justify-between items-center mb-4 gap-2 border-b border-base-200 pb-4">
                        <!-- Status Badge -->
                        <div class="uppercase tracking-widest italic font-black text-xs">
                            @php $st = data_get($detail, 'status'); @endphp
                            @if ($st === 'dipesan')
                                <span
                                    class="badge badge-info text-white rounded-md uppercase italic font-bold text-[10px] px-2.5 py-1 -skew-x-12">Dipesan</span>
                            @elseif ($st === 'dibatalkan')
                                <span
                                    class="badge badge-error text-white rounded-md uppercase italic font-bold text-[10px] px-2.5 py-1 -skew-x-12">Dibatalkan</span>
                            @elseif ($st === 'selesai')
                                <span
                                    class="badge badge-success text-white rounded-md uppercase italic font-bold text-[10px] px-2.5 py-1 -skew-x-12">Selesai</span>
                            @else
                                <span
                                    class="badge badge-neutral text-white rounded-md uppercase italic font-bold text-[10px] px-2.5 py-1 -skew-x-12">{{ strtoupper($st ?? '-') }}</span>
                            @endif
                        </div>

                        <!-- Created Date -->
                        <span
                            class="text-[10px] sm:text-xs font-semibold text-base-content/60 uppercase tracking-wider">
                            Dibuat: {{ data_get($detail, 'dibuat_pada', '-') }}
                        </span>
                    </div>

                    <!-- Title -->
                    <h4 class="text-lg sm:text-2xl font-black uppercase text-base-content mb-6 leading-tight">
                        {{ data_get($detail, 'lapangan.nama') ?? '-' }}
                    </h4>

                    <!-- Details Grid -->
                    <div class="grid grid-cols-2 gap-y-4 gap-x-4">
                        <!-- Date -->
                        <div>
                            <div
                                class="text-[9px] sm:text-[10px] font-bold text-base-content/50 uppercase tracking-widest mb-1">
                                Tanggal
                            </div>
                            <div class="flex items-center gap-2 text-base-content">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor"
                                    class="w-4 h-4 sm:w-5 sm:h-5 text-base-content/60 shrink-0">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                </svg>
                                <span class="text-xs sm:text-sm font-bold uppercase">
                                    {{ data_get($detail, 'tanggal', '-') }}
                                </span>
                            </div>
                        </div>

                        <!-- Time & Durasi -->
                        <div>
                            <div
                                class="text-[9px] sm:text-[10px] font-bold uppercase text-base-content/50 tracking-widest mb-1">
                                Jam / Durasi
                            </div>
                            <div class="flex items-center gap-2 text-base-content">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor"
                                    class="w-4 h-4 sm:w-5 sm:h-5 text-base-content/60 shrink-0">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-xs sm:text-sm font-bold font-mono">
                                    {{ $jamFmt ? \Illuminate\Support\Str::of($jamFmt)->replace(' ', ' - ') : '-' }}
                                    <span class="text-[10px] font-semibold text-base-content/60 normal-case">
                                        ({{ data_get($detail, 'durasi_menit', '-') }} Menit)
                                    </span>
                                </span>
                            </div>
                        </div>

                        @php
                            $team = data_get($detail, 'detail.nama_komunitas') ?? data_get($detail, 'nama_komunitas') ?? data_get($detail, 'pemesan.nama_komunitas');
                            $name = data_get($detail, 'user.name') ?? data_get($detail, 'pemesan.user.name') ?? data_get($detail, 'pemesan.nama');
                        @endphp

                        <!-- Details List (Tim, Pemesan, Email, Pemain, Kategori, Jenis) -->
                        <div class="col-span-2 mt-4 space-y-2.5">
                            <!-- Tim -->
                            <div class="flex items-end justify-between w-full">
                                <span class="font-semibold text-[11px] uppercase tracking-wide text-base-content/50 shrink-0">Tim</span>
                                <div class="grow border-b border-dashed border-base-content/20 mx-2 mb-1"></div>
                                <span class="text-xs font-bold text-warning uppercase shrink-0 text-right">{{ $team ?: '-' }}</span>
                            </div>

                            <!-- Pemesan -->
                            <div class="flex items-end justify-between w-full">
                                <span class="font-semibold text-[11px] uppercase tracking-wide text-base-content/50 shrink-0">Pemesan</span>
                                <div class="grow border-b border-dashed border-base-content/20 mx-2 mb-1"></div>
                                <span class="text-xs font-bold text-base-content/85 uppercase shrink-0 text-right">{{ $name ?: '-' }}</span>
                            </div>

                            <!-- Email -->
                            <div class="flex items-end justify-between w-full">
                                <span class="font-semibold text-[11px] uppercase tracking-wide text-base-content/50 shrink-0">Email</span>
                                <div class="grow border-b border-dashed border-base-content/20 mx-2 mb-1"></div>
                                <span class="text-xs font-mono font-bold text-base-content/65 shrink-0 text-right">{{ data_get($detail, 'pemesan.email', '-') }}</span>
                            </div>

                            <!-- Pemain -->
                            <div class="flex items-end justify-between w-full">
                                <span class="font-semibold text-[11px] uppercase tracking-wide text-base-content/50 shrink-0">Pemain</span>
                                <div class="grow border-b border-dashed border-base-content/20 mx-2 mb-1"></div>
                                <span class="text-xs font-bold shrink-0 text-right font-mono">{{ data_get($detail, 'detail.jumlah_pemain', '-') }}</span>
                            </div>

                            <!-- Kategori -->
                            <div class="flex items-end justify-between w-full">
                                <span class="font-semibold text-[11px] uppercase tracking-wide text-base-content/50 shrink-0">Kategori</span>
                                <div class="grow border-b border-dashed border-base-content/20 mx-2 mb-1"></div>
                                <span class="text-xs font-bold shrink-0 text-right uppercase">{{ data_get($detail, 'detail.kategori', '-') }}</span>
                            </div>

                            <!-- Jenis -->
                            <div class="flex items-end justify-between w-full">
                                <span class="font-semibold text-[11px] uppercase tracking-wide text-base-content/50 shrink-0">Jenis</span>
                                <div class="grow border-b border-dashed border-base-content/20 mx-2 mb-1"></div>
                                <span class="text-xs font-bold shrink-0 text-right uppercase">{{ data_get($detail, 'detail.jenis', '-') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Perforated Line -->
                <div
                    class="flex sm:flex-col justify-center items-center relative h-6 sm:h-auto w-full sm:w-6 shrink-0 bg-base-100">
                    <div
                        class="border-t-2 sm:border-t-0 sm:border-l-2 border-dashed border-base-300 h-px sm:h-auto w-full sm:w-px grow mx-4 my-2 sm:mx-0 sm:my-6">
                    </div>
                </div>

                <!-- Right Section (ID / Barcode) -->
                <div
                    class="w-full sm:w-48 h-54 sm:h-auto p-6 shrink-0 flex flex-col justify-center items-center bg-base-100">
                    @if (data_get($detail, 'kode_booking'))
                        <div
                            class="p-3 bg-white mb-4 rounded-2xl border border-base-200 shadow-sm flex items-center justify-center">
                            <img src="data:image/png;base64,{{ DNS2D::getBarcodePNG(data_get($detail, 'kode_booking'), 'QRCODE', 4, 4) }}"
                                alt="QR Code" class="w-32 h-32 sm:w-28 sm:h-28"
                                style="image-rendering: pixelated;" />
                        </div>
                    @endif
                    <div
                        class="text-[10px] sm:text-xs font-black uppercase tracking-widest text-base-content text-center font-mono">
                        {{ data_get($detail, 'kode_booking') }}
                    </div>
                </div>

            </div>

            <!-- Keterangan / Note (Outside Ticket Card) -->
            @if (!empty(data_get($detail, 'keterangan')))
                <div class="mt-4 rounded-2xl border border-dashed border-base-300 bg-base-100 p-4 text-left">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-5 h-5 text-warning shrink-0">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                        </svg>
                        <h4 class="text-xs sm:text-sm font-bold uppercase text-base-content/60">Catatan Booking
                        </h4>
                    </div>
                    <div class="mt-2 text-sm font-medium text-base-content leading-relaxed">
                        "{{ data_get($detail, 'keterangan') }}"
                    </div>
                </div>
            @endif
        @endif
    </div>
</div>
