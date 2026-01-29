<div>
    <button type="button" onclick="logout_modal_profile.showModal()"
        class="btn btn-xs border hover:border-info hover:text-info transition-all" title="Logout">
        <svg wire:loading.remove xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
            stroke="currentColor" class="size-4">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
        </svg>
        Keluar
        <span wire:loading class="loading loading-spinner loading-xs"></span>
    </button>

    <dialog id="logout_modal_profile" class="modal modal-bottom sm:modal-middle backdrop-blur-sm">
        <div class="modal-box">
            <h3 class="font-bold text-lg italic uppercase tracking-tight">Konfirmasi Logout</h3>
            <p class="py-4 text-base-content/70">Apakah Anda yakin ingin keluar dari AMAN Arena?</p>
            <div class="modal-action">
                <form method="dialog">
                    <button class="btn btn-ghost -skew-x-12">Batal</button>
                </form>
                <button type="button" wire:click="logout" onclick="logout_modal_profile.close()"
                    class="btn btn-warning text-white -skew-x-12 font-black uppercase tracking-widest">
                    Logout
                </button>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>
</div>
