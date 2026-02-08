<div>
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold">Manajemen Lapangan</h1>
            <p class="text-sm text-base-content/60 mt-1">Daftar lapangan</p>
        </div>
        <div class="text-sm breadcrumbs text-base-content/60">
            <ul>
                <li><a wire:navigate href="/dashboard">Aman Arena</a></li>
                <li>Apps</li>
                <li>Master Lapangan</li>
            </ul>
        </div>
    </div>
    <div class="flex items-center justify-start mb-3">
        <a wire:navigate href="/lapangan-create" class="btn btn-primary btn-sm shadow">
            Tambah Lapangan
        </a>
    </div>
    <div class="card" wire:init="load">

        <div wire:loading.flex wire:target="load" class="items-center justify-center p-10">
            <span class="loading loading-spinner loading-md"></span>
        </div>
        <div wire:loading.remove wire:target="load">
            @if ($error)
                <div class="alert alert-error mb-4">
                    <span>{{ $error }}</span>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse ($slice as $lp)
                        <div class="card border-2 border-dashed border-base-300 bg-base-100">
                            <div class="card-body">
                                <div class="flex items-start justify-between">
                                    <h2 class="card-title">{{ $lp['nama_lapangan'] ?? '-' }}</h2>
                                    <span
                                        class="{{ ($lp['status'] ?? '') === 'open' ? 'bg-success text-success-content' : 'bg-warning text-warning-content' }} rounded-full text-center text-[11px] md:text-xs px-2 md:px-3 py-0.5 md:py-1">
                                        {{ $lp['status_label'] ?? ucfirst($lp['status'] ?? '-') }}
                                    </span>
                                </div>
                                <p class="text-sm text-base-content/70">{{ $lp['deskripsi'] ?? '-' }}</p>
                                <div class="mt-2 text-sm">
                                    <div
                                        class="flex items-center gap-2 bg-base-200 border border-base-300 border-dashed p-2 rounded-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            class="w-4 h-4 shrink-0 flex-none" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19.5 10.5c0 7.5-7.5 10.5-7.5 10.5S4.5 18 4.5 10.5a7.5 7.5 0 1115 0z" />
                                        </svg>
                                        <span class="flex-1 min-w-0 truncate">{{ $lp['alamat'] ?? '-' }}</span>
                                    </div>
                                </div>
                                <div class="mt-2 text-xs text-base-content/60">
                                    <span>Admin: {{ data_get($lp, 'admin.name', '-') }}</span>
                                </div>
                            </div>
                            <div class="card-footer p-3">
                                <div class="flex items-center justify-center gap-2">
                                    <a wire:navigate href="/lapangan-detail?id={{ $lp['id'] ?? 0 }}"
                                        class="btn btn-sm btn-primary">
                                        Detail
                                    </a>
                                    <a wire:navigate href="/lapangan-update?id={{ $lp['id'] ?? 0 }}"
                                        class="btn btn-sm btn-warning">
                                        Edit
                                    </a>
                                    <button type="button" class="btn btn-sm btn-error"
                                        onclick="document.getElementById('delete_modal_lapangan').showModal()"
                                        wire:click="confirmDelete({{ $lp['id'] ?? 0 }})">
                                        Hapus
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full">
                            <div class="alert">
                                <span>Tidak ada data lapangan</span>
                            </div>
                        </div>
                    @endforelse
                </div>
                <div class="flex flex-col gap-2 mt-4 sm:flex-row sm:items-center sm:justify-between">
                    <div class="join justify-center sm:justify-end text-xs text-base-content/60">
                        Halaman {{ $curr }} dari {{ $lastPage }} • Total {{ $total }}
                    </div>
                    <div class="join justify-center sm:justify-end">
                        @foreach ($links as $link)
                            @php $lbl = $link['label'] ?? ''; @endphp
                            @if ($link['url'])
                                <a wire:navigate href="{{ $link['url'] }}"
                                    class="join-item btn btn-sm @if ($link['active']) btn-primary @endif">
                                    @if ($lbl === 'Prev')
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="3" stroke="currentColor" class="size-2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m18.75 4.5-7.5 7.5 7.5 7.5m-6-15L5.25 12l7.5 7.5" />
                                        </svg>
                                    @endif
                                    {!! $link['label'] !!}
                                    @if ($lbl === 'Next')
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="3" stroke="currentColor" class="size-2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m5.25 4.5 7.5 7.5-7.5 7.5m6-15 7.5 7.5-7.5 7.5" />
                                        </svg>
                                    @endif
                                </a>
                            @else
                                <span class="join-item btn btn-sm btn-disabled">
                                    @if ($lbl === 'Prev')
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="3" stroke="currentColor" class="size-2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m18.75 4.5-7.5 7.5 7.5 7.5m-6-15L5.25 12l7.5 7.5" />
                                        </svg>
                                    @endif
                                    {!! $link['label'] !!}
                                    @if ($lbl === 'Next')
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="3" stroke="currentColor" class="size-2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m5.25 4.5 7.5 7.5-7.5 7.5m6-15 7.5 7.5-7.5 7.5" />
                                        </svg>
                                    @endif
                                </span>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

    </div>

    <dialog id="delete_modal_lapangan" class="modal modal-bottom sm:modal-middle backdrop-blur-sm" wire:ignore>
        <div class="modal-box">
            <h3 class="font-bold text-lg italic uppercase tracking-tight">Konfirmasi Hapus</h3>
            <p class="py-4 text-base-content/70">Apakah Anda yakin ingin menghapus lapangan ini?</p>
            <div class="modal-action">
                <form method="dialog">
                    <button class="btn btn-ghost -skew-x-12">Batal</button>
                </form>
                <button type="button" wire:click="deleteLapangan"
                    onclick="document.getElementById('delete_modal_lapangan').close()"
                    class="btn btn-error text-white -skew-x-12 font-black uppercase tracking-widest"
                    wire:loading.attr="disabled" wire:target="deleteLapangan">
                    <span wire:loading.remove wire:target="deleteLapangan">Hapus</span>
                    <span class="loading loading-spinner loading-xs" wire:loading wire:target="deleteLapangan"></span>
                </button>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>
</div>
