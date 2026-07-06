<div data-theme="colorghost" wire:init="load" x-data="{ showPassword: false, recaptchaClicked: false, recaptchaLoading: false, recaptchaVerified: false }"
    class="min-h-screen flex items-center justify-center bg-base-300 p-4 font-sans transition-colors duration-500 overflow-hidden relative">

    <div wire:key="admin-login-card" class="card w-full max-w-md bg-base-200 overflow-hidden relative z-10">

        @if ($ready)
            <div class="card-body p-8" wire:key="admin-login-form-container">
                <div class="flex flex-col mb-8">
                    <div>
                        <!-- Logo KENCANA Arena -->
                        <img src="{{ asset('assets/images/logo/logo-kencana-mini-soccer.webp') }}"
                            alt="Logo Kencana Mini Soccer" class="h-13 w-13 sm:h-23 sm:w-23 object-contain">
                    </div>
                    <h3 class="text-xl sm:text-2xl font-bold text-base-content">
                        Kencana Arena Admin
                    </h3>
                    <h6 class="text-xs text-base-content/50 mt-2">
                        Silahkan masuk ke panel admin Kencana Arena
                    </h6>
                </div>

                <form class="space-y-6" wire:submit.prevent="authenticate">
                    @if ($errors->has('loginError'))
                        <div
                            class="alert bg-warning/20 border border-warning text-white shadow-lg py-2 text-xs font-bold uppercase">
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
                                class="label-text font-bold uppercase text-xs flex items-center gap-2 mb-2 text-base-content">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5 text-base-content">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                </svg>
                                Email
                            </span>
                        </label>
                        <input type="text" wire:model="email" placeholder="contoh@email.com"
                            class="input input-bordered focus:input-info bg-base-200/50 font-medium w-full placeholder:text-base-content/50 @error('email') input-warning @enderror"
                            autofocus />
                        @error('email')
                            <label class="label p-0 mt-1">
                                <span class="label-text-alt text-warning text-xs">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="form-control mb-8">
                        <label class="label">
                            <span
                                class="label-text font-bold uppercase text-xs flex items-center gap-2 mb-2 text-base-content">
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
                                <span class="label-text-alt text-warning text-xs">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <!-- Fake Google reCAPTCHA v2 -->
                    <div id="recaptcha-container" class="w-full max-w-[302px] h-[76px] bg-[#f9f9f9] border border-[#d3d3d3] rounded-[3px] flex items-center justify-between px-3 select-none text-gray-800 shadow-xs font-sans mx-auto">
                        <div class="flex items-center gap-3">
                            <!-- Checkbox / Spinner / Checkmark Area -->
                            <div class="relative w-7 h-7 flex items-center justify-center">
                                <!-- Empty Checkbox (Clickable) -->
                                <button type="button" id="recaptcha-anchor"
                                    class="w-6 h-6 border-2 border-[#c1c1c1] bg-white rounded-[2px] transition-all hover:border-[#b2b2b2] focus:outline-none cursor-pointer">
                                </button>

                                <!-- Loading Spinner (Google style) -->
                                <svg id="recaptcha-spinner" class="animate-spin h-6 w-6 text-[#4a90e2]" fill="none" viewBox="0 0 24 24" style="display: none;">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>

                                <!-- Checkmark (Google style) -->
                                <svg id="recaptcha-checkmark" class="h-8 w-8 text-[#009a44]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="4" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <!-- Label -->
                            <span class="text-[13px] font-normal text-[#555] tracking-wide">Saya bukan robot</span>
                        </div>

                        <!-- Right Brand -->
                        <div class="flex flex-col items-center justify-center opacity-90 pr-1">
                            <img src="https://www.gstatic.com/recaptcha/api2/logo_48.png" alt="reCAPTCHA logo" class="w-8 h-8 object-contain">
                            <span class="text-[8px] text-[#555] font-semibold mt-0.5">reCAPTCHA</span>
                            <div class="flex gap-1 text-[7px] text-[#555] -mt-0.5">
                                <a href="https://policies.google.com/privacy" target="_blank" class="hover:underline">Privasi</a>
                                <span>•</span>
                                <a href="https://policies.google.com/terms" target="_blank" class="hover:underline">Persyaratan</a>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-2 mt-4">
                        <button type="submit" id="submit-btn" disabled
                            class="btn btn-info w-full text-[10px] sm:text-xs font-bold uppercase group disabled:opacity-50 disabled:cursor-not-allowed">
                            <span wire:loading.remove>Masuk</span>
                            <span wire:loading>Authenticating...</span>
                        </button>
                    </div>
                </form>

                <div class="flex items-center justify-center gap-4 sm:gap-5 mt-12">
                    <img src="{{ asset('assets/images/logo/aman.webp') }}" alt="Aman"
                        class="h-4 sm:h-5.5 object-contain">
                    <img src="{{ asset('assets/images/logo/bangun-negeri.webp') }}" alt="Bangun Negeri"
                        class="h-4 sm:h-5.5 object-contain">
                    <img src="{{ asset('assets/images/logo/dispora.webp') }}" alt="Dispora"
                        class="h-4 sm:h-5.5 object-contain">
                    <img src="{{ asset('assets/images/logo/logo-diskominfo-pekanbaru.webp') }}" alt="Diskominfo"
                        class="h-4 sm:h-5.5 object-contain">
                </div>
            </div>
        @endif
    </div>
</div>
