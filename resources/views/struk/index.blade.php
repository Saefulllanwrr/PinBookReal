<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Peminjaman</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        /* Gaya untuk tampilan layar */
        @media screen {
            body {
                font-family: 'Poppins', sans-serif;
                background-color: #f4f4f4;
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                margin: 0;
            }

            .struk {
                background-color: #ffffff;
                border-radius: 12px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                padding: 24px;
                max-width: 420px;
                width: 100%;
                text-align: center;
                border: 2px dashed #3498db;
            }

            .header h2 {
                color: #2c3e50;
                font-size: 26px;
                margin-bottom: 15px;
                padding-bottom: 8px;
                border-bottom: 2px solid #3498db;
                font-weight: 600;
            }

            .content p {
                font-size: 16px;
                color: #34495e;
                margin: 12px 0;
                text-align: left;
            }

            .content p strong {
                color: #2c3e50;
                font-weight: 600;
            }

            .footer {
                margin-top: 20px;
                font-size: 14px;
                color: #7f8c8d;
            }

            .footer p {
                margin: 5px 0;
            }

            .footer p:first-child {
                color: #27ae60;
                font-weight: bold;
            }
        }

        /* Gaya khusus untuk cetak */
        @media print {
            body {
                background-color: white;
                margin: 0;
                padding: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
            }

            .struk {
                box-shadow: none;
                border-radius: 0;
                padding: 16px;
                max-width: 100%;
                width: 100%;
                border: 1px solid black;
            }

            .header h2 {
                color: black;
                font-size: 22px;
                border-bottom: 1px solid black;
                padding-bottom: 5px;
            }

            .content p {
                color: black;
                font-size: 14px;
            }

            .content p strong {
                color: black;
            }

            .footer {
                color: black;
                font-size: 12px;
            }

            .footer p:first-child {
                color: black;
            }
        }
    </style>
</head>

<body>
    <div class="struk">
        <div class="header">
            <h2>PINBOOK KUPON</h2>
        </div>
        <div class="content">
            <p><strong>Nama Peminjam:</strong> {{ $peminjaman->user->name }}</p>
            <p><strong>Judul Buku:</strong> {{ $peminjaman->book->judul }}</p>
            <p><strong>Tanggal Pinjam:</strong> {{ $peminjaman->tanggal_pinjam }}</p>
            <p><strong>Tanggal Kembali:</strong> {{ $peminjaman->tanggal_kembali }}</p>
        </div>
        <div class="footer">
            <p>Peminjaman disetujui!</p>
            <p>Terima kasih telah meminjam buku di perpustakaan kami.</p>
        </div>
    </div>
</body>

</html>
