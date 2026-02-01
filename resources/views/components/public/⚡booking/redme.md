Berikut penjelasan lengkap untuk request API BookingLapangan.

URL & Method:

Method: POST
URL: {{url}}/api/v1/lapangan/bookingLapangan
{{url}} di sini adalah variable environment yang berisi base URL API kamu (misalnya https://example.com).
Headers:

Accept: application/json
Artinya client (Postman) mengharapkan response dalam format JSON.
Body (x-www-form-urlencoded):

lapangan_id
Contoh value: 1
Tipe: number (ID lapangan/futsal/field)
Description: ID lapangan yang ingin dibooking. Biasanya mengacu pada data dari endpoint getLapangan.

tanggal
Contoh value: 2026-01-10 (atau 2026-01-31 seperti referensi)
Format: YYYY-MM-DD
Description: Tanggal booking lapangan.

jam_mulai
Contoh value: 11:00
Format: HH:MM (24 jam)
Description: Jam mulai pemakaian lapangan.

jam_selesai
Contoh value: 12:00
Format: HH:MM
Description: Jam selesai pemakaian lapangan.

nama_komunitas
Contoh value: Tim Kominfo
Tipe: string (opsional)
Description: Nama komunitas/tim yang melakukan booking.

jumlah_pemain
Contoh value: 10 (atau 16 di referensi)
Tipe: number (min 1)
Description: Perkiraan jumlah pemain yang akan bermain.

kategori_pemain
Contoh value: dewasa
Tipe: string (enum: anak-anak, remaja, dewasa)
Description: Kategori umur/tipe pemain.

jenis_permainan
Contoh value: fun_match
Tipe: string (enum: fun_match, latihan, turnamen_kecil)
Description: Jenis kegiatan yang dilakukan.

keterangan
Contoh value: tes keterangan
Tipe: string (opsional)
Description: Catatan tambahan untuk admin/pengelola lapangan (misal: “butuh wasit”, “pakai rompi”, dll).

Variables yang dipakai:
{{url}} → base URL API (diisi di Environment api)

Response:
Status: 201 Created
Body:
{ "success": true, "message": "Booking berhasil : BK-20260201-VH9S"}
success: boolean, menunjukkan booking berhasil.
message: string, berisi pesan sukses sekaligus kode booking (BK-20260201-VH9S).
