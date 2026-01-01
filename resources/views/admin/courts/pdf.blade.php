<!DOCTYPE html>
<html>

<head>
    <title>Laporan Data Lapangan</title>
    <style>
        body {
            font-family: sans-serif;
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
    <h2>Laporan Data Lapangan</h2>
    <div class="meta">
        <p>Dicetak pada: {{ now()->format('d M Y H:i:s') }}</p>
        <p>Total Lapangan: {{ $courts->count() }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 25%">Nama Lapangan</th>
                <th style="width: 20%">Kategori</th>
                <th style="width: 20%">Lokasi</th>
                <th style="width: 15%">Harga/Jam</th>
                <th style="width: 15%">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($courts as $index => $court)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $court->court_name }}</td>
                    <td>{{ $court->courtCategory->category_name ?? '-' }}</td>
                    <td>{{ $court->location }}</td>
                    <td>Rp {{ number_format($court->price_per_hour, 0, ',', '.') }}</td>
                    <td>{{ $court->is_available ? 'Tersedia' : 'Tidak Tersedia' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>