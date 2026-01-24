<div wire:init="loadStore" class="mt-4 sm:mt-8">
    {{-- Header Section --}}
    @if ($isLoading)
        <div class="mb-8 px-2 flex items-center gap-4 animate-pulse">
            <div class="w-8 h-8 sm:w-12 sm:h-12 rounded-full bg-base-300"></div>
            <div class="flex-1">
                <div class="h-6 sm:h-8 bg-base-300 w-32 sm:w-48 rounded-lg mb-2"></div>
                <div class="h-3 sm:h-4 bg-base-300 w-48 sm:w-64 rounded-md"></div>
            </div>
            <div class="flex gap-2">
                <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-base-300"></div>
                <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-base-300"></div>
            </div>
        </div>
    @else
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
                            Kencana <span class="text-info">Store</span>
                        </h2>
                        <p
                            class="text-[10px] sm:text-xs font-medium text-base-content/60 uppercase tracking-widest mt-0.5 sm:mt-1">
                            Explore our exclusive gear and official merchandise
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <button class="btn btn-ghost btn-circle btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                    <div class="indicator">
                        <span class="indicator-item badge badge-info badge-xs font-black italic">0</span>
                        <button class="btn btn-ghost btn-circle btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="mt-6">
        @if ($isLoading)
            {{-- Skeleton State --}}
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @for ($i = 0; $i < 8; $i++)
                    <div class="flex flex-col gap-3">
                        <div class="aspect-square w-full bg-base-300 rounded-2xl animate-pulse"></div>
                        <div class="space-y-2">
                            <div class="h-4 bg-base-300 w-3/4 rounded animate-pulse"></div>
                            <div class="h-3 bg-base-300 w-1/2 rounded animate-pulse"></div>
                            <div class="h-8 bg-base-300 w-full rounded-xl animate-pulse mt-2"></div>
                        </div>
                    </div>
                @endfor
            </div>
        @else
            {{-- Main Store Content with Coming Soon Overlay --}}
            <div class="relative min-h-[60vh] rounded-3xl overflow-hidden border-2 border-dashed border-base-300/50">
                {{-- Coming Soon Overlay --}}
                <div
                    class="absolute inset-0 z-20 bg-base-100 flex flex-col items-center justify-center p-6 text-center">
                    <div class="w-20 h-20 rounded-full bg-info/10 flex items-center justify-center mb-6 animate-bounce">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-info" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <h2
                        class="text-4xl md:text-6xl font-black italic uppercase tracking-tighter text-base-content mb-4">
                        Coming <span class="text-info">Soon</span>
                    </h2>
                    <p class="max-w-md text-base-content/60 font-medium leading-relaxed mb-8">
                        Kami sedang menyiapkan koleksi merchandise eksklusif dan perlengkapan olahraga terbaik untuk
                        Anda. Nantikan kehadirannya segera!
                    </p>
                    <div class="flex flex-wrap justify-center gap-4">
                        <div
                            class="bg-base-200 px-6 py-3 rounded-2xl border border-base-300 flex items-center gap-3 group transition-all hover:border-info/30">
                            <div class="w-2 h-2 rounded-full bg-info"></div>
                            <span class="font-black italic uppercase text-xs tracking-widest">Jersey Official</span>
                        </div>
                        <div
                            class="bg-base-200 px-6 py-3 rounded-2xl border border-base-300 flex items-center gap-3 group transition-all hover:border-info/30">
                            <div class="w-2 h-2 rounded-full bg-info"></div>
                            <span class="font-black italic uppercase text-xs tracking-widest">Equipment</span>
                        </div>
                        <div
                            class="bg-base-200 px-6 py-3 rounded-2xl border border-base-300 flex items-center gap-3 group transition-all hover:border-info/30">
                            <div class="w-2 h-2 rounded-full bg-info"></div>
                            <span class="font-black italic uppercase text-xs tracking-widest">Accessories</span>
                        </div>
                    </div>
                </div>

                {{-- Product Grid Placeholder (Blurred) --}}
                <div
                    class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 p-4 opacity-20 pointer-events-none grayscale">
                    @for ($i = 0; $i < 12; $i++)
                        <div class="flex flex-col gap-3">
                            <div class="aspect-square w-full bg-base-300 rounded-2xl"></div>
                            <div class="space-y-2">
                                <div class="h-4 bg-base-300 w-3/4 rounded"></div>
                                <div class="h-3 bg-base-300 w-1/2 rounded"></div>
                                <div class="h-8 bg-base-300 w-full rounded-xl mt-2"></div>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        @endif
    </div>
</div>
