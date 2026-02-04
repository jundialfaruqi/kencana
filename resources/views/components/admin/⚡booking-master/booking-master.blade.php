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
                                    <th>Aksi</th>
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
                                        <td>
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
                                                <a wire:navigate
                                                    href="/user-update?id={{ data_get($b, 'user.id', 0) }}"
                                                    class="text-xs text-warning" aria-label="Edit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="size-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                    </svg>
                                                </a>
                                                <label class="toggle toggle-xs text-blue" aria-label="Toggle Status">
                                                    <input type="checkbox" @checked(($u['is_active'] ?? false) === true)
                                                        wire:change="toggleUserStatus({{ $u['id'] ?? 0 }})"
                                                        wire:loading.attr="disabled" wire:target="toggleUserStatus">
                                                    <svg aria-label="disabled" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="4" stroke-linecap="round" stroke-linejoin="round"
                                                        class="text-accent">
                                                        <path d="M18 6 6 18" />
                                                        <path d="m6 6 12 12" />
                                                    </svg>
                                                    <svg aria-label="enabled" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 24 24">
                                                        <g stroke-linejoin="round" stroke-linecap="round"
                                                            stroke-width="4" fill="none" stroke="currentColor"
                                                            class="text-success">
                                                            <path d="M20 6 9 17l-5-5"></path>
                                                        </g>
                                                    </svg>
                                                </label>
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
