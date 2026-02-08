<div>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold">Buat Jadwal Khusus</h1>
            <p class="text-sm text-base-content/60 mt-1">Tambah jadwal tambahan/libur/event</p>
        </div>
        <div>
            <a wire:navigate href="/jadwal-khusus" class="text-sm text-base-content/60">
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
                                <span class="label-text">Tanggal</span>
                            </div>
                            <input type="date" class="input input-bordered w-full mt-1.5" placeholder="2026-02-10"
                                wire:model="tanggal">
                            @error('tanggal')
                                <p class="text-[10px] text-warning italic mt-1 font-bold uppercase">*{{ $message }}</p>
                            @enderror
                        </label>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 md:col-span-2">
                            <label class="form-control w-full col-span-2 md:col-span-1">
                                <div class="label">
                                    <span class="label-text">Tipe</span>
                                </div>
                                <select class="select select-bordered w-full mt-1.5" wire:model.live="tipe">
                                    <option value="">Pilih tipe</option>
                                    <option value="libur">Libur</option>
                                    <option value="event">Event / Block</option>
                                    <option value="tambahan">Jam Tambahan</option>
                                </select>
                                @error('tipe')
                                    <p class="text-[10px] text-warning italic mt-1 font-bold uppercase">*{{ $message }}
                                    </p>
                                @enderror
                            </label>
                            <label class="form-control w-full">
                                <div class="label">
                                    <span class="label-text">Jam Buka</span>
                                </div>
                                <input type="time" class="input input-bordered w-full mt-1.5" placeholder="08:00"
                                    wire:model="buka" @disabled($tipe === 'libur')>
                                @error('buka')
                                    <p class="text-[10px] text-warning italic mt-1 font-bold uppercase">*{{ $message }}
                                    </p>
                                @enderror
                            </label>
                            <label class="form-control w-full">
                                <div class="label">
                                    <span class="label-text">Jam Tutup</span>
                                </div>
                                <input type="time" class="input input-bordered w-full mt-1.5" placeholder="21:00"
                                    wire:model="tutup" @disabled($tipe === 'libur')>
                                @error('tutup')
                                    <p class="text-[10px] text-warning italic mt-1 font-bold uppercase">*{{ $message }}
                                    </p>
                                @enderror
                            </label>
                        </div>
                        <label class="form-control w-full md:col-span-2">
                            <div class="label">
                                <span class="label-text">Keterangan</span>
                            </div>
                            <textarea class="textarea textarea-bordered w-full mt-1.5" rows="3" placeholder="Ada event tournament"
                                wire:model="keterangan"></textarea>
                            @error('keterangan')
                                <p class="text-[10px] text-warning italic mt-1 font-bold uppercase">*{{ $message }}</p>
                            @enderror
                        </label>
                    </div>
                    <div class="mt-6 flex items-center justify-end gap-2">
                        <a wire:navigate href="/jadwal-khusus" class="btn btn-ghost" wire:loading.attr="disabled"
                            wire:target="submit">
                            Kembali
                        </a>
                        <button type="button" class="btn btn-primary" wire:click="submit" wire:loading.attr="disabled"
                            wire:target="submit">
                            <span wire:loading.remove wire:target="submit">Simpan Jadwal Khusus</span>
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
                                <h4 class="text-xs font-semibold mb-1">Format Input</h4>
                                <ol class="list-decimal list-inside text-xs text-base-content/70 space-y-1">
                                    <li class="pl-2">Tanggal: format YYYY-MM-DD</li>
                                    <li class="pl-2">Jam: format HH:MM (24 jam)</li>
                                </ol>
                            </div>
                            <div>
                                <h4 class="text-xs font-semibold mb-1">Tentang Tipe</h4>
                                <ol class="list-decimal list-inside text-xs text-base-content/70 space-y-1">
                                    <li class="pl-2">Libur: input Jam Buka/Tutup akan nonaktif</li>
                                    <li class="pl-2">Event / Block: isi jam jika perlu</li>
                                    <li class="pl-2">Jam Tambahan: isi jam tambahan</li>
                                </ol>
                            </div>
                            @if ($error)
                                <div class="alert alert-error">
                                    <span>{{ $error }}</span>
                                </div>
                            @endif
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
