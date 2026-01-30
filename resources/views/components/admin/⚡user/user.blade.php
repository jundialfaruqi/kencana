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
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>NIK</th>
                                    <th>No. WA</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($this->filteredUsers as $u)
                                    <tr>
                                        <td>{{ ($currentPage - 1) * $perPage + $loop->iteration }}</td>
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
