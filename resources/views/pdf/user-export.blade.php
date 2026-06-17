<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Export Data User</title>
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
        <h2>Data User Kencana Arena</h2>
        <p>Keseluruhan Data User Terdaftar</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">Nama</th>
                <th width="20%">Email</th>
                <th width="15%">Role</th>
                <th width="15%">NIK</th>
                <th width="15%">No. WA</th>
                <th width="10%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $index => $u)
                <tr>
                    <td align="center">{{ $index + 1 }}</td>
                    <td><b>{{ data_get($u, 'name', '-') }}</b></td>
                    <td>{{ data_get($u, 'email_masked', '-') }}</td>
                    <td>{{ data_get($u, 'role', '-') }}</td>
                    <td>{{ data_get($u, 'nik_masked', '-') }}</td>
                    <td>{{ data_get($u, 'no_wa_masked', '-') }}</td>
                    <td>
                        @if(($u['is_active'] ?? false) === true)
                            <span style="color: #10b981; font-weight: bold;">Aktif</span>
                        @else
                            <span style="color: #ef4444; font-weight: bold;">Nonaktif</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" align="center" style="padding: 20px;">Tidak ada data user.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ \Carbon\Carbon::now()->format('d M Y H:i:s') }}
        <br>
        * Data sensitif (Email, NIK, No WA) disamarkan untuk alasan keamanan dan privasi.
    </div>

</body>
</html>
