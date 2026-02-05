<div>
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold">Catatan</h1>
            <p class="text-sm text-base-content/60 mt-1">Kelola data catatan</p>
        </div>
        <div class="text-sm breadcrumbs text-base-content/60">
            <ul>
                <li><a href="#">Aman Arena</a></li>
                <li>Apps</li>
                <li>
                    <a wire:navigate href="/catatan">
                        <span class="text-base-content">Catatan</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="flex items-center justify-start mb-3">
        <a wire:navigate href="/jadwal-operasional-create" class="btn btn-primary btn-sm shadow">
            Buat Catatan
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
                                    <th>Kategori</th>
                                    <th>Catatan</th>
                                    <th class="text-center">Urutan</th>
                                    <th>Status</th>
                                    <th>Lapangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($catatans as $c)
                                    <tr>
                                        <td class="whitespace-nowrap">
                                            [ID: {{ $c['id'] ?? '-' }}]
                                            {{ $c['kategori_catatan'] ?? '-' }}
                                        </td>
                                        <td>{{ $c['catatan'] ?? '-' }}</td>
                                        <td class="whitespace-nowrap text-center font-mono">
                                            [{{ $c['urutan'] ?? '-' }}]
                                        </td>
                                        <td class="uppercase font-bold italic">
                                            @php $act = (bool) ($c['is_active'] ?? false); @endphp
                                            @if ($act)
                                                <span class="badge badge-xs badge-success">Aktif</span>
                                            @else
                                                <span class="badge badge-xs badge-neutral">Tidak Aktif</span>
                                            @endif
                                        </td>
                                        <td class="text-xs">{{ $c['nama_lapangan'] ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
