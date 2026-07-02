<div class="mt-4 sm:mt-8">
    <div class="w-full" x-transition>
        <!-- Header Section -->
        <div class="mb-8 px-2 flex items-center gap-4">
            <a href="/" wire:navigate
                class="btn btn-circle btn-ghost btn-sm sm:btn-md border-2 border-base-300 hover:border-info hover:text-info transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                    stroke="currentColor" class="size-5 sm:size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
            </a>
            <div>
                <h2 class="text-xl sm:text-2xl font-black italic uppercase tracking-tighter text-base-content">
                    Profil <span class="text-info">Saya</span>
                </h2>
                <p
                    class="text-[10px] sm:text-xs font-medium text-base-content/60 uppercase tracking-widest mt-0.5 sm:mt-1">
                    Informasi dan aktivitas akun
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-1 gap-4 items-center mb-6">
            <!-- Card 1: Ringkasan Profil dan aksi -->
            <div class="bg-base-100 rounded-3xl overflow-hidden self-start">
                <div class="p-6 bg-linier-to-r from-info/10 via-primary/10 to-base-200/30">
                    <div class="flex flex-col items-center text-center gap-4">
                        <div class="avatar">
                            <div class="w-15 h-15 rounded-2xl overflow-hidden shadow">
                                <div class="w-full h-full flex items-center justify-center bg-base-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-18 text-base-content/70">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-1">
                            <h2 class="text-lg sm:text-xl font-black uppercase tracking-tight">
                                {{ $user['name'] ?? 'Guest User' }}</h2>
                            <span class="text-xs text-base-content/70">
                                {{ $user['email'] ?? '-' }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="p-6 border-t border-base-200">
                    <div class="flex flex-row justify-center sm:flex-row gap-2">
                        <button class="btn btn-sm md:btn-sm btn-warning font-bold uppercase"
                            onclick="logout_modal_profile.showModal()" title="Logout">
                            Keluar Dari Akun
                        </button>
                    </div>
                    <livewire:admin::logout />
                </div>
            </div>
        </div>

        {{-- <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">
                <!-- Card 2: Info Pengguna -->
                <div class="bg-base-100 rounded-3xl shadow-xl overflow-hidden self-start">
                    <div class="p-6 bg-base-200/30">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" class="size-5 text-info">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-black italic uppercase tracking-tight">Informasi Akun</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            <div class="bg-base-200/50 p-4 rounded-2xl group hover:border-info/30 transition-all">
                                <p class="text-[10px] font-bold text-base-content/40 uppercase tracking-widest mb-1">
                                    Nama Lengkap</p>
                                <p class="font-bold italic uppercase">{{ $user['name'] ?? '-' }}</p>
                            </div>
                            <div class="bg-base-200/50 p-4 rounded-2xl group hover:border-info/30 transition-all">
                                <p class="text-[10px] font-bold text-base-content/40 uppercase tracking-widest mb-1">
                                    Alamat Email</p>
                                <p class="font-bold italic">{{ $user['email'] ?? '-' }}</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div> --}}

    </div>
</div>
</div>
