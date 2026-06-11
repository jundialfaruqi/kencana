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
    <div class="mx-auto rounded-2xl">
        <div class="card items-center py-10 flex flex-col">
            <h2 class="text-lg font-bold text-center mb-2 text-base-content">
                Cek Kode Booking
            </h2>
            <label class="form-control">
                <div class="join w-full">
                    <div id="booking-code-input-segments"
                        class="flex flex-col sm:flex-row items-center join-item grow gap-1">
                        <div class="flex items-center gap-1 sm:contents">
                            <input type="text" id="input-bk-b" value="B" maxlength="1" readonly
                                class="input input-xs md:input-md w-8 h-8 md:w-10 md:h-10 text-center text-[8px] md:text-[14px] uppercase focus-within:outline-none focus-within:ring-0 border-0 border-b-2 rounded-none font-bold font-mono" />
                            <input type="text" id="input-bk-k" value="K" maxlength="1" readonly
                                class="input input-xs md:input-md w-8 h-8 md:w-10 md:h-10 text-center text-[8px] md:text-[14px] uppercase focus-within:outline-none focus-within:ring-0 border-0 border-b-2 rounded-none font-bold font-mono" />
                            <span class="font-bold text-lg">-</span>
                        </div>
                        <div class="flex items-center gap-1 sm:contents">
                            <input type="text" id="input-year-1" maxlength="1"
                                class="input input-xs md:input-md w-8 h-8 md:w-10 md:h-10 text-center text-[8px] md:text-[14px] uppercase focus-within:outline-none focus-within:ring-0 border-0 border-b-2 rounded-none font-bold font-mono" />
                            <input type="text" id="input-year-2" maxlength="1"
                                class="input input-xs md:input-md w-8 h-8 md:w-10 md:h-10 text-center text-[8px] md:text-[14px] uppercase focus-within:outline-none focus-within:ring-0 border-0 border-b-2 rounded-none font-bold font-mono" />
                            <input type="text" id="input-year-3" maxlength="1"
                                class="input input-xs md:input-md w-8 h-8 md:w-10 md:h-10 text-center text-[8px] md:text-[14px] uppercase focus-within:outline-none focus-within:ring-0 border-0 border-b-2 rounded-none font-bold font-mono" />
                            <input type="text" id="input-year-4" maxlength="1"
                                class="input input-xs md:input-md w-8 h-8 md:w-10 md:h-10 text-center text-[8px] md:text-[14px] uppercase focus-within:outline-none focus-within:ring-0 border-0 border-b-2 rounded-none font-bold font-mono" />
                            <input type="text" id="input-month-1" maxlength="1"
                                class="input input-xs md:input-md w-8 h-8 md:w-10 md:h-10 text-center text-[8px] md:text-[14px] uppercase focus-within:outline-none focus-within:ring-0 border-0 border-b-2 rounded-none font-bold font-mono" />
                            <input type="text" id="input-month-2" maxlength="1"
                                class="input input-xs md:input-md w-8 h-8 md:w-10 md:h-10 text-center text-[8px] md:text-[14px] uppercase focus-within:outline-none focus-within:ring-0 border-0 border-b-2 rounded-none font-bold font-mono" />
                            <input type="text" id="input-day-1" maxlength="1"
                                class="input input-xs md:input-md w-8 h-8 md:w-10 md:h-10 text-center text-[8px] md:text-[14px] uppercase focus-within:outline-none focus-within:ring-0 border-0 border-b-2 rounded-none font-bold font-mono" />
                            <input type="text" id="input-day-2" maxlength="1"
                                class="input input-xs md:input-md w-8 h-8 md:w-10 md:h-10 text-center text-[8px] md:text-[14px] uppercase focus-within:outline-none focus-within:ring-0 border-0 border-b-2 rounded-none font-bold font-mono" />
                            <span class="font-bold text-lg">-</span>
                        </div>
                        <div class="flex items-center gap-1 sm:contents">
                            <input type="text" id="input-code-1" maxlength="1"
                                class="input input-xs md:input-md w-8 h-8 md:w-10 md:h-10 text-center text-[8px] md:text-[14px] uppercase focus-within:outline-none focus-within:ring-0 border-0 border-b-2 rounded-none font-bold font-mono" />
                            <input type="text" id="input-code-2" maxlength="1"
                                class="input input-xs md:input-md w-8 h-8 md:w-10 md:h-10 text-center text-[8px] md:text-[14px] uppercase focus-within:outline-none focus-within:ring-0 border-0 border-b-2 rounded-none font-bold font-mono" />
                            <input type="text" id="input-code-3" maxlength="1"
                                class="input input-xs md:input-md w-8 h-8 md:w-10 md:h-10 text-center text-[8px] md:text-[14px] uppercase focus-within:outline-none focus-within:ring-0 border-0 border-b-2 rounded-none font-bold font-mono" />
                            <input type="text" id="input-code-4" maxlength="1"
                                class="input input-xs md:input-md w-8 h-8 md:w-10 md:h-10 text-center text-[8px] md:text-[14px] uppercase focus-within:outline-none focus-within:ring-0 border-0 border-b-2 rounded-none font-bold font-mono" />
                        </div>
                    </div>
                    <input type="hidden" id="livewire-search-query-input" wire:model.live="searchQuery">
                </div>

                @error('searchQuery')
                    <p class="text-warning italic text-xs mt-1 text-center">*{{ $message }}</p>
                @enderror
            </label>
            <div class="flex flex-col sm:flex-row gap-3 mt-4 w-full max-w-xs justify-center">
                <button id="search-button"
                    class="btn btn-gray bg-base-300 border-0 btn-md text-base-content rounded-xl hover:bg-base-300 flex-1"
                    wire:click="searchBooking" wire:loading.attr="disabled" wire:target="searchBooking">
                    <span class="flex items-center justify-center gap-1" wire:loading.remove wire:target="searchBooking">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                            stroke="currentColor" class="size-[1.2em]">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                        Cek
                    </span>
                    <span class="loading loading-spinner loading-md" wire:loading wire:target="searchBooking"></span>
                </button>

                <button id="scan-button" type="button"
                    class="btn btn-info border-0 btn-md text-info-content rounded-xl hover:opacity-90 flex-1">
                    <span class="flex items-center justify-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-[1.2em]">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                        </svg>
                        Scan Barcode
                    </span>
                </button>
            </div>
        </div>
    </div>

    <div class="card items-center pb-4" wire:init="load">
        <div wire:loading.flex wire:target="load" class="items-center justify-center p-10">
            <span class="loading loading-spinner loading-md"></span>
        </div>
        <div wire:loading.remove wire:target="load">
            @if ($error)
                <div class="alert bg-red-500">
                    <span>{{ $error }}</span>
                </div>
            @else
                <div wire:loading.flex wire:target="searchBooking" class="items-center justify-center p-10">
                    <span class="loading loading-spinner loading-md"></span>
                </div>

                <div wire:loading.remove wire:target="searchBooking">
                    @if ($searchError)
                        <div class="alert bg-red-500 mb-4 text-white">
                            <span>{{ $searchError }}</span>
                        </div>
                    @elseif ($bookingDetail)
                        <h2 class="text-center mb-2 font-bold"> Hasil Pencarian Kode Booking:
                            <span class="underline">
                                {{ data_get($bookingDetail, 'kode_booking') }}
                            </span>
                        </h2>
                        <div class="card max-w-xl bg-black rounded-2xl overflow-hidden">
                            <div class="bp-header bg-blue-600 text-white px-4 py-3 sm:px-6 sm:py-4">
                                <div class="flex items-center justify-between">
                                    <div class="text-[10px] font-bold uppercase opacity-80">Kode
                                        Booking</div>
                                    <div class="text-[10px] font-bold uppercase opacity-80">
                                        {{ data_get($bookingDetail, 'status') ?? '-' }}</div>
                                </div>
                                <div class="text-1xl sm:text-3xl font-black italic uppercase tracking-widest">
                                    {{ data_get($bookingDetail, 'kode_booking') ?? '-' }}
                                </div>
                            </div>
                            <div class="bp-body p-4 sm:p-6">
                                <div class="flex items-center justify-between">
                                    <h4 class="text-white sm:text-lg font-black italic uppercase">
                                        {{ data_get($bookingDetail, 'lapangan.nama_lapangan') ?? '-' }}</h4>
                                </div>
                                <div class="mt-4 grid grid-cols-3 gap-4 items-start">
                                    <div>
                                        <div class="text-2xl sm:text-3xl font-black tracking-tight text-warning">
                                            {{ \Carbon\Carbon::parse(data_get($bookingDetail, 'jam_mulai'))->format('H:i') ?? '-' }}
                                        </div>
                                        <div class="text-[10px] font-bold uppercase text-gray-400 mt-1">
                                            {{ \Carbon\Carbon::parse(data_get($bookingDetail, 'tanggal'))->format('d M Y') ?? '-' }}
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-center">
                                        <div class="h-8 sm:h-10 border-l-2 border-dashed border-base-300"></div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-2xl sm:text-3xl font-black tracking-tight text-warning">
                                            {{ \Carbon\Carbon::parse(data_get($bookingDetail, 'jam_selesai'))->format('H:i') ?? '-' }}
                                        </div>
                                        <div class="text-[10px] font-bold uppercase text-gray-400 mt-1">
                                            {{ \Carbon\Carbon::parse(data_get($bookingDetail, 'tanggal'))->format('d M Y') ?? '-' }}
                                        </div>
                                    </div>
                                </div>
                                <div class="bp-divider my-4"></div>
                                <div class="grid grid-cols-3 gap-2">
                                    <div class="col-span-2">
                                        <div class="text-[10px] font-bold uppercase text-gray-400">Tim / Nama</div>
                                        <div class="mt-1 font-black text-white italic uppercase text-xs sm:text-sm">
                                            @php
                                                $team = data_get($bookingDetail, 'nama_komunitas') ?? data_get($bookingDetail, 'pemesan.nama_komunitas');
                                                $name = data_get($bookingDetail, 'user.name') ?? (data_get($bookingDetail, 'pemesan.nama') ?? data_get($bookingDetail, 'pemesan.user.name'));
                                            @endphp
                                            @if($team && $name)
                                                {{ $team }} / {{ $name }}
                                            @else
                                                {{ $team ?? ($name ?? '-') }}
                                            @endif
                                        </div>
                                        <div class="mt-3 grid grid-cols-3 gap-3">
                                            <div>
                                                <div class="text-[10px] font-bold uppercase text-gray-400">
                                                    Pemain
                                                </div>
                                                <div
                                                    class="mt-1 font-black italic uppercase text-xs md:text-sm text-white">
                                                    {{ data_get($bookingDetail, 'jumlah_pemain') ?? '-' }}
                                                </div>
                                            </div>
                                            <div>
                                                <div class="text-[10px] font-bold uppercase text-gray-400">
                                                    Kategori
                                                </div>
                                                <div
                                                    class="mt-1 font-black italic uppercase text-xs md:text-sm text-white">
                                                    {{ data_get($bookingDetail, 'kategori_pemain') ?? '-' }}
                                                </div>
                                            </div>
                                            <div>
                                                <div class="text-[10px] font-bold uppercase text-gray-400">
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
                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                    class="size-4 sm:size-7 text-white">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
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
                                        <div class="text-[10px] font-bold uppercase text-gray-400">Dibuat
                                        </div>
                                        <div class="mt-1 text-xs text-white">
                                            {{ \Carbon\Carbon::parse(data_get($bookingDetail, 'created_at'))->format('d M Y H:i') ?? '-' }}
                                        </div>
                                    </div>
                                    <div>
                                        <div class="text-[10px] font-bold uppercase text-gray-400">Status
                                        </div>
                                        <div
                                            class="mt-1 text-xs font-black italic uppercase {{ (data_get($bookingDetail, 'status') ?? '') === 'dipesan' ? 'text-info' : 'text-warning' }}">
                                            {{ data_get($bookingDetail, 'status') ?? '-' }}
                                        </div>
                                    </div>
                                    <div>
                                        <div class="text-[10px] font-bold uppercase text-gray-400">Kode
                                        </div>
                                        <div class="mt-1 text-xs font-black italic uppercase text-white">
                                            {{ data_get($bookingDetail, 'kode_booking') ?? '-' }}</div>
                                    </div>
                                </div>
                                <div class="mt-4 rounded-xl bg-base-200 border border-dashed border-base-300 p-3">
                                    <div class="text-[10px] font-bold uppercase text-gray-400">Keterangan
                                    </div>
                                    <div class="mt-1 text-sm italic">
                                        {{ data_get($bookingDetail, 'keterangan') ?? '-' }}</div>
                                </div>
                            </div>
                            <div class="bp-footer bg-blue-600 text-info-content px-4 py-3 sm:px-6">
                                <div
                                    class="text-center text-[10px] sm:text-xs font-black italic uppercase tracking-widest">
                                    {{ data_get($bookingDetail, 'lapangan.nama_lapangan') ?? '-' }}</div>
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Scanner Barcode -->
    <div id="scanner-modal" class="fixed inset-0 z-50 hidden grid place-items-center p-4">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-base-100/80 backdrop-blur-sm" id="close-scanner-backdrop"></div>
        
        <!-- Modal Box -->
        <div class="relative w-full max-w-sm sm:max-w-md mx-4 sm:mx-0 rounded-2xl border-2 border-primary bg-base-100 shadow-2xl overflow-hidden">
            <!-- Header -->
            <div class="bg-primary text-primary-content p-4 flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-xl bg-white/20 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="size-5 text-white">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-black italic uppercase tracking-tighter text-lg text-white">
                            Scan Barcode Booking
                        </h4>
                    </div>
                </div>
                <button type="button" class="btn btn-ghost btn-circle btn-sm text-white hover:bg-white/20" id="close-scanner-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <!-- Body -->
            <div class="p-4 sm:p-6 space-y-4">
                <div id="scanner-status" class="text-xs text-center font-bold text-base-content/60 uppercase">
                    Menginisialisasi Kamera...
                </div>
                
                <div class="relative overflow-hidden rounded-xl bg-black aspect-video flex items-center justify-center border border-base-300">
                    <div id="reader" class="w-full h-full"></div>
                    <!-- CSS Target Box (Visual only, no cropping) -->
                    <div class="absolute inset-0 pointer-events-none flex items-center justify-center">
                        <div class="w-40 h-40 border-2 border-dashed border-info rounded-xl flex items-center justify-center bg-info/5">
                            <span class="text-[9px] uppercase tracking-widest text-info font-black bg-base-100/90 px-2.5 py-1 rounded shadow-md">
                                Sejajarkan QR
                            </span>
                        </div>
                    </div>
                    <!-- Scanning indicator overlay line -->
                    <div id="scanner-laser" class="absolute left-0 right-0 h-0.5 bg-red-500 shadow-[0_0_8px_#ef4444] animate-[scan_2s_linear_infinite] hidden"></div>
                </div>
                
                <div class="text-xs text-center text-base-content/50">
                    Arahkan QR Code booking ke area kamera untuk memindai secara otomatis.
                </div>
            </div>
        </div>
    </div>

    <style>
    @keyframes scan {
        0% { top: 0%; }
        50% { top: 100%; }
        100% { top: 0%; }
    }
    </style>
</div>
