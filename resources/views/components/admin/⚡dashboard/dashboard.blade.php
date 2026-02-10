<div>
    <!-- Page Title & Breadcrumbs -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
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
    </div>
    <div class="mb-4 max-w-xl mx-auto">
        <h1 class="font-black text-center mb-2 text-primary/80">
            Cek Kode Booking...
        </h1>
        <label class="form-control w-full">
            <div class="join w-full">
                <input type="text"
                    class="input input-md join-item w-full focus-within:outline-none focus-within:ring-0 rounded-l-full"
                    placeholder="Masukkan kode booking" wire:model.live="searchQuery" />
                <button class="btn btn-primary btn-md join-item text-white rounded-r-full" wire:click="searchBooking"
                    wire:loading.attr="disabled" wire:target="searchBooking">
                    <span wire:loading.remove wire:target="searchBooking">Search</span>
                    <span class="loading loading-spinner loading-md" wire:loading wire:target="searchBooking"></span>
                </button>
            </div>

            @error('searchQuery')
                <p class="text-warning italic text-xs mt-1">*{{ $message }}</p>
            @enderror
        </label>
    </div>

    <div class="card" wire:init="load">
        <div class="card-body p-0">
            <div wire:loading.flex wire:target="load" class="items-center justify-center p-10">
                <span class="loading loading-spinner loading-md"></span>
            </div>
            <div wire:loading.remove wire:target="load">
                @if ($error)
                    <div class="alert alert-error">
                        <span>{{ $error }}</span>
                    </div>
                @else
                    <div wire:loading.flex wire:target="searchBooking" class="items-center justify-center p-10">
                        <span class="loading loading-spinner loading-md"></span>
                    </div>

                    <div wire:loading.remove wire:target="searchBooking">
                        @if ($searchError)
                            <div class="alert alert-error mb-4">
                                <span>{{ $searchError }}</span>
                            </div>
                        @elseif ($bookingDetail)
                            {{-- Booking Detail Card --}}
                            <div class="card bg-black border-2 border-base-200 rounded-2xl overflow-hidden">
                                <div class="bp-header bg-blue-500 text-white px-4 py-3 sm:px-6 sm:py-4">
                                    <div class="flex items-center justify-between">
                                        <div class="text-[10px] font-bold uppercase opacity-80">Kode Booking</div>
                                        <div class="text-[10px] font-bold uppercase opacity-80">
                                            {{ data_get($bookingDetail, 'status') ?? '-' }}</div>
                                    </div>
                                    <div class="text-2xl sm:text-3xl font-black italic uppercase tracking-widest">
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
                                            <div class="text-[10px] font-bold uppercase text-gray-400">Tim /
                                                Nama</div>
                                            <div class="mt-1 font-black text-white italic uppercase">
                                                {{ data_get($bookingDetail, 'nama_komunitas') ?? '-' }}</div>
                                            <div class="mt-3 grid grid-cols-3 gap-3">
                                                <div>
                                                    <div class="text-[10px] font-bold uppercase text-gray-400">
                                                        Pemain
                                                    </div>
                                                    <div class="mt-1 font-black italic uppercase text-sm text-white">
                                                        {{ data_get($bookingDetail, 'jumlah_pemain') ?? '-' }}</div>
                                                </div>
                                                <div>
                                                    <div class="text-[10px] font-bold uppercase text-gray-400">
                                                        Kategori
                                                    </div>
                                                    <div class="mt-1 font-black italic uppercase text-sm text-white">
                                                        {{ data_get($bookingDetail, 'kategori_pemain') ?? '-' }}</div>
                                                </div>
                                                <div>
                                                    <div class="text-[10px] font-bold uppercase text-gray-400">
                                                        Jenis
                                                    </div>
                                                    <div class="mt-1 font-black italic uppercase text-sm text-white">
                                                        {{ data_get($bookingDetail, 'jenis_permainan') ?? '-' }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-span-1 flex items-center justify-center">
                                            <div
                                                class="relative w-12 h-12 sm:w-23 sm:h-23 rounded-full bg-blue-500/10 flex items-center justify-center">

                                                <!-- LOGO -->
                                                <img src="{{ asset('assets/images/logo/amanarena-logo.webp') }}"
                                                    alt="Logo Aman Arena"
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
                                <div class="bp-footer bg-blue-500 text-info-content px-4 py-3 sm:px-6">
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
    </div>
</div>
