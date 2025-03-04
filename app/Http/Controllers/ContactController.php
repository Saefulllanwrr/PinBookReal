<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;

class ContactController extends Controller
{
    // Menampilkan form kontak
    public function showContactForm()
    {
        return view('contact-form'); // Ganti 'contact' dengan nama view yang sesuai
    }

    // Menangani pengiriman form kontak
    public function submitContactForm(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        // Kirim email
        Mail::to('saepulepul12277@gmail.com')->send(new ContactFormMail($request->all()));

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Pesan Anda telah berhasil dikirim!');
    }
}
