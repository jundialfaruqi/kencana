<div class="min-h-dvh bg-white flex flex-col">

    {{-- ── Hero / Greeting ── --}}
    <div class="px-4 pt-4 pb-4">
        <div class="text-xl font-black text-gray-900 leading-snug">
            Selamat Datang
        </div>
        <div class="text-xs text-gray-400 mt-1 font-medium">
            Pilih layanan yang ingin Anda gunakan
        </div>
    </div>

    {{-- ── Menu Cards ── --}}
    <div class="px-4 flex-1 space-y-3">

        {{-- Pesan Lapangan --}}
        <a href="{{ route('webview.pesan') }}" wire:navigate
            class="group flex items-center gap-4 p-4 rounded-2xl bg-white shadow-md shadow-gray-200/60 active:scale-[0.98] transition-all duration-150 cursor-pointer">
            <div class="shrink-0 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="#2563eb" class="w-7 h-7">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <div class="text-gray-900 font-black text-base leading-tight">Pesan Lapangan</div>
                <div class="text-gray-400 text-xs font-medium mt-1">Booking arena olahraga Kencana</div>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                stroke="#9ca3af"
                class="w-4 h-4 shrink-0 group-hover:text-gray-900 group-hover:translate-x-0.5 transition-all">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
            </svg>
        </a>

        {{-- Histori Booking --}}
        <a href="{{ route('webview.histori') }}" wire:navigate
            class="group flex items-center gap-4 p-4 rounded-2xl bg-white shadow-md shadow-gray-200/60 active:scale-[0.98] transition-all duration-150 cursor-pointer">
            <div class="shrink-0 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="#2563eb" class="w-7 h-7">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <div class="text-gray-900 font-black text-base leading-tight">Histori Booking</div>
                <div class="text-gray-400 text-xs font-medium mt-1">Riwayat pemesanan Anda</div>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                stroke="#9ca3af"
                class="w-4 h-4 shrink-0 group-hover:text-gray-700 group-hover:translate-x-0.5 transition-all">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
            </svg>
        </a>

    </div>

    {{-- ── Footer ── --}}
    <div class="px-4 py-6 text-center">
        <div class="text-[11px] text-gray-300 font-medium">
            Kencana Arena &bull; Pekanbaru
        </div>
    </div>

</div>
