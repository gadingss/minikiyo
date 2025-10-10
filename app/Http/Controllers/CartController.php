<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    public function add(Request $request)
    {
        $productId = $request->product_id; // ambil product_id dari request
        $quantity = $request->quantity ?? 1;

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
            $cart[$productId]['subtotal'] = $cart[$productId]['unit_price'] * $cart[$productId]['quantity'];
        } else {
            $cart[$productId] = [
                "product_id" => $productId,
                "name"       => $request->name,
                "unit_price" => $request->price,
                "quantity"   => $quantity,
                "subtotal"   => $request->price * $quantity,
            ];
        }

        session()->put('cart', $cart);

        $cartCount = array_sum(array_column($cart, 'quantity'));

        return response()->json([
            'success' => true,
            'message' => $request->name . ' ditambahkan ke keranjang',
            'cart_count' => $cartCount
        ]);
    }

    public function list()
    {
        $cart = session()->get('cart', []);

        $total = array_sum(array_column($cart, 'subtotal'));
        $cartCount = array_sum(array_column($cart, 'quantity'));

        return response()->json([
            'cart' => $cart,
            'total' => $total,
            'cart_count' => $cartCount
        ]);
    }



    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);
        if (!$cart) {
            return response()->json([
                'success' => false,
                'message' => 'Cart kosong!'
            ]);
        }

        $total = array_sum(array_map(fn($item) => ($item['unit_price'] ?? 0) * ($item['quantity'] ?? 0), $cart));


        $order = Order::create([
            'user_id' => Auth::id(),
            'status'  => 'pending',
            'total_amount' => $total,
            'shipping_address' => Auth::user()->address ?? 'Alamat default',
        ]);

        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id'  => $item['product_id'],
                'quantity' => $item['quantity'],
                'unit_price'    => $item['unit_price'],
                'subtotal' => $item['subtotal']
            ]);
        }

            // Buat Snap Token
        $snapToken = \App\Helpers\Midtrans::createTransaction($order);
        
        session()->forget('cart');

        return response()->json([
            'success' => true,
            'message' => 'Pesanan berhasil dibuat!',
            'order_id' => $order->id,
            'snap_token' => $snapToken
        ]);
    }
}
