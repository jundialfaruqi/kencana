<div class="mt-4 sm:mt-8">
    {{-- Header Section --}}
    <div class="mb-8 px-2 flex items-center gap-4">
        <div class="flex-1 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="/" wire:navigate
                    class="btn btn-circle btn-ghost btn-sm sm:btn-md border-2 border-base-300 hover:border-info hover:text-info transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                        stroke="currentColor" class="size-5 sm:size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                </a>
                <div>
                    <h2 class="text-xl sm:text-2xl font-black italic uppercase tracking-tighter text-base-content">
                        Kontak <span class="text-info">Kami</span>
                    </h2>
                    <p
                        class="text-[10px] sm:text-xs font-medium text-base-content/60 uppercase tracking-widest mt-0.5 sm:mt-1">
                        Informasi Pengelola Kencana Arena
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6">
        <div class="space-y-8 pb-12">
            {{-- Info Card Pengelola --}}
            <div
                class="bg-base-100 border border-base-300 rounded-3xl p-6 sm:p-10 shadow-sm relative overflow-hidden space-y-6">
                <!-- Background decor -->
                <div class="absolute -right-24 -top-24 w-64 h-64 rounded-full bg-info/5 blur-3xl -z-10"></div>

                <span
                    class="px-3 py-1 rounded-full bg-info/10 text-info text-[10px] sm:text-xs font-black uppercase tracking-widest w-fit inline-block">
                    Instansi Pengelola
                </span>

                <div class="space-y-3">
                    <h3
                        class="text-2xl sm:text-3xl font-black uppercase tracking-tighter text-base-content leading-none">
                        Pemerintah Kota (Pemko) Pekanbaru
                    </h3>
                    <p class="text-sm text-base-content/70 font-medium leading-relaxed">
                        Fasilitas olahraga Kencana Mini Soccer merupakan sarana publik milik **Pemerintah Kota (Pemko)
                        Pekanbaru** yang disediakan secara gratis bagi seluruh masyarakat Pekanbaru. Penyelenggaraan
                        operasional, pemeliharaan, serta administrasi pendaftaran sehari-hari dikelola secara resmi oleh
                        **Dinas Kepemudaan dan Olahraga (Dispora) Kota Pekanbaru**.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-base-300">
                    {{-- Alamat Kantor --}}
                    <div class="space-y-2">
                        <span class="text-[10px] text-base-content/50 font-bold uppercase tracking-wider block">Alamat
                            Kantor Pusat</span>
                        <div class="flex gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="size-5 text-info shrink-0 mt-0.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0z" />
                            </svg>
                            <p class="text-sm text-base-content/85 font-semibold leading-relaxed">
                                Jl. Sumatera No. 11, Simpang Empat, Kec. Pekanbaru Kota, Kota Pekanbaru, Riau 28121
                            </p>
                        </div>
                    </div>

                    {{-- Lokasi Lapangan --}}
                    <div class="space-y-2">
                        <span class="text-[10px] text-base-content/50 font-bold uppercase tracking-wider block">Lokasi
                            Lapangan Kencana</span>
                        <div class="flex gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="size-5 text-warning shrink-0 mt-0.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0z" />
                            </svg>
                            <p class="text-sm text-base-content/85 font-semibold leading-relaxed">
                                Simpang Melur (Halaman eks Kantor Dinas Kesehatan Pekanbaru), Jalan Dahlia, Kecamatan
                                Sukajadi, Kota Pekanbaru
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Layanan Aspirasi & Pengaduan --}}
            <div class="bg-base-300/40 border border-base-300 rounded-3xl p-6 sm:p-8 space-y-4">
                <h4 class="text-base sm:text-lg font-black uppercase text-base-content tracking-tight">
                    Layanan Pengaduan & Aspirasi
                </h4>
                <p class="text-xs sm:text-sm text-base-content/75 font-medium leading-relaxed">
                    Apabila Anda menemui kendala saat melakukan pemesanan online, menemukan indikasi pungutan liar
                    (pungli) di lapangan, atau memiliki saran untuk peningkatan fasilitas olahraga Kencana Arena, Anda
                    dipersilakan untuk mendatangi Kantor Dinas Kepemudaan dan Olahraga Kota Pekanbaru secara langsung
                    pada jam kerja operasional dinas (Senin - Jumat).
                </p>
            </div>
        </div>
    </div>
</div>
