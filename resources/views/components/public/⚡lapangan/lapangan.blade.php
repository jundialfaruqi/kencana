<div class="mt-4 sm:mt-8">
    <!-- Header Section -->
    <div class="mb-8 px-2 flex items-center gap-4">
        <div class="flex-1 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="/" wire:navigate
                    class="btn btn-circle btn-ghost btn-sm sm:btn-md border-2 border-base-300 hover:border-info hover:text-info transition-all"
                    aria-label="Kembali">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                        stroke="currentColor" class="size-5 sm:size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                </a>
                <div>
                    <h2 class="text-xl sm:text-2xl font-black italic uppercase tracking-tighter text-base-content">
                        Daftar <span class="text-info">Arena</span>
                    </h2>
                    <p
                        class="text-[10px] sm:text-xs font-medium text-base-content/60 uppercase tracking-widest mt-0.5 sm:mt-1">
                        Daftar sarana olahraga Kencana Arena
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Grid Layout Section -->
    <div class="mt-6">
        @if ($error)
            <div class="alert alert-error">
                <span>{{ $error }}</span>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($lapangan as $index => $lp)
                    @php
                        $cover = data_get($lp, 'coverUrl');
                        $status = data_get($lp, 'status');
                        $isOpen = $status === 'open';
                        $isFeatured = $index === 0;
                    @endphp

                    @if ($isFeatured)
                        <!-- Card 1: Featured Card (Bento Large, Full-bleed Cover Image Overlay) -->
                        <div
                            class="md:col-span-2 md:row-span-2 relative overflow-hidden rounded-3xl bg-neutral text-neutral-content border border-base-300 shadow-xl min-h-120 md:min-h-145 flex flex-col justify-end group transition-all duration-500 hover:-translate-y-1 hover:shadow-2xl hover:border-info/30">
                            <!-- Background Image -->
                            @if ($cover)
                                <div class="absolute inset-0 z-0">
                                    <img src="{{ $cover }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out"
                                        alt="{{ data_get($lp, 'nama_lapangan') }}" />
                                    <!-- Premium Dark Overlay Gradient -->
                                    <div class="absolute inset-0 bg-linear-to-t from-black via-black/50 to-transparent">
                                    </div>
                                </div>
                            @endif

                            <!-- Status Badge Top Left -->
                            <div class="absolute top-6 left-6 z-10">
                                <span
                                    class="px-4 py-2 text-[10px] sm:text-xs font-black tracking-widest uppercase rounded-full shadow-md backdrop-blur-md italic -skew-x-12 inline-block {{ $isOpen ? 'bg-success text-success-content' : 'bg-warning text-warning-content' }}">
                                    {{ data_get($lp, 'status_label', ucfirst($status)) }}
                                </span>
                            </div>

                            <!-- Content Area -->
                            <div class="relative z-10 p-6 sm:p-8 flex flex-col justify-end h-full">
                                <h3
                                    class="text-3xl sm:text-4xl font-black uppercase italic tracking-tight drop-shadow-md text-white">
                                    {{ data_get($lp, 'nama_lapangan') }}
                                </h3>

                                <p
                                    class="text-sm text-zinc-200 mt-3 max-w-xl line-clamp-3 leading-relaxed drop-shadow-sm font-semibold">
                                    {{ data_get($lp, 'deskripsi') }}
                                </p>

                                <div
                                    class="flex items-center gap-2 mt-4 text-zinc-300 text-xs sm:text-sm drop-shadow-sm font-semibold">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="w-4 h-4 text-info shrink-0">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                    </svg>
                                    <span class="text-left">{{ data_get($lp, 'alamat') }}</span>
                                </div>

                                <!-- Action Buttons -->
                                <div class="mt-8 flex flex-wrap gap-3">
                                    <a wire:navigate
                                        href="/detail-lapangan/{{ \Illuminate\Support\Str::slug(data_get($lp, 'nama_lapangan', '')) }}"
                                        class="btn btn-warning text-white font-extrabold px-6 rounded-xl transition-all -skew-x-12">
                                        Selengkapnya
                                    </a>

                                    @php $gmap = data_get($lp, 'gmap'); @endphp
                                    @if ($gmap)
                                        <a href="{{ $gmap }}" target="_blank" rel="noopener"
                                            class="btn btn-outline border-white/30 hover:border-success hover:bg-success hover:text-success-content text-white font-extrabold px-4 rounded-xl -skew-x-12">
                                            Maps
                                        </a>
                                    @endif

                                    <a wire:navigate
                                        href="/booking?lapangan={{ \Illuminate\Support\Str::slug(data_get($lp, 'nama_lapangan', '')) }}"
                                        class="btn btn-info text-white font-extrabold px-6 rounded-xl transition-all -skew-x-12 ml-auto {{ !$isOpen ? 'btn-disabled pointer-events-none opacity-50' : '' }}">
                                        Pesan Arena
                                    </a>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Cards 2+: Bento Regular Cards (Split cover and details) -->
                        <div
                            class="md:col-span-1 rounded-3xl bg-base-100 border border-base-300 shadow-xl overflow-hidden flex flex-col group transition-all duration-500 hover:-translate-y-1 hover:shadow-2xl hover:border-info/30">
                            <!-- Image Header -->
                            <div class="relative overflow-hidden aspect-video bg-base-200 shrink-0">
                                @if ($cover)
                                    <img src="{{ $cover }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out"
                                        alt="{{ data_get($lp, 'nama_lapangan') }}" />
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-base-200">
                                        <span class="text-base-content/40 text-sm">no-image</span>
                                    </div>
                                @endif

                                <!-- Status Overlay for coming soon or special states -->
                                @if (!$isOpen)
                                    <div
                                        class="absolute inset-0 bg-black/60 backdrop-blur-xs flex items-center justify-center p-4">
                                        <span
                                            class="px-3 py-1.5 text-[10px] font-black tracking-widest uppercase bg-warning text-warning-content rounded-lg shadow-md -skew-x-12">
                                            {{ data_get($lp, 'status_label', ucfirst($status)) }}
                                        </span>
                                    </div>
                                @else
                                    <div class="absolute top-4 left-4">
                                        <span
                                            class="px-3 py-1 text-[9px] font-black tracking-widest uppercase bg-success text-success-content rounded-full shadow-md -skew-x-12">
                                            {{ data_get($lp, 'status_label') }}
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <!-- Card Body -->
                            <div class="p-6 flex-1 flex flex-col text-left">
                                <h3
                                    class="text-xl font-bold uppercase italic text-base-content leading-tight group-hover:text-info transition-colors">
                                    {{ data_get($lp, 'nama_lapangan') }}
                                </h3>

                                <p class="text-xs text-base-content/70 mt-3 line-clamp-3 leading-relaxed flex-1">
                                    {{ data_get($lp, 'deskripsi') }}
                                </p>

                                <div
                                    class="flex items-center gap-1.5 mt-4 text-base-content/50 text-[11px] font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5 shrink-0">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                    </svg>
                                    <span class="line-clamp-1">{{ data_get($lp, 'alamat') }}</span>
                                </div>

                                <!-- CTA Row -->
                                <div class="mt-6 pt-4 border-t border-base-200/60 flex items-center gap-2">
                                    <a wire:navigate
                                        href="/detail-lapangan/{{ \Illuminate\Support\Str::slug(data_get($lp, 'nama_lapangan', '')) }}"
                                        class="btn btn-sm btn-outline border-base-300 hover:border-warning hover:text-warning text-base-content font-bold px-3 rounded-lg -skew-x-12 text-[10px]">
                                        Detail
                                    </a>

                                    <a wire:navigate
                                        href="/booking?lapangan={{ \Illuminate\Support\Str::slug(data_get($lp, 'nama_lapangan', '')) }}"
                                        class="btn btn-sm btn-info text-white font-bold flex-1 rounded-lg -skew-x-12 text-[10px] {{ !$isOpen ? 'btn-disabled pointer-events-none opacity-50' : '' }}">
                                        Pesan Arena
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif
    </div>
</div>
