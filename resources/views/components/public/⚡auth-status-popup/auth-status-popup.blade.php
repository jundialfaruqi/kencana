<div data-theme="chaotictoast">
    @if ($showPopup)
        {{-- <div
            class="fixed bottom-18 sm:bottom-25 left-4 right-4 sm:max-w-xl sm:mx-auto z-50 p-4 sm:p-4 bg-base-300 text-base-content text-start flex items-center justify-between rounded-xl shadow-xl text-[11px] md:text-sm gap-2">
            <span>Masuk / Daftar untuk menggunakan fitur lebih banyak</span>
            <div class="flex gap-2">
                <a href="{{ route('register') }}" wire:navigate class="btn btn-sm btn-warning">Daftar</a>
                <a href="{{ route('login') }}" wire:navigate class="btn btn-sm btn-info">Masuk</a>
            </div>
        </div> --}}

        <div
            class="fixed bottom-18 sm:bottom-25 left-4 right-4 sm:max-w-lg sm:mx-auto z-50 p-3 sm:p-3 bg-base-300 text-base-content text-start flex items-center justify-between rounded-xl shadow-xl text-[11px] md:text-sm font-normal sm:font-bold gap-2">
            {{-- Tambahkan 'relative' di sini --}}
            <span>Masuk / Daftar untuk akses fitur lengkap...</span>
            <div class="flex gap-2">
                <a href="{{ route('register') }}" wire:navigate class="btn btn-sm btn-warning">Daftar</a>
                <a href="{{ route('login') }}" wire:navigate class="btn btn-sm btn-info">Masuk</a>
            </div>
            {{-- Tombol Close --}}
            <button wire:click="hidePopup"
                class="btn-xs bg-base-300 absolute -top-2 -translate-y-1/2 left-1/2 -translate-x-1/2 text-base-content/50 hover:text-base-content text-sm font-bold flex items-center justify-center whitespace-nowrap px-2 pb-1 rounded-t-lg">
                {{-- Hapus btn-circle, tambahkan whitespace-nowrap dan px-2 --}}
                &times; tutup
            </button>
        </div>
    @endif
</div>
