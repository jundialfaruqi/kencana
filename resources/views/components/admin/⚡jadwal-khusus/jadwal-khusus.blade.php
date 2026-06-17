<div>
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold">Jadwal Khusus</h1>
            <p class="text-sm text-base-content/60 mt-1">Kelola jadwal tambahan/libur/event</p>
        </div>
        <div class="text-sm breadcrumbs text-base-content/60">
            <ul>
                <li><a wire:navigate href="/dashboard">{{ config('app.name') }}</a></li>
                <li>Apps</li>
                <li>
                    <a wire:navigate href="/jadwal-khusus">
                        <span class="text-base-content">Jadwal Khusus</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="flex items-center justify-start gap-2 mb-3">
        <a wire:navigate href="/jadwal-khusus-create" class="btn btn-primary btn-sm shadow">
            Buat Jadwal Khusus
        </a>
        <button type="button" class="btn btn-error btn-sm shadow-lg text-white font-bold italic tracking-wider uppercase" wire:click="openExportModal" wire:loading.attr="disabled">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 mr-1"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" /></svg>
            Export PDF
        </button>
    </div>
    <div class="card bg-base-100 border border-base-300" wire:init="load">
        <div class="card-body">
            <div wire:loading.flex class="items-center justify-center p-10" wire:target="load">
                <span class="loading loading-spinner loading-md"></span>
            </div>
            <div wire:loading.remove wire:target="load">
                @if ($error)
                    <div class="alert alert-error">
                        <span>{{ $error }}</span>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="table table-zebra">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Mulai</th>
                                    <th>Selesai</th>
                                    <th>Tipe</th>
                                    <th>Keterangan</th>
                                    <th>Arena</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($items as $it)
                                    <tr>
                                        <td class="whitespace-nowrap">
                                            {{ \Illuminate\Support\Str::of($it['tanggal'] ?? '')->substr(0, 10)->explode('-')->reverse()->implode('-') }}
                                        </td>
                                        <td class="whitespace-nowrap">
                                            {{ $it['buka'] ?? '-' ? substr((string) $it['buka'], 0, 5) : '-' }}
                                        </td>
                                        <td class="whitespace-nowrap">
                                            {{ $it['tutup'] ?? '-' ? substr((string) $it['tutup'], 0, 5) : '-' }}
                                        </td>
                                        <td class="font-bold italic">
                                            {{ $it['tipe_label'] ?? '-' }}
                                        </td>
                                        <td>{{ $it['keterangan'] ?? '-' }}</td>
                                        <td class="text-xs font-bold">
                                            {{ data_get($it, 'lapangan.nama_lapangan') ?? '-' }}
                                        </td>
                                        <td>
                                            <div class="flex items-center gap-3">
                                                <a wire:navigate href="/jadwal-khusus-update/{{ $it['id'] ?? '' }}"
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

    <dialog id="exportModal" class="modal modal-bottom sm:modal-middle backdrop-blur-sm" @if($showExportModal) open @endif>
        <div class="modal-box">
            <h3 class="font-bold text-lg text-info flex items-center gap-2 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" /></svg>
                <span class="italic uppercase tracking-wider">Export PDF Jadwal Khusus</span>
            </h3>
            
            <div class="mt-4">
                <p class="text-sm text-base-content/70 mb-3">Pilih rentang tanggal jadwal yang ingin diexport menjadi file PDF.</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label"><span class="label-text font-bold text-[10px] uppercase tracking-wider">Dari Tanggal (Opsional)</span></label>
                        <input type="date" class="input input-bordered focus-within:ring-0 focus-within:outline-none font-mono text-sm" wire:model="exportFrom">
                    </div>
                    <div class="form-control">
                        <label class="label"><span class="label-text font-bold text-[10px] uppercase tracking-wider">Sampai Tanggal (Opsional)</span></label>
                        <input type="date" class="input input-bordered focus-within:ring-0 focus-within:outline-none font-mono text-sm" wire:model="exportTo">
                    </div>
                </div>
            </div>

            @if($exportMessage)
                <div class="mt-6 p-4 bg-success/10 border border-success rounded-xl text-center">
                    <div class="w-12 h-12 bg-success text-white rounded-full flex items-center justify-center mx-auto mb-2 shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                    </div>
                    <p class="font-bold text-success">{{ $exportMessage }}</p>
                    <button class="btn btn-success text-white mt-4 w-full shadow-lg font-bold italic tracking-widest uppercase" wire:click="downloadExport">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5 mr-1"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
                        Download PDF
                    </button>
                </div>
            @endif

            <div class="modal-action">
                <button type="button" class="btn btn-ghost btn-sm" wire:click="closeExportModal" wire:loading.attr="disabled">Tutup</button>
                @if(!$exportMessage)
                <button class="btn btn-info btn-sm text-white font-bold italic uppercase tracking-widest" wire:click="processExport" wire:loading.attr="disabled" wire:target="processExport">
                    <span wire:loading.remove wire:target="processExport">Proses Export</span>
                    <span class="loading loading-spinner loading-xs" wire:loading wire:target="processExport"></span>
                </button>
                @endif
            </div>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button wire:click="closeExportModal">close</button>
        </form>
    </dialog>
</div>
