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
    <div class="card bg-base-100 shadow" wire:init="load">
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
                                        <td>{{ $u['name'] ?? '-' }}</td>
                                        <td>{{ $u['email'] ?? '-' }}</td>
                                        <td>{{ $u['role'] ?? '-' }}</td>
                                        <td>{{ $u['nik'] ?? '-' }}</td>
                                        <td>{{ $u['no_wa'] ?? '-' }}</td>
                                        <td>
                                            @if (($u['is_active'] ?? false) === true)
                                                <span class="badge badge-success">Aktif</span>
                                            @else
                                                <span class="badge badge-neutral">Nonaktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="flex items-center gap-3">
                                                <a wire:navigate href="/user-detail?id={{ $u['id'] ?? 0 }}"
                                                    class="text-xs text-secondary" aria-label="Detail">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="size-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v16.5c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Zm3.75 11.625a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                                    </svg>
                                                </a>
                                                <a wire:navigate href="/user-update?id={{ $u['id'] ?? 0 }}"
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
                                        <td colspan="6" class="text-center">Tidak ada data</td>
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
