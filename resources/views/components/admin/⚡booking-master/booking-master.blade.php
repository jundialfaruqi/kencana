<div>
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold">Booking Master</h1>
            <p class="text-sm text-base-content/60 mt-1">Kelola data booking</p>
        </div>
        <div class="text-sm breadcrumbs text-base-content/60">
            <ul>
                <li><a href="#">Aman Arena</a></li>
                <li>Apps</li>
                <li>
                    <a wire:navigate href="/booking-master">
                        <span class="text-base-content">
                            Booking Master
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="card bg-base-100 shadow" wire:init="load">
        <div class="card-body">
            <div class="flex flex-wrap items-center justify-between mb-4 gap-2">
                <div class="w-full sm:w-xs">
                    {{-- pencarian --}}
                    <div class="join w-full sm:max-w-xl">
                        <label
                            class="input border-0 join-item flex items-center gap-2 w-full focus-within:outline-none focus-within:ring-0 bg-base-200">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5 opacity-70">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                            <input type="text" class="grow focus:outline-none focus-within:ring-0 bg-base-200"
                                placeholder="Cari Pemesan / Kode Booking" wire:model.live.debounce.300ms="search">
                        </label>
                        <button type="button"
                            class="btn join-item btn-base-200 rounded-r-lg disabled:bg-base-200 hover:bg-base-200 border-0"
                            aria-label="Clear" wire:click="$set('search','')" @disabled(!$search)>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5" fill="none"
                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M18 6 6 18" />
                                <path d="m6 6 12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="sm:flex items-center gap-2 w-full sm:w-auto justify-end">
                    {{-- filter date from to --}}
                    <div class="flex flex-row sm:flex-row w-full sm:w-auto gap-2 mt-2 sm:mt-0">
                        <input type="date"
                            class="input input-bordered w-full sm:w-36 focus-within:outline-none focus-within:ring-0 border-0 bg-base-200"
                            wire:model.live="from">
                        <input type="date"
                            class="input input-bordered w-full sm:w-36 focus-within:outline-none focus-within:ring-0 border-0 bg-base-200"
                            wire:model.live="to">
                    </div>
                    {{-- filter status --}}
                    <label
                        class="select select-bordered w-full sm:max-w-xs mt-2 sm:mt-0  focus-within:outline-none focus-within:ring-0 border-0 bg-base-200">
                        <select wire:model.live="status">
                            <option value="">Semua Status</option>
                            <option value="dipesan">Dipesan</option>
                            <option value="dibatalkan">Dibatalkan</option>
                            <option value="selesai">Selesai</option>
                        </select>
                    </label>
                </div>
            </div>
            <div wire:loading.flex wire:target="load,applyFilter,goToPage,executeCancelBooking"
                class="items-center
                justify-center p-10">
                <span class="loading loading-spinner loading-md"></span>
            </div>
            <div wire:loading.remove wire:target="load,applyFilter,goToPage,executeCancelBooking">
                @if ($error)
                    <div class="alert alert-error">
                        <span>{{ $error }}</span>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="table table-zebra">
                            <thead>
                                <tr>
                                    <th>Kode Booking</th>
                                    <th>Tanggal</th>
                                    <th>Jam</th>
                                    <th>Pemesan</th>
                                    <th>Lapangan</th>
                                    <th>Jumlah</th>
                                    <th>Kategori</th>
                                    <th>Jenis</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>
                                    <th class="sticky right-0 bg-base-100 z-10">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($bookings as $b)
                                    <tr>
                                        <td class="whitespace-nowrap font-mono font-bold">
                                            {{ $b['kode_booking'] ?? '-' }}</td>
                                        <td class="whitespace-nowrap">
                                            {{ \Illuminate\Support\Str::of($b['tanggal'] ?? '')->substr(0, 10)->explode('-')->reverse()->implode('-') }}
                                        </td>
                                        <td class="whitespace-nowrap font-mono">
                                            {{ $b['jam_mulai'] ?? '-' ? substr((string) $b['jam_mulai'], 0, 5) : '-' }}
                                            -
                                            {{ $b['jam_selesai'] ?? '-' ? substr((string) $b['jam_selesai'], 0, 5) : '-' }}
                                        </td>
                                        <td>{{ data_get($b, 'user.name') ?? '-' }}</td>
                                        <td class="text-xs">{{ data_get($b, 'lapangan.nama_lapangan') ?? '-' }}</td>
                                        <td>{{ $b['jumlah_pemain'] ?? '-' }}</td>
                                        <td>{{ $b['kategori_pemain'] ?? '-' }}</td>
                                        <td>{{ $b['jenis_permainan'] ?? '-' }}</td>
                                        <td class="uppercase font-bold italic">
                                            @php $st = $b['status'] ?? '-'; @endphp
                                            @if ($st === 'dipesan')
                                                <span class="badge badge-xs badge-info">Dipesan</span>
                                            @elseif ($st === 'dibatalkan')
                                                <span class="badge badge-xs badge-error">Dibatalkan</span>
                                            @elseif ($st === 'selesai')
                                                <span class="badge badge-xs badge-success">Selesai</span>
                                            @else
                                                <span class="badge badge-xs badge-neutral">{{ strtoupper($st) }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $b['keterangan'] ?? '-' }}</td>
                                        <td
                                            class="sticky right-0 bg-base-100 z-10 border-l border-base-300 shadow-l-sm">
                                            <div class="flex items-center gap-3">
                                                <a wire:navigate href="/booking-detail?id={{ $b['id'] ?? 0 }}"
                                                    class="text-xs text-secondary" aria-label="Detail">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="size-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v16.5c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Zm3.75 11.625a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                                    </svg>
                                                </a>
                                                <button class="text-xs text-red-500 disabled:text-red-300"
                                                    data-cancel-btn data-kode="{{ $b['kode_booking'] ?? '-' }}"
                                                    data-tanggal="{{ \Illuminate\Support\Str::of($b['tanggal'] ?? '')->substr(0, 10)->explode('-')->reverse()->implode('-') }}"
                                                    data-jam_mulai="{{ $b['jam_mulai'] ?? '-' ? substr((string) $b['jam_mulai'], 0, 5) : '-' }}"
                                                    data-jam_selesai="{{ $b['jam_selesai'] ?? '-' ? substr((string) $b['jam_selesai'], 0, 5) : '-' }}"
                                                    data-user="{{ data_get($b, 'user.name') ?? '-' }}"
                                                    data-lapangan="{{ data_get($b, 'lapangan.nama_lapangan') ?? '-' }}"
                                                    @if (in_array($b['status'] ?? '', ['dibatalkan', 'selesai'])) disabled @endif
                                                    wire:click="openCancelModal({{ $b['id'] ?? 0 }})"
                                                    wire:loading.class="pointer-events-none opacity-50"
                                                    wire:target="openCancelModal">
                                                    <span wire:loading.remove wire:target="openCancelModal">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                            class="size-5">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m6 4.125 2.25 2.25m0 0 2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                                                        </svg>
                                                    </span>
                                                    <span class="loading loading-spinner loading-xs" wire:loading
                                                        wire:target="openCancelModal"></span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center">Tidak ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="flex flex-col gap-2 mt-4 sm:flex-row sm:items-center sm:justify-between">
                        <div class="text-xs text-base-content/60 text-center sm:text-left">
                            Halaman {{ $currentPage }} dari {{ $lastPage }} • Total {{ $total }}
                        </div>

                        <div class="join justify-center sm:justify-end">
                            @foreach ($links as $link)
                                <button
                                    class="join-item btn btn-sm @if ($link['active']) btn-primary @endif"
                                    @if (!$link['url'] || !($link['page'] ?? null)) disabled @endif
                                    wire:click="goToPage({{ $link['page'] ?? 1 }})" wire:loading.attr="disabled"
                                    wire:target="goToPage">
                                    {!! $link['label'] !!}
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <dialog id="cancelModal" class="modal modal-bottom sm:modal-middle backdrop-blur-sm" wire:ignore>
        <div class="modal-box">
            <h3 class="font-bold text-lg">Masukkan Alasan Pembatalan Booking</h3>
            <div class="mt-2 text-xs text-base-content/70 grid grid-cols-1 sm:grid-cols-2 gap-2" id="cancelInfo">
                <div class="flex items-center justify-between rounded-lg border border-base-300 px-3 py-2">
                    <span class="font-semibold text-[11px] uppercase tracking-wide text-base-content/70">Kode
                    </span>
                    <span id="cancelInfoKode" class="text-xs px-2 py-1 font-mono font-bold italic">-</span>
                </div>
                <div class="flex items-center justify-between rounded-lg border border-base-300 px-3 py-2">
                    <span class="font-semibold text-[11px] uppercase tracking-wide text-base-content/70">Tanggal</span>
                    <span id="cancelInfoTanggal" class="text-xs px-2 py-1">-</span>
                </div>
                <div
                    class="flex items-center justify-between rounded-lg border border-base-300 px-3 py-2 sm:col-span-2">
                    <span class="font-semibold text-[11px] uppercase tracking-wide text-base-content/70">Jam</span>
                    <span id="cancelInfoJam" class="text-xs px-2 py-1 font-mono">-</span>
                </div>
                <div class="flex items-center justify-between rounded-lg border border-base-300 px-3 py-2">
                    <span class="font-semibold text-[11px] uppercase tracking-wide text-base-content/70">Pemesan</span>
                    <span id="cancelInfoUser" class="text-xs px-2 py-1">-</span>
                </div>
                <div class="flex items-center justify-between rounded-lg border border-base-300 px-3 py-2">
                    <span
                        class="font-semibold text-[11px] uppercase tracking-wide text-base-content/70">Lapangan</span>
                    <span id="cancelInfoLapangan" class="text-xs px-2 py-1">-</span>
                </div>
            </div>
            <div class="mt-3">
                <textarea id="cancelReasonInput" class="textarea textarea-bordered w-full" rows="4"
                    placeholder="Tulis alasan pembatalan (opsional)" wire:model.defer="cancelReason"></textarea>
            </div>
            <div class="mt-2 text-xs text-red-500 px-2">
                <ul class="space-y-2">
                    <li class="flex items-center"><span class="flex-none w-6 text-xs font-bold">1.
                        </span>
                        <span class="text-xs sm:text-sm leading-relaxed">
                            Jika alasan pembatalan tidak diisi maka
                            keterangan otomatis diisi
                            "dibatalkan oleh admin"
                        </span>
                    </li>
                    <li class="flex items-center"><span class="flex-none w-6 text-xs font-bold">2.
                        </span>
                        <span class="text-xs sm:text-sm leading-relaxed">
                            Perhatikan baik-baik data booking yang ingin dibatalkan karena booking yg dibatalkan tidak
                            bisa di aktifkan kembali
                        </span>
                    </li>
                </ul>
            </div>
            <div class="modal-action">
                <button id="cancelModalCloseBtn" type="button" class="btn btn-ghost btn-sm">Batal</button>
                <button class="btn btn-error btn-sm" wire:click="executeCancelBooking" wire:loading.attr="disabled"
                    wire:target="executeCancelBooking">
                    <span wire:loading.remove>Kirim</span>
                    <span class="loading loading-dots loading-xs" wire:loading
                        wire:target="executeCancelBooking"></span>
                </button>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>
</div>
