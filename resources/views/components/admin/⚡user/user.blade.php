<div>
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold">Manajemen User</h1>
            <p class="text-sm text-base-content/60 mt-1">Kelola data user</p>
        </div>
        <div class="text-sm breadcrumbs text-base-content/60">
            <ul>
                <li><a href="#">Aman Arena</a></li>
                <li>Setting</li>
                <li>User</li>
                <li><a wire:navigate href="/manajemen-user"><span class="text-base-content">Manajemen User</span></a></li>
            </ul>
        </div>
    </div>
    <div class="card bg-base-100 border border-base-300" wire:init="load">
        <div class="card-body">
            <div class="flex items-center gap-2 mb-4">
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
                                    {{-- <th>No</th> --}}
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
                                        {{-- <td>{{ ($currentPage - 1) * $perPage + $loop->iteration }}</td> --}}
                                        <td class="font-bold">{{ $u['name'] ?? '-' }}</td>
                                        <td x-data="{ showEmail: false }">
                                            <div class="flex items-center gap-2 font-mono">
                                                <span x-show="showEmail">{{ $u['email'] ?? '-' }}</span>
                                                <span
                                                    x-show="!showEmail">{{ substr($u['email'] ?? '', 0, 4) }}••••••</span>
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
                                                <span
                                                    x-show="!showWa">{{ substr($u['no_wa'] ?? '', 0, 6) }}••••••</span>
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
                                                            viewBox="0 0 24 24" stroke-width="1.5"
                                                            stroke="currentColor" class="size-5">
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
                                                <a wire:navigate
                                                    href="{{ route('user-detail', ['id' => $u['id'] ?? 0]) }}"
                                                    class="text-xs text-secondary" aria-label="Detail">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="size-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v16.5c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Zm3.75 11.625a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                                    </svg>
                                                </a>
                                                <a wire:navigate
                                                    href="{{ route('user-update', ['id' => $u['id'] ?? 0]) }}"
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
                                                        stroke-width="4" stroke-linecap="round"
                                                        stroke-linejoin="round" class="text-accent">
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
                                    {!! $link['label'] !!}
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
