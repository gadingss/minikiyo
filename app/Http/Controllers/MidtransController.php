<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;

class MidtransController extends Controller
{
    public function callback(Request $request)
    {
        Log::info('MIDTRANS CALLBACK', $request->all());

        // Ambil server key dari config
        $serverKey = config('midtrans.server_key');

        // Cek kalau server key kosong (agar mudah debug)
        if (empty($serverKey)) {
            Log::error('Midtrans server key kosong! Cek .env atau config/midtrans.php');
            return response()->json(['message' => 'Server key not configured'], 500);
        }

        // Buat string untuk hash sesuai dokumentasi Midtrans
        $signatureString = $request->order_id . $request->status_code . $request->gross_amount . $serverKey;
        $expectedSignature = hash('sha512', $signatureString);

        Log::info('SIGNATURE DEBUG', [
            'string_for_hash' => $signatureString,
            'expected' => $expectedSignature,
            'received' => $request->signature_key,
        ]);

        // Validasi signature
        if ($expectedSignature !== $request->signature_key) {
            Log::error('Invalid signature', [
                'expected' => $expectedSignature,
                'received' => $request->signature_key,
                'order_id' => $request->order_id,
                'gross_amount' => $request->gross_amount,
                'status_code' => $request->status_code,
            ]);
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // Ambil order berdasarkan order_id
        $order = Order::find($request->order_id);
        if (!$order) {
            Log::error('Order not found', ['order_id' => $request->order_id]);
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Simpan / update data pembayaran
        $statusMidtrans = $request->transaction_status;

        switch ($statusMidtrans) {
            case 'settlement':
            case 'capture':
                $status = 'paid';
                break;
            case 'pending':
                $status = 'pending';
                break;
            case 'expire':
            case 'cancel':
            case 'deny':
                $status = 'failed';
                break;
            default:
                $status = 'unpaid';
                break;
        }

        // Simpan / update data pembayaran
        Payment::updateOrCreate(
            ['order_id' => $order->id],
            [
                'payment_date'          => now(),
                'amount'                => $request->gross_amount,
                'payment_method'        => $request->payment_type,
                'payment_status'        => $status,
                'transaction_reference' => $request->transaction_id,
            ]
        );

        Log::info("Order {$order->id} updated to status {$status}");

        // ⬇️ Tambahkan di atas "return response()->json..."
        if ($status === 'paid') {

            // Ambil item pesanan
            $items = $order->items; // relasi order_items

            foreach ($items as $item) {
                $product = $item->product; // relasi ke product

                if ($product) {
                    // Kurangi stok produk sesuai qty
                    $product->stock_quantity -= $item->quantity; 
                    $product->save();
                }
            }

            Log::info("Stok produk untuk Order {$order->id} berhasil dikurangi");
        }


        return response()->json(['message' => 'Callback processed successfully'], 200);
    }

    
}
