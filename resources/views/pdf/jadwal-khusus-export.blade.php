<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Export Data Jadwal Khusus</title>
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
        <h2>Data Jadwal Khusus Kencana Arena</h2>
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
                <th width="15%">Tanggal</th>
                <th width="12%">Jam</th>
                <th width="15%">Tipe</th>
                <th width="20%">Keterangan</th>
                <th width="33%">Arena</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $index => $it)
                <tr>
                    <td align="center">{{ $index + 1 }}</td>
                    <td><b>{{ \Carbon\Carbon::parse(data_get($it, 'tanggal'))->format('d M Y') }}</b></td>
                    <td>
                        {{ substr(data_get($it, 'buka', ''), 0, 5) }} - {{ substr(data_get($it, 'tutup', ''), 0, 5) }}
                    </td>
                    <td>{{ data_get($it, 'tipe_label', '-') }}</td>
                    <td>{{ data_get($it, 'keterangan', '-') }}</td>
                    <td>{{ data_get($it, 'lapangan.nama_lapangan') ?? data_get($it, 'lapangan.nama', '-') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" align="center" style="padding: 20px;">Tidak ada data jadwal khusus pada rentang waktu tersebut.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ \Carbon\Carbon::now()->format('d M Y H:i:s') }}
    </div>

</body>
</html>
