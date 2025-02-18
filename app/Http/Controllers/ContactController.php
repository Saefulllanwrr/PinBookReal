<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message; // Import model Message
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;

class ContactController extends Controller
{
    /**
     * Menampilkan form kontak (jika diperlukan)
     */
    public function show()
    {
        return view('contact'); // Sesuaikan dengan nama view jika diperlukan
    }

    /**
     * Menangani pengiriman form kontak
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:1000',
        ]);

        // Simpan pesan ke database
        Message::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
        ]);

        // Kirim email (opsional)
        Mail::to('info@pinbook.com')->send(new ContactFormMail($request->all()));

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Pesan Anda telah berhasil dikirim!');
    }
}
