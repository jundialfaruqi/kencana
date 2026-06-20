<div wire:init="load">
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
        <div class="grid grid-cols-1 2xl:grid-cols-2 gap-6 items-start mb-8">
            <!-- Kolom Cek Kode Booking -->
            <div class="w-full">
                <div
                    class="card bg-base-100 shadow-xl border border-base-200 mx-auto rounded-2xl items-center py-10 flex flex-col">
                    <h2 class="text-lg font-bold text-center mb-2 text-base-content">
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
                    <div class="flex flex-row sm:flex-row gap-3 mt-4 w-full max-w-xs justify-center">
                        <button id="search-button"
                            class="btn btn-gray bg-base-300 border-0 btn-md text-base-content rounded-xl hover:bg-base-300 flex-1"
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
                        <button id="reset-button" type="button" wire:click="resetSearch" wire:loading.attr="disabled"
                            style="display: none;"
                            class="btn btn-error bg-red-100 hover:bg-red-200 border-0 btn-md text-red-600 rounded-xl flex-none px-4"
                            title="Reset">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="2.5" stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                            </svg>
                        </button>

                        <button id="scan-button" type="button"
                            class="btn btn-info border-0 btn-md text-info-content rounded-xl hover:opacity-90 flex-1">
                            <span class="flex items-center justify-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" class="size-[1.2em]">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                                </svg>
                                QR CODE
                            </span>
                        </button>
                    </div>
                    <div class="w-full">
                        <div wire:loading.flex wire:target="load" class="items-center justify-center p-10">
                            <span class="loading loading-spinner loading-md"></span>
                        </div>
                        <div wire:loading.remove wire:target="load">
                            @if ($error)
                                <div class="alert bg-red-500">
                                    <span>{{ $error }}</span>
                                </div>
                            @else
                                <div wire:loading.flex wire:target="searchBooking"
                                    class="items-center justify-center p-10">
                                    <span class="loading loading-spinner loading-md"></span>
                                </div>

                                <div wire:loading.remove wire:target="searchBooking">
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
                                        <div class="card max-w-xl mx-auto bg-black rounded-2xl overflow-hidden">
                                            <div class="bp-header bg-blue-600 text-white px-4 py-3 sm:px-6 sm:py-4">
                                                <div class="flex items-center justify-between">
                                                    <div class="text-[10px] font-bold uppercase opacity-80">Kode
                                                        Booking</div>
                                                    <div class="text-[10px] font-bold uppercase opacity-80">
                                                        {{ data_get($bookingDetail, 'status') ?? '-' }}</div>
                                                </div>
                                                <div
                                                    class="text-1xl sm:text-3xl font-black italic uppercase tracking-widest">
                                                    {{ data_get($bookingDetail, 'kode_booking') ?? '-' }}
                                                </div>
                                            </div>
                                            <div class="bp-body p-4 sm:p-6">
                                                <div class="flex items-center justify-between">
                                                    <h4 class="text-white sm:text-lg font-black italic uppercase">
                                                        {{ data_get($bookingDetail, 'lapangan.nama_lapangan') ?? '-' }}
                                                    </h4>
                                                </div>
                                                <div class="mt-4 grid grid-cols-3 gap-4 items-start">
                                                    <div>
                                                        <div
                                                            class="text-2xl sm:text-3xl font-black tracking-tight text-warning">
                                                            {{ \Carbon\Carbon::parse(data_get($bookingDetail, 'jam_mulai'))->format('H:i') ?? '-' }}
                                                        </div>
                                                        <div
                                                            class="text-[10px] font-bold uppercase text-gray-400 mt-1">
                                                            {{ \Carbon\Carbon::parse(data_get($bookingDetail, 'tanggal'))->format('d M Y') ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center justify-center">
                                                        <div
                                                            class="h-8 sm:h-10 border-l-2 border-dashed border-base-300">
                                                        </div>
                                                    </div>
                                                    <div class="text-right">
                                                        <div
                                                            class="text-2xl sm:text-3xl font-black tracking-tight text-warning">
                                                            {{ \Carbon\Carbon::parse(data_get($bookingDetail, 'jam_selesai'))->format('H:i') ?? '-' }}
                                                        </div>
                                                        <div
                                                            class="text-[10px] font-bold uppercase text-gray-400 mt-1">
                                                            {{ \Carbon\Carbon::parse(data_get($bookingDetail, 'tanggal'))->format('d M Y') ?? '-' }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="bp-divider my-4"></div>
                                                <div class="grid grid-cols-3 gap-2">
                                                    <div class="col-span-2">
                                                        <div class="text-[10px] font-bold uppercase text-gray-400">
                                                            Tim
                                                            / Nama</div>
                                                        <div class="mt-1 flex flex-col">
                                                            @php
                                                                $sessionName = data_get(
                                                                    Session::get('user_data'),
                                                                    'name',
                                                                );
                                                                $apiTeam =
                                                                    data_get($bookingDetail, 'nama_komunitas') ??
                                                                    data_get($bookingDetail, 'pemesan.nama_komunitas');
                                                                $apiName =
                                                                    data_get($bookingDetail, 'user.name') ??
                                                                    data_get($bookingDetail, 'pemesan.user.name');
                                                                $pemesanNama = data_get($bookingDetail, 'pemesan.nama');

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
                                                                        if (
                                                                            filled($sessionName) &&
                                                                            strcasecmp(
                                                                                trim((string) $pemesanNama),
                                                                                trim((string) $sessionName),
                                                                            ) !== 0
                                                                        ) {
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
                                                            <span
                                                                class="font-black text-white italic uppercase text-xs sm:text-sm">
                                                                {{ $team ?: '-' }}
                                                            </span>
                                                            <span
                                                                class="text-[10px] sm:text-xs text-gray-400 font-semibold uppercase mt-0.5">
                                                                {{ $name ?: '-' }}
                                                            </span>
                                                            @php
                                                                $nik =
                                                                    data_get($bookingDetail, 'user.nik') ??
                                                                    (data_get($bookingDetail, 'pemesan.user.nik') ??
                                                                        data_get($bookingDetail, 'pemesan.nik'));
                                                            @endphp
                                                            @if (filled($nik))
                                                                <span
                                                                    class="text-[10px] sm:text-xs text-info font-bold uppercase mt-0.5">
                                                                    NIK: {{ $nik }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <div class="mt-3 grid grid-cols-3 gap-3">
                                                            <div>
                                                                <div
                                                                    class="text-[10px] font-bold uppercase text-gray-400">
                                                                    Pemain
                                                                </div>
                                                                <div
                                                                    class="mt-1 font-black italic uppercase text-xs md:text-sm text-white">
                                                                    {{ data_get($bookingDetail, 'jumlah_pemain') ?? '-' }}
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <div
                                                                    class="text-[10px] font-bold uppercase text-gray-400">
                                                                    Kategori
                                                                </div>
                                                                <div
                                                                    class="mt-1 font-black italic uppercase text-xs md:text-sm text-white">
                                                                    {{ data_get($bookingDetail, 'kategori_pemain') ?? '-' }}
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <div
                                                                    class="text-[10px] font-bold uppercase text-gray-400">
                                                                    Jenis
                                                                </div>
                                                                <div
                                                                    class="mt-1 font-black italic uppercase text-xs md:text-sm text-white">
                                                                    {{ $this->getJenisPermainanAlias(data_get($bookingDetail, 'jenis_permainan')) ?? '-' }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-span-1 flex items-center justify-center">
                                                        <div
                                                            class="relative w-12 h-12 sm:w-23 sm:h-23 rounded-full bg-blue-500/10 flex items-center justify-center">

                                                            <!-- LOGO -->
                                                            <img src="{{ asset('assets/images/logo/logo-kencana-mini-soccer.webp') }}"
                                                                alt="Logo Kencana Arena"
                                                                class="w-full h-full object-contain p-1.5 sm:p-3 opacity-20 grayscale" />

                                                            <!-- OVERLAY VERIFIED (1 BARIS) -->
                                                            <div class="absolute flex items-center justify-between">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke-width="2"
                                                                    stroke="currentColor"
                                                                    class="size-4 sm:size-7 text-white">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round"
                                                                        d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                                                                </svg>
                                                                <div
                                                                    class="text-blue-500 font-black uppercase italic tracking-widest text-[10px] sm:text-[20px] text-center leading-none">
                                                                    Verified
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="bp-divider my-4"></div>
                                                <div class="grid grid-cols-3 gap-3">
                                                    <div>
                                                        <div class="text-[10px] font-bold uppercase text-gray-400">
                                                            Dibuat
                                                        </div>
                                                        <div class="mt-1 text-xs text-white">
                                                            {{ \Carbon\Carbon::parse(data_get($bookingDetail, 'created_at'))->format('d M Y H:i') ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="text-[10px] font-bold uppercase text-gray-400">
                                                            Status
                                                        </div>
                                                        <div
                                                            class="mt-1 text-xs font-black italic uppercase {{ (data_get($bookingDetail, 'status') ?? '') === 'dipesan' ? 'text-info' : 'text-warning' }}">
                                                            {{ data_get($bookingDetail, 'status') ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="text-[10px] font-bold uppercase text-gray-400">
                                                            Kode
                                                        </div>
                                                        <div
                                                            class="mt-1 text-xs font-black italic uppercase text-white">
                                                            {{ data_get($bookingDetail, 'kode_booking') ?? '-' }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div
                                                    class="mt-4 rounded-xl bg-base-200 border border-dashed border-base-300 p-3">
                                                    <div class="text-[10px] font-bold uppercase text-gray-400">
                                                        Keterangan
                                                    </div>
                                                    <div class="mt-1 text-sm italic">
                                                        {{ data_get($bookingDetail, 'keterangan') ?? '-' }}</div>
                                                </div>
                                            </div>
                                            <div class="bp-footer bg-blue-600 text-info-content px-4 py-3 sm:px-6">
                                                <div
                                                    class="text-center text-[10px] sm:text-xs font-black italic uppercase tracking-widest">
                                                    {{ data_get($bookingDetail, 'lapangan.nama_lapangan') ?? '-' }}
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>

            <!-- Kolom Download Aplikasi -->
            <div class="w-full h-full">
                <div x-data="{ apk: 'armeabi-v7a' }"
                    class="card bg-white border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] relative overflow-hidden h-full">

                    <!-- Background blobs -->
                    <div
                        class="absolute -right-20 -top-20 w-64 h-64 bg-blue-50 rounded-full mix-blend-multiply filter blur-3xl opacity-70">
                    </div>
                    <div
                        class="absolute -right-10 bottom-0 w-80 h-80 bg-blue-100/50 rounded-full mix-blend-multiply filter blur-3xl opacity-70">
                    </div>

                    <!-- Phone Mockup -->
                    <img src="{{ asset('assets/images/ilustrasi/home-screen-android-mockup-phone.png') }}"
                        class="absolute -right-16 sm:-right-16 bottom-6 sm:-bottom-2 w-102 sm:w-100 lg:w-95 drop-shadow-[0_20px_30px_rgba(0,0,0,0.25)] z-0 pointer-events-none transform -rotate-2"
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
                                    class="text-[16px] sm:text-3xl font-black text-[#143e99] leading-tight tracking-tight">
                                    Aplikasi Kencana Admin</h2>
                            </div>

                            <!-- Description -->
                            <p
                                class="text-[13px] sm:text-[15px] text-gray-500 mb-6 leading-relaxed drop-shadow-[0_1px_2px_rgba(255,255,255,0.8)]">
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
                            <a :href="'/apk-download/kencana-admin-' + apk + '.apk'" download
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
                        <div class="w-8 h-8 rounded-xl bg-white/20 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="2.5" stroke="currentColor" class="size-5 text-white">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-black italic uppercase tracking-tighter text-lg text-white">
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
                                <span
                                    class="text-[9px] uppercase tracking-widest text-info font-black bg-base-100/90 px-2.5 py-1 rounded shadow-md">
                                    Sejajarkan QR
                                </span>
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
