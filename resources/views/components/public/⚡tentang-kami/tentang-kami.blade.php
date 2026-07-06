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
                        Tentang <span class="text-info">Kami</span>
                    </h2>
                    <p
                        class="text-[10px] sm:text-xs font-medium text-base-content/60 uppercase tracking-widest mt-0.5 sm:mt-1">
                        Mengenal Kencana Mini Soccer dan Komitmen Kami
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6">
        {{-- Main Content --}}
        <div class="space-y-8 pb-12">
            {{-- Hero Banner Image/Card --}}
            <div class="relative -mx-4 sm:mx-0 rounded-none sm:rounded-3xl overflow-hidden shadow-xl border-y sm:border border-base-300 p-6 sm:p-10 flex flex-col justify-end aspect-[3/2] bg-cover bg-center"
                style="background-image: url('{{ asset('assets/images/landing-pages/banners/slide-3.jpg') }}');">
                <!-- Dark gradient overlay for text readability -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-black/10 z-0"></div>

                <div class="relative z-10">
                    <span
                        class="px-3 py-1 rounded-full bg-info text-info-content text-[10px] sm:text-xs font-black uppercase tracking-widest w-fit mb-4 inline-block">
                        Fasilitas Publik Gratis
                    </span>
                    <h1 class="text-2xl sm:text-4xl font-black uppercase tracking-tighter text-white leading-none">
                        Kencana Mini Soccer
                    </h1>
                    <p class="text-xs sm:text-sm font-medium text-white/80 mt-2 max-w-2xl leading-relaxed">
                        Sebuah sarana olahraga berstandar nasional yang dibangun oleh Pemerintah Kota Pekanbaru untuk
                        seluruh lapisan masyarakat Sukajadi dan sekitarnya.
                    </p>
                </div>
            </div>

            {{-- Sejarah Singkat & Kutipan Walikota --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2 space-y-4">
                    <h3 class="text-lg sm:text-xl font-bold uppercase text-base-content tracking-tight w-fit pb-1">
                        Latar Belakang
                    </h3>
                    <p class="text-sm text-base-content/80 leading-relaxed font-medium">
                        Diresmikan secara langsung oleh <strong>Walikota Pekanbaru H. Agung Nugroho, SE, MM</strong>
                        pada hari <strong>Jumat, 16 Januari 2026</strong>, Lapangan Kencana Mini Soccer merupakan wujud
                        nyata komitmen Pemko Pekanbaru dalam menyediakan ruang publik dan olahraga yang bermutu serta
                        mudah diakses.
                    </p>
                    <p class="text-sm text-base-content/80 leading-relaxed font-medium">
                        Terletak strategis di kawasan <strong>Simpang Melur</strong> (halaman eks Kantor Dinas Kesehatan
                        Kota Pekanbaru, Jalan Dahlia, Kecamatan Sukajadi), fasilitas olahraga ini dibangun sebagai
                        sarana positif untuk mendukung gaya hidup sehat dan mempererat kebersamaan antarwarga kota.
                    </p>
                </div>

                <div
                    class="bg-base-300/50 rounded-2xl border border-base-content/5 p-5 flex flex-col justify-between shadow-sm relative overflow-hidden">
                    <div class="absolute -right-6 -bottom-6 opacity-5 text-base-content">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="size-24">
                            <path
                                d="M11.19 12.07c0-2 .83-4 2.5-5.33L15 8c-1.5 1.17-2 2.17-2 3.5h3v5h-6v-4.43zm-7 0c0-2 .83-4 2.5-5.33L8 8c-1.5 1.17-2 2.17-2 3.5h3v5h-6v-4.43z" />
                        </svg>
                    </div>
                    <p class="text-xs italic font-semibold text-base-content/85 relative z-10 leading-relaxed">
                        "Masyarakat cukup membayar pajak saja, perawatan lapangan akan ditanggung oleh Pemko. Lapangan
                        ini kita pastikan gratis tanpa pungutan pembayaran apapun. Kalau ada pungli, laporkan langsung
                        ke saya."
                    </p>
                    <div class="mt-4 relative z-10">
                        <h4 class="text-xs font-black uppercase text-info italic">H. Agung Nugroho, SE, MM</h4>
                        <span class="text-[9px] text-base-content/50 font-bold uppercase tracking-wider">Walikota
                            Pekanbaru</span>
                    </div>
                </div>
            </div>

            {{-- Ketentuan Pemanfaatan --}}
            <div class="space-y-4">
                <h3 class="text-lg sm:text-xl font-bold uppercase text-base-content tracking-tight w-fit pb-1">
                    Syarat & Aturan Lapangan
                </h3>
                <p class="text-xs sm:text-sm text-base-content/60 font-medium">
                    Demi kenyamanan, ketertiban, and pemeliharaan bersama, seluruh pengguna lapangan diwajibkan mematuhi
                    aturan berikut:
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- Aturan 1 --}}
                    <div class="flex gap-4 p-4 bg-base-100 border border-base-300 rounded-2xl shadow-xs">
                        <div class="w-10 h-10 text-white flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="2.5" stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold uppercase text-base-content tracking-tight">Kawasan Bebas Asap
                                Rokok</h4>
                            <p class="text-xs text-base-content/65 font-medium mt-1 leading-relaxed">
                                Dilarang keras merokok di seluruh area lapangan dan sekitarnya guna mendukung
                                terciptanya lingkungan olahraga yang sehat dan bersih.
                            </p>
                        </div>
                    </div>

                    {{-- Aturan 2 --}}
                    <div class="flex gap-4 p-4 bg-base-100 border border-base-300 rounded-2xl shadow-xs">
                        <div class="w-10 h-10 text-white flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="2.5" stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold uppercase text-base-content tracking-tight">Menjaga Kebersihan
                            </h4>
                            <p class="text-xs text-base-content/65 font-medium mt-1 leading-relaxed">
                                Berlaku prinsip "Masuk bersih, pulang harus bersih". Semua pengguna wajib menjaga
                                kebersihan dan membuang sampah pada tempatnya.
                            </p>
                        </div>
                    </div>

                    {{-- Aturan 3 --}}
                    <div class="flex gap-4 p-4 bg-base-100 border border-base-300 rounded-2xl shadow-xs">
                        <div class="w-10 h-10 text-white flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="2.5" stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold uppercase text-base-content tracking-tight">Berhenti Saat Waktu
                                Salat</h4>
                            <p class="text-xs text-base-content/65 font-medium mt-1 leading-relaxed">
                                Setiap kali memasuki waktu salat bagi umat Muslim, seluruh kegiatan di lapangan wajib
                                dihentikan sementara untuk melaksanakan ibadah salat.
                            </p>
                        </div>
                    </div>

                    {{-- Aturan 4 --}}
                    <div class="flex gap-4 p-4 bg-base-100 border border-base-300 rounded-2xl shadow-xs">
                        <div class="w-10 h-10 text-white flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="2.5" stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold uppercase text-base-content tracking-tight">Gratis & Bebas
                                Pungli</h4>
                            <p class="text-xs text-base-content/65 font-medium mt-1 leading-relaxed">
                                Segala penggunaan fasilitas ini bebas dari biaya sewa apa pun. Laporkan langsung jika
                                Anda mendapati adanya pungutan liar.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Tentang Aplikasi Booking --}}
                <div
                    class="bg-base-100 border-2 border-base-300 rounded-3xl p-6 sm:p-8 flex flex-col md:flex-row items-center gap-6 shadow-sm">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 text-white flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-8 h-8 sm:w-10 sm:h-10">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                        </svg>
                    </div>
                    <div class="flex-1 space-y-2">
                        <h4 class="text-base sm:text-lg font-black uppercase text-base-content italic">
                            Aplikasi Booking Online Kencana Arena
                        </h4>
                        <p class="text-xs sm:text-sm text-base-content/70 leading-relaxed font-medium">
                            Untuk menjamin keadilan akses dan kemudahan pendaftaran bagi seluruh masyarakat Kota
                            Pekanbaru, Dinas Pemuda dan Olahraga (Dispora) Kota Pekanbaru menyediakan platform ini.
                            Melalui portal ini, masyarakat dapat secara transparan melihat jadwal kosong, memilih waktu
                            permainan, dan melakukan pendaftaran secara langsung tanpa birokrasi berbelit.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
