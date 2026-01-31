<div data-theme="chaotictoast" wire:init="load" x-data="{ showPassword: false, showConfirmPassword: false }"
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

    <div wire:key="register-card"
        class="card w-full max-w-md bg-base-200 shadow-[0_0_50px_-12px_rgba(0,0,0,0.5)] overflow-hidden relative z-10 my-8">
        <!-- Sporty Accent Line (Top Border with Glow) -->
        <div
            class="absolute top-0 left-0 w-full h-1.5 bg-linear-to-r from-info via-black to-info shadow-[0_0_15px_rgba(var(--p),0.5)]">
        </div>

        @if ($ready)
            @if ($registrationSuccess)
                <!-- Registration Success Message -->
                <div class="card-body p-8 text-center" wire:key="register-success-container" x-transition>
                    <div class="flex flex-col items-center justify-center">
                        <!-- Success Icon -->
                        <div class="mb-4">
                            <div class="w-16 h-16 rounded-full bg-blue-300 flex items-center justify-center mx-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-blue-600">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                                </svg>
                            </div>
                        </div>

                        <!-- Success Message -->
                        <h3 class="font-black italic tracking-tighter text-info mb-4">
                            Berhasil membuat akun
                        </h3>

                        <!-- User Data -->
                        <div class="bg-base-200/50 rounded-lg p-4 mb-8 w-full max-w-md">
                            <p class="text-sm font-medium text-base-content">
                                <span class="font-bold">{{ $successMessage }}</span>
                            </p>
                        </div>

                        <!-- Action Button -->
                        <button wire:click="goToLogin"
                            class="btn btn-info text-[10px] -skew-x-12 sm:text-xs font-black italic uppercase tracking-widest shadow-lg group h-12 px-8">
                            <span>Login Sekarang</span>
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4 ml-1 transition-transform group-hover:translate-x-1" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </div>
                </div>
            @else
                <!-- Registration Form -->
                <div class="card-body p-8" wire:key="register-form-container" x-transition>
                    <div class="flex flex-col items-center mb-8">
                        <div>
                            <!-- Logo AMAN Arena Soccer -->
                            <img src="{{ asset('assets/images/logo/logo-kencana-mini-soccer.webp') }}"
                                alt="Logo Kencana Mini Soccer" class="h-15 w-15 sm:h-25 sm:w-25 object-contain">
                        </div>
                        <h3 class="text-xl sm:text-3xl font-black italic tracking-tighter uppercase text-warning">
                            DAFTAR <span class="text-info">AMAN Arena</span>
                        </h3>
                        {{-- <div class="text-xs text-base-content/50 text-center font-bold italic tracking-tighter uppercase">
                            MINI
                            SOCCER</div> --}}
                    </div>

                    <form class="space-y-6" wire:submit.prevent="register" enctype="multipart/form-data">
                        @if ($errors->has('registerError'))
                            <div
                                class="alert bg-warning/20 border border-warning text-white shadow-lg py-2 text-xs font-bold italic uppercase tracking-wider">
                                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-5 w-5"
                                    fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>{{ $errors->first('registerError') }}</span>
                            </div>
                        @endif
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
                                class="input input-bordered focus:input-info bg-base-200/50 font-medium w-full italic h-10 @error('name') input-warning @enderror"
                                wire:model="name" />
                            @error('name')
                                <label class="label p-0 mt-1">
                                    <span class="label-text-alt text-warning italic text-xs">{{ $message }}</span>
                                </label>
                            @enderror
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
                                    Email Address
                                </span>
                            </label>
                            <input type="text" placeholder="contoh@email.com"
                                class="input input-bordered focus:input-info bg-base-200/50 font-medium w-full italic h-10 @error('email') input-warning @enderror"
                                wire:model="email" />
                            @error('email')
                                <label class="label p-0 mt-1">
                                    <span class="label-text-alt text-warning italic text-xs">{{ $message }}</span>
                                </label>
                            @enderror
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
                            <!-- Joined Input with +62 Prefix -->
                            <div
                                class="flex items-center border rounded-lg overflow-hidden bg-base-200/50 focus-within:ring-2 focus-within:ring-info @error('no_wa') border-warning @enderror">
                                <!-- Fixed +62 Prefix -->
                                <div class="px-4 py-2 bg-base-300/70 text-base-content font-medium italic">
                                    +62
                                </div>
                                <!-- Phone Number Input -->
                                <input type="tel" placeholder="8123456789"
                                    class="input input-ghost border-0 bg-transparent focus:outline-none focus:ring-0 font-medium w-full italic h-10"
                                    wire:model.live.debounce.300ms="phone_number" id="no_wa_input"
                                    inputmode="numeric" inputmode="numeric" pattern="[0-9]*"
                                    oninput="
                                        // Remove all non-numeric characters
                                        this.value = this.value.replace(/[^0-9]/g, '');
                                    " />
                            </div>
                            @error('no_wa')
                                <label class="label p-0 mt-1">
                                    <span class="label-text-alt text-warning italic text-xs">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <!-- NIK -->
                        <div class="form-control">
                            <label class="label">
                                <span
                                    class="label-text font-bold uppercase tracking-wider text-xs flex items-center gap-2 mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-5 text-info">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                                    </svg>
                                    NIK (16 Digit)
                                </span>
                            </label>
                            <input type="number" placeholder="1234567890123456"
                                class="input input-bordered focus:input-info bg-base-200/50 font-medium w-full italic h-10 @error('nik') input-warning @enderror"
                                wire:model="nik" />
                            @error('nik')
                                <label class="label p-0 mt-1">
                                    <span class="label-text-alt text-warning italic text-xs">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <!-- Foto KTP -->
                        <div class="form-control">
                            <label class="label">
                                <span
                                    class="label-text font-bold uppercase tracking-wider text-xs flex items-center gap-2 mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-5 text-info">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.25 15.75l5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                    </svg>
                                    Foto KTP
                                </span>
                            </label>
                            <input type="file" accept="image/png,image/jpeg,image/jpg"
                                class="file-input file-input-bordered file-input-info bg-base-200/50 font-medium w-full italic h-10 @error('foto_ktp') @enderror"
                                wire:model.live="foto_ktp" />
                            <p class="text-xs text-base-content/50 italic mt-1">Max 2MB, format PNG/JPEG/JPG</p>

                            <!-- Image Preview with Video Aspect Ratio - Only shows when file is selected -->
                            @if ($foto_ktp)
                                <div class="mt-4">
                                    <!-- Container for preview and loading -->
                                    <div
                                        class="aspect-video bg-base-200 rounded-lg border border-base-300 overflow-hidden relative">
                                        <!-- Loading skeleton that shows when foto_ktp is loading -->
                                        <div wire:loading wire:target="foto_ktp"
                                            class="absolute inset-0 bg-linear-to-r from-base-200 via-base-300 to-base-200 animate-pulse z-10 flex items-center justify-center">
                                            <div class="text-base-content/50">Loading...</div>
                                        </div>

                                        <!-- Image preview -->
                                        <img src="{{ $foto_ktp->temporaryUrl() }}" alt="Preview Foto KTP"
                                            class="w-full h-full object-cover" />
                                    </div>
                                </div>
                            @endif

                            @error('foto_ktp')
                                <label class="label p-0 mt-1">
                                    <span class="label-text-alt text-warning italic text-xs">{{ $message }}</span>
                                </label>
                            @enderror

                            <!-- Password -->
                            <div class="form-control my-5">
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
                                        class="input input-bordered focus:input-info bg-base-200/50 w-full pr-12 italic h-10 @error('password') input-warning @enderror"
                                        wire:model="password" />
                                    <div class="absolute right-4 top-2">
                                        <label class="swap text-base-content/30 hover:text-info transition-colors">
                                            <input type="checkbox" x-model="showPassword" />
                                            <!-- eye icon -->
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                class="swap-on size-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            </svg>
                                            <!-- eye-slash icon -->
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                class="swap-off size-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                            </svg>
                                        </label>
                                    </div>
                                </div>
                                @error('password')
                                    <label class="label p-0 mt-1">
                                        <span class="label-text-alt text-warning italic text-xs">{{ $message }}</span>
                                    </label>
                                @enderror
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
                                        class="input input-bordered focus:input-info bg-base-200/50 w-full pr-12 italic h-10 @error('password_confirmation') input-warning @enderror"
                                        wire:model="password_confirmation" />
                                    <div class="absolute right-4 top-2">
                                        <label class="swap text-base-content/30 hover:text-info transition-colors">
                                            <input type="checkbox" x-model="showConfirmPassword" />
                                            <!-- eye icon -->
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                class="swap-on size-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            </svg>
                                            <!-- eye-slash icon -->
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                class="swap-off size-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                            </svg>
                                        </label>
                                    </div>
                                </div>
                                @error('password_confirmation')
                                    <label class="label p-0 mt-1">
                                        <span
                                            class="label-text-alt text-warning italic text-xs">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>

                            <div class="grid grid-cols-2 gap-3 mt-6">
                                <button type="submit" wire:loading.attr="disabled" wire:target="register"
                                    class="btn btn-info text-[10px] -skew-x-12 sm:text-xs font-black italic uppercase tracking-widest shadow-lg group h-12">
                                    <span wire:loading.remove wire:target="register">Daftar Sekarang</span>
                                    <span wire:loading wire:target="register">Registering...</span>
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-4 w-4 ml-1 transition-transform group-hover:translate-x-1"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
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

                    <div class="mt-4 text-center border-t border-white/10 pt-6">
                        <p
                            class="text-[10px] sm:text-xs font-medium opacity-50 uppercase tracking-[0.15em] sm:tracking-[0.2em]">
                            Powered by DISKOMINFOTIKSAN
                            Pekanbaru</p>
                    </div>
                </div>
            @endif
        @endif
    </div>
</div>
