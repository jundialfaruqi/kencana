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

            <div class="w-full px-2">
                <div class="relative">
                    @if ($error)
                        <div class="alert alert-error mb-4">
                            <span>{{ $error }}</span>
                        </div>
                    @endif

                    <div class="flex justify-center mb-6" wire:loading.class="opacity-50 pointer-events-none"
                        wire:target="setStatus">
                        <div
                            class="flex bg-base-200/50 p-1.5 rounded-full border border-base-300 gap-1 w-full sm:w-auto">
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
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4"
                        wire:loading.class="opacity-0 pointer-events-none" wire:target="applyFilter,goToPage">
                        @forelse ($items as $it)
                            <a wire:navigate href="/booking-detail/{{ $it['kode_booking'] ?? '' }}"
                                style="--cut-pos: 4.75rem; -webkit-mask-image: radial-gradient(circle 10px at calc(100% - var(--cut-pos)) 0, transparent 10px, black 10.5px), radial-gradient(circle 10px at calc(100% - var(--cut-pos)) 100%, transparent 10px, black 10.5px); -webkit-mask-size: 100% 51%; -webkit-mask-position: top, bottom; -webkit-mask-repeat: no-repeat; mask-image: radial-gradient(circle 10px at calc(100% - var(--cut-pos)) 0, transparent 10px, black 10.5px), radial-gradient(circle 10px at calc(100% - var(--cut-pos)) 100%, transparent 10px, black 10.5px); mask-size: 100% 51%; mask-position: top, bottom; mask-repeat: no-repeat;"
                                class="block w-full bg-base-100 rounded-2xl border-2 border-base-200 shadow-sm hover:border-info hover:shadow-info/20 transition-all flex flex-row relative group sm:[--cut-pos:5.75rem]">

                                <!-- Left Section (Main Details) -->
                                <div class="flex-1 p-3 sm:p-4 flex flex-col justify-between min-w-0">
                                    <!-- Header -->
                                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-2 sm:mb-4 gap-2 sm:gap-4">
                                        <!-- Status Badge -->
                                        <div
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-[10px] sm:text-xs font-black uppercase tracking-wider {{ ($it['status'] ?? '') === 'dipesan' ? 'bg-info/10 text-info' : (($it['status'] ?? '') === 'dibatalkan' ? 'bg-error/10 text-error' : 'bg-success/10 text-success') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                fill="currentColor" class="w-4 h-4">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-13a.75.75 0 00-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 000-1.5h-3.25V5z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ $it['status'] ?? '-' }}
                                        </div>

                                        <!-- Created Date -->
                                        @php
                                            $dp = (string) ($it['dibuat_pada'] ?? '');
                                            $dibuatFmt = $dp ? date('Y-m-d H:i', strtotime($dp)) : null;
                                        @endphp
                                        <span class="text-[10px] sm:text-xs font-medium text-base-content/50">
                                            {{ $dibuatFmt ?? ($it['dibuat_pada'] ?? '-') }}
                                        </span>
                                    </div>

                                    <!-- Title -->
                                    <h4 class="text-sm sm:text-lg font-extrabold text-base-content mb-3 sm:mb-4 leading-tight truncate">
                                        {{ $it['lapangan'] ?? '-' }}
                                    </h4>

                                    <!-- Details Grid -->
                                    <div class="grid grid-cols-2 gap-y-2 gap-x-2 sm:gap-y-2 sm:gap-x-3">
                                        <!-- Date -->
                                        <div class="flex items-center gap-1 sm:gap-2 text-base-content/70">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-3.5 h-3.5 sm:w-5 sm:h-5 opacity-70">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                            </svg>
                                            <span class="text-[9px] sm:text-sm font-medium leading-none">{{ $it['tanggal'] ?? '-' }}</span>
                                        </div>

                                        <!-- Time -->
                                        @php
                                            $jr = explode(' - ', (string) ($it['jam'] ?? ''));
                                            $jm = [];
                                            foreach ($jr as $t) {
                                                $t = trim($t);
                                                $jm[] = substr($t, 0, 5);
                                            }
                                            $jamFmt = implode(' - ', $jm);
                                        @endphp
                                        <div class="flex items-center gap-1 sm:gap-2 text-base-content/70">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-3.5 h-3.5 sm:w-5 sm:h-5 opacity-70">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span
                                                class="text-[9px] sm:text-sm font-medium leading-none">{{ $jamFmt ?: $it['jam'] ?? '-' }}</span>
                                        </div>

                                        <!-- Players -->
                                        <div class="flex items-center gap-1 sm:gap-2 text-base-content/70">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-3.5 h-3.5 sm:w-5 sm:h-5 opacity-70">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                            </svg>
                                            <span class="text-[9px] sm:text-sm font-medium leading-none">{{ $it['jumlah_pemain'] ?? '-' }}
                                                <span class="hidden sm:inline">Pemain</span></span>
                                        </div>

                                        <!-- Jenis -->
                                        @php
                                            $jenisRaw = (string) ($it['jenis'] ?? '');
                                            $jenisAlias = match ($jenisRaw) {
                                                'fun_match' => 'FUN MATCH',
                                                'latihan' => 'LATIHAN',
                                                'turnamen_kecil' => 'TURNAMEN KECIL',
                                                default => strtoupper(str_replace('_', ' ', $jenisRaw)),
                                            };
                                        @endphp
                                        <div class="flex items-center gap-1 sm:gap-2 text-base-content/70">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-3.5 h-3.5 sm:w-5 sm:h-5 opacity-70">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                                            </svg>
                                            <span
                                                class="text-[9px] sm:text-sm font-medium capitalize leading-none">{{ strtolower($jenisAlias ?: '-') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Perforated Line -->
                                <div class="flex flex-col justify-center items-center relative w-6 shrink-0">
                                    <div class="border-l-2 border-dashed border-base-300 w-px flex-grow my-3 sm:my-4"></div>
                                </div>


                                <!-- Right Section (ID) -->
                                <div
                                    class="w-16 sm:w-20 p-3 sm:p-4 shrink-0 flex flex-col justify-center items-center bg-base-100/50">
                                    <div style="writing-mode: vertical-rl; transform: rotate(180deg);"
                                        class="text-xs sm:text-base font-black uppercase tracking-widest text-base-content/70 group-hover:text-info transition-colors">
                                        {{ $it['kode_booking'] ?? '-' }}
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
                                <div
                                    class="flex bg-base-200/50 p-1.5 rounded-full border border-base-300 gap-1 w-full sm:w-auto animate-pulse">
                                    <div class="h-8 sm:h-10 bg-base-300 w-24 sm:w-32 rounded-full flex-1 sm:flex-none">
                                    </div>
                                    <div class="h-8 sm:h-10 bg-base-300 w-24 sm:w-32 rounded-full flex-1 sm:flex-none">
                                    </div>
                                    <div class="h-8 sm:h-10 bg-base-300 w-24 sm:w-32 rounded-full flex-1 sm:flex-none">
                                    </div>
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

            <div class="w-full px-2">
                <div class="relative">
                    <!-- Filter Bar Skeleton -->
                    <div class="flex justify-center mb-6">
                        <div
                            class="flex bg-base-200/50 p-1.5 rounded-full border border-base-300 gap-1 w-full sm:w-auto animate-pulse">
                            <div class="h-8 sm:h-10 bg-base-300 w-24 sm:w-32 rounded-full flex-1 sm:flex-none"></div>
                            <div class="h-8 sm:h-10 bg-base-300 w-24 sm:w-32 rounded-full flex-1 sm:flex-none"></div>
                            <div class="h-8 sm:h-10 bg-base-300 w-24 sm:w-32 rounded-full flex-1 sm:flex-none"></div>
                        </div>
                    </div>
                    <!-- List Grid Skeleton -->
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                        @for ($i = 0; $i < 6; $i++)
                            <div style="--cut-pos: 4.75rem; -webkit-mask-image: radial-gradient(circle 10px at calc(100% - var(--cut-pos)) 0, transparent 10px, black 10.5px), radial-gradient(circle 10px at calc(100% - var(--cut-pos)) 100%, transparent 10px, black 10.5px); -webkit-mask-size: 100% 51%; -webkit-mask-position: top, bottom; -webkit-mask-repeat: no-repeat; mask-image: radial-gradient(circle 10px at calc(100% - var(--cut-pos)) 0, transparent 10px, black 10.5px), radial-gradient(circle 10px at calc(100% - var(--cut-pos)) 100%, transparent 10px, black 10.5px); mask-size: 100% 51%; mask-position: top, bottom; mask-repeat: no-repeat;"
                                class="w-full bg-base-200 rounded-2xl border-2 border-base-300/30 flex flex-row relative sm:[--cut-pos:5.75rem]">
                                <!-- Left Section -->
                                <div class="flex-1 p-3 sm:p-4 flex flex-col justify-between min-w-0">
                                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-2 sm:mb-3 gap-2 sm:gap-3">
                                        <div class="h-6 bg-base-300 w-16 sm:w-24 rounded-xl"></div>
                                        <div class="h-3 bg-base-300 w-20 sm:w-24 rounded"></div>
                                    </div>
                                    <div class="h-5 sm:h-6 bg-base-300 w-32 sm:w-48 rounded mb-3 sm:mb-4"></div>
                                    <div class="grid grid-cols-2 gap-2 sm:gap-3">
                                        <div class="h-4 bg-base-300 w-full rounded"></div>
                                        <div class="h-4 bg-base-300 w-full rounded"></div>
                                        <div class="h-4 bg-base-300 w-full rounded"></div>
                                        <div class="h-4 bg-base-300 w-full rounded"></div>
                                    </div>
                                </div>
                                <!-- Perforated Line -->
                                <div class="flex flex-col justify-center items-center relative w-6 shrink-0">
                                    <div class="border-l-2 border-dashed border-base-300/50 w-px flex-grow my-3 sm:my-4"></div>
                                </div>
                                <!-- Right Section -->
                                <div class="w-16 sm:w-20 p-3 sm:p-4 shrink-0 flex flex-col justify-center items-center">
                                    <div class="w-4 bg-base-300 h-24 sm:h-28 rounded"></div>
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
