<div>
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold">Manajemen Lapangan</h1>
            <p class="text-sm text-base-content/60 mt-1">Daftar lapangan</p>
        </div>
        <div class="text-sm breadcrumbs text-base-content/60">
            <ul>
                <li><a wire:navigate href="/dashboard">{{ config('app.name') }}</a></li>
                <li>Apps</li>
                <li>Master Lapangan</li>
            </ul>
        </div>
    </div>
    <div class="flex items-center justify-start mb-3">
        <a wire:navigate href="/lapangan-create" class="btn btn-secondary btn-sm shadow">
            Tambah Lapangan
        </a>
    </div>
    <div class="card">

        <div>
            @if ($error)
                <div class="alert alert-error mb-4">
                    <span>{{ $error }}</span>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse ($slice as $lp)
                        <div class="card border border-base-300 bg-base-100 shadow-sm overflow-hidden">
                            <div class="card-body flex flex-row gap-4 p-4 items-start">
                                <!-- Cover Image -->
                                @php
                                    $imageBase = rtrim((string) config('services.api.image_base_url'), '/');
                                    $cover = data_get($lp, 'image_cover');
                                    $coverUrl = null;
                                    if (!empty($cover)) {
                                        $p = ltrim((string) $cover, '/');
                                        if (preg_match('/^https?:\/\//', $p)) {
                                            $coverUrl = $p;
                                        } else {
                                            $coverUrl = $imageBase . '/' . $p;
                                        }
                                    }
                                @endphp
                                <div
                                    class="w-20 h-20 sm:w-24 sm:h-24 rounded-xl bg-base-200 border border-base-300 overflow-hidden shrink-0 flex items-center justify-center">
                                    @if ($coverUrl)
                                        <img src="{{ $coverUrl }}" class="w-full h-full object-cover"
                                            alt="{{ $lp['nama_lapangan'] ?? 'Lapangan' }}">
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor"
                                            class="w-8 h-8 text-base-content/40">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m2.25 15.75 5.159-5.159a4.125 4.125 0 0 1 5.857 0L18.25 16.5m-1.5-1.5 3.093-3.093a4.125 4.125 0 0 1 5.857 0L21.75 15.75M9 10.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                                        </svg>
                                    @endif
                                </div>

                                <!-- Field Details -->
                                <div class="flex-1 min-w-0">
                                    <!-- Status (Moved under description) -->
                                    <div class="mb-1">
                                        @php $is_open = ($lp['status'] ?? '') === 'open'; @endphp
                                        <span
                                            class="inline-flex items-center rounded-md px-2 py-0.5 text-[10px] font-bold uppercase {{ $is_open ? 'bg-warning/15 text-warning' : 'bg-success/15 text-success' }}">
                                            {{ $lp['status_label'] ?? ucfirst($lp['status'] ?? '-') }}
                                        </span>
                                    </div>
                                    <h2 class="font-bold text-sm sm:text-base text-base-content truncate">
                                        {{ $lp['nama_lapangan'] ?? '-' }}</h2>
                                    <p
                                        class="text-xs sm:text-sm text-base-content/70 mt-1 line-clamp-2 leading-relaxed">
                                        {{ $lp['deskripsi'] ?? '-' }}</p>

                                    <!-- Author -->
                                    <div class="mt-2 text-[10px] sm:text-xs text-base-content/50">
                                        <span>Author: {{ data_get($lp, 'admin.name', '-') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer px-4 pb-4 pt-0">
                                <div class="flex items-center justify-end gap-2">
                                    <a wire:navigate href="/lapangan-detail?id={{ $lp['id'] ?? 0 }}"
                                        class="btn btn-sm btn-secondary">
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
                                    class="join-item btn btn-sm @if ($link['active']) btn-secondary @endif">
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
