<div class="flex-1 flex flex-col min-h-0 overflow-hidden bg-white">

    {{-- ══════════════════════════════════════════════════════════════════
         TOP BAR
    ══════════════════════════════════════════════════════════════════ --}}
    <div class="sticky top-0 z-30 bg-white border-b border-gray-200 shrink-0 relative">
        <div class="flex items-center gap-3 px-4 py-4">
            <a href="{{ route('webview.menu') }}" wire:navigate
                class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center shrink-0 active:scale-95 transition-transform">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="#374151" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
            </a>
            <div class="flex-1 min-w-0">
                <div class="text-[11px] text-gray-400 font-semibold uppercase tracking-widest leading-none mb-1">Kencana Arena</div>
                <div class="text-sm font-black text-gray-900">Histori Booking</div>
            </div>
        </div>

        {{-- Status Filter Tabs --}}
        <div class="flex px-4 pb-4 gap-2" wire:loading.class="opacity-50 pointer-events-none" wire:target="setStatus">
            @foreach(['dipesan' => 'Aktif', 'dibatalkan' => 'Dibatalkan', 'selesai' => 'Selesai'] as $val => $label)
                <button type="button" wire:click="setStatus('{{ $val }}')"
                    class="flex-1 py-2 rounded-xl text-[11px] font-black uppercase tracking-wide transition-all
                        {{ ($status ?? '') === $val
                            ? 'bg-blue-600 text-white shadow-md shadow-blue-200'
                            : 'bg-gray-100 text-gray-500' }}">
                    {{ $label }}
                </button>
            @endforeach
        </div>
    </div>


    {{-- ══════════════════════════════════════════════════════════════════
         CONTENT
    ══════════════════════════════════════════════════════════════════ --}}
    <div class="flex-1 px-4 py-4 relative overflow-y-auto min-h-0">

        @if($error)
            <div class="p-4 rounded-2xl bg-red-50 border border-red-100 text-sm text-red-500 font-semibold mb-4">{{ $error }}</div>
        @endif

        {{-- Loading Skeleton --}}
        <div wire:loading wire:target="setStatus,goToPage" class="space-y-3 w-full">
            @for($i = 0; $i < 3; $i++)
                <div class="w-full bg-white rounded-2xl border-2 border-gray-100 shadow-sm overflow-hidden flex animate-pulse">
                    {{-- Accent stripe left --}}
                    <div class="w-1.5 shrink-0 bg-gray-200"></div>

                    {{-- Main content --}}
                    <div class="flex-1 p-4 min-w-0">
                        {{-- Header row --}}
                        <div class="flex items-center justify-between mb-3">
                            <div class="h-5 w-16 bg-gray-200 rounded-lg"></div>
                            <div class="h-3.5 w-24 bg-gray-100 rounded"></div>
                        </div>

                        {{-- Arena name --}}
                        <div class="h-4 bg-gray-200 rounded w-44 mb-3"></div>

                        {{-- Details grid --}}
                        <div class="grid grid-cols-2 gap-y-2 gap-x-2">
                            <div class="flex items-center gap-1.5">
                                <div class="w-3.5 h-3.5 rounded bg-gray-200 shrink-0"></div>
                                <div class="h-3 bg-gray-100 rounded w-24"></div>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <div class="w-3.5 h-3.5 rounded bg-gray-200 shrink-0"></div>
                                <div class="h-3 bg-gray-100 rounded w-20"></div>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <div class="w-3.5 h-3.5 rounded bg-gray-200 shrink-0"></div>
                                <div class="h-3 bg-gray-100 rounded w-16"></div>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <div class="w-3.5 h-3.5 rounded bg-gray-200 shrink-0"></div>
                                <div class="h-3 bg-gray-100 rounded w-20"></div>
                            </div>
                        </div>
                    </div>

                    {{-- Right side --}}
                    <div class="w-14 shrink-0 bg-gray-50 flex items-center justify-center border-l-2 border-dashed border-gray-200">
                        <div class="w-2.5 h-16 bg-gray-200 rounded-full"></div>
                    </div>
                </div>
            @endfor
        </div>

        {{-- Booking List --}}
        <div class="space-y-3" wire:loading.remove wire:target="setStatus,goToPage">
            @forelse($items as $it)
                @php
                    $st      = $it['status'] ?? '';
                    $stColor = match($st) {
                        'dipesan'    => ['bg' => 'bg-blue-100',   'text' => 'text-blue-600'],
                        'dibatalkan' => ['bg' => 'bg-red-100',    'text' => 'text-red-500'],
                        'selesai'    => ['bg' => 'bg-green-100',  'text' => 'text-green-600'],
                        default      => ['bg' => 'bg-gray-100',   'text' => 'text-gray-600'],
                    };

                    // Format tanggal
                    $tglRaw = (string) ($it['tanggal'] ?? '');
                    $tglFmt = null;
                    if (preg_match('/^\d{4}-\d{2}-\d{2}/', $tglRaw)) {
                        $tglFmt   = date('d/m/Y', strtotime($tglRaw));
                        $dayIndex = date('N', strtotime($tglRaw));
                        $days     = [1=>'Senin',2=>'Selasa',3=>'Rabu',4=>'Kamis',5=>'Jumat',6=>'Sabtu',7=>'Minggu'];
                        if ($dayName = ($days[$dayIndex] ?? '')) {
                            $tglFmt = $dayName . ', ' . $tglFmt;
                        }
                    }

                    // Format jam
                    $jr  = explode(' - ', (string) ($it['jam'] ?? ''));
                    $jm  = array_map(fn($t) => substr(trim($t), 0, 5), $jr);
                    $jamFmt = implode(' – ', $jm);

                    // Dibuat pada
                    $dp = (string) ($it['dibuat_pada'] ?? '');
                    $dibuatFmt = $dp ? date('d/m/Y H:i', strtotime($dp)) : null;
                @endphp

                {{-- Ticket card (tiket sobek style) --}}
                <div class="w-full bg-white rounded-2xl border-2 border-gray-100 shadow-sm overflow-hidden flex">

                    {{-- Accent stripe left --}}
                    <div class="w-1.5 shrink-0 {{ $stColor['bg'] }}"></div>

                    {{-- Main content --}}
                    <div class="flex-1 p-4 min-w-0">
                        {{-- Header row --}}
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-[10px] font-black uppercase px-2.5 py-1 rounded-lg {{ $stColor['bg'] }} {{ $stColor['text'] }}">
                                {{ $it['status'] ?? '-' }}
                            </span>
                            <span class="text-[10px] text-gray-400 font-semibold">{{ $dibuatFmt ?? ($it['dibuat_pada'] ?? '-') }}</span>
                        </div>

                        {{-- Arena name --}}
                        <div class="text-sm font-black text-gray-900 mb-3 truncate">{{ $it['lapangan'] ?? '-' }}</div>

                        {{-- Details grid --}}
                        <div class="grid grid-cols-2 gap-y-2">
                            {{-- Tanggal --}}
                            <div class="flex items-center gap-1.5 text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3.5 h-3.5 text-gray-400 shrink-0">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                </svg>
                                <span class="text-xs font-semibold truncate">{{ $tglFmt ?: ($it['tanggal'] ?? '-') }}</span>
                            </div>

                            {{-- Jam --}}
                            <div class="flex items-center gap-1.5 text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3.5 h-3.5 text-gray-400 shrink-0">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-xs font-semibold">{{ $jamFmt ?: ($it['jam'] ?? '-') }}</span>
                            </div>

                            {{-- Jumlah Pemain --}}
                            <div class="flex items-center gap-1.5 text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3.5 h-3.5 text-gray-400 shrink-0">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                </svg>
                                <span class="text-xs font-semibold">{{ $it['jumlah_pemain'] ?? '-' }} Pemain</span>
                            </div>

                            {{-- Jenis --}}
                            @php
                                $jenisRaw   = (string) ($it['jenis'] ?? '');
                                $jenisLabel = match($jenisRaw) {
                                    'fun_match'      => 'Fun Match',
                                    'latihan'        => 'Latihan',
                                    'turnamen_kecil' => 'Turnamen Kecil',
                                    default          => ucwords(str_replace('_', ' ', $jenisRaw)),
                                };
                            @endphp
                            <div class="flex items-center gap-1.5 text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3.5 h-3.5 text-gray-400 shrink-0">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625z" />
                                </svg>
                                <span class="text-xs font-semibold">{{ $jenisLabel ?: '-' }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Right side — booking code (rotated) --}}
                    <div class="relative w-14 shrink-0 bg-gray-50 flex flex-col justify-center items-center border-l-2 border-dashed border-gray-200 px-1">
                        <div style="writing-mode: vertical-rl; transform: rotate(180deg);"
                            class="text-[10px] font-black uppercase tracking-widest text-gray-500">
                            {{ $it['kode_booking'] ?? '-' }}
                        </div>
                    </div>
                </div>

            @empty
                <div class="py-16 text-center">
                    <div class="text-5xl mb-4">📋</div>
                    <div class="text-sm font-black text-gray-700">Belum Ada Histori</div>
                    <div class="text-xs text-gray-400 mt-1">Histori booking Anda akan muncul di sini</div>
                    <div class="mt-8">
                        <a href="{{ route('webview.pesan') }}" wire:navigate
                            class="inline-flex items-center gap-2 px-6 py-3.5 rounded-2xl bg-blue-600 text-white font-black text-sm shadow-lg shadow-blue-200 active:scale-95 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Pesan Sekarang
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($lastPage > 1)
            <div class="flex items-center justify-between mt-5 gap-2"
                wire:loading.class="opacity-0 pointer-events-none" wire:target="goToPage">
                <button class="flex-1 py-3 rounded-xl bg-gray-100 text-gray-700 font-black text-xs uppercase"
                    wire:click="goToPage({{ max(1, $currentPage - 1) }})"
                    wire:loading.attr="disabled"
                    @disabled($currentPage <= 1)>
                    ← Sebelumnya
                </button>
                <div class="text-xs text-gray-400 font-bold shrink-0">{{ $currentPage }} / {{ $lastPage }}</div>
                <button class="flex-1 py-3 rounded-xl bg-gray-100 text-gray-700 font-black text-xs uppercase"
                    wire:click="goToPage({{ min($lastPage, $currentPage + 1) }})"
                    wire:loading.attr="disabled"
                    @disabled($currentPage >= $lastPage)>
                    Berikutnya →
                </button>
            </div>
        @endif

        <div class="pb-8"></div>
    </div>

</div>
