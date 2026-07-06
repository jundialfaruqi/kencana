<div class="mt-4 sm:mt-8">
    {{-- Header Section --}}
    <div class="mb-8 px-2 flex items-center gap-4">
        <div class="flex-1 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="/" wire:navigate
                    class="btn btn-circle btn-ghost btn-sm sm:btn-md border-2 border-base-300 hover:border-info hover:text-info transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                        stroke="currentColor" class="size-5 sm:size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                </a>
                <div>
                    <h2 class="text-xl sm:text-2xl font-black italic uppercase tracking-tighter text-base-content">
                        Fasilitas <span class="text-info">Arena</span>
                    </h2>
                    <p
                        class="text-[10px] sm:text-xs font-medium text-base-content/60 uppercase tracking-widest mt-0.5 sm:mt-1">
                        Daftar Fasilitas Penunjang di Kencana Mini Soccer
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6">
        <div class="space-y-8 pb-12">
            {{-- Grid Fasilitas --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                {{-- Fasilitas 1 --}}
                <div class="bg-base-100 border border-base-300 rounded-3xl p-6 shadow-sm relative overflow-hidden flex flex-col justify-between min-h-[220px]">
                    <div class="space-y-4">
                        <div class="w-12 h-12 text-white flex items-center justify-center">
                            <!-- Soccer ball / Pitch icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                            </svg>
                        </div>
                        <div class="space-y-2">
                            <h4 class="text-lg font-black uppercase text-base-content italic leading-tight">Rumput Sintetis Standar Nasional</h4>
                            <p class="text-xs text-base-content/75 font-medium leading-relaxed">
                                Lapangan menggunakan rumput sintetis berkualitas tinggi berstandar nasional yang empuk dan aman untuk sendi pemain, mengurangi risiko cedera saat berlari dan terjatuh.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Fasilitas 2 --}}
                <div class="bg-base-100 border border-base-300 rounded-3xl p-6 shadow-sm relative overflow-hidden flex flex-col justify-between min-h-[220px]">
                    <div class="space-y-4">
                        <div class="w-12 h-12 text-white flex items-center justify-center">
                            <!-- Lighting icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-12.728l.707.707m12.728 12.728l.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z" />
                            </svg>
                        </div>
                        <div class="space-y-2">
                            <h4 class="text-lg font-black uppercase text-base-content italic leading-tight">Lampu Sorot LED Malam Hari</h4>
                            <p class="text-xs text-base-content/75 font-medium leading-relaxed">
                                Dilengkapi pencahayaan lampu sorot LED berdaya tinggi di sekeliling lapangan untuk menjamin visibilitas maksimal bagi pemain dan penonton hingga sesi malam hari berakhir pukul 22.00 WIB.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Fasilitas 3 --}}
                <div class="bg-base-100 border border-base-300 rounded-3xl p-6 shadow-sm relative overflow-hidden flex flex-col justify-between min-h-[220px]">
                    <div class="space-y-4">
                        <div class="w-12 h-12 text-white flex items-center justify-center">
                            <!-- Bench icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m-10.12 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.705-13.223a3 3 0 11-4.8 3.6 8 8 0 004.8-3.6zm10.12 0a3 3 0 11-4.8 3.6 8 8 0 004.8-3.6zM14 12a4 4 0 11-8 0 4 4 0 018 0zm-2 8a4 4 0 00-8 0v.5A.5.5 0 004.5 21h7a.5.5 0 00.5-.5v-.5z" />
                            </svg>
                        </div>
                        <div class="space-y-2">
                            <h4 class="text-lg font-black uppercase text-base-content italic leading-tight">Tribun Penonton Minimalis</h4>
                            <p class="text-xs text-base-content/75 font-medium leading-relaxed">
                                Tersedia tribun penonton di pinggir lapangan yang nyaman bagi penonton, pemain cadangan, maupun keluarga yang mendampingi untuk mendukung tim bermain secara langsung.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Fasilitas 4 --}}
                <div class="bg-base-100 border border-base-300 rounded-3xl p-6 shadow-sm relative overflow-hidden flex flex-col justify-between min-h-[220px]">
                    <div class="space-y-4">
                        <div class="w-12 h-12 text-white flex items-center justify-center">
                            <!-- Bathroom icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg>
                        </div>
                        <div class="space-y-2">
                            <h4 class="text-lg font-black uppercase text-base-content italic leading-tight">Toilet & Kamar Ganti Bersih</h4>
                            <p class="text-xs text-base-content/75 font-medium leading-relaxed">
                                Fasilitas kamar bilas, toilet, dan area ruang ganti pakaian yang bersih dan terawat untuk kenyamanan sebelum maupun sesudah selesai berolahraga.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Fasilitas 5 --}}
                <div class="bg-base-100 border border-base-300 rounded-3xl p-6 shadow-sm relative overflow-hidden flex flex-col justify-between min-h-[220px]">
                    <div class="space-y-4">
                        <div class="w-12 h-12 text-white flex items-center justify-center">
                            <!-- Mosque / Prayer icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 11.517.517l-.02.041m-5.96 5.96a2.25 2.25 0 003 3h7.5a2.25 2.25 0 003-3v-7.5a2.25 2.25 0 00-3-3h-7.5a2.25 2.25 0 00-3 3v7.5z" />
                            </svg>
                        </div>
                        <div class="space-y-2">
                            <h4 class="text-lg font-black uppercase text-base-content italic leading-tight">Mushola Area Lapangan</h4>
                            <p class="text-xs text-base-content/75 font-medium leading-relaxed">
                                Disediakan mushola di dekat lapangan bagi pemain beragama Islam untuk melaksanakan salat berjamaah begitu memasuki waktu salat (sesuai aturan jeda salat).
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Fasilitas 6 --}}
                <div class="bg-base-100 border border-base-300 rounded-3xl p-6 shadow-sm relative overflow-hidden flex flex-col justify-between min-h-[220px]">
                    <div class="space-y-4">
                        <div class="w-12 h-12 text-white flex items-center justify-center">
                            <!-- Parking icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.129-1.125V11.25M12 9h4.5m-4.5 3h4.5M3.75 6h16.5M3 9h18" />
                            </svg>
                        </div>
                        <div class="space-y-2">
                            <h4 class="text-lg font-black uppercase text-base-content italic leading-tight">Area Parkir Kendaraan</h4>
                            <p class="text-xs text-base-content/75 font-medium leading-relaxed">
                                Area parkir yang luas, aman, dan memadai untuk menampung kendaraan roda dua maupun roda empat tepat di dalam kompleks eks-Dinas Kesehatan.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
