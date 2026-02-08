<div>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold">Detail User</h1>
            <p class="text-sm text-base-content/60 mt-1">Informasi lengkap user</p>
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

    <div wire:init="load">
        <div>
            <div wire:loading.flex wire:target="load" class="items-center justify-center p-10">
                <span class="loading loading-spinner loading-md"></span>
            </div>
            <div wire:loading.remove wire:target="load">
                @if ($error)
                    <div class="alert alert-error">
                        <span>{{ $error }}</span>
                    </div>
                @elseif ($user)
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
                        <div class="card bg-base-100 border-2 border-dashed border-base-300 md:col-span-2">
                            <div class="card-body">
                                <div class="px-2 grid grid-cols-1 md:grid-cols-3 gap-6 text-sm">
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5 opacity-70">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                            </svg>
                                            <span class="text-base-content/70">Nama</span>
                                        </div>
                                        <div class="mt-1">{{ $user['name'] ?? '-' }}</div>
                                    </div>

                                    <div>
                                        <div class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-5 opacity-70">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                            </svg>

                                            <span class="text-base-content/70">Email</span>
                                        </div>
                                        <div class="mt-1">{{ $user['email'] ?? '-' }}</div>
                                    </div>

                                    <div>
                                        <div class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-5 opacity-70">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                                            </svg>
                                            <span class="text-base-content/70">NIK</span>
                                            <button class="btn btn-primary btn-xs ml-auto" wire:click="toggleShowNik"
                                                wire:loading.attr="disabled" wire:target="toggleShowNik"
                                                aria-label="Toggle NIK">
                                                <span class="inline-flex items-center justify-center gap-1">
                                                    @if ($showNik)
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            class="w-4 h-4">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M3.98 8.223A10.477 10.477 0 001.653 12c1.66 3.525 5.583 6 10.347 6 1.582 0 3.087-.262 4.454-.744M6.228 6.228A10.478 10.478 0 0112 6c4.764 0 8.687 2.475 10.347 6a10.467 10.467 0 01-4.523 4.774M6.228 6.228L3 3m3.228 3.228l13.544 13.544M17.772 17.772L21 21" />
                                                        </svg>
                                                        <span>Sembunyikan</span>
                                                    @else
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            class="w-4 h-4">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M2.036 12.322a1.012 1.012 0 010-.644C3.423 8.517 7.36 6 12 6c4.64 0 8.577 2.517 9.964 5.678.09.196.09.448 0 .644C20.577 15.483 16.64 18 12 18c-4.64 0-8.577-2.517-9.964-5.678z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        </svg>
                                                        <span>Lihat</span>
                                                    @endif
                                                </span>
                                            </button>
                                        </div>
                                        <div class="mt-1">
                                            @if ($showNik)
                                                {{ $user['nik'] ?? '-' }}
                                            @else
                                                {{ $user['nik'] ?? null ? '••••••••••••••••' : '-' }}
                                            @endif
                                        </div>
                                    </div>

                                    <div>
                                        <div class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5 opacity-70">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6.62 10.79a15.05 15.05 0 006.59 6.59l2.1-2.1a1 1 0 011.08-.2l3.2 1.28a1 1 0 01.66.94V21a1 1 0 01-1 1A16 16 0 013 5a1 1 0 011-1h2.7a1 1 0 01.94.66l1.28 3.2a1 1 0 01-.2 1.08l-2.1 2.1z" />
                                            </svg>
                                            <span class="text-base-content/70">No. WA</span>
                                        </div>
                                        <div class="mt-1">{{ $user['no_wa'] ?? '-' }}</div>
                                    </div>
                                </div>
                                <div class="py-2"></div>
                                <div class="p-5 bg-base-200 border border-base-300 rounded-xl">
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-5 h-5 opacity-70">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 3l8 4v5c0 5-8 9-8 9s-8-4-8-9V7l8-4z" />
                                                </svg>
                                                <span class="text-base-content/70">Role</span>
                                            </div>
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
                                                    <span class="badge {{ $roleClass }}">{{ $user['role'] }}</span>
                                                @else
                                                    <span class="badge badge-neutral">-</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-5 h-5 opacity-70">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M9 12l2 2 4-4" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 21a9 9 0 1 1 0-18 9 9 0 0 1 0 18z" />
                                                </svg>
                                                <span class="text-base-content/70">Status</span>
                                            </div>
                                            <div class="mt-1">
                                                @if (($user['is_active'] ?? false) === true)
                                                    <span class="badge badge-success">Aktif</span>
                                                @else
                                                    <span class="badge badge-neutral">Nonaktif</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-5 h-5 opacity-70">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M6.75 3v2.25M17.25 3v2.25M3.75 7.5h16.5" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M4.5 21h15a2.25 2.25 0 0 0 2.25-2.25V8.25A2.25 2.25 0 0 0 19.5 6H4.5A2.25 2.25 0 0 0 2.25 8.25v10.5A2.25 2.25 0 0 0 4.5 21z" />
                                                </svg>
                                                <span class="text-base-content/70">Dibuat</span>
                                            </div>
                                            <div class="mt-1 text-xs text-base-content/80">
                                                {{ $createdAtFormatted ?? '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card bg-base-100 border-2 border-dashed border-base-300">
                            <div class="card-body">
                                <div class="text-sm font-semibold mb-2">Foto KTP</div>
                                <div
                                    class="relative bg-base-200 rounded-xl border-2 border-base-300 border-dashed overflow-hidden max-w-lg">
                                    <img class="w-full h-auto object-cover transition duration-300 ease-in-out @if ($blurKtp) blur-md @endif"
                                        src="{{ rtrim(config('services.api.image_base_url'), '/') . '/' . ltrim($user['foto_ktp'] ?? '', '/') }}"
                                        alt="Foto KTP">
                                    <div class="absolute top-2 right-2 flex items-center gap-2">
                                        <button class="btn btn-xs" wire:click="toggleBlurKtp"
                                            wire:loading.attr="disabled" wire:target="toggleBlurKtp"
                                            aria-label="Toggle Blur">
                                            <span class="inline-flex items-center justify-center gap-1">
                                                @if ($blurKtp)
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M2.036 12.322a1.012 1.012 0 010-.644C3.423 8.517 7.36 6 12 6c4.64 0 8.577 2.517 9.964 5.678.09.196.09.448 0 .644C20.577 15.483 16.64 18 12 18c-4.64 0-8.577-2.517-9.964-5.678z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                    <span>Lihat</span>
                                                @else
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M3.98 8.223A10.477 10.477 0 001.653 12c1.66 3.525 5.583 6 10.347 6 1.582 0 3.087-.262 4.454-.744M6.228 6.228A10.478 10.478 0 0112 6c4.764 0 8.687 2.475 10.347 6a10.467 10.467 0 01-4.523 4.774M6.228 6.228L3 3m3.228 3.228l13.544 13.544M17.772 17.772L21 21" />
                                                    </svg>
                                                    <span>Sembunyikan</span>
                                                @endif
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-sm text-base-content/60">Data tidak tersedia</div>
                @endif
            </div>
        </div>
    </div>
</div>
