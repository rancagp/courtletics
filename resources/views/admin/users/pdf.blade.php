<!DOCTYPE html>
<html>

<head>
    <title>Laporan Data User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 12px;
        }

        th {
            background-color: #f2f2f2;
            color: #333;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .meta {
            margin-bottom: 20px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>

<body>
    <h2>Laporan Data User</h2>
    <div class="meta">
        <p>Dicetak pada: {{ now()->format('d M Y H:i:s') }}</p>
        <p>Total User: {{ $users->count() }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 25%">Nama</th>
                <th style="width: 30%">Email</th>
                <th style="width: 15%">Role</th>
                <th style="width: 15%">No. HP</th>
                <th style="width: 20%">Tanggal Bergabung</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $index => $user)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ ucfirst($user->role->name) }}</td>
                    <td>{{ $user->phone_number ?? '-' }}</td>
                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">Tidak ada data user.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>