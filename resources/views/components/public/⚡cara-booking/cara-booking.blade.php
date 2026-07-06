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
                        Cara <span class="text-info">Booking</span>
                    </h2>
                    <p
                        class="text-[10px] sm:text-xs font-medium text-base-content/60 uppercase tracking-widest mt-0.5 sm:mt-1">
                        Panduan Langkah Demi Langkah Pemesanan Lapangan
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6">
        <div class="space-y-8 pb-12">
            {{-- Stepper / Timeline Layout --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                {{-- Langkah 1 --}}
                <div
                    class="bg-base-100 border border-base-300 rounded-3xl p-6 shadow-sm relative overflow-hidden flex flex-col justify-between min-h-[200px]">
                    <div class="absolute -right-4 -top-4 opacity-5 text-base-content font-black text-8xl">1</div>
                    <div class="space-y-3">
                        <span class="text-xs font-black uppercase text-info tracking-wider">Langkah 01</span>
                        <h4 class="text-lg font-black uppercase text-base-content leading-tight">Registrasi & Login</h4>
                        <p class="text-xs text-base-content/75 font-medium leading-relaxed">
                            Buat akun baru di menu <a href="/register" wire:navigate
                                class="text-info font-bold underline">Daftar</a> menggunakan nama lengkap asli dan nomor
                            WhatsApp aktif. Pastikan data yang dimasukkan benar. Setelah mendaftar, lakukan <a
                                href="/login" wire:navigate class="text-info font-bold underline">Masuk</a> ke akun
                            Anda.
                        </p>
                    </div>
                </div>

                {{-- Langkah 2 --}}
                <div
                    class="bg-base-100 border border-base-300 rounded-3xl p-6 shadow-sm relative overflow-hidden flex flex-col justify-between min-h-[200px]">
                    <div class="absolute -right-4 -top-4 opacity-5 text-base-content font-black text-8xl">2</div>
                    <div class="space-y-3">
                        <span class="text-xs font-black uppercase text-info tracking-wider">Langkah 02</span>
                        <h4 class="text-lg font-black uppercase text-base-content leading-tight">Pilih Jadwal & Lapangan
                        </h4>
                        <p class="text-xs text-base-content/75 font-medium leading-relaxed">
                            Masuk ke halaman utama / <a href="/booking" wire:navigate
                                class="text-info font-bold underline">Pemesanan</a>. Pilih lapangan mini soccer yang
                            diinginkan, tentukan tanggal bermain, lalu cari jam/sesi sesi permainan yang statusnya masih
                            kosong (tersedia).
                        </p>
                    </div>
                </div>

                {{-- Langkah 3 --}}
                <div
                    class="bg-base-100 border border-base-300 rounded-3xl p-6 shadow-sm relative overflow-hidden flex flex-col justify-between min-h-[200px]">
                    <div class="absolute -right-4 -top-4 opacity-5 text-base-content font-black text-8xl">3</div>
                    <div class="space-y-3">
                        <span class="text-xs font-black uppercase text-info tracking-wider">Langkah 03</span>
                        <h4 class="text-lg font-black uppercase text-base-content leading-tight">Dapatkan QR Code</h4>
                        <p class="text-xs text-base-content/75 font-medium leading-relaxed">
                            Masukkan nama tim/klub Anda dan selesaikan booking. Tiket pemesanan digital beserta **QR
                            Code** unik akan langsung terbit dan dapat Anda lihat kapan saja di menu <a
                                href="/booking-history" wire:navigate class="text-info font-bold underline">History</a>
                            akun Anda.
                        </p>
                    </div>
                </div>

                {{-- Langkah 4 --}}
                <div
                    class="bg-base-100 border border-base-300 rounded-3xl p-6 shadow-sm relative overflow-hidden flex flex-col justify-between min-h-[200px]">
                    <div class="absolute -right-4 -top-4 opacity-5 text-base-content font-black text-8xl">4</div>
                    <div class="space-y-3">
                        <span class="text-xs font-black uppercase text-info tracking-wider">Langkah 04</span>
                        <h4 class="text-lg font-black uppercase text-base-content leading-tight">Datang & Main</h4>
                        <p class="text-xs text-base-content/75 font-medium leading-relaxed">
                            Datanglah ke lapangan Kencana Mini Soccer 15 menit sebelum sesi dimulai. Jangan lupa untuk
                            melakukan tangkapan layar (*screenshot*) QR Code tiket booking Anda untuk ditunjukkan ke
                            petugas.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Aturan Penting Verifikasi NIK & KTP di Lapangan --}}
            <div
                class="bg-error/10 border-2 border-error/20 rounded-3xl p-6 sm:p-8 flex flex-col md:flex-row items-center gap-6 shadow-sm">
                <div class="w-16 h-16 sm:w-20 sm:h-20 text-white flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-8 h-8 sm:w-10 sm:h-10">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div class="flex-1 space-y-2">
                    <h4 class="text-base sm:text-lg font-black uppercase text-error leading-none">
                        PENTING: Alur Verifikasi NIK & KTP oleh Petugas
                    </h4>
                    <p class="text-xs sm:text-sm text-base-content/85 leading-relaxed font-semibold">
                        Setibanya di lokasi lapangan Kencana Mini Soccer, pemesan wajib melakukan verifikasi fisik
                        kepada petugas jaga:
                    </p>
                    <ul class="list-disc pl-5 text-xs text-base-content/75 space-y-1 font-medium">
                        <li>Petugas akan melakukan pemindaian (**Scan QR Code**) tiket digital yang Anda peroleh dari
                            aplikasi ini.</li>
                        <li>Pemesan wajib menunjukkan **KTP asli fisik**. Petugas akan melakukan pemeriksaan kecocokan
                            antara **Nomor NIK** yang tertera di KTP fisik Anda dengan nomor NIK yang terdaftar pada
                            detail booking.</li>
                        <li>Jika nomor NIK di KTP tidak sama dengan NIK pada sistem booking, atau tidak dapat
                            menunjukkan KTP fisik asli, petugas berwenang penuh untuk membatalkan booking Anda dan
                            menolak memberikan izin bermain di lapangan.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
