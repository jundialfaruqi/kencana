<div class="mt-4 sm:mt-8" wire:init="load">
    @if ($ready)
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
                        Informasi lengkap booking arena
                    </p>
                </div>
            </div>

            <div class="boarding-pass border-2 border-base-200 bg-base-100 rounded-2xl overflow-hidden shadow-lg"
                id="detail-card">
                <div class="bp-header bg-info text-warning-content px-4 py-3 sm:px-6 sm:py-4">
                    <div class="flex items-center justify-between">
                        <div class="text-[10px] font-bold uppercase opacity-80">Kode Booking</div>
                        <div class="text-[10px] font-bold uppercase opacity-80">{{ data_get($detail, 'status') ?? '-' }}
                        </div>
                    </div>
                    <div class="text-2xl sm:text-3xl font-black italic uppercase tracking-widest">
                        {{ $detail['kode_booking'] ?? $kode_booking }}</div>
                </div>
                <div class="bp-body p-4 sm:p-6">
                    @php
                        $tgl = (string) ($detail['tanggal'] ?? '');
                        $tglFmt = null;
                        if (preg_match('/^\d{4}-\d{2}-\d{2}/', $tgl)) {
                            $tglFmt = date('d/m/Y', strtotime($tgl));
                        } else {
                            $parts = explode(',', $tgl);
                            $rest = trim(end($parts));
                            $tok = preg_split('/\s+/', $rest);
                            $bulanMap = [
                                'januari' => 1,
                                'februari' => 2,
                                'maret' => 3,
                                'april' => 4,
                                'mei' => 5,
                                'juni' => 6,
                                'juli' => 7,
                                'agustus' => 8,
                                'september' => 9,
                                'oktober' => 10,
                                'november' => 11,
                                'desember' => 12,
                            ];
                            if (count($tok) >= 3) {
                                $d = (int) preg_replace('/\D/', '', $tok[0]);
                                $b = $bulanMap[strtolower($tok[1])] ?? null;
                                $y = (int) preg_replace('/\D/', '', $tok[2]);
                                if ($d && $b && $y) {
                                    $tglFmt = sprintf('%02d/%02d/%04d', $d, $b, $y);
                                }
                            }
                        }
                        $mulai = data_get($detail, 'jam.mulai');
                        $selesai = data_get($detail, 'jam.selesai');
                    @endphp
                    <div class="flex items-center justify-between">
                        <h4 class="text-base sm:text-lg font-black italic uppercase">
                            {{ data_get($detail, 'lapangan.nama') ?? '-' }}</h4>
                    </div>

                    <div class="mt-4 grid grid-cols-3 gap-4 items-start">
                        <div>
                            <div class="text-2xl sm:text-3xl font-black tracking-tight text-warning">{{ $mulai ?? '-' }}
                            </div>
                            <div class="text-[10px] font-bold uppercase text-base-content/60 mt-1">
                                {{ $tglFmt ?? ($tgl ?? '-') }}</div>
                        </div>
                        <div class="flex items-center justify-center">
                            <div class="h-8 sm:h-10 border-l-2 border-dashed border-base-300"></div>
                        </div>
                        <div class="text-right">
                            <div class="text-2xl sm:text-3xl font-black tracking-tight text-warning">
                                {{ $selesai ?? '-' }}</div>
                            <div class="text-[10px] font-bold uppercase text-base-content/60 mt-1">
                                {{ $tglFmt ?? ($tgl ?? '-') }}</div>
                        </div>
                    </div>
                    <div class="bp-divider my-4"></div>

                    <div class="grid grid-cols-3 gap-4">
                        <div class="col-span-2">
                            <div class="text-[10px] font-bold uppercase text-base-content/50">Pemesan</div>
                            <div class="mt-1 font-black italic uppercase">{{ data_get($detail, 'pemesan.nama') ?? '-' }}
                            </div>
                            <div class="mt-3 grid grid-cols-3 gap-3">
                                <div>
                                    <div class="text-[10px] font-bold uppercase text-base-content/50">Pemain</div>
                                    <div class="mt-1 font-black italic uppercase text-sm">
                                        {{ data_get($detail, 'pemesan.jumlah_pemain') ?? '-' }}</div>
                                </div>
                                <div>
                                    <div class="text-[10px] font-bold uppercase text-base-content/50">Kategori</div>
                                    <div class="mt-1 font-black italic uppercase text-sm">
                                        {{ data_get($detail, 'pemesan.kategori') ?? '-' }}</div>
                                </div>
                                <div>
                                    <div class="text-[10px] font-bold uppercase text-base-content/50">Jenis</div>
                                    <div class="mt-1 font-black italic uppercase text-sm">
                                        {{ data_get($detail, 'pemesan.jenis_permainan') ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-1 flex items-center justify-end">
                            <div
                                class="w-24 h-24 sm:w-28 sm:h-28 rounded-md overflow-hidden flex items-center justify-end bg-base-100">
                                <img src="{{ asset('assets/images/logo/logo-pemko-persegi.png') }}" alt="Logo Pemko"
                                    class="w-full h-full object-cover" />
                            </div>
                        </div>
                    </div>

                    <div class="bp-divider my-4"></div>

                    <div class="grid grid-cols-3 gap-3">
                        <div>
                            <div class="text-[10px] font-bold uppercase text-base-content/50">Dibuat</div>
                            <div class="mt-1 text-xs">
                                @php
                                    $dp = (string) (data_get($detail, 'dibuat_pada') ?? '');
                                    $dpFmt = null;
                                    if (preg_match('/^\d{4}-\d{2}-\d{2}/', $dp)) {
                                        $dpFmt = date('d-m-Y H:i', strtotime($dp));
                                    } else {
                                        $tok = preg_split('/\s+/', trim($dp));
                                        $bulanMap = [
                                            'januari' => 1,
                                            'februari' => 2,
                                            'maret' => 3,
                                            'april' => 4,
                                            'mei' => 5,
                                            'juni' => 6,
                                            'juli' => 7,
                                            'agustus' => 8,
                                            'september' => 9,
                                            'oktober' => 10,
                                            'november' => 11,
                                            'desember' => 12,
                                        ];
                                        if (count($tok) >= 4) {
                                            $d = (int) preg_replace('/\D/', '', $tok[0]);
                                            $b = $bulanMap[strtolower($tok[1])] ?? null;
                                            $y = (int) preg_replace('/\D/', '', $tok[2]);
                                            $time = $tok[3];
                                            if ($d && $b && $y && preg_match('/^\d{2}:\d{2}/', $time)) {
                                                $dpFmt = sprintf('%02d-%02d-%04d %s', $d, $b, $y, $time);
                                            }
                                        }
                                    }
                                @endphp
                                {{ $dpFmt ?? (data_get($detail, 'dibuat_pada') ?? '-') }}
                            </div>
                        </div>
                        <div>
                            <div class="text-[10px] font-bold uppercase text-base-content/50">Status</div>
                            <div
                                class="mt-1 text-xs font-black italic uppercase {{ (data_get($detail, 'status') ?? '') === 'dipesan' ? 'text-info' : 'text-warning' }}">
                                {{ data_get($detail, 'status') ?? '-' }}</div>
                        </div>
                        <div>
                            <div class="text-[10px] font-bold uppercase text-base-content/50">Kode</div>
                            <div class="mt-1 text-xs font-black italic uppercase">
                                {{ $detail['kode_booking'] ?? $kode_booking }}</div>
                        </div>
                    </div>

                    <div class="mt-4 rounded-xl bg-base-200 border border-dashed border-base-300 p-3">
                        <div class="text-[10px] font-bold uppercase text-base-content/50">Keterangan</div>
                        <div class="mt-1 text-sm italic">{{ data_get($detail, 'keterangan') ?? '-' }}</div>
                    </div>
                </div>
                <div class="bp-footer bg-info text-info-content px-4 py-3 sm:px-6">
                    <div class="text-center text-[10px] sm:text-xs font-black italic uppercase tracking-widest">Kencana
                        Minisoccer</div>
                </div>
            </div>
        </div>
    @else
        <div class="space-y-4 p-4">
            <div class="h-8 w-40 bg-base-300 rounded animate-pulse"></div>
            <div
                class="boarding-pass border-2 border-base-200 bg-base-100 rounded-2xl overflow-hidden shadow-lg animate-pulse">
                <div class="bp-header bg-base-300 px-4 py-3 sm:px-6 sm:py-4">
                    <div class="flex items-center justify-between">
                        <div class="h-3 w-24 bg-base-200 rounded"></div>
                        <div class="h-3 w-20 bg-base-200 rounded"></div>
                    </div>
                    <div class="h-6 sm:h-8 w-40 sm:w-56 bg-base-200 rounded mt-2"></div>
                </div>
                <div class="bp-body p-4 sm:p-6">
                    <div class="h-4 w-48 bg-base-300 rounded"></div>
                    <div class="mt-4 grid grid-cols-2 gap-4 items-start">
                        <div>
                            <div class="h-8 sm:h-10 w-24 sm:w-32 bg-base-300 rounded"></div>
                            <div class="h-3 w-28 bg-base-300 rounded mt-2"></div>
                        </div>
                        <div class="text-right">
                            <div class="h-8 sm:h-10 w-24 sm:w-32 bg-base-300 rounded ml-auto"></div>
                            <div class="h-3 w-28 bg-base-300 rounded mt-2 ml-auto"></div>
                        </div>
                    </div>
                    <div class="bp-divider my-4"></div>
                    <div class="grid grid-cols-3 gap-4">
                        <div class="col-span-2">
                            <div class="h-3 w-20 bg-base-300 rounded"></div>
                            <div class="h-4 w-36 bg-base-300 rounded mt-1"></div>
                            <div class="mt-3 grid grid-cols-3 gap-3">
                                <div>
                                    <div class="h-3 w-16 bg-base-300 rounded"></div>
                                    <div class="h-4 w-20 bg-base-300 rounded mt-1"></div>
                                </div>
                                <div>
                                    <div class="h-3 w-16 bg-base-300 rounded"></div>
                                    <div class="h-4 w-20 bg-base-300 rounded mt-1"></div>
                                </div>
                                <div>
                                    <div class="h-3 w-12 bg-base-300 rounded"></div>
                                    <div class="h-4 w-20 bg-base-300 rounded mt-1"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-1 flex items-center justify-end">
                            <div
                                class="w-24 h-24 sm:w-28 sm:h-28 rounded-md border-2 border-base-300 overflow-hidden flex items-center justify-end bg-base-100">
                                <div class="w-full h-full bg-base-300"></div>
                            </div>
                        </div>
                    </div>
                    <div class="bp-divider my-4"></div>
                    <div class="grid grid-cols-3 gap-3">
                        <div>
                            <div class="h-3 w-16 bg-base-300 rounded"></div>
                            <div class="h-3 w-24 bg-base-300 rounded mt-1"></div>
                        </div>
                        <div>
                            <div class="h-3 w-16 bg-base-300 rounded"></div>
                            <div class="h-3 w-20 bg-base-300 rounded mt-1"></div>
                        </div>
                        <div>
                            <div class="h-3 w-16 bg-base-300 rounded"></div>
                            <div class="h-3 w-20 bg-base-300 rounded mt-1"></div>
                        </div>
                    </div>
                    <div class="mt-4 rounded-xl border border-dashed border-base-300 p-3">
                        <div class="h-3 w-20 bg-base-300 rounded"></div>
                        <div class="h-4 w-full bg-base-300 rounded mt-2"></div>
                    </div>
                </div>
                <div class="bp-footer bg-base-300 px-4 py-3 sm:px-6"></div>
            </div>
        </div>
    @endif
</div>
