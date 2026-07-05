<div>
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold">Manajemen User</h1>
            <p class="text-sm text-base-content/60 mt-1">Kelola data user</p>
        </div>
        <div class="text-sm breadcrumbs text-base-content/60">
            <ul>
                <li><a href="/dashboard">{{ config('app.name') }}</a></li>
                <li>Setting</li>
                <li>User</li>
                <li><a wire:navigate href="/manajemen-user"><span class="text-base-content">Manajemen User</span></a></li>
            </ul>
        </div>
    </div>
    <div class="card bg-base-100 border border-base-300">
        <div class="card-body">
            <div class="flex items-center justify-between gap-2 mb-4">
                <div class="flex items-center gap-2">
                    <label class="input input-bordered flex items-center gap-2 w-full max-w-xs">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5 opacity-70">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                        <input type="text" class="grow" placeholder="Cari nama, NIK, atau email"
                            wire:model.live.debounce.300ms="search">
                    </label>
                    @if ($search !== '')
                        <span class="text-xs text-base-content/60">Hasil: {{ count($this->filteredUsers) }}</span>
                    @endif
                </div>
                <div>
                    <button type="button" class="btn btn-secondary text-white font-bold uppercase"
                        wire:click="openExportModal" wire:loading.attr="disabled">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-4 h-4 mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                        </svg>
                        Export Data
                    </button>
                </div>
            </div>
            @if ($error)
                <div class="alert alert-error">
                    <span>{{ $error }}</span>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="table table-zebra">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>NIK</th>
                                <th>No. WA</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($this->filteredUsers as $u)
                                <tr>
                                    <td class="font-bold text-base-content/75">{{ ($currentPage - 1) * $perPage + $loop->iteration }}</td>
                                    <td class="font-bold">{{ $u['name'] ?? '-' }}</td>
                                    <td x-data="{ showEmail: false }">
                                        <div class="flex items-center gap-2 font-mono">
                                            <span x-show="showEmail">{{ $u['email'] ?? '-' }}</span>
                                            <span x-show="!showEmail">{{ substr($u['email'] ?? '', 0, 4) }}••••••</span>
                                            <button type="button" x-on:click="showEmail = !showEmail"
                                                class="text-base-content/30 hover:text-info transition-colors">
                                                <span x-show="!showEmail">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="size-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                                    </svg>
                                                </span>
                                                <span x-show="showEmail">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="size-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                    </svg>
                                                </span>
                                            </button>
                                        </div>
                                    </td>
                                    <td>{{ $u['role'] ?? '-' }}</td>
                                    <td x-data="{ showNik: false }">
                                        <div class="flex items-center gap-2 font-mono">
                                            <span x-show="showNik">{{ $u['nik'] ?? '-' }}</span>
                                            <span x-show="!showNik">••••••••</span>
                                            <button type="button" x-on:click="showNik = !showNik"
                                                class="text-base-content/30 hover:text-info transition-colors">
                                                <span x-show="!showNik">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="size-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                                    </svg>
                                                </span>
                                                <span x-show="showNik">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="size-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                    </svg>
                                                </span>
                                            </button>
                                        </div>
                                    </td>
                                    <td x-data="{ showWa: false }">
                                        <div class="flex items-center gap-2 font-mono">
                                            <span x-show="showWa">{{ $u['no_wa'] ?? '-' }}</span>
                                            <span x-show="!showWa">{{ substr($u['no_wa'] ?? '', 0, 6) }}••••••</span>
                                            <button type="button" x-on:click="showWa = !showWa"
                                                class="text-base-content/30 hover:text-info transition-colors">
                                                <span x-show="!showWa">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="size-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                                    </svg>
                                                </span>
                                                <span x-show="showWa">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="size-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                    </svg>
                                                </span>
                                            </button>
                                        </div>
                                    </td>
                                    <td class="italic font-bold">
                                        @if (($u['is_active'] ?? false) === true)
                                            <span class="badge badge-xs badge-success">Aktif</span>
                                        @else
                                            <span class="badge badge-xs badge-neutral">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="flex items-center gap-3">
                                            <div class="tooltip tooltip-bottom" data-tip="Detail">
                                                <a wire:navigate
                                                    href="{{ route('user-detail', ['id' => $u['id'] ?? 0]) }}"
                                                    class="text-xs text-secondary flex items-center justify-center" aria-label="Detail">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="size-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v16.5c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Zm3.75 11.625a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                                    </svg>
                                                </a>
                                            </div>
                                            <div class="tooltip tooltip-bottom" data-tip="Edit">
                                                <a wire:navigate
                                                    href="{{ route('user-update', ['id' => $u['id'] ?? 0]) }}"
                                                    class="text-xs text-warning flex items-center justify-center" aria-label="Edit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="size-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                    </svg>
                                                </a>
                                            </div>
                                            <div class="tooltip tooltip-bottom" data-tip="{{ ($u['is_active'] ?? false) === true ? 'Nonaktifkan' : 'Aktifkan' }}">
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
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">Tidak ada data</td>
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
                                @if ($link['active']) btn-secondary @endif"
                                @if (!$link['url']) disabled @endif
                                wire:click="goToUrl('{{ $link['url'] }}')">
                                {!! $link['label'] !!}
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif
            <dialog id="exportModal" class="modal modal-bottom sm:modal-middle backdrop-blur-sm"
                @if ($showExportModal) open @endif>
                <div class="modal-box">
                    <h3 class="font-bold text-lg text-primary flex items-center gap-2 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                        </svg>
                        <span class="uppercase">Export Data User</span>
                    </h3>

                    <div class="mt-4">
                        <p class="text-sm text-base-content/70 mb-3">Pilih format export yang diinginkan. (Catatan:
                            Data sensitif seperti NIK, Email, dan No WA akan disamarkan secara otomatis demi keamanan).
                        </p>
                        <div class="form-control mb-4">
                            <label class="label"><span
                                    class="label-text font-bold text-[10px] uppercase tracking-wider">Format
                                    Export</span></label>
                            <div class="flex gap-4">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="exportFormat" value="pdf"
                                        wire:model.live="exportFormat" class="radio radio-primary radio-sm">
                                    <span class="text-sm font-semibold">PDF (.pdf)</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="exportFormat" value="xlsx"
                                        wire:model.live="exportFormat" class="radio radio-success radio-sm">
                                    <span class="text-sm font-semibold">Excel (.xlsx)</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    @if ($exportMessage)
                        <div
                            class="mt-6 p-4 @if ($exportFormat === 'xlsx') bg-success/10 border-success @else bg-success/10 border-success @endif border rounded-xl text-center">
                            <div
                                class="w-12 h-12 @if ($exportFormat === 'xlsx') bg-success @else bg-success @endif text-white rounded-full flex items-center justify-center mx-auto mb-2 shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                </svg>
                            </div>
                            <p
                                class="font-bold @if ($exportFormat === 'xlsx') text-success @else text-success @endif">
                                {{ $exportMessage }}</p>
                            <button
                                class="btn @if ($exportFormat === 'xlsx') btn-success @else btn-success @endif text-white mt-4 w-full shadow-lg font-bold uppercase"
                                wire:click="downloadExport">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2.5" stroke="currentColor" class="w-5 h-5 mr-1">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                </svg>
                                Download {{ strtoupper($exportFormat) }}
                            </button>
                        </div>
                    @endif

                    <div class="modal-action">
                        <button type="button" class="btn btn-ghost btn-sm" wire:click="closeExportModal"
                            wire:loading.attr="disabled">Tutup</button>
                        @if (!$exportMessage)
                            <button class="btn btn-accent btn-sm text-white font-bold uppercase"
                                wire:click="processExport" wire:loading.attr="disabled" wire:target="processExport">
                                <span wire:loading.remove wire:target="processExport">Proses Export</span>
                                <span class="loading loading-spinner loading-xs" wire:loading
                                    wire:target="processExport"></span>
                            </button>
                        @endif
                    </div>
                </div>
                <form method="dialog" class="modal-backdrop">
                    <button wire:click="closeExportModal">close</button>
                </form>
            </dialog>
        </div>
    </div>
</div>
