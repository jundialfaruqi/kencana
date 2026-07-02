@php
    $name = trim($user['name'] ?? 'Guest');
    $parts = preg_split('/\s+/', $name);
    $initials = '';
    foreach (array_slice($parts, 0, 2) as $part) {
        $initials .= strtoupper(mb_substr($part, 0, 1));
    }
@endphp

<div class="w-full flex-1 pt-8 pb-28 px-4 md:px-8 flex flex-col" x-data>
    <div class="max-w-2xl mx-auto w-full">

        <!-- Info Pengguna Utama (Sederhana, Tengah, 1 Kolom) -->
        <div class="flex flex-col items-center text-center space-y-4 mb-12">
            <!-- Avatar Circle -->
            <div
                class="w-24 h-24 rounded-full bg-linear-to-br from-blue-600 to-indigo-600 flex items-center justify-center shadow-md text-white font-bold text-3xl">
                {{ $initials }}
            </div>
            <div class="space-y-1">
                <h2 class="text-3xl font-bold text-slate-100 capitalize">
                    {{ $user['name'] ?? 'Guest' }}
                </h2>
                <div class="flex items-center justify-center gap-2 text-slate-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5 shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                    </svg>
                    <span class="text-lg">{{ $user['email'] ?? '-' }}</span>
                </div>
            </div>
        </div>

        <!-- Pengaturan Akun (Tanpa Card) -->
        <div class="space-y-3">
            <h3 class="text-sm font-semibold text-slate-900 uppercase tracking-wider mb-4">
                Pengaturan Akun
            </h3>

            <button @click="$dispatch('toast', { title: 'Info', message: 'Fitur belum tersedia', type: 'info' })"
                class="w-full flex items-center justify-between p-4 rounded-2xl bg-white hover:bg-slate-50 border border-slate-200 transition-all group">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5 text-slate-600">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                    </div>
                    <div class="text-left">
                        <p class="font-semibold text-slate-900">Informasi Pribadi</p>
                        <p class="text-xs text-slate-500 mt-0.5">Ubah nama dan data pribadi</p>
                    </div>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-5 h-5 text-slate-400 group-hover:text-slate-900 transition-colors">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
            </button>

            <button onclick="logout_modal_profile.showModal()"
                class="w-full flex items-center justify-between p-4 rounded-2xl bg-white hover:bg-red-50 border border-slate-200 hover:border-red-200 transition-all group">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5 text-red-600">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.25 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                        </svg>
                    </div>
                    <div class="text-left">
                        <p class="font-semibold text-red-600">Keluar Aplikasi</p>
                        <p class="text-xs text-red-500/70 mt-0.5">Akhiri sesi Anda saat ini</p>
                    </div>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-5 h-5 text-red-400 group-hover:text-red-600 transition-colors">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
            </button>
        </div>

        <livewire:admin::logout />
    </div>
</div>
