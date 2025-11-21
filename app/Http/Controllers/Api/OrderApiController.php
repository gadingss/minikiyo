<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;

class OrderApiController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'total' => 'required|numeric',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.unit_price' => 'required|numeric',
            'items.*.quantity' => 'required|integer|min:1',
        ]);


        $order = Order::create([
            'user_id' => $request->user_id,
            'total_amount' => 0,
        ]);
        $total = 0;

        foreach ($request->items as $item) {
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $item['product_id'],
                'unit_price' => $item['unit_price'],
                'quantity'   => $item['quantity'],
            ]);

            $total += $item['unit_price'] * $item['quantity'];
        }

        $order->update(['total_amount' => $total]);



        return response()->json([
            'success' => true,
            'order_id' => $order->id,
            'message' => 'Order berhasil dibuat'
        ]);
    }
    
    public function getUserOrders($user_id)
    {
        $orders = \App\Models\Order::with('items') // ambil relasi item juga
            ->where('user_id', $user_id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($order) {
                return [
                    'id' => $order->id,
                    'total' => $order->total_amount, // rename supaya cocok Android
                    'status' => $order->status,
                    'created_at' => $order->created_at,
                    'items' => $order->items->map(function($item) {
                        return [
                            'product_name' => $item->product->name, // pastikan relasi product
                            'quantity' => $item->quantity,
                            'unit_price' => $item->unit_price,
                        ];
                    }),
                ];
            });

        return response()->json($orders);
    }



}
