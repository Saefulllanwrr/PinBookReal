<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Struk Peminjaman</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
        }

        .struk {
            border: 1px dashed #3498db;
            padding: 20px;
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
        }

        .header h2 {
            color: #2c3e50;
            font-size: 22px;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 1px solid #3498db;
            font-weight: bold;
            text-align: center;
        }

        .content p {
            font-size: 14px;
            color: #000;
            margin: 8px 0;
        }

        .content p strong {
            font-weight: bold;
        }

        .footer {
            margin-top: 20px;
            font-size: 13px;
            color: #000;
            text-align: center;
        }

        .footer p {
            margin: 4px 0;
        }
    </style>
</head>

<body>
    <div class="struk">
        <div class="header">
            <h2>PINBOOK KUPON</h2>
        </div>
        <div class="content">
            @if ($peminjaman->user && $peminjaman->book)
                <p><strong>Nama Peminjam:</strong> {{ $peminjaman->user->name }}</p>
                <p><strong>Judul Buku:</strong> {{ $peminjaman->book->judul }}</p>
                <p><strong>Tanggal Pinjam:</strong> {{ $peminjaman->tanggal_pinjam }}</p>
                <p><strong>Tanggal Kembali:</strong> {{ $peminjaman->tanggal_kembali }}</p>
            @else
                <p>Data peminjaman tidak lengkap.</p>
            @endif
        </div>
        <div class="footer">
            <p><strong>Peminjaman disetujui!</strong></p>
            <p>Terima kasih telah meminjam buku di perpustakaan kami.</p>
        </div>
    </div>
</body>

</html>
