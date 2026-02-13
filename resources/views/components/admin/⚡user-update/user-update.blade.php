<div>
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold">Update User</h1>
            <p class="text-sm text-base-content/60 mt-1">Perbarui data user</p>
        </div>
        <div class="text-sm breadcrumbs text-base-content/60">
            <ul>
                <li><a href="#">Aman Arena</a></li>
                <li>Setting</li>
                <li>User</li>
                <li><a wire:navigate href="/manajemen-user"><span class="text-base-content">Manajemen User</span></a></li>
                <li>Update</li>
            </ul>
        </div>
    </div>
    <div wire:init="load">
        <div wire:loading.flex wire:target="load" class="items-center justify-center p-10">
            <span class="loading loading-spinner loading-md"></span>
        </div>
        <div wire:loading.remove wire:target="load">
            @if ($error)
                <div class="alert alert-error mb-4">
                    <span>{{ $error }}</span>
                </div>
            @endif
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-start">
                <div class="card bg-base-100 border-2 border-dashed border-base-300">
                    <div class="card-body">
                        <label class="form-control w-full">
                            <div class="label">
                                <span class="label-text">Nama</span>
                            </div>
                            <input type="text" class="input input-bordered w-full mt-1.5" wire:model.live="name"
                                placeholder="Nama lengkap">
                            @error('name')
                                <p class="text-warning italic text-xs mt-1">*{{ $message }}</p>
                            @enderror
                        </label>
                        <label class="form-control w-full">
                            <div class="label">
                                <span class="label-text">Email</span>
                            </div>
                            <div class="relative group/input mt-1.5" x-data="{ showEmail: false }">
                                <input x-bind:type="showEmail ? 'text' : 'password'"
                                    class="input input-bordered w-full pr-12" wire:model.live="email"
                                    placeholder="email@contoh.com">
                                <div class="absolute right-3 top-2">
                                    <button type="button" x-on:click="showEmail = !showEmail"
                                        class="text-base-content/30 hover:text-info transition-colors">
                                        <span x-show="!showEmail">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                            </svg>
                                        </span>
                                        <span x-show="showEmail">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            </svg>
                                        </span>
                                    </button>
                                </div>
                            </div>
                            @error('email')
                                <p class="text-warning italic text-xs mt-1">*{{ $message }}</p>
                            @enderror
                        </label>
                        <label class="form-control w-full">
                            <div class="label">
                                <span class="label-text">NIK</span>
                            </div>
                            <div class="relative group/input mt-1.5" x-data="{ showNik: false }">
                                <input x-bind:type="showNik ? 'text' : 'password'"
                                    class="input input-bordered w-full pr-12" wire:model.live="nik"
                                    placeholder="Nomor Induk Kependudukan">
                                <div class="absolute right-3 top-2">
                                    <button type="button" x-on:click="showNik = !showNik"
                                        class="text-base-content/30 hover:text-info transition-colors">
                                        <span x-show="!showNik">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                            </svg>
                                        </span>
                                        <span x-show="showNik">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            </svg>
                                        </span>
                                    </button>
                                </div>
                            </div>
                            @error('nik')
                                <p class="text-warning italic text-xs mt-1">*{{ $message }}</p>
                            @enderror
                        </label>
                    </div>
                </div>
                <div class="card bg-base-100 border-2 border-dashed border-base-300">
                    <div class="card-body">
                        <label class="form-control w-full">
                            <div class="label">
                                <span class="label-text">No. WA</span>
                            </div>
                            <div
                                class="flex items-center border rounded-lg overflow-hidden bg-base-200/50 focus-within:ring-2 focus-within:ring-info mt-1.5">
                                <div class="px-4 py-2 bg-base-300/70 text-base-content font-medium italic">
                                    +62
                                </div>
                                <input type="tel" placeholder="8123456789"
                                    class="input input-ghost border-0 bg-transparent focus:outline-none focus:ring-0 font-medium w-full italic h-10"
                                    wire:model.live.debounce.300ms="phone_number" inputmode="numeric"
                                    pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9]/g, '');" />
                            </div>
                            @error('phone_number')
                                <p class="text-warning italic text-xs mt-1">*{{ $message }}</p>
                            @enderror
                        </label>
                        <label class="form-control w-full">
                            <div class="label">
                                <span class="label-text">Password </span>
                            </div>
                            <span class="mt-2 text-xs text-primary">
                                (*Biarkan kosong jika tidak ingin mengubah password)
                            </span>
                            <div class="relative group/input mt-1.5">
                                <input type="{{ $showPassword ? 'text' : 'password' }}" wire:model.live="password"
                                    placeholder="••••••••" class="input input-bordered w-full pr-12" />
                                <div class="absolute right-3 top-2">
                                    <label class="swap text-base-content/30 hover:text-info transition-colors">
                                        <input type="checkbox" wire:model.live="showPassword" />
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="swap-on size-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M13.5 10.5V6.75a4.5 4.5 0 1 1 9 0v3.75M3.75 21.75h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H3.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                                        </svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="swap-off size-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                                        </svg>
                                    </label>
                                </div>
                            </div>
                            @error('password')
                                <p class="text-warning italic text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </label>
                    </div>
                    <div class="card-footer p-4 rounded-b-xl">
                        <div class="flex items-center justify-end gap-2 rounded-b-xl">
                            <a wire:navigate href="/manajemen-user" class="btn btn-ghost"
                                wire:loading.attr="disabled"
                                wire:loading.class="btn-disabled pointer-events-none opacity-50" wire:target="submit">
                                Kembali
                            </a>
                            <button class="btn btn-primary" wire:click="submit" wire:loading.attr="disabled"
                                wire:target="submit">
                                <span wire:loading.remove wire:target="submit">Update</span>
                                <span class="loading loading-spinner loading-xs" wire:loading
                                    wire:target="submit"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
