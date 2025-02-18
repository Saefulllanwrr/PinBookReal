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
        // Middleware auth agar hanya user yang login bisa donasi


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
            'item_details' => [
                [
                    'id' => $orderId,
                    'price' => $donation->amount,
                    'quantity' => 1,
                    'name' => "Donasi"
                ]
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

    /**
     * Callback dari Midtrans
     */
    public function callback(Request $request)
    {
        // Verifikasi Signature
        $serverKey = env('MIDTRANS_SERVER_KEY');
        $signatureKey = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($signatureKey !== $request->signature_key) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // Cari donasi berdasarkan order_id
        $donation = Donation::where('order_id', $request->order_id)->first();

        if (!$donation) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Update status donasi berdasarkan status Midtrans
        switch ($request->transaction_status) {
            case 'capture':
            case 'settlement':
                $donation->payment_status = 'success';
                break;
            case 'pending':
                $donation->payment_status = 'pending';
                break;
            case 'deny':
            case 'expire':
            case 'cancel':
                $donation->payment_status = 'failed';
                break;
        }

        $donation->save();

        return response()->json(['message' => 'Callback processed successfully']);
    }
}
