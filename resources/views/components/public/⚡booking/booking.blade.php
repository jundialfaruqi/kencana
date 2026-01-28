<div class="mt-4 sm:mt-8" wire:init="load">
    @if ($ready)
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
                        Book Your <span class="text-info">Match</span>
                    </h2>
                    <p
                        class="text-[10px] sm:text-xs font-medium text-base-content/60 uppercase tracking-widest mt-0.5 sm:mt-1">
                        Choose your preferred date, time, and arena
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Booking Form -->
                <div class="lg:col-span-2 space-y-10">

                    <!-- 1. Select Date -->
                    <section>
                        <div class="flex items-center gap-3 mb-4 px-2">
                            <div class="w-8 h-8 rounded-lg bg-info/10 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" class="size-5 text-info">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-black italic uppercase tracking-tight">1. Select Date</h3>
                        </div>

                        <div class="carousel carousel-center w-full bg-base-200/30 rounded-2xl p-4 space-x-3">
                            @php
                                $today = now();
                            @endphp
                            @for ($i = 0; $i < 30; $i++)
                                @php
                                    $date = $today->copy()->addDays($i);
                                    $isSelected = $i === 0;
                                @endphp
                                <div class="carousel-item">
                                    <button
                                        class="flex flex-col items-center justify-center w-16 h-20 rounded-xl transition-all {{ $isSelected ? 'bg-info text-info-content shadow-lg shadow-info/20' : 'bg-base-100 hover:bg-base-200 text-base-content/70' }}">
                                        <span class="text-[10px] font-bold uppercase">{{ $date->format('D') }}</span>
                                        <span class="text-xl font-black italic">{{ $date->format('d') }}</span>
                                        <span class="text-[9px] font-bold uppercase">{{ $date->format('M') }}</span>
                                    </button>
                                </div>
                            @endfor
                        </div>
                    </section>

                    <!-- 2. Select Arena & Time (Horizontal Scroll on Mobile) -->
                    <section>
                        <div class="flex items-center gap-3 mb-4 px-2">
                            <div class="w-8 h-8 rounded-lg bg-info/10 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" class="size-5 text-info">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.362 5.214A8.252 8.252 0 0 1 12 21 8.25 8.25 0 0 1 6.038 7.047 8.287 8.287 0 0 0 9 9.601a8.983 8.983 0 0 1 3.361-6.867 8.21 8.21 0 0 0 3 2.48Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 18a3.75 3.75 0 0 0 .495-7.468 5.99 5.99 0 0 0-4.625 3.352A3.75 3.75 0 0 0 12 18Z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-black italic uppercase tracking-tight">2. Select Arena & Time</h3>
                        </div>

                        <div
                            class="carousel carousel-start w-full gap-4 pb-6 px-2 lg:grid lg:grid-cols-2 lg:carousel-none">
                            @php
                                $arenas = [
                                    ['name' => 'Mini Soccer Arena', 'type' => 'Grass', 'price' => 'GRATIS'],
                                    ['name' => 'Badminton Court 1', 'type' => 'Indoor', 'price' => 'GRATIS'],
                                    ['name' => 'Basketball Court', 'type' => 'Premium', 'price' => 'GRATIS'],
                                    ['name' => 'Tennis Court', 'type' => 'Outdoor', 'price' => 'GRATIS'],
                                    ['name' => 'Volleyball Arena', 'type' => 'Team', 'price' => 'GRATIS'],
                                ];
                            @endphp

                            @foreach ($arenas as $index => $arena)
                                @php
                                    $isComingSoon = $arena['name'] !== 'Mini Soccer Arena';
                                @endphp
                                <div class="carousel-item w-[85%] sm:w-95 lg:w-full flex-col gap-3 relative">
                                    <!-- Coming Soon Overlay -->
                                    @if ($isComingSoon)
                                        <div
                                            class="absolute inset-0 z-20 bg-base-200/40 backdrop-blur-[1px] rounded-2xl flex items-center justify-center overflow-hidden border-2 border-dashed border-base-content/10">
                                            <div
                                                class="bg-black/60 backdrop-blur-md px-4 py-2 -skew-x-12 border border-white/20">
                                                <span
                                                    class="text-white text-lg font-black italic uppercase tracking-widest skew-x-12 block">
                                                    Coming Soon
                                                </span>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Arena Header Card -->
                                    <div
                                        class="w-full p-4 rounded-2xl bg-base-100 border-2 {{ $index === 0 ? 'border-info shadow-lg' : 'border-base-200' }} transition-all">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <span
                                                    class="text-[9px] font-black uppercase italic px-1.5 py-0.5 rounded {{ $index === 0 ? 'bg-info text-info-content' : 'bg-base-200 text-base-content/50' }}">
                                                    {{ $arena['type'] }}
                                                </span>
                                                <h4 class="text-base font-black italic uppercase mt-1 leading-none">
                                                    {{ $arena['name'] }}
                                                </h4>
                                            </div>
                                            <div class="text-right">
                                                <span
                                                    class="text-xs font-black italic text-info">{{ $arena['price'] }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Time Grid for this Arena -->
                                    <div class="bg-base-200/40 rounded-2xl p-4 border border-base-200/50">
                                        <div class="grid grid-cols-4 gap-2">
                                            @for ($h = 6; $h <= 22; $h++)
                                                @php
                                                    $time = sprintf('%02d:00', $h);
                                                    $isBooked = in_array($h, [10, 14, 15, 19]);
                                                    $isSelected = !$isComingSoon && $index === 0 && $h === 8;
                                                @endphp
                                                <button {{ $isBooked || $isComingSoon ? 'disabled' : '' }}
                                                    class="py-2 rounded-lg font-black italic text-[10px] transition-all
                                                    {{ $isBooked || $isComingSoon
                                                        ? 'bg-base-300/50 text-base-content/10 cursor-not-allowed line-through'
                                                        : ($isSelected
                                                            ? 'bg-info text-info-content shadow-md shadow-info/20'
                                                            : 'bg-base-100 hover:bg-info/10 hover:text-info border border-transparent hover:border-info/20') }}">
                                                    {{ $time }}
                                                </button>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Legend -->
                        <div
                            class="mt-2 flex flex-wrap gap-x-4 gap-y-2 text-[9px] font-bold uppercase tracking-widest text-base-content/50 px-4">
                            <div class="flex items-center gap-1.5">
                                <div class="w-2.5 h-2.5 rounded bg-base-100 border border-base-300"></div>
                                Available
                            </div>
                            <div class="flex items-center gap-1.5">
                                <div class="w-2.5 h-2.5 rounded bg-info"></div>
                                Selected
                            </div>
                            <div class="flex items-center gap-1.5">
                                <div class="w-2.5 h-2.5 rounded bg-base-300/50 line-through"></div>
                                Booked
                            </div>
                        </div>
                    </section>
                </div>

                <!-- Sidebar / Summary -->
                <div class="lg:col-span-1">
                    <div class="sticky top-6 space-y-6">
                        <div class="bg-base-100 rounded-3xl border-2 border-base-200 overflow-hidden shadow-xl">
                            <div class="bg-info p-6">
                                <h4 class="text-info-content font-black italic uppercase tracking-tighter text-xl">
                                    Booking
                                    Summary</h4>
                            </div>
                            <div class="p-6 space-y-4">
                                <div
                                    class="flex justify-between items-center py-2 border-b border-base-200 border-dashed">
                                    <span class="text-xs font-bold uppercase text-base-content/50">Arena</span>
                                    <span class="font-black italic uppercase text-sm">Mini Soccer Arena</span>
                                </div>
                                <div
                                    class="flex justify-between items-center py-2 border-b border-base-200 border-dashed">
                                    <span class="text-xs font-bold uppercase text-base-content/50">Date</span>
                                    <span
                                        class="font-black italic uppercase text-sm">{{ now()->format('d M Y') }}</span>
                                </div>
                                <div
                                    class="flex justify-between items-center py-2 border-b border-base-200 border-dashed">
                                    <span class="text-xs font-bold uppercase text-base-content/50">Time Slot</span>
                                    <span class="font-black italic uppercase text-sm">08:00 - 09:00</span>
                                </div>

                                <div class="pt-4">
                                    <div class="flex justify-between items-end">
                                        <span class="text-xs font-bold uppercase text-base-content/50">Total
                                            Biaya</span>
                                        <span class="text-2xl font-black italic text-info leading-none">GRATIS</span>
                                    </div>
                                </div>

                                <button
                                    class="btn btn-info w-full mt-6 -skew-x-12 italic font-black uppercase text-lg h-14 shadow-lg shadow-info/20">
                                    <span class="skew-x-12">Konfirmasi Booking</span>
                                </button>
                            </div>
                        </div>

                        <!-- Sporty Info Card -->
                        <div class="bg-warning rounded-3xl p-6 shadow-lg">
                            <div class="flex items-center gap-3 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2.5" stroke="currentColor" class="size-6 text-warning-content">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                                </svg>
                                <h5 class="font-black italic uppercase text-warning-content">Sporty Rules</h5>
                            </div>
                            <ul class="text-[10px] font-bold uppercase text-warning-content/80 space-y-1">
                                <li>• Wear proper sports shoes</li>
                                <li>• Be on time for your slot</li>
                                <li>• Keep the arena clean</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Skeleton Loading -->
        <div class="w-full animate-pulse">
            <!-- Header Skeleton -->
            <div class="mb-8 px-2 flex items-center gap-4">
                <div class="size-8 sm:size-12 rounded-full bg-base-300"></div>
                <div>
                    <div class="h-6 sm:h-8 bg-base-300 w-48 sm:w-64 rounded-lg"></div>
                    <div class="h-3 sm:h-4 bg-base-300 w-32 sm:w-48 mt-2 rounded-lg"></div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Form Skeleton -->
                <div class="lg:col-span-2 space-y-10">
                    <!-- Date Skeleton -->
                    <section>
                        <div class="flex items-center gap-3 mb-4 px-2">
                            <div class="w-8 h-8 rounded-lg bg-base-300"></div>
                            <div class="h-6 bg-base-300 w-32 rounded"></div>
                        </div>
                        <div class="carousel carousel-center w-full bg-base-200/30 rounded-2xl p-4 space-x-3">
                            @for ($i = 0; $i < 7; $i++)
                                <div class="carousel-item">
                                    <div class="w-16 h-20 bg-base-300 rounded-xl"></div>
                                </div>
                            @endfor
                        </div>
                    </section>

                    <!-- Arena & Time Skeleton -->
                    <section>
                        <div class="flex items-center gap-3 mb-4 px-2">
                            <div class="w-8 h-8 rounded-lg bg-base-300"></div>
                            <div class="h-6 bg-base-300 w-48 rounded"></div>
                        </div>
                        <div
                            class="carousel carousel-start w-full gap-4 pb-6 px-2 lg:grid lg:grid-cols-2 lg:carousel-none">
                            @for ($i = 0; $i < 2; $i++)
                                <div class="carousel-item w-[85%] sm:w-95 lg:w-full flex-col gap-3">
                                    <!-- Header Card Skeleton -->
                                    <div class="w-full p-4 rounded-2xl bg-base-200 border-2 border-base-300/30 h-20">
                                        <div class="flex justify-between items-start">
                                            <div class="space-y-2">
                                                <div class="h-3 bg-base-300 w-16 rounded"></div>
                                                <div class="h-5 bg-base-300 w-32 rounded"></div>
                                            </div>
                                            <div class="h-4 bg-base-300 w-20 rounded"></div>
                                        </div>
                                    </div>
                                    <!-- Time Grid Skeleton -->
                                    <div class="bg-base-200/40 rounded-2xl p-4 border border-base-200/50">
                                        <div class="grid grid-cols-4 gap-2">
                                            @for ($j = 0; $j < 12; $j++)
                                                <div class="h-8 bg-base-300 rounded-lg"></div>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </section>
                </div>

                <!-- Sidebar Skeleton -->
                <div class="lg:col-span-1">
                    <div class="sticky top-6 space-y-6">
                        <div class="bg-base-100 rounded-3xl border-2 border-base-200 overflow-hidden shadow-xl">
                            <div class="h-16 bg-base-300"></div>
                            <div class="p-6 space-y-6">
                                @for ($i = 0; $i < 3; $i++)
                                    <div class="flex justify-between">
                                        <div class="h-4 bg-base-300 w-16 rounded"></div>
                                        <div class="h-4 bg-base-300 w-24 rounded"></div>
                                    </div>
                                @endfor
                                <div class="pt-4">
                                    <div class="flex justify-between items-end">
                                        <div class="h-3 bg-base-300 w-20 rounded"></div>
                                        <div class="h-8 bg-base-300 w-24 rounded"></div>
                                    </div>
                                </div>
                                <div class="h-14 bg-base-300 rounded-xl mt-6"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
