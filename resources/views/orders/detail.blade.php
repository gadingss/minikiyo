@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-10">
    <h2 class="text-2xl font-semibold mb-4">Detail Pesanan #{{ $order->id }}</h2>

    <div class="bg-white p-5 rounded-lg shadow">
        <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
        <p><strong>Total:</strong> Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
        <p><strong>Alamat:</strong> {{ $order->shipping_address }}</p>
        <hr class="my-3">

        <h3 class="font-semibold mb-2">Daftar Item:</h3>
        <ul class="list-disc ml-5">
            @foreach($order->items as $item)
                <li>{{ $item->product->name }} ({{ $item->quantity }}x) — Rp {{ number_format($item->subtotal, 0, ',', '.') }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
