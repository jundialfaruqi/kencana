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

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4" wire:init="load">
        <div wire:loading.flex wire:target="load" class="items-center justify-center p-10 md:col-span-2">
            <span class="loading loading-spinner loading-md"></span>
        </div>
        <div wire:loading.remove wire:target="load" class="md:col-span-2">
            @if ($error)
                <div class="alert alert-error mb-4">
                    <span>{{ $error }}</span>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-start">
                    <!-- Card 1: Pemesan & Lapangan -->
                    <div class="card bg-base-100 border-2 border-dashed border-base-300">
                        <div class="card-body">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <h2 class="card-title">{{ data_get($detail, 'lapangan.nama', '-') }}</h2>
                                    <p class="text-sm text-base-content/70 mt-1">
                                        Dibuat pada: {{ data_get($detail, 'dibuat_pada', '-') }}
                                    </p>
                                </div>
                            </div>
                            <div class="mt-4 space-y-3 text-sm">
                                <div class="flex items-start gap-3 p-3 rounded-xl bg-base-200 border border-base-300">
                                    <div class="bg-secondary p-2 rounded-3xl">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-5 text-white">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-semibold text-base-content/60">Nama / Tim</p>
                                        <p class="text-sm font-medium text-base-content truncate">
                                            {{ data_get($detail, 'pemesan.nama', '-') }}
                                        </p>
                                        <div class="mt-1">
                                            <span class="font-mono text-xs">Email:
                                                {{ data_get($detail, 'pemesan.email', '-') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-3 gap-3">
                                    <div class="rounded-xl border border-base-200 p-3">
                                        <div class="text-xs font-semibold text-base-content/60">Jumlah Pemain</div>
                                        <div class="text-sm font-medium">
                                            {{ data_get($detail, 'detail.jumlah_pemain', '-') }}
                                        </div>
                                    </div>
                                    <div class="rounded-xl border border-base-200 p-3">
                                        <div class="text-xs font-semibold text-base-content/60">Kategori</div>
                                        <div class="text-sm font-medium">
                                            {{ data_get($detail, 'detail.kategori', '-') }}
                                        </div>
                                    </div>
                                    <div class="rounded-xl border border-base-200 p-3">
                                        <div class="text-xs font-semibold text-base-content/60">Jenis</div>
                                        <div class="text-sm font-medium">
                                            {{ data_get($detail, 'detail.jenis', '-') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2: Informasi Booking -->
                    <div
                        class="card bg-base-100 rounded-2xl overflow-hidden border-2 border-base-300 border-dashed shadow-lg">
                        <!-- Ticket Header -->
                        <div class="px-4 py-3 sm:px-6 sm:py-4 bg-info text-info-content">
                            <div class="flex items-center justify-between">
                                <div class="text-[10px] font-bold uppercase opacity-80">Kode Booking</div>
                                <span
                                    class="{{ data_get($detail, 'status') === 'dipesan' ? 'bg-info text-info-content' : (data_get($detail, 'status') === 'selesai' ? 'bg-success text-success-content' : 'bg-error text-error-content') }} rounded-md text-center text-[10px] sm:text-xs px-2 py-0.5">
                                    {{ ucfirst(data_get($detail, 'status', '-')) }}
                                </span>
                            </div>
                            <div class="text-xl sm:text-2xl font-black italic uppercase tracking-widest mt-1">
                                {{ data_get($detail, 'kode_booking', '-') }}
                            </div>
                        </div>
                        <!-- Ticket Body -->
                        <div class="p-4 sm:p-6">
                            <div class="grid grid-cols-3 gap-4 items-start">
                                <div>
                                    <div class="text-[10px] font-bold uppercase text-base-content/50">Tanggal
                                    </div>
                                    <div class="mt-1 font-black italic uppercase text-sm">
                                        {{ data_get($detail, 'tanggal', '-') }}
                                    </div>
                                </div>
                                <div class="flex items-center justify-center">
                                    <div class="h-8 sm:h-10 border-l-2 border-dashed border-base-300"></div>
                                </div>
                                <div class="text-right">
                                    <div class="text-[10px] font-bold uppercase text-base-content/50">Jam
                                    </div>
                                    <div class="text-sm sm:text-base font-black tracking-tight text-base-content mt-1">
                                        {{ $jamFmt ? \Illuminate\Support\Str::of($jamFmt)->replace(' ', ' - ') : '-' }}
                                    </div>
                                    <div class="text-[10px] font-bold uppercase text-base-content/60">
                                        Durasi {{ data_get($detail, 'durasi_menit', '-') }} menit
                                    </div>
                                </div>
                            </div>
                            <div class="my-4 border-t border-dashed border-base-300"></div>
                            <div class="rounded-xl bg-base-200 border border-dashed border-base-300 p-3">
                                <div class="text-[10px] font-bold uppercase text-base-content/50">Keterangan
                                </div>
                                <div class="mt-1 text-sm italic">{{ data_get($detail, 'keterangan', '-') }}
                                </div>
                            </div>
                        </div>
                        <!-- Ticket Footer -->
                        <div class="px-4 py-3 sm:px-6 bg-base-200">
                            <div class="flex items-end gap-1 h-6">
                                <div class="w-1 h-4 bg-base-300"></div>
                                <div class="w-1 h-6 bg-base-300"></div>
                                <div class="w-1 h-3 bg-base-300"></div>
                                <div class="w-1 h-5 bg-base-300"></div>
                                <div class="w-1 h-4 bg-base-300"></div>
                                <div class="w-1 h-6 bg-base-300"></div>
                                <div class="w-1 h-3 bg-base-300"></div>
                                <div class="w-1 h-5 bg-base-300"></div>
                                <div class="w-1 h-4 bg-base-300"></div>
                                <div class="w-1 h-6 bg-base-300"></div>
                                <div class="w-1 h-3 bg-base-300"></div>
                                <div class="w-1 h-5 bg-base-300"></div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
