@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-10">
    <h2 class="text-2xl font-semibold mb-4">Detail Pesanan #{{ $order->id }}</h2>

    <div class="bg-white p-5 rounded-lg shadow">
        <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
        <p><strong>Total:</strong> Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>

        @if($order->shipping_address)
            <p><strong>Alamat:</strong> {{ $order->shipping_address }}</p>
        @endif

        <h3 class="font-semibold mb-2 mt-4">Daftar Item:</h3>

        <ul class="list-disc ml-5">
            @foreach($order->items as $item)
                <li>
                    {{ $item->product_name }} ({{ $item->quantity }}x) — 
                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                </li>
            @endforeach

            {{-- Tambahkan diskon jika ada --}}
            @if($order->discount_amount > 0)
                <li>
                    <strong>Diskon Promo</strong> — 
                    -Rp {{ number_format($order->discount_amount, 0, ',', '.') }}
                </li>
            @endif

            {{-- Tambahkan ongkir jika ada --}}
            @if($order->delivery_fee > 0)
                <li>
                    <strong>Biaya Pengiriman</strong> — 
                    Rp {{ number_format($order->delivery_fee, 0, ',', '.') }}
                </li>
            @endif
        </ul>
    </div>
</div>
@endsection
