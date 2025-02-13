<?php

namespace App\Http\Controllers;

use Midtrans\Config;
use App\Models\Donation;
use Midtrans\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class notificationController extends Controller
{
    public function handleNotification(Request $request)
    {
        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        // Validasi request
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|string',
            'transaction_status' => 'required|string',
            'fraud_status' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            Log::error('Request notifikasi tidak valid: ' . json_encode($validator->errors()));
            return response()->json(['message' => 'Request tidak valid'], 400);
        }

        try {
            // Ambil notifikasi dari Midtrans
            $notification = new Notification();

            $orderId = $notification->order_id;
            $transactionStatus = $notification->transaction_status;
            $fraudStatus = $notification->fraud_status;

            // Cari pesanan berdasarkan order_id
            $order = Donation::where('order_id', $orderId)->first();

            if (!$order) {
                Log::error("Order tidak ditemukan: $orderId");
                return response()->json(['message' => 'Order tidak ditemukan'], 404);
            }

            // Proses status transaksi
            switch ($transactionStatus) {
                case 'capture':
                    if ($fraudStatus == 'accept') {
                        $order->update(['status' => 'paid']);
                        Log::info("Order $orderId berhasil dibayar (capture).");
                    } else {
                        $order->update(['status' => 'failed']);
                        Log::warning("Order $orderId ditolak karena fraud status: $fraudStatus.");
                    }
                    break;

                case 'settlement':
                    $order->update(['status' => 'paid']);
                    Log::info("Order $orderId berhasil diselesaikan (settlement).");
                    break;

                case 'pending':
                    $order->update(['status' => 'pending']);
                    Log::info("Order $orderId menunggu pembayaran (pending).");
                    break;

                case 'deny':
                    $order->update(['status' => 'failed']);
                    Log::warning("Order $orderId ditolak (deny).");
                    break;

                case 'expire':
                    $order->update(['status' => 'expired']);
                    Log::warning("Order $orderId kedaluwarsa (expire).");
                    break;

                case 'cancel':
                    $order->update(['status' => 'canceled']);
                    Log::warning("Order $orderId dibatalkan (cancel).");
                    break;

                default:
                    Log::warning("Status transaksi tidak dikenali: $transactionStatus untuk order $orderId.");
                    break;
            }

            return response()->json(['message' => 'Notifikasi berhasil diproses']);
        } catch (\Exception $e) {
            // Log error dan kembalikan respons error
            Log::error("Error memproses notifikasi: " . $e->getMessage());
            return response()->json(['message' => 'Terjadi kesalahan internal'], 500);
        }
    }
}
