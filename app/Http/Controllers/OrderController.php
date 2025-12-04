<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('items.product')
            ->where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->get();

        return view('orders.index', compact('orders'));
    }

    public function riwayat()
    {
        $status = request('status'); // ambil ?status= dari URL

        $orders = Order::where('user_id', auth()->id())
            ->when($status, function ($query) use ($status) {
                return $query->where('status', $status);
            })
            ->latest()
            ->get();

        return view('orders.riwayat', compact('orders', 'status'));
    }


    public function show($id)
    {
        $order = Order::with('items.product') // ambil relasi sekaligus
            ->where('user_id', auth()->id())
            ->findOrFail($id);
        return view('orders.detail', compact('order'));
    }

    public function cancel($id)
    {
        $order = Order::where('user_id', auth()->id())->findOrFail($id);
        if ($order->status === 'pending') {
            $order->update(['status' => 'dibatalkan']);
        }

        return redirect()->route('orders.riwayat')->with('success', 'Pesanan berhasil dibatalkan.');
    }

    public function checkout(Request $request)
    {

        // 1️⃣ Buat order di database
        $order = Order::create([
            'user_id' => auth()->id(),
            'total_amount' => $request->total,  // disesuaikan dengan kolom total_amount
            'status' => 'pending',
        ]);

        // 2️⃣ Konfigurasi Midtrans
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = false; // ubah ke true kalau sudah live
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        // 3️⃣ Parameter transaksi
        $params = [
            'transaction_details' => [
                'order_id' => $order->id,
                'gross_amount' => $order->total_amount,
            ],
            'customer_details' => [
                'name' => auth()->user()->name,
                'email' => auth()->user()->email,
            ],
        ];

        // 4️⃣ Dapatkan Snap Token dari Midtrans
        $snapToken = \Midtrans\Snap::getSnapToken($params);

        // 5️⃣ Kirim token ke frontend untuk ditampilkan lewat Snap.js
        return response()->json([
            'success' => true,
            'snap_token' => $snapToken,
            'order_id' => $order->id,
        ]);
    }




}
