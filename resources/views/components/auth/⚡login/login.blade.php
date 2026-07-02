<div data-theme="goldcandy" wire:init="load" x-data="{ showPassword: false }"
    class="min-h-screen flex items-center justify-center bg-base-300 p-4 font-sans transition-colors duration-500 overflow-hidden relative">

    <div wire:key="login-card" class="card w-full max-w-md bg-base-200 overflow-hidden relative z-10">

        @if ($ready)
            <div class="card-body p-8" wire:key="login-form-container">
                <div class="flex flex-col mb-8">
                    <div>
                        <!-- Logo KENCANA Arena -->
                        <img src="{{ asset('assets/images/logo/logo-kencana-mini-soccer.webp') }}"
                            alt="Logo Kencana Mini Soccer" class="h-13 w-13 sm:h-23 sm:w-23 object-contain">
                    </div>
                    <h3 class="text-xl sm:text-2xl font-bold text-base-content">
                        Kencana Arena
                    </h3>
                    <h6 class="text-xs text-base-content/50 mt-2">
                        Silahkan masuk untuk mengakses layanan dan fitur yang tersedia
                    </h6>
                </div>

                <form class="space-y-6" wire:submit.prevent="authenticate">
                    @if ($errors->has('loginError'))
                        <div
                            class="alert bg-warning/20 border border-warning text-white shadow-lg py-2 text-xs font-bold uppercase tracking-wider">
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
                                class="label-text font-bold uppercase tracking-wider text-xs flex items-center gap-2 mb-2 text-base-content">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5 text-info">
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
                                class="label-text font-bold uppercase tracking-wider text-xs flex items-center gap-2 mb-2 text-base-content">
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

                    <div class="flex flex-col gap-2 mt-4">
                        <button type="submit" wire:loading.attr="disabled"
                            class="btn btn-info w-full text-[10px] sm:text-xs font-bold uppercase group">
                            <span wire:loading.remove>Masuk</span>
                            <span wire:loading>Authenticating...</span>
                        </button>

                        <div class="divider text-xs opacity-50 my-0">atau</div>

                        <a href="{{ route('register') }}" wire:navigate
                            class="btn btn-outline border border-info/50 w-full text-[10px] sm:text-xs font-bold uppercase group">
                            Buat Akun Baru
                        </a>
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
