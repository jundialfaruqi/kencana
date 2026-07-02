<div>
    <dialog id="logout_modal_profile" class="modal modal-bottom sm:modal-middle backdrop-blur-sm">
        <div class="modal-box rounded-3xl border border-zinc-800 p-6 bg-black text-left max-w-sm">
            <h3 class="font-black text-xl text-white uppercase tracking-tight">Keluar dari akun?</h3>
            <p class="py-4 text-sm text-zinc-400">Sesi Anda akan diakhiri dan Anda perlu masuk kembali untuk mengakses akun Anda.</p>
            <div class="flex justify-end gap-3 mt-4">
                <form method="dialog">
                    <button class="px-5 py-2.5 text-zinc-400 hover:text-zinc-200 font-semibold text-sm transition-colors">
                        Batal
                    </button>
                </form>
                <button type="button" wire:click="logout" onclick="logout_modal_profile.close()"
                    class="px-5 py-2.5 bg-red-950/20 hover:bg-red-900/30 border border-red-900/30 hover:border-red-800/40 text-red-500 rounded-2xl font-bold transition-all text-sm">
                    Ya, Keluar
                </button>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>
</div>
