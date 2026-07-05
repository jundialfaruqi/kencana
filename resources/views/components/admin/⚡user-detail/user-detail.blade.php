<div>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold">Detail User</h1>
            <p class="text-sm text-base-content/60 mt-1">Informasi lengkap akun user</p>
        </div>
        <div>
            <a wire:navigate href="/manajemen-user" class="text-sm text-base-content/60">
                <span class="inline-flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                    </svg>
                    <span>Kembali</span>
                </span>
            </a>
        </div>
    </div>

    <div>
        @if ($error)
            <div class="alert alert-error">
                <span>{{ $error }}</span>
            </div>
        @elseif ($user)
            <div class="card bg-base-100 border border-base-300 rounded-xl shadow-sm">
                <div class="card-body p-6">
                    <h2 class="text-lg font-bold mb-6 border-b pb-2 border-base-300 text-base-content">Informasi Profil
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                        <!-- Left Column -->
                        <div class="space-y-4">
                            <div>
                                <span class="text-base-content/50 font-medium block">Nama Lengkap</span>
                                <span
                                    class="text-base-content font-bold text-base mt-1 block">{{ $user['name'] ?? '-' }}</span>
                            </div>

                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="text-base-content/50 font-medium">Alamat Email</span>
                                    <button class="btn btn-ghost btn-xs text-primary h-auto min-h-0 py-0.5 px-1.5"
                                        wire:click="toggleShowEmail" wire:loading.attr="disabled"
                                        wire:target="toggleShowEmail" aria-label="Toggle Email">
                                        {{ $showEmail ? 'Sembunyikan' : 'Lihat' }}
                                    </button>
                                </div>
                                <span class="text-base-content font-mono mt-1 block">
                                    @if ($showEmail)
                                        {{ $user['email'] ?? '-' }}
                                    @else
                                        {{ $user['email'] ? substr($user['email'], 0, 4) . '••••••••' : '-' }}
                                    @endif
                                </span>
                            </div>

                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="text-base-content/50 font-medium">Nomor Induk Kependudukan (NIK)</span>
                                    <button class="btn btn-ghost btn-xs text-primary h-auto min-h-0 py-0.5 px-1.5"
                                        wire:click="toggleShowNik" wire:loading.attr="disabled"
                                        wire:target="toggleShowNik" aria-label="Toggle NIK">
                                        {{ $showNik ? 'Sembunyikan' : 'Lihat' }}
                                    </button>
                                </div>
                                <span class="text-base-content font-mono mt-1 block">
                                    @if ($showNik)
                                        {{ $user['nik'] ?? '-' }}
                                    @else
                                        {{ $user['nik'] ?? null ? '••••••••••••••••' : '-' }}
                                    @endif
                                </span>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-4">
                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="text-base-content/50 font-medium">Nomor WhatsApp</span>
                                    <button class="btn btn-ghost btn-xs text-primary h-auto min-h-0 py-0.5 px-1.5"
                                        wire:click="toggleShowNoWa" wire:loading.attr="disabled"
                                        wire:target="toggleShowNoWa" aria-label="Toggle No. WA">
                                        {{ $showNoWa ? 'Sembunyikan' : 'Lihat' }}
                                    </button>
                                </div>
                                <span class="text-base-content font-mono mt-1 block">
                                    @if ($showNoWa)
                                        {{ $user['no_wa'] ?? '-' }}
                                    @else
                                        {{ $user['no_wa'] ? substr($user['no_wa'], 0, 4) . '••••••••' : '-' }}
                                    @endif
                                </span>
                            </div>

                            <div>
                                <span class="text-base-content/50 font-medium block">Role Akses</span>
                                <div class="mt-1">
                                    @php
                                        $role = strtolower($user['role'] ?? '');
                                        $roleClass = 'badge-neutral';
                                        if ($role === 'admin') {
                                            $roleClass = 'badge-primary';
                                        } elseif ($role === 'operator') {
                                            $roleClass = 'badge-info';
                                        } elseif ($role === 'manager') {
                                            $roleClass = 'badge-warning';
                                        }
                                    @endphp
                                    @if (!empty($user['role']))
                                        <span
                                            class="badge badge-sm font-semibold {{ $roleClass }}">{{ strtoupper($user['role']) }}</span>
                                    @else
                                        <span class="badge badge-neutral">-</span>
                                    @endif
                                </div>
                            </div>

                            <div>
                                <span class="text-base-content/50 font-medium block">Status Akun</span>
                                <div class="mt-1">
                                    @if (($user['is_active'] ?? false) === true)
                                        <span class="badge badge-sm badge-success font-semibold text-white">AKTIF</span>
                                    @else
                                        <span class="badge badge-sm badge-neutral font-semibold">NONAKTIF</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="mt-8 pt-4 border-t border-base-200 text-xs text-base-content/50 flex justify-between items-center">
                        <span>ID User: {{ $user['id'] ?? '-' }}</span>
                        <span>Terdaftar Pada: {{ $createdAtFormatted ?? '-' }}</span>
                    </div>
                </div>
            </div>
        @else
            <div class="text-sm text-base-content/60">Data tidak tersedia</div>
        @endif
    </div>
</div>
