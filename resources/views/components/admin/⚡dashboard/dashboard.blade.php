<div>
    <!-- Page Title & Breadcrumbs -->
    {{-- <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold">Dashboard</h1>
            <p class="text-sm text-base-content/60 mt-1">Admin Dashboard</p>
        </div>
        <div class="text-sm breadcrumbs text-base-content/60">
            <ul>
                <li><a href="#">Aman Arena</a></li>
                <li>Dashboard</li>
            </ul>
        </div>
    </div> --}}
    <div>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
            <!-- Kolom Cek Kode Booking -->
            <div class="w-full lg:col-span-2">
                <div
                    class="card bg-base-100 -mx-6 sm:mx-auto rounded-none sm:rounded-2xl items-center py-10 px-4 flex flex-col min-h-196 w-[calc(100%+3rem)] sm:w-full">
                    <h2 class="text-lg uppercase text-center mb-2 text-base-content">
                        Cek Kode Booking
                    </h2>

                    <label class="form-control">
                        <div class="join w-full">
                            <div id="booking-code-input-segments"
                                class="flex flex-row flex-wrap justify-center items-center join-item grow gap-2 sm:gap-1">
                                <div class="flex items-center gap-1 sm:contents">
                                    <input type="text" id="input-bk-b" value="B" maxlength="1" readonly
                                        class="input input-xs sm:input-md w-8 h-8 sm:w-10 sm:h-10 text-center text-[10px] sm:text-[14px] uppercase focus-within:outline-none focus-within:ring-0 border-0 border-b-2 rounded-none font-bold font-mono" />
                                    <input type="text" id="input-bk-k" value="K" maxlength="1" readonly
                                        class="input input-xs sm:input-md w-8 h-8 sm:w-10 sm:h-10 text-center text-[10px] sm:text-[14px] uppercase focus-within:outline-none focus-within:ring-0 border-0 border-b-2 rounded-none font-bold font-mono" />
                                    <span class="font-bold text-lg">-</span>
                                </div>
                                <div class="flex items-center gap-1 sm:contents">
                                    <input type="text" id="input-year-1" maxlength="1"
                                        class="input input-xs sm:input-md w-8 h-8 sm:w-10 sm:h-10 text-center text-[10px] sm:text-[14px] uppercase focus-within:outline-none focus-within:ring-0 border-0 border-b-2 rounded-none font-bold font-mono" />
                                    <input type="text" id="input-year-2" maxlength="1"
                                        class="input input-xs sm:input-md w-8 h-8 sm:w-10 sm:h-10 text-center text-[10px] sm:text-[14px] uppercase focus-within:outline-none focus-within:ring-0 border-0 border-b-2 rounded-none font-bold font-mono" />
                                    <input type="text" id="input-year-3" maxlength="1"
                                        class="input input-xs sm:input-md w-8 h-8 sm:w-10 sm:h-10 text-center text-[10px] sm:text-[14px] uppercase focus-within:outline-none focus-within:ring-0 border-0 border-b-2 rounded-none font-bold font-mono" />
                                    <input type="text" id="input-year-4" maxlength="1"
                                        class="input input-xs sm:input-md w-8 h-8 sm:w-10 sm:h-10 text-center text-[10px] sm:text-[14px] uppercase focus-within:outline-none focus-within:ring-0 border-0 border-b-2 rounded-none font-bold font-mono" />
                                    <input type="text" id="input-month-1" maxlength="1"
                                        class="input input-xs sm:input-md w-8 h-8 sm:w-10 sm:h-10 text-center text-[10px] sm:text-[14px] uppercase focus-within:outline-none focus-within:ring-0 border-0 border-b-2 rounded-none font-bold font-mono" />
                                    <input type="text" id="input-month-2" maxlength="1"
                                        class="input input-xs sm:input-md w-8 h-8 sm:w-10 sm:h-10 text-center text-[10px] sm:text-[14px] uppercase focus-within:outline-none focus-within:ring-0 border-0 border-b-2 rounded-none font-bold font-mono" />
                                    <input type="text" id="input-day-1" maxlength="1"
                                        class="input input-xs sm:input-md w-8 h-8 sm:w-10 sm:h-10 text-center text-[10px] sm:text-[14px] uppercase focus-within:outline-none focus-within:ring-0 border-0 border-b-2 rounded-none font-bold font-mono" />
                                    <input type="text" id="input-day-2" maxlength="1"
                                        class="input input-xs sm:input-md w-8 h-8 sm:w-10 sm:h-10 text-center text-[10px] sm:text-[14px] uppercase focus-within:outline-none focus-within:ring-0 border-0 border-b-2 rounded-none font-bold font-mono" />
                                    <span class="font-bold text-lg">-</span>
                                </div>
                                <div class="flex items-center gap-1 sm:contents">
                                    <input type="text" id="input-code-1" maxlength="1"
                                        class="input input-xs sm:input-md w-8 h-8 sm:w-10 sm:h-10 text-center text-[10px] sm:text-[14px] uppercase focus-within:outline-none focus-within:ring-0 border-0 border-b-2 rounded-none font-bold font-mono" />
                                    <input type="text" id="input-code-2" maxlength="1"
                                        class="input input-xs sm:input-md w-8 h-8 sm:w-10 sm:h-10 text-center text-[10px] sm:text-[14px] uppercase focus-within:outline-none focus-within:ring-0 border-0 border-b-2 rounded-none font-bold font-mono" />
                                    <input type="text" id="input-code-3" maxlength="1"
                                        class="input input-xs sm:input-md w-8 h-8 sm:w-10 sm:h-10 text-center text-[10px] sm:text-[14px] uppercase focus-within:outline-none focus-within:ring-0 border-0 border-b-2 rounded-none font-bold font-mono" />
                                    <input type="text" id="input-code-4" maxlength="1"
                                        class="input input-xs sm:input-md w-8 h-8 sm:w-10 sm:h-10 text-center text-[10px] sm:text-[14px] uppercase focus-within:outline-none focus-within:ring-0 border-0 border-b-2 rounded-none font-bold font-mono" />
                                </div>
                            </div>
                            <input type="hidden" id="livewire-search-query-input" wire:model.live="searchQuery">
                        </div>

                        @error('searchQuery')
                            <p class="text-warning italic text-xs mt-1 text-center">*{{ $message }}</p>
                        @enderror
                    </label>
                    <div class="flex flex-row sm:flex-row gap-2 sm:gap-3 mt-4 w-full max-w-xs justify-center">
                        <button id="search-button"
                            class="btn btn-gray bg-base-300 border-0 btn-sm sm:btn-md text-base-content rounded-xl hover:bg-base-300 flex-1"
                            wire:click="searchBooking" wire:loading.attr="disabled" wire:target="searchBooking">
                            <span class="flex items-center justify-center gap-1" wire:loading.remove
                                wire:target="searchBooking">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2.5" stroke="currentColor" class="size-[1.2em]">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                </svg>
                                Cek
                            </span>
                            <span class="loading loading-spinner loading-md" wire:loading
                                wire:target="searchBooking"></span>
                        </button>

                        <button id="scan-button" type="button"
                            class="btn btn-info border-0 btn-sm sm:btn-md text-info-content rounded-xl hover:opacity-90 flex-1">
                            <span class="flex items-center justify-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-qrcode size-[1.2em]">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M4 5a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1l0 -4" />
                                    <path d="M7 17l0 .01" />
                                    <path
                                        d="M14 5a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1l0 -4" />
                                    <path d="M7 7l0 .01" />
                                    <path
                                        d="M4 15a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1l0 -4" />
                                    <path d="M17 7l0 .01" />
                                    <path d="M14 14l3 0" />
                                    <path d="M20 14l0 .01" />
                                    <path d="M14 14l0 3" />
                                    <path d="M14 20l3 0" />
                                    <path d="M17 17l3 0" />
                                    <path d="M20 17l0 3" />
                                </svg>
                                QR CODE
                            </span>
                        </button>

                        <button id="reset-button" type="button" wire:click="resetSearch"
                            wire:loading.attr="disabled" style="display: none;"
                            class="btn btn-error bg-red-100 hover:bg-red-200 border-0 btn-sm sm:btn-md text-red-600 rounded-xl flex-none px-3 sm:px-4"
                            title="Reset">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="2.5" stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                            </svg>
                        </button>
                    </div>
                    <div class="w-full">

                        @if ($error)
                            <div class="alert bg-red-500">
                                <span>{{ $error }}</span>
                            </div>
                        @else
                            <div wire:loading.flex wire:target="searchBooking"
                                class="flex flex-col items-center justify-center text-center p-10 mt-40">
                                <span class="loading loading-spinner loading-lg text-primary"></span>
                            </div>

                            <div wire:loading.remove wire:target="searchBooking" class="w-full">
                                @if ($searchError)
                                    <div class="alert bg-red-500 mb-4 mx-4 mt-4 text-white">
                                        <span>{{ $searchError }}</span>
                                    </div>
                                @elseif ($bookingDetail)
                                    <h2 class="text-center mb-2 mt-6 font-bold"> Hasil Pencarian Kode Booking:
                                        <span class="underline">
                                            {{ data_get($bookingDetail, 'kode_booking') }}
                                        </span>
                                    </h2>

                                    @php
                                        $tanggal = data_get($bookingDetail, 'tanggal');
                                        $jamMulai = data_get($bookingDetail, 'jam_mulai');
                                        $jamSelesai = data_get($bookingDetail, 'jam_selesai');
                                        $status = data_get($bookingDetail, 'status');
                                        $isExpired = false;

                                        if ($tanggal && $jamSelesai) {
                                            try {
                                                $dateOnly = \Carbon\Carbon::parse($tanggal)->format('Y-m-d');
                                                $dateTimeSelesai = \Carbon\Carbon::parse($dateOnly . ' ' . $jamSelesai);
                                                $isExpired = $dateTimeSelesai->isPast();
                                            } catch (\Exception $e) {
                                                //
                                            }
                                        }

                                        $warningMessage = null;
                                        if ($status === 'dibatalkan') {
                                            $warningMessage =
                                                'Tiket anda sudah tidak berlaku karena sudah dibatalkan. Lihat keterangan alasan pembatalan pada Catatan Booking di bawah.';
                                        } elseif ($status === 'selesai') {
                                            $warningMessage = 'Tiket anda tidak berlaku karena sudah digunakan.';
                                        } elseif ($status === 'dipesan' && $isExpired) {
                                            $formattedDate = \Carbon\Carbon::parse($tanggal)->format('d M Y');
                                            $formattedMulai = \Carbon\Carbon::parse($jamMulai)->format('H:i');
                                            $formattedSelesai = \Carbon\Carbon::parse($jamSelesai)->format('H:i');
                                            $warningMessage = "Tiket anda tanggal {$formattedDate} dan jam {$formattedMulai}-{$formattedSelesai} sudah tidak berlaku.";
                                        }
                                    @endphp

                                    @if ($warningMessage)
                                        <div class="text-xs text-error font-bold text-center mt-1 mb-4">
                                            {{ $warningMessage }}
                                        </div>
                                    @endif

                                    <style>
                                        .dashboard-ticket-mask {
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
                                            .dashboard-ticket-mask {
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

                                    <div class="relative w-full max-w-xl sm:max-w-3xl lg:max-w-4xl mx-auto">
                                        <!-- Card Tiket -->
                                        <div
                                            class="w-full rounded-2xl border border-base-300 shadow-lg flex flex-col sm:flex-row relative overflow-hidden dashboard-ticket-mask [--cut-pos:14.25rem] sm:[--cut-pos:10.75rem]">
                                            <!-- Left Section (Main Details) -->
                                            <div
                                                class="flex-1 p-4 sm:p-6 flex flex-col justify-between min-w-0 bg-base-100 rounded-t-2xl sm:rounded-l-2xl sm:rounded-tr-none">
                                                <!-- Header -->
                                                <div
                                                    class="flex flex-row justify-between items-center mb-2 sm:mb-4 gap-2">
                                                    <!-- Status Badge -->
                                                    <div
                                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-[10px] sm:text-xs font-black uppercase tracking-wider {{ (data_get($bookingDetail, 'status') ?? '') === 'dipesan' ? 'bg-info/10 text-info' : ((data_get($bookingDetail, 'status') ?? '') === 'dibatalkan' ? 'bg-error/10 text-error' : 'bg-success/10 text-success') }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" class="w-4 h-4">
                                                            <path fill-rule="evenodd"
                                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-13a.75.75 0 00-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 000-1.5h-3.25V5z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                        {{ data_get($bookingDetail, 'status') ?? '-' }}
                                                    </div>

                                                    <!-- Created Date -->
                                                    <span
                                                        class="text-[10px] sm:text-xs font-medium text-base-content/50">
                                                        Dibuat:
                                                        {{ \Carbon\Carbon::parse(data_get($bookingDetail, 'created_at'))->format('d M Y H:i') ?? '-' }}
                                                    </span>
                                                </div>

                                                <!-- Title -->
                                                <h4
                                                    class="text-sm sm:text-xl font-extrabold text-base-content mb-4 sm:mb-6 leading-tight truncate">
                                                    {{ data_get($bookingDetail, 'lapangan.nama_lapangan') ?? '-' }}
                                                </h4>

                                                <!-- Details Grid -->
                                                <div class="grid grid-cols-2 gap-y-3 gap-x-3 sm:gap-y-4 sm:gap-x-4">
                                                    <!-- Date -->
                                                    <div>
                                                        <div
                                                            class="text-[9px] sm:text-[10px] font-bold text-base-content/50 uppercase mb-1 sm:mb-1.5">
                                                            Tanggal
                                                        </div>
                                                        <div
                                                            class="flex items-center gap-1.5 sm:gap-2 text-base-content">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke-width="1.5"
                                                                stroke="currentColor"
                                                                class="w-4 h-4 sm:w-5 sm:h-5 text-base-content/50 shrink-0">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                                            </svg>
                                                            <span class="text-xs sm:text-sm font-medium leading-none">
                                                                {{ \Carbon\Carbon::parse(data_get($bookingDetail, 'tanggal'))->format('d M Y') ?? '-' }}
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <!-- Time -->
                                                    <div>
                                                        <div
                                                            class="text-[9px] sm:text-[10px] font-bold uppercase text-base-content/50 mb-1 sm:mb-1.5">
                                                            Jam
                                                        </div>
                                                        <div
                                                            class="flex items-center gap-1.5 sm:gap-2 text-base-content">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke-width="1.5"
                                                                stroke="currentColor"
                                                                class="w-4 h-4 sm:w-5 sm:h-5 text-base-content/50 shrink-0">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                            <span class="text-xs sm:text-sm font-medium leading-none">
                                                                {{ \Carbon\Carbon::parse(data_get($bookingDetail, 'jam_mulai'))->format('H:i') ?? '-' }}
                                                                -
                                                                {{ \Carbon\Carbon::parse(data_get($bookingDetail, 'jam_selesai'))->format('H:i') ?? '-' }}
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <!-- Tim/Nama -->
                                                    @php
                                                        $team =
                                                            data_get($bookingDetail, 'nama_komunitas') ??
                                                            data_get($bookingDetail, 'pemesan.nama_komunitas');
                                                        $name =
                                                            data_get($bookingDetail, 'user.name') ??
                                                            (data_get($bookingDetail, 'pemesan.user.name') ??
                                                                data_get($bookingDetail, 'pemesan.nama'));
                                                        $nik =
                                                            data_get($bookingDetail, 'user.nik') ??
                                                            (data_get($bookingDetail, 'pemesan.user.nik') ??
                                                                data_get($bookingDetail, 'pemesan.nik'));
                                                        $email =
                                                            data_get($bookingDetail, 'user.email') ??
                                                            (data_get($bookingDetail, 'pemesan.user.email') ??
                                                                data_get($bookingDetail, 'pemesan.email'));
                                                        $jumlahPemain =
                                                            data_get($bookingDetail, 'jumlah_pemain') ??
                                                            data_get($bookingDetail, 'detail.jumlah_pemain');
                                                        $kategori =
                                                            data_get($bookingDetail, 'kategori_pemain') ??
                                                            data_get($bookingDetail, 'detail.kategori');
                                                        $jenis =
                                                            data_get($bookingDetail, 'jenis_permainan') ??
                                                            data_get($bookingDetail, 'detail.jenis');
                                                    @endphp

                                                    <!-- Details List (Tim, Pemesan, NIK, Email, Pemain, Kategori, Jenis) -->
                                                    <div class="col-span-2 mt-4 space-y-2.5">
                                                        <!-- Tim -->
                                                        <div class="flex items-end justify-between w-full">
                                                            <span
                                                                class="font-semibold text-[11px] uppercase tracking-wide text-base-content/50 shrink-0">Tim</span>
                                                            <div
                                                                class="grow border-b border-dashed border-base-content/20 mx-2 mb-1">
                                                            </div>
                                                            <span
                                                                class="text-xs font-bold text-warning uppercase shrink-0 text-right">{{ $team ?: '-' }}</span>
                                                        </div>

                                                        <!-- Pemesan -->
                                                        <div class="flex items-end justify-between w-full">
                                                            <span
                                                                class="font-semibold text-[11px] uppercase tracking-wide text-base-content/50 shrink-0">Pemesan</span>
                                                            <div
                                                                class="grow border-b border-dashed border-base-content/20 mx-2 mb-1">
                                                            </div>
                                                            <span
                                                                class="text-xs font-bold text-base-content/85 uppercase shrink-0 text-right">{{ $name ?: '-' }}</span>
                                                        </div>

                                                        <!-- NIK -->
                                                        <div class="flex items-end justify-between w-full">
                                                            <span
                                                                class="font-semibold text-[11px] uppercase tracking-wide text-base-content/50 shrink-0">NIK</span>
                                                            <div
                                                                class="grow border-b border-dashed border-base-content/20 mx-2 mb-1">
                                                            </div>
                                                            <span
                                                                class="text-xs font-mono font-bold text-base-content shrink-0 text-right">{{ $nik ?: '-' }}</span>
                                                        </div>

                                                        <!-- Email -->
                                                        <div class="flex items-end justify-between w-full">
                                                            <span
                                                                class="font-semibold text-[11px] uppercase tracking-wide text-base-content/50 shrink-0">Email</span>
                                                            <div
                                                                class="grow border-b border-dashed border-base-content/20 mx-2 mb-1">
                                                            </div>
                                                            <span
                                                                class="text-xs font-mono font-bold text-base-content/65 shrink-0 text-right">{{ $email ?: '-' }}</span>
                                                        </div>

                                                        <!-- Pemain -->
                                                        <div class="flex items-end justify-between w-full">
                                                            <span
                                                                class="font-semibold text-[11px] uppercase tracking-wide text-base-content/50 shrink-0">Pemain</span>
                                                            <div
                                                                class="grow border-b border-dashed border-base-content/20 mx-2 mb-1">
                                                            </div>
                                                            <span
                                                                class="text-xs font-bold shrink-0 text-right font-mono">{{ $jumlahPemain ?: '-' }}</span>
                                                        </div>

                                                        <!-- Kategori -->
                                                        <div class="flex items-end justify-between w-full">
                                                            <span
                                                                class="font-semibold text-[11px] uppercase tracking-wide text-base-content/50 shrink-0">Kategori</span>
                                                            <div
                                                                class="grow border-b border-dashed border-base-content/20 mx-2 mb-1">
                                                            </div>
                                                            <span
                                                                class="text-xs font-bold shrink-0 text-right uppercase">{{ $kategori ?: '-' }}</span>
                                                        </div>

                                                        <!-- Jenis -->
                                                        <div class="flex items-end justify-between w-full">
                                                            <span
                                                                class="font-semibold text-[11px] uppercase tracking-wide text-base-content/50 shrink-0">Jenis</span>
                                                            <div
                                                                class="grow border-b border-dashed border-base-content/20 mx-2 mb-1">
                                                            </div>
                                                            <span
                                                                class="text-xs font-bold shrink-0 text-right uppercase">{{ $this->getJenisPermainanAlias($jenis) ?: '-' }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Perforated Line -->
                                            <div
                                                class="flex sm:flex-col justify-center items-center relative h-6 sm:h-auto w-full sm:w-6 shrink-0">
                                                <div
                                                    class="border-t-2 sm:border-t-0 sm:border-l-2 border-dashed border-base-300 h-px sm:h-auto w-full sm:w-px grow mx-4 my-2 sm:mx-0 sm:my-6">
                                                </div>
                                            </div>

                                            <!-- Right Section (QR) -->
                                            <div
                                                class="w-full sm:w-40 h-54 sm:h-auto p-4 shrink-0 flex flex-col justify-center items-center bg-base-100 rounded-b-2xl sm:rounded-r-2xl sm:rounded-bl-none">
                                                @if (data_get($bookingDetail, 'kode_booking'))
                                                    <div
                                                        class="p-2 bg-white mb-2 sm:mb-4 rounded-xl border border-base-300 shadow-sm">
                                                        <img src="data:image/png;base64,{{ DNS2D::getBarcodePNG(data_get($bookingDetail, 'kode_booking'), 'QRCODE', 4, 4) }}"
                                                            alt="QR Code" class="w-32 h-32 sm:w-24 sm:h-24"
                                                            style="image-rendering: pixelated;" />
                                                    </div>
                                                @endif
                                                <div
                                                    class="text-[10px] sm:text-xs font-black uppercase tracking-widest text-base-content text-center">
                                                    {{ data_get($bookingDetail, 'kode_booking') }}
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Border circles for cuts (Desktop) -->
                                        <div
                                            class="hidden sm:block absolute top-0 right-[10.75rem] translate-x-1/2 w-5 h-2.5 rounded-b-full bg-transparent border-b border-l border-r border-t-0 border-base-300 pointer-events-none z-10">
                                        </div>
                                        <div
                                            class="hidden sm:block absolute bottom-0 right-[10.75rem] translate-x-1/2 w-5 h-2.5 rounded-t-full bg-transparent border-t border-l border-r border-b-0 border-base-300 pointer-events-none z-10">
                                        </div>

                                        <!-- Border circles for cuts (Mobile) -->
                                        <div
                                            class="block sm:hidden absolute left-0 bottom-[14.25rem] translate-y-1/2 w-2.5 h-5 rounded-r-full bg-transparent border-t border-b border-r border-l-0 border-base-300 pointer-events-none z-10">
                                        </div>
                                        <div
                                            class="block sm:hidden absolute right-0 bottom-[14.25rem] translate-y-1/2 w-2.5 h-5 rounded-l-full bg-transparent border-t border-b border-l border-r-0 border-base-300 pointer-events-none z-10">
                                        </div>
                                    </div>

                                    @if (!empty(data_get($bookingDetail, 'keterangan')))
                                        <div
                                            class="mt-4 max-w-xl sm:max-w-3xl lg:max-w-4xl mx-auto rounded-2xl border border-base-300 bg-base-100 p-4">
                                            <div class="flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                    class="w-5 h-5 text-warning">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                                </svg>
                                                <h4
                                                    class="text-xs sm:text-sm font-bold uppercase text-base-content/60">
                                                    Catatan Booking</h4>
                                            </div>
                                            <div
                                                class="mt-2 text-sm italic font-medium text-base-content leading-relaxed">
                                                "{{ data_get($bookingDetail, 'keterangan') }}"
                                            </div>
                                        </div>
                                    @endif
                                @else
                                    <div
                                        class="flex flex-col items-center justify-center text-center p-10 opacity-50 mt-40">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor"
                                            class="size-20 mb-4 text-base-content">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 0 1 0 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 0 1 0-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z" />
                                        </svg>
                                        <h3 class="text-xl font-black italic uppercase text-base-content mb-2">
                                            Belum Ada Pencarian</h3>
                                        <p class="text-sm font-semibold text-base-content/60 max-w-xs">
                                            Masukkan kode booking atau scan QR Code untuk melihat detail tiket di
                                            sini.
                                        </p>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Kolom Download Aplikasi -->
            <div class="w-full lg:col-span-1">
                <div x-data="{ apk: 'armeabi-v7a' }"
                    class="card bg-white border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] relative overflow-hidden">

                    <!-- Background blobs -->
                    <div
                        class="absolute -right-20 -top-20 w-64 h-64 bg-blue-50 rounded-full mix-blend-multiply filter blur-3xl opacity-70">
                    </div>
                    <div
                        class="absolute -right-10 bottom-0 w-80 h-80 bg-blue-100/50 rounded-full mix-blend-multiply filter blur-3xl opacity-70">
                    </div>

                    <!-- Phone Mockup -->
                    <img src="{{ asset('assets/images/ilustrasi/home-screen-android-mockup-phone.png') }}"
                        class="absolute -right-16 sm:-right-18 bottom-6 sm:-bottom-1 w-102 sm:w-100 lg:w-100 drop-shadow-[0_20px_30px_rgba(0,0,0,0.25)] z-0 pointer-events-none transform -rotate-2"
                        alt="Mockup" />

                    <div
                        class="card-body relative z-10 w-[75%] sm:w-[65%] lg:w-[65%] p-6 sm:p-8 flex flex-col justify-between">
                        <div>
                            <!-- Header: Logo & Title -->
                            <div class="flex flex-row sm:flex-row items-start sm:items-center gap-2 mb-3">
                                <div
                                    class="w-10 h-10 bg-[#143e99] rounded-lg flex items-center justify-center shrink-0 shadow-lg overflow-hidden">
                                    <img src="{{ asset('assets/images/logo/logo-kencana-mini-soccer.webp') }}"
                                        class="w-full h-full object-contain p-1" alt="Logo Kencana">
                                </div>
                                <h2
                                    class="text-[16px] sm:text-xl font-black text-[#143e99] leading-tight tracking-tight">
                                    Aplikasi Kencana Admin</h2>
                            </div>

                            <!-- Description -->
                            <p class="text-[13px] sm:text-[15px] text-gray-500 mb-6 leading-relaxed text-stroke-white">
                                Kelola booking, ketersediaan jadwal, dan pengguna lebih mudah langsung dari aplikasi
                                Android.
                            </p>

                            <!-- Form Control -->
                            <div class="form-control w-full max-w-sm mb-6">
                                <label class="label px-0 pt-0 pb-2">
                                    <span class="label-text text-[#143e99] font-bold text-sm">Pilih Arsitektur
                                        APK</span>
                                </label>
                                <div class="relative">
                                    <div
                                        class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-[#3DDC84] z-10">
                                        <!-- Android Icon -->
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M17.523 15.3414c-.5511 0-.9993-.4486-.9993-.9997s.4482-.9993.9993-.9993c.5511 0 .9993.4482.9993.9993.0004.5511-.4482.9997-.9993.9997m-11.046 0c-.5511 0-.9993-.4486-.9993-.9997s.4482-.9993.9993-.9993c.5511 0 .9993.4482.9993.9993 0 .5511-.4482.9997-.9993.9997m11.4045-6.02l1.9973-3.4592c.1158-.2018.0468-.4584-.1558-.5742-.203-.1165-.4588-.0464-.5746.1558l-2.022 3.5027c-1.4746-.6731-3.1511-1.0454-4.9452-1.0454-1.8021 0-3.4866.3768-4.9662 1.0567l-2.006-3.4754c-.1154-.2026-.3715-.2727-.5746-.1565-.2026.115-.2716.3715-.1554.5746l1.9793 3.4284C2.793 10.7719.2559 14.8693.0232 19.6715h23.9529c-.2323-4.8022-2.7694-8.8996-6.4256-10.3501" />
                                        </svg>
                                    </div>
                                    <select x-model="apk"
                                        class="select select-bordered w-65 pl-10 bg-white border-gray-200 text-gray-700 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 shadow-[0_2px_10px_rgb(0,0,0,0.02)] transition-all h-12 rounded-xl text-[14px]">
                                        <option value="armeabi-v7a">Android 32-bit (armeabi-v7a)</option>
                                        <option value="arm64-v8a">Android 64-bit (arm64-v8a)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Button -->
                        <div class="card-actions">
                            <a :href="'/admin/apk-download/kencana-admin-' + apk + '.apk'" download
                                class="btn bg-[#044bc0] hover:bg-[#033c99] text-white border-none shadow-[0_4px_15px_rgba(4,75,192,0.3)] px-6 rounded-xl font-semibold flex items-center gap-2 normal-case h-11 min-h-11">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                </svg>
                                Download APK
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Scanner Barcode -->
        <div id="scanner-modal" class="fixed inset-0 z-50 hidden grid place-items-center p-4">
            <!-- Backdrop -->
            <div class="absolute inset-0 bg-base-100/80 backdrop-blur-sm" id="close-scanner-backdrop"></div>

            <!-- Modal Box -->
            <div
                class="relative w-full max-w-sm sm:max-w-md mx-4 sm:mx-0 rounded-2xl border-2 border-primary bg-base-100 shadow-2xl overflow-hidden">
                <!-- Header -->
                <div class="bg-primary text-primary-content p-4 flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="2.5" stroke="currentColor" class="size-5 text-white">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-black uppercase text-lg tex-base-content">
                                Scan Barcode Booking
                            </h4>
                        </div>
                    </div>
                    <button type="button" class="btn btn-ghost btn-circle btn-sm text-white hover:bg-white/20"
                        id="close-scanner-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="2.5" stroke="currentColor" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Body -->
                <div class="p-4 sm:p-6 space-y-4">
                    <div id="scanner-status" class="text-xs text-center font-bold text-base-content/60 uppercase">
                        Menginisialisasi Kamera...
                    </div>

                    <div
                        class="relative overflow-hidden rounded-xl bg-black aspect-video flex items-center justify-center border border-base-300">
                        <div id="reader" class="w-full h-full"></div>
                        <!-- CSS Target Box (Visual only, no cropping) -->
                        <div class="absolute inset-0 pointer-events-none flex items-center justify-center">
                            <div
                                class="w-40 h-40 border-2 border-dashed border-info rounded-xl flex items-center justify-center bg-info/5">
                            </div>
                        </div>
                        <!-- Scanning indicator overlay line -->
                        <div id="scanner-laser"
                            class="absolute left-0 right-0 h-0.5 bg-red-500 shadow-[0_0_8px_#ef4444] animate-[scan_2s_linear_infinite] hidden">
                        </div>
                    </div>

                    <div class="text-xs text-center text-base-content/50">
                        Arahkan QR Code booking ke area kamera untuk memindai secara otomatis.
                    </div>
                </div>
            </div>
        </div>

        <style>
            @keyframes scan {
                0% {
                    top: 0%;
                }

                50% {
                    top: 100%;
                }

                100% {
                    top: 0%;
                }
            }
        </style>
    </div>
