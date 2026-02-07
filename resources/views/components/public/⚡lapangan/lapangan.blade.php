<div wire:init="loadLapangan" class="mt-4 sm:mt-8" x-data>
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
                        Daftar sarana olahraga Aman Arena
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6">
        @if ($isLoading)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @for ($i = 0; $i < 6; $i++)
                    <div class="card bg-base-100 animate-pulse">
                        <figure>
                            <div class="w-full overflow-hidden aspect-video bg-base-300"></div>
                        </figure>
                        <div class="card-body">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex-1">
                                    <div class="h-4 bg-base-300 w-2/3 rounded"></div>
                                    <div class="h-3 bg-base-300 w-3/4 rounded mt-2"></div>
                                </div>
                                <div class="h-5 bg-base-300 w-16 rounded"></div>
                            </div>
                            <div class="mt-3 space-y-2">
                                <div class="flex items-start gap-2 p-2 rounded-xl bg-base-200 border border-base-200">
                                    <div class="w-6 h-6 rounded-2xl bg-base-300"></div>
                                    <div class="flex-1 min-w-0 space-y-2">
                                        <div class="h-3 bg-base-300 w-24 rounded"></div>
                                        <div class="h-3 bg-base-300 w-3/4 rounded"></div>
                                    </div>
                                </div>
                                <div class="flex items-start gap-2">
                                    <div class="h-8 bg-base-300 w-36 rounded-xl -skew-x-12"></div>
                                    <div class="h-8 bg-base-300 w-36 rounded-xl -skew-x-12"></div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-base-300 h-10 rounded-b-xl">
                        </div>
                    </div>
                @endfor
            </div>
        @else
            @if ($error)
                <div class="alert alert-error">
                    <span>{{ $error }}</span>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($lapangan as $lp)
                        <div class="card bg-base-100 opacity-0 translate-y-2 transition-all duration-300 will-change-transform"
                            data-animate-card>
                            <figure>
                                @php $cover = data_get($lp, 'coverUrl'); @endphp
                                @if ($cover)
                                    <div class="w-full overflow-hidden aspect-video bg-base-200 relative">
                                        <img src="{{ $cover }}" class="w-full h-full object-cover"
                                            alt="Cover Lapangan" />
                                        @if (data_get($lp, 'status') !== 'open')
                                            <div
                                                class="absolute inset-0 bg-black/70 backdrop-blur-sm pointer-events-none">
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <div
                                        class="w-full overflow-hidden aspect-video bg-base-200 flex items-center justify-center">
                                        <span class="text-base-content/60 text-sm">no-image</span>
                                    </div>
                                @endif
                            </figure>
                            <div class="card-body">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <h3 class="card-title text-base">
                                            {{ data_get($lp, 'nama_lapangan', '-') }}
                                        </h3>
                                        <p class="text-xs text-base-content/70 mt-1">
                                            @if ((data_get($lp, 'status') ?? '') === 'open')
                                                <p class="text-xs font-medium text-base-content">
                                                    {{ data_get($lp, 'deskripsi', '-') }}
                                                </p>
                                            @else
                                                <p class="text-xs font-medium text-base-content">
                                                    {{ data_get($lp, 'status_label', ucfirst(data_get($lp, 'status', '-'))) }}
                                                </p>
                                            @endif
                                        </p>
                                    </div>
                                    <span
                                        class="{{ data_get($lp, 'status') === 'open' ? 'bg-success text-success-content' : 'bg-warning text-warning-content' }} rounded-md text-center uppercase italic font-bold text-[8px] sm:text-[10px] px-2 py-1 -skew-x-12">
                                        {{ data_get($lp, 'status_label', ucfirst(data_get($lp, 'status', '-'))) }}
                                    </span>
                                </div>
                                <div class="mt-3 space-y-2 text-xs">
                                    <div
                                        class="flex items-center gap-2 p-3 rounded-xl bg-base-200 border border-base-200">
                                        <div class="bg-success p-1.5 rounded-md">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-4 text-white">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-[10px] font-semibold text-base-content/60">Alamat</p>
                                            @if ((data_get($lp, 'status') ?? '') === 'open')
                                                <p class="text-xs font-medium text-base-content">
                                                    {{ data_get($lp, 'alamat', '-') }}
                                                </p>
                                            @else
                                                <p class="text-xs font-medium text-base-content">
                                                    {{ data_get($lp, 'status_label', ucfirst(data_get($lp, 'status', '-'))) }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                    @php $gmap = data_get($lp, 'gmap'); @endphp
                                    @if (!empty($gmap))
                                        <div class="flex items-center gap-2 justify-center sm:justify-start">
                                            <a href="{{ $gmap }}" target="_blank" rel="noopener"
                                                class="btn btn-sm btn-info border-base-300 -skew-x-12">
                                                Lihat di Google Maps
                                            </a>
                                            <a wire:navigate
                                                href="/detail-lapangan/{{ \Illuminate\Support\Str::slug(data_get($lp, 'nama_lapangan', '')) }}"
                                                class="btn btn-sm btn-warning text-white -skew-x-12">
                                                Selengkapnya
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="card-footer text-center rounded-b-xl">
                                <a wire:navigate
                                    href="/booking?lapangan={{ \Illuminate\Support\Str::slug(data_get($lp, 'nama_lapangan', '')) }}"
                                    class="btn btn-info w-full italic uppercase font-black rounded-b-xl rounded-t-none {{ data_get($lp, 'status') !== 'open' ? 'btn-disabled pointer-events-none opacity-50' : '' }}"
                                    aria-disabled="{{ data_get($lp, 'status') !== 'open' ? 'true' : 'false' }}">
                                    @if ((data_get($lp, 'status') ?? '') === 'open')
                                        Pesan Sekarang
                                    @else
                                        {{ data_get($lp, 'status_label', ucfirst(data_get($lp, 'status', '-'))) }}
                                    @endif

                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        @endif
    </div>

    <script>
        function initLapanganAnimations() {
            const cards = document.querySelectorAll('[data-animate-card]');
            let i = 0;
            cards.forEach((el) => {
                setTimeout(() => {
                    el.classList.remove('opacity-0', 'translate-y-2');
                }, i * 40);
                i++;
            });
        }
        window.addEventListener('livewire:navigated', () => {
            initLapanganAnimations();
        });
        document.addEventListener('DOMContentLoaded', () => {
            initLapanganAnimations();
        });
        document.addEventListener('alpine:init', () => {
            initLapanganAnimations();
        });
        window.addEventListener('lapangan-loaded', () => {
            initLapanganAnimations();
        });
    </script>
</div>
