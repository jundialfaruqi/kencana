<div>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold">Buat Catatan</h1>
            <p class="text-sm text-base-content/60 mt-1">Tambah catatan aturan</p>
        </div>
        <div>
            <a wire:navigate href="{{ route('catatan') }}" class="text-sm text-base-content/60">
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
                        <label class="form-control w-full md:col-span-2">
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
                        <div
                            class="card md:col-span-2 p-4 border-2 border-dashed border-base-200 bg-blue-200 text-primary-content mt-1">
                            <div class="form-control w-full md:col-span-2 mb-4">
                                <div>
                                    <span class="label-text font-bold">Pilih Kategori yang Sudah Ada</span>
                                </div>
                                <div class="flex flex-wrap gap-2 mt-1.5" wire:ignore.self>
                                    @foreach ($availableKategoriCatatan as $kategori)
                                        <button type="button" wire:key="{{ $kategori }}"
                                            class="btn btn-sm {{ $selectedKategoriCatatan === $kategori ? 'btn-primary' : 'btn-outline' }}"
                                            wire:click="selectKategoriCatatan('{{ $kategori }}')">
                                            {{ $kategori }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                            <label class="form-control w-full md:col-span-2">
                                <div class="label">
                                    <span class="label-text font-semibold">Atau Ketik Kategori Catatan Baru</span>
                                </div>
                                <label class="input input-bordered flex items-center w-full gap-2 mt-1.5">
                                    <input type="text"
                                        class="grow text-gray-600 disabled:text-success disabled:font-bold"
                                        placeholder="Tulis kategori catatan..." wire:model.live="kategori_catatan"
                                        x-data="{}"
                                        x-bind:disabled="$wire.selectedKategoriCatatan !== null">
                                    <span x-show="$wire.selectedKategoriCatatan !== null">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6 text-success">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m4.5 12.75 6 6 9-13.5" />
                                        </svg>
                                    </span>
                                </label>
                                @error('kategori_catatan')
                                    <p class="text-[10px] text-warning italic mt-1 font-bold uppercase">*{{ $message }}
                                    </p>
                                @enderror
                            </label>
                        </div>
                        <label class="form-control w-full md:col-span-2">
                            <div class="label">
                                <span class="label-text">Isi Catatan</span>
                            </div>
                            <textarea class="textarea textarea-bordered w-full mt-1.5" rows="4" placeholder="Tulis catatan..."
                                wire:model="catatan"></textarea>
                            @error('catatan')
                                <p class="text-[10px] text-warning italic mt-1 font-bold uppercase">*{{ $message }}
                                </p>
                            @enderror
                        </label>
                    </div>
                    <div class="mt-6 flex items-center justify-end gap-2">
                        <a wire:navigate href="{{ route('catatan') }}" class="btn btn-ghost"
                            wire:loading.attr="disabled" wire:target="submit">
                            Kembali
                        </a>
                        <button type="button" class="btn btn-primary" wire:click="submit" wire:loading.attr="disabled"
                            wire:target="submit">
                            <span wire:loading.remove wire:target="submit">Simpan Catatan</span>
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
                                <h4 class="text-xs font-semibold mb-1">Nama Lapangan</h4>
                                <ol class="list-decimal list-inside text-xs text-base-content/70 space-y-1">
                                    <li class="pl-2">Pastikan lapangan terdaftar di Master Lapangan</li>
                                </ol>
                            </div>
                            <div>
                                <h4 class="text-xs font-semibold mb-1">Pilih Kategori</h4>
                                <ol class="list-decimal list-inside text-xs text-base-content/70 space-y-1">
                                    <li class="pl-2">Bisa gunakan kategori yang sudah ada, atau ketik baru</li>
                                    <li class="pl-2">Contoh: Aturan Pemakaian</li>
                                </ol>
                            </div>
                            <div>
                                <h4 class="text-xs font-semibold mb-1">Catatan</h4>
                                <ol class="list-decimal list-inside text-xs text-base-content/70 space-y-1">
                                    <li class="pl-2">Isi catatan wajib diisi dan jelas</li>
                                    <li class="pl-2">Gunakan bahasa ringkas dan to the point</li>
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
