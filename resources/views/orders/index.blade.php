@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-10 px-4">
    <h2 class="text-2xl font-bold mb-6">Riwayat Pesanan</h2>

    @forelse ($orders as $order)
        <div class="border rounded-lg p-4 mb-4 bg-white shadow-sm">
            <h3 class="font-semibold text-gray-800">Pesanan #{{ $order->id }}</h3>
            <p class="text-sm text-gray-600">Status: {{ ucfirst($order->status) }}</p>
            <p class="font-bold text-orange-600 mt-2">
                Total: Rp {{ number_format($order->total, 0, ',', '.') }}
            </p>
            <ul class="mt-2 text-sm text-gray-700">
                @foreach ($order->items as $item)
                    <li>• {{ $item->product->name }} ({{ $item->quantity }}x)</li>
                @endforeach
            </ul>
        </div>
    @empty
        <p class="text-gray-500">Belum ada pesanan.</p>
    @endforelse
</div>
@endsection
