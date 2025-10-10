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
        $orders = Order::where('user_id', auth()->id())->latest()->get();
        return view('orders.riwayat', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::where('user_id', auth()->id())->findOrFail($id);
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

}
