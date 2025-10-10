<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class MidtransController extends Controller
{
    public function callback(Request $request)
    {
        $orderId = $request->order_id;
        $status = $request->transaction_status;

        $order = Order::find($orderId);

        if ($order) {
            if (in_array($status, ['settlement', 'capture'])) {
                $order->update(['status' => 'paid']);
            } elseif ($status === 'cancel') {
                $order->update(['status' => 'cancelled']);
            } elseif ($status === 'expire') {
                $order->update(['status' => 'expired']);
            } elseif ($status === 'pending') {
                $order->update(['status' => 'pending']);
            }
        }

        return response()->json(['success' => true]);
    }
}
