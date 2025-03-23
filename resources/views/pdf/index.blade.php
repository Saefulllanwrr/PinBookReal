<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PDF PINBOOK REPORT</title>
</head>

<body>
    <div style="text-align: center;">
        <h1>Report Data</h1>
        <p>Generated on: {{ date('Y-m-d H:i:s') }}</p>
    </div>

    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th style="border: 1px solid #ddd; padding: 8px;">No</th>
                <th style="border: 1px solid #ddd; padding: 8px;">Judul</th>
                <th style="border: 1px solid #ddd; padding: 8px;">Penulis</th>
                <th style="border: 1px solid #ddd; padding: 8px;">Penerbit</th>
                <th style="border: 1px solid #ddd; padding: 8px;">ISBN</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($books as $index => $book)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $book->judul }}</td>
                    <td>{{ $book->penulis }}</td>
                    <td>{{ $book->penerbit }}</td>
                    <td>{{ $book->isbn }}</td>

                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
