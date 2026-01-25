<div data-theme="chaotictoast" wire:init="load" x-data="{ showPassword: false, showConfirmPassword: false }"
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

    <div wire:key="register-card"
        class="card w-full max-w-md bg-base backdrop-blur-xl shadow-[0_0_50px_-12px_rgba(0,0,0,0.5)] border border-white/10 overflow-hidden relative z-10 my-8">
        <!-- Sporty Accent Line (Top Border with Glow) -->
        <div
            class="absolute top-0 left-0 w-full h-1.5 bg-linear-to-r from-info via-black to-info shadow-[0_0_15px_rgba(var(--p),0.5)]">
        </div>

        @if ($ready)
            <div class="card-body p-8" wire:key="register-form-container" x-transition>
                <div class="flex flex-col items-center mb-8">
                    <div>
                        <!-- Logo Kencana Mini Soccer -->
                        <img src="{{ asset('assets/images/logo/logo-kencana-mini-soccer.webp') }}"
                            alt="Logo Kencana Mini Soccer" class="h-15 w-15 sm:h-25 sm:w-25 object-contain">
                    </div>
                    <h3 class="text-xl sm:text-3xl font-black italic tracking-tighter uppercase text-warning">
                        DAFTAR <span class="text-info">KENCANA</span>
                    </h3>
                    <div class="text-xs text-base-content text-center font-bold italic tracking-tighter uppercase">MINI
                        SOCCER</div>
                </div>

                <form class="space-y-6">
                    <!-- Nama -->
                    <div class="form-control">
                        <label class="label">
                            <span
                                class="label-text font-bold uppercase tracking-wider text-xs flex items-center gap-2 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5 text-info">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>
                                Nama Lengkap
                            </span>
                        </label>
                        <input type="text" placeholder="Masukkan nama lengkap"
                            class="input input-bordered focus:input-info bg-base-200/50 font-medium w-full italic h-10"
                            required autofocus />
                    </div>

                    <!-- Email -->
                    <div class="form-control">
                        <label class="label">
                            <span
                                class="label-text font-bold uppercase tracking-wider text-xs flex items-center gap-2 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5 text-info">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                </svg>
                                Email
                            </span>
                        </label>
                        <input type="email" placeholder="contoh@email.com"
                            class="input input-bordered focus:input-info bg-base-200/50 font-medium w-full italic h-10"
                            required />
                    </div>

                    <!-- No HP -->
                    <div class="form-control">
                        <label class="label">
                            <span
                                class="label-text font-bold uppercase tracking-wider text-xs flex items-center gap-2 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5 text-info">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M10.5 1.5H8.25A2.25 2.25 0 0 0 6 3.75v16.5a2.25 2.25 0 0 0 2.25 2.25h7.5A2.25 2.25 0 0 0 18 20.25V3.75a2.25 2.25 0 0 0-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                                </svg>
                                Nomor WhatsApp
                            </span>
                        </label>
                        <input type="tel" placeholder="08123456789"
                            class="input input-bordered focus:input-info bg-base-200/50 font-medium w-full italic h-10"
                            required />
                    </div>

                    <!-- Alamat -->
                    <div class="form-control">
                        <label class="label">
                            <span
                                class="label-text font-bold uppercase tracking-wider text-xs flex items-center gap-2 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5 text-info">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                </svg>
                                Alamat Lengkap
                            </span>
                        </label>
                        <textarea placeholder="Masukkan alamat lengkap"
                            class="textarea textarea-bordered focus:textarea-info bg-base-200/50 font-medium w-full italic h-20 resize-none"
                            required></textarea>
                    </div>

                    <!-- Password -->
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
                            <input :type="showPassword ? 'text' : 'password'" placeholder="••••••••"
                                class="input input-bordered focus:input-info bg-base-200/50 w-full pr-12 italic h-10"
                                required />
                            <div class="absolute right-4 top-2">
                                <label class="swap text-base-content/30 hover:text-info transition-colors">
                                    <input type="checkbox" x-model="showPassword" />
                                    <!-- eye icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="swap-on size-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                    <!-- eye-slash icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="swap-off size-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                    </svg>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-control">
                        <label class="label">
                            <span
                                class="label-text font-bold uppercase tracking-wider text-xs flex items-center gap-2 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5 text-info">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                                </svg>
                                Konfirmasi Password
                            </span>
                        </label>
                        <div class="relative group/input">
                            <input :type="showConfirmPassword ? 'text' : 'password'" placeholder="••••••••"
                                class="input input-bordered focus:input-info bg-base-200/50 w-full pr-12 italic h-10"
                                required />
                            <div class="absolute right-4 top-2">
                                <label class="swap text-base-content/30 hover:text-info transition-colors">
                                    <input type="checkbox" x-model="showConfirmPassword" />
                                    <!-- eye icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="swap-on size-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                    <!-- eye-slash icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="swap-off size-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                    </svg>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3 mt-6">
                        <button type="button"
                            class="btn btn-info text-[10px] -skew-x-12 sm:text-xs font-black italic uppercase tracking-widest shadow-lg group h-12">
                            Daftar Sekarang
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4 ml-1 transition-transform group-hover:translate-x-1" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                        <a href="/" wire:navigate
                            class="btn btn-warning text-[10px] -skew-x-12 sm:text-xs font-black italic uppercase tracking-widest shadow-lg h-12 flex items-center justify-center">
                            Batal
                        </a>
                    </div>

                    <div class="text-center mt-4">
                        <span class="text-xs font-bold opacity-70">Sudah punya akun? </span>
                        <a href="/login" wire:navigate
                            class="text-xs font-black italic uppercase tracking-wider text-info hover:link">Masuk
                            Disini</a>
                    </div>
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
