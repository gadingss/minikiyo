<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PromoCode;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $summary = session()->get('checkout_summary');
        $address = session('user_address');

        // Jika summary belum ada → fallback hitung manual
        if (!$summary) {
            $subtotal = array_sum(array_map(fn($item) =>
                ($item['unit_price'] ?? 0) * ($item['quantity'] ?? 0), $cart
            ));

            $deliveryOption = session('delivery_option', 'takeaway');
            $deliveryFee = $deliveryOption === 'takeaway' ? 0 : 10000;

            $summary = [
                'subtotal' => $subtotal,
                'discount' => 0,
                'delivery_fee' => $deliveryFee,
                'total' => $subtotal + $deliveryFee,
                'promo_code' => null,
                'note' => session('order_note')
            ];
        }
        // Inject note dari session agar tampil di keranjang
        if (!empty(session('order_note'))) {
            $summary['note'] = session('order_note');
        }


        return view('cart.index', compact('cart', 'summary', 'address'));
    }


    public function add(Request $request)
    {
        $productId = (int) $request->product_id;

        $quantity = (int) ($request->quantity ?? 1);
        $price = (float) ($request->price ?? 0);

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
            $cart[$productId]['subtotal'] = ($cart[$productId]['unit_price'] ?? 0) * ($cart[$productId]['quantity'] ?? 0);
        } else {
            $cart[$productId] = [
                "product_id" => $productId, // WAJIB
                "name"       => $request->name ?? 'Produk Tanpa Nama',
                "unit_price" => $price,
                "quantity"   => $quantity,
                "subtotal"   => $price * $quantity,
            ];
        }

        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => ($request->name ?? 'Produk') . ' ditambahkan ke keranjang',
            'cart' => $cart,
            'cart_total' => array_sum(array_column($cart, 'subtotal')),
            'cart_count' => array_sum(array_column($cart, 'quantity')),
        ]);
    }

    public function list()
    {
        $cart = session()->get('cart', []);
        $cartTotal = array_sum(array_column($cart, 'subtotal'));
        $cartCount = array_sum(array_column($cart, 'quantity'));

        $discountAmount = session('discount_amount', 0);
        $promoCode = session('promo_code');

        $deliveryOption = session('delivery_option', 'takeaway');
        $deliveryFee = $this->calculateDeliveryFee($deliveryOption, $cartTotal);

        $totalAmount = $cartTotal - $discountAmount + $deliveryFee;

        return response()->json([
            'cart' => $cart,
            'cart_total' => $cartTotal,
            'cart_count' => $cartCount,
            'discount_amount' => $discountAmount,
            'promo_code' => $promoCode,
            'delivery_fee' => $deliveryFee,
            'total_amount' => $totalAmount,
            'delivery_option' => $deliveryOption
        ]);
    }

    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return response()->json([
                'success' => false,
                'message' => 'Cart kosong!'
            ]);
        }

        // Prefer nilai yang disimpan Livewire di session (sinkronisasi)
        $summary = session('checkout_summary', null);

        if ($summary) {
            $subtotal = (float) ($summary['subtotal'] ?? 0);
            $discountAmount = (float) ($summary['discount'] ?? 0);
            $deliveryOption = $summary['delivery_option'] ?? 'takeaway';
            $deliveryFee = (float) ($summary['delivery_fee'] ?? 0);
            $totalAmount = (float) ($summary['total'] ?? ($subtotal - $discountAmount + $deliveryFee));
        } else {
            // fallback: kalau session checkout_summary belum ada, hitung di server
            $subtotal = array_sum(array_map(fn($item) =>
                ($item['unit_price'] ?? 0) * ($item['quantity'] ?? 0), $cart
            ));
            $deliveryOption = $request->input('delivery_option', 'takeaway');
            $discountAmount = session('discount_amount', 0);
            $deliveryFee = $this->calculateDeliveryFee($deliveryOption, $subtotal);
            $totalAmount = $subtotal - $discountAmount + $deliveryFee;
        }

        // buat order
        $order = Order::create([
            'user_id' => Auth::id(),
            'status'  => 'pending',
            'subtotal' => $subtotal,
            'discount_amount' => $discountAmount,
            'promo_code_id' => session('promo_code_id'),
            'delivery_fee' => $deliveryFee,
            'total_amount' => $totalAmount,
            'delivery_option' => $deliveryOption,
            'shipping_address' => $deliveryOption === 'delivery'
                ? (session('user_address') ?? Auth::user()->address ?? 'Alamat tidak tersedia')
                : null,
            'note' => session('order_note') ?? ($summary['note'] ?? null),



        ]);

        // simpan order items
        foreach ($cart as $key => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'] ?? (int)$key,
                'product_name' => $item['name'] ?? 'Produk',
                'quantity' => $item['quantity'] ?? 0,
                'unit_price' => $item['unit_price'] ?? 0,
                'subtotal' => $item['subtotal'] ?? 0
            ]);
        }

        if (session('promo_code_id')) {
            PromoCode::where('id', session('promo_code_id'))->increment('used_count');
        }

        \Log::info('=== DEBUG DATA CHECKOUT ===', [
            'subtotal' => $subtotal,
            'discountAmount' => $discountAmount,
            'deliveryFee' => $deliveryFee,
            'totalAmount' => $totalAmount,
            'deliveryOption' => $deliveryOption,
            'promoCodeId' => session('promo_code_id') ?? null
        ]);

        // Token Midtrans (gunakan total yang sinkron)
        $snapToken = $this->createMidtransToken($order, $subtotal, $discountAmount, $deliveryFee, $totalAmount);

        // bersihkan session (sama seperti sebelumnya)
        session()->forget([
            'cart', 'promo_code', 'promo_code_id',
            'discount_amount', 'discount_type',
            'discount_value', 'delivery_option', 'checkout_summary'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pesanan berhasil dibuat!',
            'order_id' => $order->id,
            'snap_token' => $snapToken
        ]);
    }


    public function update(Request $request, $id)
    {
        $id = (int) $id;
        $cart = session()->get('cart', []);
        $newQty = max(1, (int) ($request->quantity ?? 1));

        if (isset($cart[$id])) {

            // FIX: selalu set product_id saat update
            $cart[$id]['product_id'] = $id;

            $cart[$id]['quantity'] = $newQty;
            $cart[$id]['subtotal'] = ($cart[$id]['unit_price'] ?? 0) * $newQty;

            session()->put('cart', $cart);
        }

        return response()->json([
            'success' => true,
            'item_quantity' => $cart[$id]['quantity'] ?? 0,
            'item_subtotal' => $cart[$id]['subtotal'] ?? 0,
            'cart_total' => array_sum(array_column($cart, 'subtotal')),
            'cart_count' => array_sum(array_column($cart, 'quantity'))
        ]);
    }

    public function removeItem($id)
    {
        $id = (int) $id;
        $cart = session('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session(['cart' => $cart]);
        }

        return response()->json([
            'success' => true,
            'cart_count' => array_sum(array_column($cart, 'quantity')),
            'cart_total' => array_sum(array_column($cart, 'subtotal'))
        ]);
    }

    private function calculateDeliveryFee($option, $subtotal)
    {
        if ($option === 'takeaway') return 0;
        if ($subtotal >= 35000) return 0;
        return 12000;
    }

    private function createMidtransToken($order, $subtotal, $discountAmount, $deliveryFee, $totalAmount)
    {
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $itemDetails = [];

        // ADD CART ITEMS
        foreach ($order->items as $item) {
            $itemDetails[] = [
                'id' => $item->product_id,
                'price' => (int) round($item->unit_price),
                'quantity' => (int) $item->quantity,
                'name' => $item->product_name ?: 'Product ' . $item->product_id,
            ];
        }

        // ADD DISKON (jika ada) -> gunakan nama & price positif/negatif sesuai Midtrans
        if ($discountAmount > 0) {
            // Midtrans menerima negative price for discount, tapi safer: kirim diskon sebagai item negatif
            $itemDetails[] = [
                'id' => 'DISKON',
                'price' => -(int) round($discountAmount),
                'quantity' => 1,
                'name' => 'Diskon Promo',
            ];
        }

        // ADD ONGKIR
        if ($deliveryFee > 0) {
            $itemDetails[] = [
                'id' => 'ONGKIR',
                'price' => (int) round($deliveryFee),
                'quantity' => 1,
                'name' => 'Biaya Pengiriman',
            ];
        }

        // HITUNG TOTAL dari item_details (WAJIB SAMA DENGAN gross_amount)
        $totalFromItems = array_sum(array_map(function ($it) {
            return $it['price'] * $it['quantity'];
        }, $itemDetails));

        // Jika totalFromItems tidak sama dengan $totalAmount, pilih $totalFromItems sebagai sumber kebenaran
        // (tapi log jelas agar dapat trace). Midtrans butuh kedua jumlah sinkron.
        if ((int) round($totalFromItems) !== (int) round($totalAmount)) {
            \Log::warning('Midtrans total mismatch: items_sum != provided_total', [
                'totalFromItems' => $totalFromItems,
                'providedTotal' => $totalAmount
            ]);
            // gunakan totalFromItems dan juga update order agar sinkron
            $order->update(['total_amount' => (int) round($totalFromItems)]);
            $grossAmount = (int) round($totalFromItems);
        } else {
            $grossAmount = (int) round($totalAmount);
            // juga update order supaya sama
            $order->update(['total_amount' => $grossAmount]);
        }

        $params = [
            'transaction_details' => [
                'order_id' => $order->id . '-' . time(),
                'gross_amount' => $grossAmount,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'phone' => Auth::user()->phone ?? '',
            ],
            'item_details' => $itemDetails,
        ];

        \Log::info('Midtrans item_details', $itemDetails);
        \Log::info('Midtrans gross_amount: ' . $grossAmount);

        try {
            return \Midtrans\Snap::getSnapToken($params);
        } catch (\Exception $e) {
            \Log::error('Midtrans Error: ' . $e->getMessage());
            return null;
        }
    }


}
