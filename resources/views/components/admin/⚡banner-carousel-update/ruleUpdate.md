Endpoint : /v1/master/slider/1 (1 adalah ID dari banner yg akan di update)
Method : POST
AUTH Session : YES

Body Fotm Data di POST MAN :

1. judul =
2. kategori =
3. deskripsi =
4. image = fileUpload (JPG,JPEG,PNG)

Tolong dicermati hal2 berikut :

Project ini menggunakan livewire 4 yg baru rilis di januari 2026

wire:navigate: Livewire 4 sangat mengandalkan SPA-feel dengan wire:navigate. Pastikan inisialisasi js dibungkus dalam event livewire:navigated agar animasi tetap berjalan saat berpindah halaman tanpa full reload.

Re-inisialisasi: Salah satu masalah umum adalah animasi "mati" setelah Livewire melakukan update data (misal: klik tombol filter). Di Livewire 4, pastikan Anda memanggil fungsi animasi kembali menggunakan hook $wire.on(...) atau menggunakan atribut wire:ignore pada elemen yang animasinya tidak ingin diganggu oleh proses re-render.

Jangan ubah hal lain yg tidak saya perintah kan.
