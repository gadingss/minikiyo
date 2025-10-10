<?php

namespace App\Helpers;

use Midtrans\Config;
use Midtrans\Snap;

class Midtrans
{
    public static function config()
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = env('MIDTRANS_SANITIZE', true);
        Config::$is3ds = env('MIDTRANS_3DS', true);
    }

    public static function createTransaction($order)
    {
        self::config();

        $params = [
            'transaction_details' => [
                'order_id' => $order->id,
                'gross_amount' => $order->total_amount,
            ],
            'customer_details' => [
                'first_name' => $order->user->full_name ?? 'Customer',
                'email' => $order->user->email ?? 'noemail@example.com',
                'phone' => $order->user->phone ?? '0000',
            ],
        ];

        return Snap::getSnapToken($params);
    }
}
