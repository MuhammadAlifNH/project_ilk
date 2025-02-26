<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Inventaris - PDF</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1, .header h2, .header p {
            margin: 4px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            padding: 6px;
            text-align: left;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>INVENTARIS</h1>
        <h2>
            RUANG LABORATORIUM {{ optional($inventaris->lab)->nama_lab ?? 'Tidak Diketahui' }},
            {{ optional($inventaris->fakultas)->nama_fakultas ?? 'Tidak Diketahui' }}
        </h2>
        <p>Universitas Islam Nahdlatul Ulama Jepara</p>
        <p>Tanggal: {{ $inventaris->tanggal }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Merk/Type</th>
                <th>Tahun Pembelian</th>
                <th>Jumlah</th>
                <th>Kondisi</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inventaris->details as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->kode_barang }}</td>
                <td>{{ $item->nama_barang }}</td>
                <td>{{ $item->merk_type }}</td>
                <td>{{ $item->tahun_pembelian }}</td>
                <td>{{ $item->jumlah }}</td>
                <td>{{ $item->kondisi }}</td>
                <td>{{ $item->keterangan }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Koordinator Laboratorium Komputer</p>
        <br><br><br>
        <p><strong>Muhamad Husen, S.Kom</strong></p>
    </div>
</body>
</html>
