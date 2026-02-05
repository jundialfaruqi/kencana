Endpoint API = /v1/master/jadwalKhusus
Type = POST
Session AUTH = YES
Body Form Data :

1. lapangan_id = pilih Lapangan
2. tanggal = date format
3. buka = time format
4. tutup = time format
5. tipe = ENUM ('libur', 'event', 'tambahan')
6. keterangan = contoh : Ada event tournament

Kalau tipe yg dipilih adalah 'libur', di UI nya bikin input tutup dan buka nya menjadi disable menggunakan wire live.
