<div>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold">Update Jadwal Operasional</h1>
            <p class="text-sm text-base-content/60 mt-1">Ubah jam buka/tutup dan status</p>
        </div>
        <div>
            <a wire:navigate href="/manajemen-jadwal-operasional" class="text-sm text-base-content/60">
                <span class="inline-flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                    </svg>
                    <span>Kembali</span>
                </span>
            </a>
        </div>
    </div>

    <div wire:init="load">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-start" wire:loading.remove wire:target="load">
            <div class="card bg-base-100 md:col-span-3 shadow">
                <div class="card-body">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <label class="form-control w-full">
                            <div class="label">
                                <span class="label-text">Nama Lapangan</span>
                            </div>
                            <input type="text"
                                class="input text-primary-content italic font-black border-2 border-dashed border-base-300 input-bordered w-full mt-1.5"
                                value="{{ $lapangan_nama ?: '-' }}" disabled />
                        </label>
                        <label class="form-control w-full">
                            <div class="label">
                                <span class="label-text">Hari</span>
                            </div>
                            <select class="select select-bordered w-full mt-1.5" wire:model.live="hari"
                                wire:key="select-hari">
                                <option value="">Pilih hari</option>
                                <option value="0">Minggu</option>
                                <option value="1">Senin</option>
                                <option value="2">Selasa</option>
                                <option value="3">Rabu</option>
                                <option value="4">Kamis</option>
                                <option value="5">Jumat</option>
                                <option value="6">Sabtu</option>
                            </select>
                            @error('hari')
                                <p class="text-[10px] text-warning italic mt-1 font-bold uppercase">*{{ $message }}</p>
                            @enderror
                        </label>
                        <label class="form-control w-full">
                            <div class="label">
                                <span class="label-text">Jam Buka</span>
                            </div>
                            <input type="time" class="input input-bordered w-full mt-1.5" placeholder="08:00"
                                wire:model="buka">
                            @error('buka')
                                <p class="text-[10px] text-warning italic mt-1 font-bold uppercase">*{{ $message }}</p>
                            @enderror
                        </label>
                        <label class="form-control w-full">
                            <div class="label">
                                <span class="label-text">Jam Tutup</span>
                            </div>
                            <input type="time" class="input input-bordered w-full mt-1.5" placeholder="21:00"
                                wire:model="tutup">
                            @error('tutup')
                                <p class="text-[10px] text-warning italic mt-1 font-bold uppercase">*{{ $message }}</p>
                            @enderror
                        </label>
                        <div class="md:col-span-2">
                            <div class="flex items-center justify-between rounded-xl border border-base-300 p-3">
                                <div>
                                    <div class="text-xs font-bold uppercase text-base-content/50">Status</div>
                                    <div class="mt-1 text-sm font-semibold">
                                        {{ $is_active ? 'Aktif' : 'Nonaktif' }}
                                    </div>
                                </div>
                                <label class="toggle text-base-content">
                                    <input type="checkbox" wire:model.live="is_active" />
                                    <svg aria-label="disabled" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M18 6 6 18" />
                                        <path d="m6 6 12 12" />
                                    </svg>
                                    <svg aria-label="enabled" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <g stroke-linejoin="round" stroke-linecap="round" stroke-width="4"
                                            fill="none" stroke="currentColor">
                                            <path d="M20 6 9 17l-5-5"></path>
                                        </g>
                                    </svg>

                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6">
                        <button type="button" class="btn btn-primary" wire:click="submit" wire:loading.attr="disabled"
                            wire:target="submit">
                            <span wire:loading.remove wire:target="submit">Simpan Perubahan</span>
                            <span class="loading loading-spinner loading-xs" wire:loading wire:target="submit"></span>
                        </button>
                        @if ($error)
                            <div class="alert alert-error mt-3">
                                <span>{{ $error }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="md:col-span-2">
                <div class="card bg-base-100 border-2 border-dashed border-base-300">
                    <div class="card-body">
                        <h3 class="text-sm font-semibold mb-2">Informasi</h3>
                        <div class="space-y-3">
                            <div>
                                <h4 class="text-xs font-semibold mb-1">Tentang Jam</h4>
                                <ol class="list-decimal list-inside text-xs text-base-content/70 space-y-1">
                                    <li class="pl-2">Format jam: HH:MM (contoh 08:00)</li>
                                    <li class="pl-2">Jam menggunakan format 24 jam, tanpa detik</li>
                                    <li class="pl-2">Gunakan 00:00 untuk tengah malam; 24:00 tidak valid</li>
                                    <li class="pl-2">Disarankan jam tutup lebih besar dari jam buka di hari yang sama
                                    </li>
                                </ol>
                            </div>
                            <div>
                                <h4 class="text-xs font-semibold mb-1">Status</h4>
                                <ol class="list-decimal list-inside text-xs text-base-content/70 space-y-1">
                                    <li class="pl-2">Aktif: jadwal akan diterapkan saat booking</li>
                                    <li class="pl-2">Nonaktif: jadwal tidak digunakan</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div wire:loading.flex wire:target="load" class="items-center justify-center p-10">
            <span class="loading loading-spinner loading-md"></span>
        </div>
    </div>
</div>
