<div data-theme="chaotictoast" wire:init="load" x-data="{ showPassword: false }"
    class="min-h-screen flex items-center justify-center bg-base-300 p-4 font-sans transition-colors duration-500 overflow-hidden relative">
    <!-- Dynamic Mesh Gradient Background -->
    <div class="absolute inset-0 z-0 pointer-events-none opacity-50">
        <div
            class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] rounded-full bg-info blur-[120px] opacity-20 animate-pulse">
        </div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] rounded-full bg-warning blur-[120px] opacity-20">
        </div>
    </div>

    <!-- Floating Sporty Elements -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden z-0">
        <!-- Floating Circles/Shapes -->
        <div class="absolute top-20 left-[10%] w-32 h-32 border-4 border-info/10 rounded-full animate-bounce"
            style="animation-duration: 4s"></div>
        <div class="absolute bottom-20 right-[15%] w-48 h-48 border-4 border-warning/10 rounded-full animate-bounce"
            style="animation-duration: 6s"></div>

        <!-- Large Background Text (Sporty Vibe) -->
        <div
            class="absolute top-1/2 left-0 -translate-y-1/2 -translate-x-1/4 rotate-90 text-[15rem] font-black opacity-[0.02] select-none uppercase italic leading-none">
            KENCANA
        </div>
        <div
            class="absolute top-1/2 right-0 -translate-y-1/2 translate-x-1/4 -rotate-90 text-[15rem] font-black opacity-[0.02] select-none uppercase italic leading-none text-right">
            SPORT
        </div>
    </div>

    <!-- Background Sporty Pattern Overlay (More visible Diagonal Lines) -->
    {{-- <div class="absolute inset-0 pointer-events-none z-1 opacity-[0.08]"
        style="background-image: url('data:image/svg+xml,%3Csvg width=\'40\' height=\'40\' viewBox=\'0 0 40 40\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M0 40L40 0H20L0 20M40 40V20L20 40\' fill=\'%23888888\' fill-rule=\'evenodd\'/%3E%3C/svg%3E');">
    </div> --}}

    <div wire:key="login-card"
        class="card w-full max-w-md bg-base backdrop-blur-xl shadow-[0_0_50px_-12px_rgba(0,0,0,0.5)] border border-white/10 overflow-hidden relative z-10">
        <!-- Sporty Accent Line (Top Border with Glow) -->
        <div
            class="absolute top-0 left-0 w-full h-1.5 bg-linear-to-r from-info via-black to-info shadow-[0_0_15px_rgba(var(--p),0.5)]">
        </div>

        @if ($ready)
            <div class="card-body p-8" wire:key="login-form-container" x-transition>
                <div class="flex flex-col items-center mb-8">
                    <div>
                        <!-- Logo Kencana Mini Soccer -->
                        <img src="{{ asset('assets/images/logo/logo-kencana-mini-soccer.webp') }}"
                            alt="Logo Kencana Mini Soccer" class="h-15 w-15 sm:h-25 sm:w-25 object-contain">
                    </div>
                    <h3 class="text-xl sm:text-3xl font-black italic tracking-tighter uppercase text-info">
                        KENCANA <span class="text-warning">SPORT</span>
                    </h3>
                    <div class="text-xs text-base-content text-center font-bold italic tracking-tighter uppercase">MINI
                        SOCCER</div>
                </div>

                <form class="space-y-6">
                    <div class="form-control">
                        <label class="label">
                            <span
                                class="label-text font-bold uppercase tracking-wider text-xs flex items-center gap-2 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5 text-info">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                </svg>
                                Admin Email
                            </span>
                        </label>
                        <input type="email" placeholder="admin@kencana.com"
                            class="input input-bordered focus:input-info bg-base-200/50 font-medium w-full" required
                            autofocus />
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span
                                class="label-text font-bold uppercase tracking-wider text-xs flex items-center gap-2 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5 text-info">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                                </svg>
                                Access Key
                            </span>
                        </label>
                        <div class="relative group/input">
                            <input :type="showPassword ? 'text' : 'password'" placeholder="••••••••"
                                class="input input-bordered focus:input-info bg-base-200/50 mb-2 w-full pr-12"
                                required />
                            <div class="absolute right-4 top-2">
                                <label class="swap text-base-content/30 hover:text-info transition-colors">
                                    <input type="checkbox" x-model="showPassword" />

                                    <!-- eye icon (show) -->
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="swap-on size-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M13.5 10.5V6.75a4.5 4.5 0 1 1 9 0v3.75M3.75 21.75h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H3.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                                    </svg>

                                    <!-- eye-slash icon (hide) -->
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="swap-off size-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                                    </svg>
                                </label>
                            </div>
                        </div>
                        <label class="label justify-end">
                            <a href="#" class="label-text-alt link link-hover text-info font-semibold">Forgot
                                Key?</a>
                        </label>
                    </div>

                    <div class="form-control">
                        <label class="label cursor-pointer justify-start gap-3">
                            <input type="checkbox" class="checkbox checkbox-sm checkbox-info" />
                            <span class="label-text font-medium">Keep me in the game</span>
                        </label>
                    </div>

                    <div class="card-actions mt-4">
                        <button type="button"
                            class="btn btn-info btn-block text-sm sm:text-lg font-black italic uppercase tracking-widest shadow-lg group">
                            Enter Kencana
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 ml-2 transition-transform group-hover:translate-x-1" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </div>
                    <a href="/" wire:navigate
                        class="text-[10px] sm:text-xs font-black italic uppercase tracking-widest text-info hover:text-info/80 transition-colors flex items-center justify-center gap-2 group">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                            stroke="currentColor" class="size-3 transition-transform group-hover:-translate-x-1">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                        </svg>
                        Back to Home
                    </a>
                </form>

                <div class="mt-4 text-center border-t border-white/10 pt-6">
                    <p
                        class="text-[10px] sm:text-xs font-medium opacity-50 uppercase tracking-[0.15em] sm:tracking-[0.2em]">
                        Powered by DISKOMINFOTIKSAN
                        Pekanbaru</p>
                </div>
            </div>
        @endif
    </div>
</div>
