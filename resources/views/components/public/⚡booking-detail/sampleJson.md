Lapangan A : GET /v1/catatan/1
{
"success": true,
"message": "Daftar catatan lapangan",
"data": [
{
"kategori_catatan": "Aturan Pemakaian",
"items": [
{
"catatan": "Durasi permainan maksimal 1 jam.",
"urutan": 1
},
{
"catatan": "Keterlambatan lebih dari 15 menit dari jadwal booking dianggap pembatalan.",
"urutan": 2
},
{
"catatan": "Dilarang membawa minuman keras dan zat adiktif lainnya.",
"urutan": 3
},
{
"catatan": "Dilarang merokok, meludah, makan permen karet, dan membuang sampah sembarangan di area lapangan.",
"urutan": 4
},
{
"catatan": "Dilarang merusak fasilitas lapangan dan wajib menjaga ketertiban selama penggunaan lapangan.",
"urutan": 5
},
{
"catatan": "Menghentikan aktivitas permainan saat tiba waktu shalat lima waktu.",
"urutan": 6
},
{
"catatan": "Menjaga kebersihan dan ketertiban selama berada di lokasi lapangan.",
"urutan": 7
}
]
}
]
}

Lapangan B : /v1/catatan/10
{
"success": true,
"message": "Daftar catatan lapangan",
"data": [
{
"kategori_catatan": "Syarat dan Ketentuan",
"items": [
{
"catatan": "Catatan Satu",
"urutan": 1
},
{
"catatan": "Catatan Dua",
"urutan": 2
}
]
}
]
}

/v1/lapangan/historyBooking/BK-20260208-DVY9
{
"success": true,
"data": {
"kode_booking": "BK-20260208-DVY9",
"tanggal": "Minggu, 29 Maret 2026",
"jam": {
"mulai": "11:00",
"selesai": "12:00"
},
"lapangan": {
"nama": "Badminton"
},
"pemesan": {
"nama": "e",
"jumlah_pemain": 2,
"kategori": "anak-anak",
"jenis_permainan": "latihan"
},
"status": "dipesan",
"keterangan": null,
"dibuat_pada": "08 Februari 2026 11:43"
}
}

Custom header : Accept value : application/json
