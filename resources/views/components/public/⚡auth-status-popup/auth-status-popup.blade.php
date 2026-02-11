<div data-theme="chaotictoast">
    @if ($showPopup)
        <div
            class="fixed bottom-18 sm:bottom-25 left-4 right-4 sm:max-w-xl sm:mx-auto z-50 p-4 sm:p-4 bg-base-300 text-base-content text-start flex items-center justify-between rounded-xl shadow-xl text-[11px] md:text-sm gap-2">
            <span>Masuk / Daftar untuk menggunakan fitur lebih banyak</span>
            <div class="flex gap-2">
                <a href="{{ route('register') }}" wire:navigate class="btn btn-sm btn-warning">Daftar</a>
                <a href="{{ route('login') }}" wire:navigate class="btn btn-sm btn-info">Masuk</a>
            </div>
        </div>
    @endif
</div>
