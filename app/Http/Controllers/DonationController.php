<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use Midtrans\Config;
use Illuminate\Http\Request;
use App\Models\Donation;
use Illuminate\Support\Facades\Log;

class DonationController extends Controller
{
    public function __construct()
    {
        // Konfigurasi Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('APP_ENV') === 'production';
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    /**
     * Proses donasi dan buat transaksi Midtrans
     */
    public function process(Request $request)
    {
        // Validasi input
        $request->validate([
            'amount' => 'required|numeric|min:1000',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        // Buat order ID unik
        $orderId = 'DON-' . time();

        // Simpan data donasi ke database
        $donation = Donation::create([
            'name' => $request->name,
            'email' => $request->email,
            'amount' => $request->amount,
            'payment_status' => 'pending',
            'order_id' => $orderId,
        ]);

        // Buat parameter transaksi Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $donation->amount,
            ],
            'customer_details' => [
                'first_name' => $donation->name,
                'email' => $donation->email,
            ],
            'callbacks' => [
                'finish' => route('peminjaman.index')
            ]
        ];

        try {
            // Generate snap token
            $snapToken = Snap::getSnapToken($params);
            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            Log::error('Midtrans Error: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan saat memproses pembayaran.'], 500);
        }
    }
}
