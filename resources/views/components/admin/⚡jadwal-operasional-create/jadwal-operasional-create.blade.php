<div>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold">Buat Jadwal Operasional</h1>
            <p class="text-sm text-base-content/60 mt-1">Tambah jadwal buka/tutup</p>
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
            <div class="card bg-base-100 md:col-span-3 border-2 border-dashed border-base-300">
                <div class="card-body">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <label class="form-control w-full">
                            <div class="label">
                                <span class="label-text">Nama Lapangan</span>
                            </div>
                            <select class="select select-bordered w-full mt-1.5" wire:model="lapangan_id">
                                <option value="">Pilih lapangan</option>
                                @foreach ($arenas as $a)
                                    <option value="{{ $a['id'] ?? '' }}">{{ $a['nama_lapangan'] ?? '-' }}</option>
                                @endforeach
                            </select>
                            @error('lapangan_id')
                                <p class="text-[10px] text-warning italic mt-1 font-bold uppercase">*{{ $message }}</p>
                            @enderror
                        </label>
                        <label class="form-control w-full">
                            <div class="label">
                                <span class="label-text">Hari</span>
                            </div>
                            <select class="select select-bordered w-full mt-1.5" wire:model="hari">
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
                    </div>
                    <div class="mt-6 flex items-center justify-end gap-2">
                        <a wire:navigate href="/manajemen-jadwal-operasional" class="btn btn-ghost"
                            wire:loading.attr="disabled" wire:target="submit">
                            Kembali
                        </a>
                        <button type="button" class="btn btn-primary" wire:click="submit" wire:loading.attr="disabled"
                            wire:target="submit">
                            <span wire:loading.remove wire:target="submit">Simpan Jadwal</span>
                            <span class="loading loading-spinner loading-xs" wire:loading wire:target="submit"></span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="md:col-span-2">
                <div class="card bg-base-100 border-2 border-dashed border-base-300">
                    <div class="card-body">
                        <h3 class="text-sm font-semibold mb-2">Informasi</h3>
                        <div class="space-y-3">
                            <div>
                                <h4 class="text-xs font-semibold mb-1">Lapangan</h4>
                                <ol class="list-decimal list-inside text-xs text-base-content/70 space-y-1">
                                    <li class="pl-2">Pastikan lapangan sudah terdaftar di Master Lapangan</li>
                                    <li class="pl-2">Dropdown lapangan mengisi data lapangan dari Master Lapangan</li>
                                </ol>
                            </div>
                            <div>
                                <h4 class="text-xs font-semibold mb-1">Hari</h4>
                                <ol class="list-decimal list-inside text-xs text-base-content/70 space-y-1">
                                    <li class="pl-2">Hari: berisi dropdown menu dalam 7 hari di mulai dari Minggu,
                                        Senin, Selasa, Rabu, Kamis, Jumat, dan Sabtu</li>
                                    <li class="pl-2">Hari wajib dipilih, tidak boleh kosong</li>
                                    <li class="pl-2">Cek kembali hari dan nama lapangan sebelum simpan jadwal</li>
                                </ol>
                            </div>
                            <div>
                                <h4 class="text-xs font-semibold mb-1">Jam</h4>
                                <ol class="list-decimal list-inside text-xs text-base-content/70 space-y-1">
                                    <li class="pl-2">Format jam: HH:MM (contoh 08:00)</li>
                                    <li class="pl-2">Jam menggunakan format 24 jam, tanpa detik</li>
                                    <li class="pl-2">Gunakan 00:00 untuk tengah malam; 24:00 tidak valid</li>
                                    <li class="pl-2">Disarankan jam tutup lebih besar dari jam buka di hari yang sama
                                    </li>
                                </ol>
                            </div>
                            <div>
                                <h4 class="text-xs font-semibold mb-1">Lainnya</h4>
                                <ol class="list-decimal list-inside text-xs text-base-content/70 space-y-1">
                                    <li class="pl-2">Semua field wajib diisi: lapangan, hari, jam buka, jam tutup</li>
                                    <li class="pl-2">Jadwal yang disimpan akan muncul di Manajemen Jadwal Operasional
                                    </li>
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
