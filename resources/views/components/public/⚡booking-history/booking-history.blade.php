<div class="mt-4 sm:mt-8" wire:init="load">
    @if ($ready)
        <div class="w-full" x-transition>
            <!-- Header Section -->
            <div class="mb-8 px-2 flex items-center gap-4">
                <a href="/" wire:navigate
                    class="btn btn-circle btn-ghost btn-sm sm:btn-md border-2 border-base-300 hover:border-info hover:text-info transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                        stroke="currentColor" class="size-5 sm:size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                </a>
                <div>
                    <h2 class="text-xl sm:text-2xl font-black italic uppercase tracking-tighter text-base-content">
                        History <span class="text-info">Booking</span>
                    </h2>
                    <p
                        class="text-[10px] sm:text-xs font-medium text-base-content/60 uppercase tracking-widest mt-0.5 sm:mt-1">
                        Data history booking kamu
                    </p>
                </div>
            </div>

            {{-- Section konten booking history --}}

            <div class="w-full max-w-5xl mx-auto">
                <div class="relative">
                    @if ($error)
                        <div class="alert alert-error mb-4">
                            <span>{{ $error }}</span>
                        </div>
                    @endif

                    <div class="flex justify-center mb-6" wire:loading.class="opacity-50 pointer-events-none" wire:target="setStatus">
                        <div class="flex bg-base-200/50 p-1.5 rounded-full border border-base-300 gap-1 w-full sm:w-auto">
                            <button type="button" 
                                class="btn btn-sm sm:btn-md rounded-full border-none flex-1 sm:flex-none uppercase font-black italic text-[10px] sm:text-xs px-4 sm:px-6 {{ ($status ?? '') === 'dipesan' ? 'btn-info text-info-content shadow-md' : 'btn-ghost text-base-content/70 hover:bg-base-300/50' }}"
                                wire:click="setStatus('dipesan')">
                                Dipesan
                            </button>
                            <button type="button" 
                                class="btn btn-sm sm:btn-md rounded-full border-none flex-1 sm:flex-none uppercase font-black italic text-[10px] sm:text-xs px-4 sm:px-6 {{ ($status ?? '') === 'dibatalkan' ? 'btn-info text-info-content shadow-md' : 'btn-ghost text-base-content/70 hover:bg-base-300/50' }}"
                                wire:click="setStatus('dibatalkan')">
                                Dibatalkan
                            </button>
                            <button type="button" 
                                class="btn btn-sm sm:btn-md rounded-full border-none flex-1 sm:flex-none uppercase font-black italic text-[10px] sm:text-xs px-4 sm:px-6 {{ ($status ?? '') === 'selesai' ? 'btn-info text-info-content shadow-md' : 'btn-ghost text-base-content/70 hover:bg-base-300/50' }}"
                                wire:click="setStatus('selesai')">
                                Selesai
                            </button>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4"
                        wire:loading.class="opacity-0 pointer-events-none" wire:target="applyFilter,goToPage">
                        @forelse ($items as $it)
                            <a wire:navigate href="/booking-detail/{{ $it['kode_booking'] ?? '' }}"
                                class="block w-full p-4 rounded-2xl bg-base-100 border-2 border-base-200 shadow-lg hover:border-info hover:shadow-info/20 transition-all">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <div
                                            class="w-fit text-[10px] font-black uppercase italic px-1.5 py-0.5 rounded bg-info text-info-content -skew-x-12">
                                            {{ $it['kode_booking'] ?? '-' }}
                                        </div>
                                        <h4 class="text-base font-black italic uppercase mt-2 leading-none">
                                            {{ $it['lapangan'] ?? '-' }}
                                        </h4>
                                        <p class="text-xs text-warning mt-1">
                                            {{ $it['tanggal'] ?? '-' }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <span
                                            class="text-xs font-black italic {{ ($it['status'] ?? '') === 'dipesan' ? 'text-info' : 'text-warning' }}">
                                            {{ $it['status'] ?? '-' }}
                                        </span>
                                        <div class="text-[10px] text-base-content/50 mt-2">
                                            @php
                                                $dp = (string) ($it['dibuat_pada'] ?? '');
                                                $dibuatFmt = $dp ? date('d-m-Y H:i', strtotime($dp)) : null;
                                            @endphp
                                            {{ $dibuatFmt ?? ($it['dibuat_pada'] ?? '-') }}
                                        </div>
                                        @php
                                            $jr = explode(' - ', (string) ($it['jam'] ?? ''));
                                            $jm = [];
                                            foreach ($jr as $t) {
                                                $t = trim($t);
                                                $jm[] = substr($t, 0, 5);
                                            }
                                            $jamMenit = implode(' - ', $jm);
                                        @endphp
                                        <p class="text-xs font-bold text-warning">
                                            <span class="uppercase text-base-content">
                                                jam
                                            </span>
                                            {{ $jamMenit ?: '-' }}
                                        </p>
                                    </div>
                                </div>
                                <div
                                    class="flex justify-between gap-3 mt-4 bg-base-200 border border-dashed border-base-300 p-2 rounded-xl">
                                    <div class="flex flex-col">
                                        <span class="text-[10px] font-bold uppercase text-base-content/50">
                                            Pemain</span>
                                        <span class="font-black italic uppercase text-sm">
                                            {{ $it['jumlah_pemain'] ?? '-' }}
                                        </span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span
                                            class="text-[10px] font-bold uppercase text-base-content/50">Kategori</span>
                                        <span class="font-black italic uppercase text-sm">
                                            {{ $it['kategori'] ?? '-' }}
                                        </span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-[10px] font-bold uppercase text-base-content/50">Jenis</span>
                                        <span class="font-black italic uppercase text-sm">
                                            @php
                                                $jenisRaw = (string) ($it['jenis'] ?? '');
                                                $jenisAlias = match ($jenisRaw) {
                                                    'fun_match' => 'FUN MATCH',
                                                    'latihan' => 'LATIHAN',
                                                    'turnamen_kecil' => 'TURNAMEN KECIL',
                                                    default => strtoupper(str_replace('_', ' ', $jenisRaw)),
                                                };
                                            @endphp
                                            {{ $jenisAlias ?: '-' }}
                                        </span>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div
                                class="w-full p-6 rounded-2xl bg-base-100 border-2 border-base-200 text-center lg:col-span-2">
                                <span class="text-sm font-bold uppercase text-base-content/60">Belum ada history
                                    booking</span>
                            </div>
                        @endforelse
                    </div>
                    <div class="flex items-center gap-2 mt-4" wire:loading.class="opacity-0 pointer-events-none"
                        wire:target="applyFilter,goToPage">
                        <button class="btn btn-sm" wire:click="goToPage({{ max(1, $currentPage - 1) }})"
                            wire:loading.attr="disabled" @disabled($currentPage <= 1)>
                            « Prev
                        </button>
                        <div class="join">
                            @for ($i = 1; $i <= $lastPage; $i++)
                                <button
                                    class="join-item btn btn-sm {{ $i === $currentPage ? 'btn-info text-info-content' : 'btn-ghost' }}"
                                    wire:click="goToPage({{ $i }})" wire:loading.attr="disabled">
                                    {{ $i }}
                                </button>
                            @endfor
                        </div>
                        <button class="btn btn-sm" wire:click="goToPage({{ min($lastPage, $currentPage + 1) }})"
                            wire:loading.attr="disabled" @disabled($currentPage >= $lastPage)>
                            Next »
                        </button>
                    </div>
                    <div wire:loading wire:target="goToPage,applyFilter" class="absolute inset-0 z-10 rounded-xl">
                        <div class="space-y-4">
                            <!-- Filter Bar Skeleton -->
                            <div class="flex justify-center mb-6">
                                <div class="flex bg-base-200/50 p-1.5 rounded-full border border-base-300 gap-1 w-full sm:w-auto animate-pulse">
                                    <div class="h-8 sm:h-10 bg-base-300 w-24 sm:w-32 rounded-full flex-1 sm:flex-none"></div>
                                    <div class="h-8 sm:h-10 bg-base-300 w-24 sm:w-32 rounded-full flex-1 sm:flex-none"></div>
                                    <div class="h-8 sm:h-10 bg-base-300 w-24 sm:w-32 rounded-full flex-1 sm:flex-none"></div>
                                </div>
                            </div>
                            <!-- List Grid Skeleton -->
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 animate-pulse">
                                @for ($i = 0; $i < 4; $i++)
                                    <div class="w-full p-4 rounded-2xl bg-base-200 border-2 border-base-300/30">
                                        <div class="flex justify-between items-start">
                                            <div class="space-y-2">
                                                <div class="h-3 bg-base-300 w-24 rounded"></div>
                                                <div class="h-5 bg-base-300 w-40 rounded"></div>
                                                <div class="h-4 bg-base-300 w-48 rounded"></div>
                                            </div>
                                            <div class="space-y-2">
                                                <div class="h-4 bg-base-300 w-16 rounded"></div>
                                                <div class="h-3 bg-base-300 w-24 rounded"></div>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-3 gap-3 mt-4">
                                            <div class="h-4 bg-base-300 w-20 rounded"></div>
                                            <div class="h-4 bg-base-300 w-20 rounded"></div>
                                            <div class="h-4 bg-base-300 w-20 rounded"></div>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                            <!-- Pagination Skeleton -->
                            <div class="join mt-4 gap-2">
                                <div class="join-item h-8 bg-base-300 w-16 rounded-xl"></div>
                                <div class="join-item h-8 bg-base-300 w-10 rounded-xl"></div>
                                <div class="join-item h-8 bg-base-300 w-16 rounded-xl"></div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
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

                <div class="w-full max-w-5xl mx-auto">
                    <div class="relative">
                        <!-- Filter Bar Skeleton -->
                        <div class="flex justify-center mb-6">
                            <div class="flex bg-base-200/50 p-1.5 rounded-full border border-base-300 gap-1 w-full sm:w-auto animate-pulse">
                                <div class="h-8 sm:h-10 bg-base-300 w-24 sm:w-32 rounded-full flex-1 sm:flex-none"></div>
                                <div class="h-8 sm:h-10 bg-base-300 w-24 sm:w-32 rounded-full flex-1 sm:flex-none"></div>
                                <div class="h-8 sm:h-10 bg-base-300 w-24 sm:w-32 rounded-full flex-1 sm:flex-none"></div>
                            </div>
                        </div>
                        <!-- List Grid Skeleton -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                            @for ($i = 0; $i < 4; $i++)
                                <div class="w-full p-4 rounded-2xl bg-base-200 border-2 border-base-300/30">
                                    <div class="flex justify-between items-start">
                                        <div class="space-y-2">
                                            <div class="h-3 bg-base-300 w-24 rounded"></div>
                                            <div class="h-5 bg-base-300 w-40 rounded"></div>
                                            <div class="h-4 bg-base-300 w-48 rounded"></div>
                                        </div>
                                        <div class="space-y-2">
                                            <div class="h-4 bg-base-300 w-16 rounded"></div>
                                            <div class="h-3 bg-base-300 w-24 rounded"></div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-3 gap-3 mt-4">
                                        <div class="h-4 bg-base-300 w-20 rounded"></div>
                                        <div class="h-4 bg-base-300 w-20 rounded"></div>
                                        <div class="h-4 bg-base-300 w-20 rounded"></div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                        <!-- Pagination Skeleton -->
                        <div class="join mt-4 gap-2">
                            <div class="join-item h-8 bg-base-300 w-16 rounded-xl"></div>
                            <div class="join-item h-8 bg-base-300 w-10 rounded-xl"></div>
                            <div class="join-item h-8 bg-base-300 w-16 rounded-xl"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

