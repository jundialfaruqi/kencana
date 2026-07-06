<div class="mt-4 sm:mt-8" x-data>
    @if ($error)
        <div class="alert alert-error mb-6">
            <span>{{ $error }}</span>
        </div>
    @else
        <div class="flex flex-col lg:flex-row gap-8 lg:gap-12 pb-12">
            <!-- Kolom Kiri: Konten Utama -->
            <div class="flex-1">
                <div class="mb-6 flex flex-col gap-2 sm:gap-3">
                    <span
                        class="bg-info/10 text-info font-black uppercase px-3 py-1 rounded-md w-fit text-xs sm:text-sm">{{ data_get($info, 'kategori', 'Info') }}</span>
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-base-content">
                        {{ data_get($info, 'judul', '-') }}
                    </h1>
                </div>

                <!-- Gambar Utama -->
                <figure class="h-auto bg-base-300 overflow-hidden mb-6 shadow-sm -mx-4 sm:mx-0">
                    @if (data_get($info, 'image'))
                        <img src="{{ data_get($info, 'image') }}" class="w-full h-auto object-cover"
                            alt="{{ data_get($info, 'judul') }}" />
                    @else
                        <div class="w-full h-48 flex items-center justify-center text-base-content/40">
                            <span class="text-sm font-semibold tracking-widest uppercase">No Image</span>
                        </div>
                    @endif
                </figure>

                <!-- Deskripsi -->
                <article class="max-w-none">
                    <p class="text-base-content/80 leading-relaxed sm:leading-loose text-base sm:text-lg font-medium">
                        {!! str_replace('. ', '.<br><br>', e(data_get($info, 'deskripsi', ''))) !!}</p>
                </article>
            </div>

            <!-- Kolom Kanan: Banner Lainnya -->
            <div class="w-full lg:w-1/3 flex flex-col gap-6">
                <h3 class="text-lg font-bold uppercase text-base-content pb-3">Informasi Lainnya</h3>

                <div class="flex flex-col gap-4">
                    @forelse ($otherBanners as $other)
                        <a href="{{ route('info.slug', ['slug' => \Illuminate\Support\Str::slug($other['judul'])]) }}"
                            wire:navigate
                            class="card card-side bg-base-100 border border-base-200 hover:border-info transition-colors shadow-sm hover:shadow-md h-28 sm:h-32 overflow-hidden group/other">
                            <!-- Gambar Kiri -->
                            <figure class="w-1/3 h-full bg-base-300 overflow-hidden relative">
                                <img src="{{ data_get($other, 'image') }}"
                                    class="w-full h-full object-cover transition-transform duration-500 group-hover/other:scale-110"
                                    alt="{{ data_get($other, 'judul') }}" />
                            </figure>
                            <!-- Teks Kanan -->
                            <div class="w-2/3 p-4 sm:p-5 flex flex-col justify-center gap-1 sm:gap-2">
                                <span
                                    class="text-[9px] sm:text-[10px] font-black text-info uppercase">{{ data_get($other, 'kategori', '') }}</span>
                                <h4
                                    class="text-sm sm:text-base font-black uppercase leading-tight line-clamp-2 text-base-content group-hover/other:text-info transition-colors">
                                    {{ data_get($other, 'judul') }}</h4>
                            </div>
                        </a>
                    @empty
                        <div class="text-sm text-base-content/50">Belum ada informasi lainnya.</div>
                    @endforelse
                </div>
            </div>
        </div>
    @endif
</div>
