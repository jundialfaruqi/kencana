<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Export Data Booking</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            padding: 0;
            color: #1e3a8a;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #1e3a8a;
            color: white;
            font-size: 11px;
            text-transform: uppercase;
        }
        td {
            font-size: 11px;
        }
        .status {
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-selesai { color: #10b981; }
        .status-dipesan { color: #3b82f6; }
        .status-dibatalkan { color: #ef4444; }
        
        .footer {
            margin-top: 30px;
            font-size: 10px;
            color: #999;
            text-align: right;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>Data Booking Kencana Arena</h2>
        <p>
            Periode: 
            @if(filled($from) && filled($to))
                {{ \Carbon\Carbon::parse($from)->format('d M Y') }} - {{ \Carbon\Carbon::parse($to)->format('d M Y') }}
            @elseif(filled($from))
                Sejak {{ \Carbon\Carbon::parse($from)->format('d M Y') }}
            @elseif(filled($to))
                Hingga {{ \Carbon\Carbon::parse($to)->format('d M Y') }}
            @else
                Keseluruhan
            @endif
        </p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Kode Booking</th>
                <th width="15%">Tanggal</th>
                <th width="12%">Jam</th>
                <th width="18%">Pemesan</th>
                <th width="15%">Lapangan</th>
                <th width="10%">Status</th>
                <th width="10%">Pemain</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bookings as $index => $b)
                <tr>
                    <td align="center">{{ $index + 1 }}</td>
                    <td><b>{{ data_get($b, 'kode_booking', '-') }}</b></td>
                    <td>{{ \Carbon\Carbon::parse(data_get($b, 'tanggal'))->format('d M Y') }}</td>
                    <td>
                        {{ substr(data_get($b, 'jam_mulai', ''), 0, 5) }} - {{ substr(data_get($b, 'jam_selesai', ''), 0, 5) }}
                    </td>
                    <td>
                        {{ data_get($b, 'user.name') ?? data_get($b, 'pemesan.nama', '-') }}
                        <br>
                        <small style="color: #666;">
                            {{ data_get($b, 'nama_komunitas') ?? data_get($b, 'pemesan.nama_komunitas', '-') }}
                        </small>
                    </td>
                    <td>{{ data_get($b, 'lapangan.nama_lapangan') ?? data_get($b, 'lapangan.nama', '-') }}</td>
                    <td class="status status-{{ strtolower(data_get($b, 'status', '')) }}">
                        {{ data_get($b, 'status', '-') }}
                    </td>
                    <td align="center">{{ data_get($b, 'jumlah_pemain', '-') }} org</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" align="center" style="padding: 20px;">Tidak ada data booking pada rentang waktu tersebut.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ \Carbon\Carbon::now()->format('d M Y H:i:s') }}
    </div>

</body>
</html>
