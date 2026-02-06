<div>
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold">Banner Carousel</h1>
            <p class="text-sm text-base-content/60 mt-1">Kelola data banner</p>
        </div>
        <div class="text-sm breadcrumbs text-base-content/60">
            <ul>
                <li><a href="#">Aman Arena</a></li>
                <li>Apps</li>
                <li>
                    <a wire:navigate href="/banner-carousel">
                        <span class="text-base-content">Banner Carousel</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="flex items-center justify-start mb-3">
        <a wire:navigate href="/banner-carousel-create" class="btn btn-primary btn-sm shadow">
            Tambah Banner
        </a>
    </div>
    <div class="card bg-base-100 shadow" wire:init="load">
        <div class="card-body">
            <div wire:loading.flex wire:target="load" class="items-center justify-center p-10">
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
                                    <th>Judul</th>
                                    <th>Kategori</th>
                                    <th>Deskripsi</th>
                                    <th class="text-center">Urutan</th>
                                    <th>Status</th>
                                    <th class="sticky right-0 bg-base-100 z-10">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($banners as $b)
                                    <tr>
                                        <td class="whitespace-nowrap">{{ $b['judul'] ?? '-' }}</td>
                                        <td class="whitespace-nowrap">
                                            {{-- [ID: {{ $b['id'] ?? '-' }}] --}}
                                            {{ $b['kategori'] ?? '-' }}
                                        </td>
                                        <td>{{ $b['deskripsi'] ?? '-' }}</td>
                                        <td class="whitespace-nowrap text-center font-mono">
                                            [{{ $b['urutan'] ?? '-' }}]
                                        </td>
                                        <td class="uppercase font-bold italic">
                                            @if ((bool) ($b['is_active'] ?? false))
                                                <span class="badge badge-xs badge-success">Aktif</span>
                                            @else
                                                <span class="badge badge-xs badge-neutral">Tidak Aktif</span>
                                            @endif
                                        </td>
                                        <td
                                            class="sticky right-0 bg-base-100 z-10 border-l border-base-300 shadow-l-sm">
                                            <div class="flex items-center gap-3">
                                                <a wire:navigate href="/banner-carousel-detail/{{ $b['id'] ?? 0 }}"
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
