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
                                placeholder="Cari Pemesan/Kode Booking" wire:model.live.debounce.300ms="search">
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
            <div wire:loading.flex class="items-center justify-center p-10">
                <span class="loading loading-spinner loading-md"></span>
            </div>
            <div wire:loading.remove>
                @if ($error)
                    <div class="alert alert-error">
                        <span>{{ $error }}</span>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="table table-zebra">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Tanggal</th>
                                    <th>Jam</th>
                                    <th>Pemesan</th>
                                    <th>Lapangan</th>
                                    <th>Jumlah</th>
                                    <th>Kategori</th>
                                    <th>Jenis</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($bookings as $b)
                                    <tr>
                                        <td>{{ $b['kode_booking'] ?? '-' }}</td>
                                        <td>{{ \Illuminate\Support\Str::of($b['tanggal'] ?? '')->substr(0, 10) }}</td>
                                        <td>{{ $b['jam_mulai'] ?? '-' ? substr((string) $b['jam_mulai'], 0, 5) : '-' }}
                                            -
                                            {{ $b['jam_selesai'] ?? '-' ? substr((string) $b['jam_selesai'], 0, 5) : '-' }}
                                        </td>
                                        <td>{{ data_get($b, 'user.name') ?? '-' }}</td>
                                        <td>{{ data_get($b, 'lapangan.nama_lapangan') ?? '-' }}</td>
                                        <td>{{ $b['jumlah_pemain'] ?? '-' }}</td>
                                        <td>{{ $b['kategori_pemain'] ?? '-' }}</td>
                                        <td>{{ $b['jenis_permainan'] ?? '-' }}</td>
                                        <td>
                                            @php $st = $b['status'] ?? '-'; @endphp
                                            @if ($st === 'dipesan')
                                                <span class="badge badge-info">Dipesan</span>
                                            @elseif ($st === 'dibatalkan')
                                                <span class="badge badge-error">Dibatalkan</span>
                                            @elseif ($st === 'selesai')
                                                <span class="badge badge-success">Selesai</span>
                                            @else
                                                <span class="badge badge-neutral">{{ strtoupper($st) }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $b['keterangan'] ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center">Tidak ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="flex items-center justify-between mt-4">
                        <div class="text-xs text-base-content/60">
                            Halaman {{ $currentPage }} dari {{ $lastPage }} • Total {{ $total }}
                        </div>
                        <div class="join">
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
</div>
