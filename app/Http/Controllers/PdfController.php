<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    public function __invoke(Book $book)
    {
        // Ambil semua buku dari database
        $books = Book::all();

        // Kirim variabel $books ke view
        $pdf = Pdf::loadView('pdf.index', ['books' => $books]);

        return response($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="books-report.pdf"',
        ]);
    }

    public function allBooks()
    {
        $books = Book::all(); // Ambil semua buku
        $pdf = Pdf::loadView('pdf.index', ['books' => $books]);

        return response($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="all-books-report.pdf"',
        ]);
    }
}
