<div data-theme="chaotictoast" wire:init="load" x-data="{ showPassword: false }"
    class="min-h-screen flex items-center justify-center bg-base-300 p-4 font-sans transition-colors duration-500 overflow-hidden relative">
    <!-- Dynamic Mesh Gradient Background -->
    <div class="absolute inset-0 z-0 pointer-events-none opacity-50">
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] rounded-full bg-info blur-[120px] opacity-20">
        </div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] rounded-full bg-warning blur-[120px] opacity-20">
        </div>
    </div>

    <!-- Floating Sporty Elements -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden z-0">
        <!-- Floating Circles/Shapes -->
        <div class="absolute top-20 left-[10%] w-32 h-32 border-4 border-info/10 rounded-full"
            style="animation-duration: 4s"></div>
        <div class="absolute bottom-20 right-[15%] w-48 h-48 border-4 border-warning/10 rounded-full"
            style="animation-duration: 6s"></div>

        <!-- Large Background Text (Sporty Vibe) -->
        <div
            class="absolute top-1/2 left-0 -translate-y-1/2 -translate-x-1/4 rotate-90 text-[15rem] font-black opacity-[0.02] select-none uppercase italic leading-none">
            AMAN
        </div>
        <div
            class="absolute top-1/2 right-0 -translate-y-1/2 translate-x-1/4 -rotate-90 text-[15rem] font-black opacity-[0.02] select-none uppercase italic leading-none text-right">
            ARENA
        </div>
    </div>

    <div wire:key="login-card"
        class="card w-full max-w-md bg-base-200 shadow-[0_0_50px_-12px_rgba(0,0,0,0.5)] overflow-hidden relative z-10">
        <!-- Sporty Accent Line (Top Border with Glow) -->
        <div
            class="absolute top-0 left-0 w-full h-1.5 bg-linear-to-r from-info via-black to-info shadow-[0_0_15px_rgba(var(--p),0.5)]">
        </div>

        @if ($ready)
            <div class="card-body p-8" wire:key="login-form-container">
                <div class="flex flex-col items-center mb-8">
                    <div>
                        <!-- Logo AMAN Arena -->
                        <img src="{{ asset('assets/images/logo/logo-kencana-mini-soccer.webp') }}"
                            alt="Logo Kencana Mini Soccer" class="h-15 w-15 sm:h-25 sm:w-25 object-contain">
                    </div>
                    <h3 class="text-xl sm:text-3xl font-black italic tracking-tighter uppercase text-info">
                        AMAN <span
                            class="text-xl sm:text-3xl text-warning text-center font-black italic tracking-tighter uppercase">
                            ARENA</span>
                    </h3>
                    {{-- <div class="text-xs text-base-content/50 text-center font-bold italic tracking-tighter uppercase">
                        ARENA
                    </div> --}}
                </div>

                <form class="space-y-6" wire:submit.prevent="authenticate">
                    @if ($errors->has('loginError'))
                        <div
                            class="alert bg-warning/20 border border-warning text-white shadow-lg py-2 text-xs font-bold italic uppercase tracking-wider">
                            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-5 w-5"
                                fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ $errors->first('loginError') }}</span>
                        </div>
                    @endif

                    <div class="form-control">
                        <label class="label">
                            <span
                                class="label-text font-bold uppercase tracking-wider text-xs flex items-center gap-2 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5 text-info">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                </svg>
                                Email Address
                            </span>
                        </label>
                        <input type="text" wire:model="email" placeholder="contoh@email.com"
                            class="input input-bordered focus:input-info bg-base-200/50 font-medium w-full italic @error('email') input-warning @enderror"
                            autofocus />
                        @error('email')
                            <label class="label p-0 mt-1">
                                <span class="label-text-alt text-warning italic text-xs">{{ $message }}</span>
                            </label>
                        @enderror
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
                                Password
                            </span>
                        </label>
                        <div class="relative group/input">
                            <input :type="showPassword ? 'text' : 'password'" wire:model="password"
                                placeholder="••••••••"
                                class="input input-bordered focus:input-info bg-base-200/50 w-full pr-12 italic @error('password') input-warning @enderror" />
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
                        @error('password')
                            <label class="label">
                                <span class="label-text-alt text-warning italic text-xs">{{ $message }}</span>
                            </label>
                        @enderror
                        <div class="flex items-center justify-between mt-4">
                            <label class="label text-xs cursor-pointer justify-start gap-3 p-0">
                                <input type="checkbox" class="checkbox checkbox-sm checkbox-info" />
                                <span class="label-text font-medium">Keep me in the game</span>
                            </label>
                            <a href="#"
                                class="label-text-alt text-xs link link-hover text-info italic font-semibold">Forgot
                                Key?</a>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3 mt-4">
                        <button type="submit" wire:loading.attr="disabled"
                            class="btn btn-info text-[10px] -skew-x-12 sm:text-xs font-black italic uppercase tracking-widest shadow-lg group">
                            <span wire:loading.remove>Masuk</span>
                            <span wire:loading>Authenticating...</span>
                            <svg wire:loading.remove xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4 ml-1 transition-transform group-hover:translate-x-1" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                        <a href="/register" wire:navigate
                            class="btn btn-warning text-[10px] -skew-x-12 sm:text-xs font-black italic uppercase tracking-widest shadow-lg group">
                            Buat Akun
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor" class="size-4 ml-1">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                            </svg>
                        </a>
                    </div>

                    <a href="/" wire:navigate
                        class="text-[10px] sm:text-xs font-black italic uppercase tracking-widest text-info hover:text-info/80 transition-colors flex items-center justify-center gap-2 group">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="2.5" stroke="currentColor"
                            class="size-3 transition-transform group-hover:-translate-x-1">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                        </svg>
                        Back to Home
                    </a>
                </form>

                <div class="flex items-center justify-center gap-4 sm:gap-5 mt-8">
                    <img src="{{ asset('assets/images/logo/aman.webp') }}" alt="Aman"
                        class="h-4.5 sm:h-5.5 object-contain">
                    <img src="{{ asset('assets/images/logo/bangun-negeri.webp') }}" alt="Bangun Negeri"
                        class="h-4.5 sm:h-5.5 object-contain">
                    <img src="{{ asset('assets/images/logo/dispora.webp') }}" alt="Dispora"
                        class="h-4.5 sm:h-5.5 object-contain">
                    <img src="{{ asset('assets/images/logo/logo-diskominfo-pekanbaru.webp') }}" alt="Diskominfo"
                        class="h-4.5 sm:h-5.5 object-contain">
                </div>

                <div class="mt-2 text-center border-t border-white/10 pt-3">
                    <p
                        class="text-[10px] sm:text-xs font-medium opacity-50 uppercase tracking-[0.15em] sm:tracking-[0.2em]">
                        Powered by DISKOMINFOTIKSAN
                        Pekanbaru</p>
                </div>
            </div>
        @endif
    </div>
</div>
