<?php

namespace App\Livewire;

use Livewire\Component;

class MenuCartSidebar extends Component
{
    public $isOpen = false;
    public $cart = [];
    public $cartSummary = [
        'subtotal' => 0,
        'discount' => 0,
        'delivery_fee' => 0,
        'total' => 0,
        'promo_code' => null
    ];
    public $deliveryOption = 'takeaway';

    public $note = null;


    public $lat;
    public $lng;

    private $storeLat = -7.814729;
    private $storeLng = 112.108366;

    protected $listeners = [
        'showCartSidebar' => 'open',
        'cartUpdated' => 'updateCartData',
        'location-detected' => 'setLocation',
        'add-to-cart' => 'addToCart',


    ];

    public function addToCart($id)
    {
        // Jika item sudah ada
        if (isset($this->cart[$id])) {
            $this->cart[$id]['quantity']++;
        } else {

            $product = \App\Models\Product::find($id);
            if (!$product) return;

            $this->cart[$id] = [
                'id' => $product->id,
                'name' => $product->name,
                'unit_price' => $product->price,
                'quantity' => 1,
            ];
        }

        $this->saveCart();
        $this->syncToSession();

    }



    public function mount()
    {
        $this->deliveryOption = session()->get('delivery_option', 'takeaway');
        $this->note = session()->get('order_note');
        $this->loadCartData();
    }

    public function loadCartData()
    {
        $this->cart = session()->get('cart', []);
        $this->calculateSummary();
    }

    public function setLocation($data = [])
    {
        if (!is_array($data) || empty($data)) {
            return;
        }

        $this->lat = $data['lat'] ?? null;
        $this->lng = $data['lon'] ?? $data['lng'] ?? null;
        $address = $data['address'] ?? null;

        if (!$this->lat || !$this->lng) return;

        session()->put('user_lat', $this->lat);
        session()->put('user_lng', $this->lng);

        if ($address) session()->put('user_address', $address);

        session()->save();

        $this->calculateSummary();
        $this->syncToSession();

    }


    private function distanceInKm($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371;

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) ** 2 +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon / 2) ** 2;

        return 2 * $earthRadius * atan2(sqrt($a), sqrt(1 - $a));
    }

    public function updateDeliveryOption()
    {
        session()->put('delivery_option', $this->deliveryOption);
        session()->save();

        $this->calculateSummary();
        $this->syncToSession();

    }


    public function calculateSummary()
    {
        $subtotal = 0;

        foreach ($this->cart as $item) {
            $subtotal += ($item['unit_price'] ?? 0) * ($item['quantity'] ?? 0);
        }

        $deliveryFee = $this->calculateDeliveryFee();
        $discount = $this->calculateDiscount($subtotal);

        $this->cartSummary = [
            'subtotal' => $subtotal,
            'discount' => $discount,
            'delivery_fee' => $deliveryFee,
            'total' => $subtotal - $discount + $deliveryFee,
            'promo_code' => session()->get('promo_code')
        ];
    }

    private function syncToSession()
    {
        session()->put('order_note', $this->note);

        session()->put('checkout_summary', [
            'address' => session('user_address'),
            'delivery_option' => $this->deliveryOption,
            'delivery_fee' => $this->cartSummary['delivery_fee'],
            'discount' => $this->cartSummary['discount'],
            'promo_code' => $this->cartSummary['promo_code'],
            'subtotal' => $this->cartSummary['subtotal'],
            'total' => $this->cartSummary['total'],
            'note' => $this->note,
        ]);

        session()->save();
    }


    private function calculateDeliveryFee()
    {
        if ($this->deliveryOption === 'takeaway') return 0;

        if (!session()->has('user_lat')) return 10000;

        $distance = $this->distanceInKm(
            $this->storeLat,
            $this->storeLng,
            session('user_lat'),
            session('user_lng')
        );

        if ($distance <= 3) return 5000;
        if ($distance <= 6) return 10000;
        if ($distance <= 10) return 15000;

        return 999999;
    }

    private function calculateDiscount($subtotal)
    {
        $promo = session('promo_code');

        if (!$promo) return 0;

        $promoModel = \App\Models\PromoCode::where('code', $promo)
            ->where('is_active', true)
            ->first();

        if (!$promoModel) return 0;

        if ($promoModel->type === 'percentage') {
            return $subtotal * ($promoModel->value / 100);
        }

        if ($promoModel->type === 'fixed') {
            return min($subtotal, $promoModel->value); // jangan minus
        }

        return 0;
    }

    public $promoCodeInput = null;

    public function applyPromoCode()
    {
        $promo = $this->promoCodeInput ?: session('promo_code');


        if (!$promo) {
            session()->forget('promo_code');
            $this->calculateSummary();
            $this->syncToSession();
            return;
        }

        $promoModel = \App\Models\PromoCode::where('code', $promo)
            ->where('is_active', true)
            ->first();

        if (!$promoModel) {
            session()->forget('promo_code');
            $this->calculateSummary();
            $this->syncToSession();
            return;
        }

        session()->put('promo_code', $promoModel->code);
        session()->save();

        $this->calculateSummary();
        $this->syncToSession();
    }


    public function removePromoCode()
    {
        session()->forget('promo_code');
        session()->save();

        $this->calculateSummary();
        $this->syncToSession();
    }


    public function open()
    {
        $this->isOpen = true;
        $this->loadCartData();
    }

    public function close()
    {
        $this->isOpen = false;
    }

    public function increase($id)
    {
        if (isset($this->cart[$id])) {
            $this->cart[$id]['quantity']++;
            $this->saveCart();
            $this->syncToSession();

        }
    }

    public function decrease($id)
    {
        if (!isset($this->cart[$id])) return;

        if ($this->cart[$id]['quantity'] > 1) {
            $this->cart[$id]['quantity']--;
        } else {
            unset($this->cart[$id]);
        }

        $this->saveCart();
        $this->syncToSession();

    }

    public function remove($id)
    {
        unset($this->cart[$id]);
        $this->saveCart();
        $this->syncToSession();

    }

    private function saveCart()
    {
        session()->put('cart', $this->cart);
        session()->save();

        $this->calculateSummary();
        $this->dispatch('updateCartBadge', count: array_sum(array_column($this->cart, 'quantity')));
    }

    public function updateCartData()
    {
        $this->loadCartData();
    }
    public function updatedNote()
    {
        $this->syncToSession();
    }
    public function goToCart()
    {
        $this->syncToSession(); // pastikan Note tersimpan
        return redirect()->route('cart.index');
    }



    public function render()
    {
        return view('livewire.menu-cart-sidebar');
    }
}
