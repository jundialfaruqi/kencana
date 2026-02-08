<div>
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold">Manajemen Jadwal Operasional</h1>
            <p class="text-sm text-base-content/60 mt-1">Kelola jadwal buka/tutup per hari</p>
        </div>
        <div class="text-sm breadcrumbs text-base-content/60">
            <ul>
                <li><a wire:navigate href="/dashboard">Aman Arena</a></li>
                <li>Apps</li>
                <li>
                    <a wire:navigate href="/manajemen-jadwal-operasional">
                        <span class="text-base-content">
                            Manajemen Jadwal Operasional
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="flex items-center justify-start mb-3">
        <a wire:navigate href="/jadwal-operasional-create" class="btn btn-primary btn-sm shadow">
            Buat Jadwal
        </a>
    </div>
    <div class="card bg-base-100 border border-base-300" wire:init="load">
        <div class="card-body">
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
                                    <th>Hari</th>
                                    <th>Buka</th>
                                    <th>Tutup</th>
                                    <th>Status</th>
                                    <th>Arena</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($jadwal as $it)
                                    <tr>
                                        <td class="font-bold">{{ $it['hari_label'] ?? '-' }}</td>
                                        <td>{{ $it['buka'] ?? '-' }}</td>
                                        <td>{{ $it['tutup'] ?? '-' }}</td>
                                        <td class="font-bold italic">
                                            @if (($it['is_active'] ?? false) === true)
                                                <span class="badge badge-xs badge-success">Aktif</span>
                                            @else
                                                <span class="badge badge-xs badge-neutral">Nonaktif</span>
                                            @endif
                                        </td>
                                        <td class="font-bold">
                                            {{ data_get($it, 'lapangan.nama_lapangan') ?? '-' }}</td>
                                        <td>
                                            <div class="flex items-center gap-3">
                                                <a wire:navigate href="/jadwal-operasional-update/{{ $it['id'] ?? '' }}"
                                                    class="text-xs text-secondary">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="size-5 text-warning">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                    </svg>
                                                </a>
                                                <button type="button" class="text-xs text-red-500"
                                                    onclick="document.getElementById('delete_modal_jadwal_{{ $it['id'] ?? '' }}').showModal()">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="size-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                    </svg>
                                                </button>
                                            </div>
                                            <dialog id="delete_modal_jadwal_{{ $it['id'] ?? '' }}"
                                                class="modal modal-bottom sm:modal-middle backdrop-blur-sm" wire:ignore>
                                                <div class="modal-box">
                                                    <h3 class="font-bold text-lg italic uppercase tracking-tight">
                                                        Konfirmasi Hapus</h3>
                                                    <p class="py-4 text-base-content/70">Apakah Anda yakin ingin
                                                        menghapus jadwal ini?</p>
                                                    <div class="modal-action">
                                                        <form method="dialog">
                                                            <button class="btn btn-ghost -skew-x-12">Batal</button>
                                                        </form>
                                                        <button type="button"
                                                            wire:click="deleteJadwal({{ $it['id'] ?? '' }})"
                                                            onclick="document.getElementById('delete_modal_jadwal_{{ $it['id'] ?? '' }}').close()"
                                                            class="btn btn-error text-white -skew-x-12 font-black uppercase tracking-widest"
                                                            wire:loading.attr="disabled" wire:target="deleteJadwal">
                                                            <span wire:loading.remove
                                                                wire:target="deleteJadwal">Hapus</span>
                                                            <span class="loading loading-spinner loading-xs"
                                                                wire:loading wire:target="deleteJadwal"></span>
                                                        </button>
                                                    </div>
                                                </div>
                                                <form method="dialog" class="modal-backdrop">
                                                    <button>close</button>
                                                </form>
                                            </dialog>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="flex flex-col gap-2 mt-4 sm:flex-row sm:items-center sm:justify-between">
                        <div class="join justify-center sm:justify-end text-xs text-base-content/60">
                            Halaman {{ $currentPage }} dari {{ $lastPage }} • Total {{ $total }}
                        </div>
                        <div class="join justify-center sm:justify-end">
                            @foreach ($links as $link)
                                <button
                                    class="join-item btn btn-sm
                                @if ($link['active']) btn-primary @endif"
                                    @if (!$link['url']) disabled @endif
                                    wire:click="goToUrl('{{ $link['url'] }}')">
                                    @php $lbl = $link['label'] ?? ''; @endphp
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
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
