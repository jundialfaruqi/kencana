<div data-theme="goldcandy" wire:init="load" x-data="{ showPassword: false, showConfirmPassword: false }"
    class="min-h-dvh bg-base-300 py-12 px-4 sm:py-16 font-sans relative">

    <div wire:key="register-card" class="card w-full max-w-md mx-auto bg-base-200 relative z-10">

        @if ($ready)
            @if ($registrationSuccess)
                <!-- Registration Success Message -->
                <div class="card-body p-8 text-center" wire:key="register-success-container">
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
                        <h3 class="font-black tracking-tighter text-base-content mb-4">
                            Berhasil membuat akun
                        </h3>

                        <!-- User Data -->
                        <div class="bg-base-200/50 rounded-lg p-4 mb-8 w-full max-w-md">
                            <p class="text-sm font-medium text-base-content">
                                <span class="font-bold">{{ $successMessage }}</span>
                            </p>
                        </div>

                        <!-- Action Button -->
                        <a href="{{ route('login') }}" wire:navigate
                            class="btn btn-info text-[10px] -skew-x-12 sm:text-xs font-black uppercase tracking-widest shadow-lg group h-12 px-8 flex items-center justify-center">
                            <span>Login Sekarang</span>
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4 ml-1 transition-transform group-hover:translate-x-1" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>
                </div>
            @else
                <!-- Registration Form -->
                <div class="card-body p-8" wire:key="register-form-container">
                    <div class="flex flex-col items-center mb-8">
                        <h3 class="text-xl sm:text-3xl font-bold text-base-content">
                            Daftar Akun
                        </h3>
                    </div>

                    <form class="space-y-6" wire:submit.prevent="register" enctype="multipart/form-data">
                        @if ($errors->has('registerError'))
                            <div
                                class="alert bg-warning/20 border border-warning text-white shadow-lg py-2 text-xs font-bold uppercase tracking-wider">
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
                                    class="label-text font-bold uppercase text-xs text-base-content flex items-center gap-2 mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-5 text-base-content">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                    </svg>
                                    Nama Lengkap
                                </span>
                            </label>
                            <input type="text" placeholder="Masukkan nama lengkap"
                                class="input input-bordered focus:input-info bg-base-200/50 font-medium w-full placeholder:text-base-content/50 h-10 @error('name') input-warning @enderror"
                                wire:model="name" />
                            @error('name')
                                <label class="label p-0 mt-1">
                                    <span class="label-text-alt text-warning text-xs">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="form-control">
                            <label class="label">
                                <span
                                    class="label-text text-base-content font-bold uppercase tracking-wider text-xs flex items-center gap-2 mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-5 text-base-content">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                    </svg>
                                    Email Address
                                </span>
                            </label>
                            <input type="text" placeholder="contoh@email.com"
                                class="input input-bordered focus:input-info bg-base-200/50 font-medium w-full h-10 placeholder:text-base-content/50 @error('email') input-warning @enderror"
                                wire:model="email" />
                            @error('email')
                                <label class="label p-0 mt-1">
                                    <span class="label-text-alt text-warning text-xs">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <!-- No HP -->
                        <div class="form-control">
                            <label class="label">
                                <span
                                    class="label-text text-base-content font-bold uppercase tracking-wider text-xs flex items-center gap-2 mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-5 text-base-content">
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
                                <div class="px-4 py-2 bg-base-300/70 text-base-content font-medium">
                                    +62
                                </div>
                                <!-- Phone Number Input -->
                                <input type="tel" placeholder="8123456789"
                                    class="input input-ghost border-0 bg-transparent focus:outline-none focus:ring-0 font-medium w-full placeholder:text-base-content/50 h-10"
                                    wire:model.live.debounce.300ms="phone_number" id="no_wa_input" inputmode="numeric"
                                    pattern="[0-9]*" maxlength="12"
                                    oninput="
                                        // Remove all non-numeric characters and limit to 12 digits
                                        this.value = this.value.replace(/[^0-9]/g, '').slice(0, 12);
                                    " />
                            </div>
                            @error('no_wa')
                                <label class="label p-0 mt-1">
                                    <span class="label-text-alt text-warning text-xs">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <!-- NIK -->
                        <div class="form-control">
                            <label class="label">
                                <span
                                    class="label-text text-base-content font-bold uppercase tracking-wider text-xs flex items-center gap-2 mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-5 text-base-content">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                                    </svg>
                                    NIK (16 Digit)
                                </span>
                            </label>
                            <input type="tel" placeholder="1234567890123456"
                                class="input input-bordered focus:input-info bg-base-200/50 font-medium w-full placeholder:text-base-content/50 h-10 @error('nik') input-warning @enderror"
                                wire:model="nik" inputmode="numeric" pattern="[0-9]*" maxlength="16"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 16);" />
                            @error('nik')
                                <label class="label p-0 mt-1">
                                    <span class="label-text-alt text-warning text-xs">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="form-control my-5">
                            <label class="label">
                                <span
                                    class="label-text text-base-content font-bold uppercase tracking-wider text-xs flex items-center gap-2 mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-5 text-base-content">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                                    </svg>
                                    Password
                                </span>
                            </label>
                            <div class="relative group/input">
                                <input :type="showPassword ? 'text' : 'password'" wire:model="password"
                                    placeholder="••••••••"
                                    class="input input-bordered focus:input-info bg-base-200/50 w-full pr-12 placeholder:text-base-content/50 @error('password') input-warning @enderror" />
                                <div class="absolute right-4 top-2">
                                    <label class="swap text-base-content/30 hover:text-base-content transition-colors">
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
                                <label class="label p-0 mt-1">
                                    <span class="label-text-alt text-warning text-xs">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="form-control">
                            <label class="label">
                                <span
                                    class="label-text text-base-content font-bold uppercase tracking-wider text-xs flex items-center gap-2 mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-5 text-base-content">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                                    </svg>
                                    Konfirmasi Password
                                </span>
                            </label>
                            <div class="relative group/input">
                                <input :type="showConfirmPassword ? 'text' : 'password'"
                                    wire:model="password_confirmation" placeholder="••••••••"
                                    class="input input-bordered focus:input-info bg-base-200/50 w-full pr-12 placeholder:text-base-content/50 @error('password_confirmation') input-warning @enderror" />
                                <div class="absolute right-4 top-2">
                                    <label class="swap text-base-content/30 hover:text-base-content transition-colors">
                                        <input type="checkbox" x-model="showConfirmPassword" />

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
                            @error('password_confirmation')
                                <label class="label p-0 mt-1">
                                    <span class="label-text-alt text-warning text-xs">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-3 mt-6">
                            <a href="{{ route('home') }}" wire:navigate
                                class="btn btn-ghost text-[10px] sm:text-xs font-black uppercase h-12 flex items-center justify-center">
                                Batal
                            </a>
                            <button type="submit" wire:loading.attr="disabled" wire:target="register"
                                class="btn btn-info text-[10px] sm:text-xs font-black uppercase group h-12">
                                <span wire:loading.remove wire:target="register">Daftar</span>
                                <span wire:loading wire:target="register">Registering...</span>
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4 ml-1 transition-transform group-hover:translate-x-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </button>
                        </div>

                        <div class="text-center mt-4">
                            <span class="text-xs opacity-70">Sudah punya akun? </span>
                            <a href="{{ route('login') }}" wire:navigate
                                class="text-xs font-bold text-base-content hover:link">Masuk
                                Disini</a>
                        </div>
                    </form>
                </div>
            @endif
        @endif
    </div>
</div>
