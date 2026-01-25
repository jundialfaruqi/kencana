# Lazy Loading (Pemuatan Lambat)

Fitur `#[Lazy]` di Livewire v4 memungkinkan sebuah komponen untuk dimuat **hanya ketika komponen tersebut terlihat di layar (viewport)**. Ini sangat berguna untuk mencegah komponen yang lambat (misalnya yang memiliki query database besar atau memuat peta) menghambat proses render awal halaman.

---

## Penggunaan Dasar

Cukup tambahkan atribut `#[Lazy]` pada class komponen Anda:

```php
<?php // resources/views/components/⚡revenue.blade.php

use Livewire\Attributes\Lazy;
use Livewire\Component;
use App\Models\Transaction;

new #[Lazy] class extends Component {
    public $amount;

    public function mount()
    {
        // Query database yang lambat...
        $this->amount = Transaction::monthToDate()->sum('amount');
    }
};
?>

<div>
    Pendapatan bulan ini: {{ $amount }}
</div>
```

Dengan `#[Lazy]`, komponen awalnya akan merender `<div></div>` kosong, lalu baru akan memuat isinya saat pengguna scroll ke area tersebut.

---

## Lazy vs Defer

Livewire menyediakan dua cara untuk menunda pemuatan komponen:

1.  **Lazy loading (`#[Lazy]`)**: Komponen dimuat saat **terlihat di layar** (ketika pengguna scroll ke arahnya).
2.  **Deferred loading (`#[Defer]`)**: Komponen dimuat **segera setelah halaman selesai dimuat sepenuhnya**, tanpa menunggu scroll.

**Tips:** Gunakan _lazy_ untuk konten di bagian bawah halaman yang mungkin tidak discroll oleh pengguna. Gunakan _defer_ untuk konten yang ada di atas layar tapi ingin Anda muat setelah halaman utama tampil.

---

## Menampilkan Placeholder (Kerangka Loading)

Secara default, Livewire merender `<div>` kosong. Anda bisa memberikan tampilan "loading" menggunakan method `placeholder()`:

```php
<?php // resources/views/components/⚡revenue.blade.php

use Livewire\Attributes\Lazy;
use Livewire\Component;

new #[Lazy] class extends Component {
    // ... logic lainnya

    public function placeholder()
    {
        return <<<'HTML'
        <div class="animate-pulse bg-gray-200 h-20 rounded">
            <!-- Tampilan kerangka loading (skeleton) -->
        </div>
        HTML;
    }
};
?>
```

---

## Menggabungkan Request (Bundling)

Jika Anda memiliki banyak komponen lazy di satu halaman, Livewire bisa menggabungkannya dalam satu pengiriman data (request) agar lebih efisien:

```php
new #[Lazy(bundle: true)] class extends Component { ... };
```

---

## Kapan Harus Menggunakan Lazy?

Gunakan `#[Lazy]` ketika:

1. Komponen melakukan operasi lambat (query database berat, panggil API luar).
2. Komponen berada di bagian bawah halaman (below the fold).
3. Anda ingin halaman utama tampil secepat mungkin (perceived performance).
4. Ada banyak komponen berat dalam satu halaman.
