<!-- {{ auth()->id() }}
<pre>{{ print_r($orders->toArray(), true) }}</pre> -->

@extends('layouts.app')

@section('content')
<section class="py-10 bg-gray-50 min-h-screen">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-6 flex items-center gap-2">
            <i class="fas fa-clock text-orange-500"></i> Riwayat Transaksi Saya
        </h1>

        @if(empty($orders))

            <div class="text-center bg-white p-10 rounded-xl shadow-sm">
                <i class="fas fa-box-open text-4xl text-gray-400 mb-4"></i>
                <p class="text-gray-500">Kamu belum memiliki transaksi.</p>
                <a href="{{ route('menu') }}" class="mt-4 inline-block bg-orange-500 text-white px-6 py-2 rounded-lg hover:bg-orange-600">
                    Pesan Sekarang
                </a>
            </div>
        @else
            <div class="mb-4 flex gap-2">
                <a href="{{ route('orders.riwayat') }}"
                class="px-3 py-1 rounded {{ $status ? 'bg-gray-200' : 'bg-blue-500 text-white' }}">
                Semua
                </a>

                <a href="{{ route('orders.riwayat', ['status' => 'pending']) }}"
                class="px-3 py-1 rounded {{ $status == 'pending' ? 'bg-blue-500 text-white' : 'bg-gray-200' }}">
                Pending
                </a>

                <a href="{{ route('orders.riwayat', ['status' => 'completed']) }}"
                class="px-3 py-1 rounded {{ $status == 'completed' ? 'bg-blue-500 text-white' : 'bg-gray-200' }}">
                Selesai
                </a>

                <a href="{{ route('orders.riwayat', ['status' => 'dibatalkan']) }}"
                class="px-3 py-1 rounded {{ $status == 'dibatalkan' ? 'bg-blue-500 text-white' : 'bg-gray-200' }}">
                Dibatalkan
                </a>
            </div>

            <div class="space-y-4">
                @foreach($orders as $order)
                    <div x-data="{ open: false }" class="bg-white rounded-xl shadow-sm p-6 flex flex-col md:flex-row justify-between items-start md:items-center">
                        <div>
                            <h2 class="font-semibold text-lg text-gray-900">Pesanan #{{ $order->id }}</h2>
                            <p class="text-gray-600 text-sm mt-1">
                                Tanggal: {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y, H:i') }}
                            </p>
                            <p class="text-gray-600 text-sm">
                                Total: <span class="font-bold text-orange-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                            </p>
                            <p class="text-gray-600 text-sm">
                                Status:
                                @php
                                $bgColor = match($order->status) {
                                    'pending' => 'bg-yellow-100 text-yellow-700',
                                    'diproses' => 'bg-blue-100 text-blue-700',
                                    'selesai' => 'bg-green-100 text-green-700',
                                    'dibatalkan' => 'bg-red-100 text-red-700',
                                    default => 'bg-gray-100 text-gray-700',
                                };
                                @endphp

                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $bgColor }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </p>
                        </div>

                        <div class="mt-4 md:mt-0 flex flex-wrap gap-3">
                            <button @click="open = true"
                                class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition">
                                <i class="fas fa-eye mr-2"></i>Detail
                            </button>

                            @if($order->status === 'pending')
                                <a href="{{ route('orders.cancel', $order->id) }}" 
                                class="bg-red-100 text-red-600 px-4 py-2 rounded-lg hover:bg-red-200 transition">
                                    <i class="fas fa-times mr-2"></i>Batalkan
                                </a>
                            @endif
                        </div>

                        <!-- MODAL POPUP -->
                        <div x-show="open" 
                            class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50"
                            x-transition>
                            <div class="bg-white w-full max-w-md p-6 rounded-xl shadow-lg relative">

                                <!-- Tombol close -->
                                <button class="absolute top-2 right-3 text-gray-500 hover:text-gray-700"
                                        @click="open = false">&times;</button>

                                <h3 class="text-xl font-semibold mb-4">Detail Pesanan #{{ $order->id }}</h3>

                                <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
                                <p><strong>Total:</strong> Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>

                                @if($order->shipping_address)
                                    <p class="mt-1"><strong>Alamat:</strong> {{ $order->shipping_address }}</p>
                                @endif

                                <h4 class="font-semibold mt-4 mb-2">Daftar Item:</h4>
                                <ul class="list-disc ml-5 text-sm">
                                    @foreach($order->items as $item)
                                        <li>
                                            {{ $item->product_name }} ({{ $item->quantity }}x) — 
                                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                        </li>
                                    @endforeach
                                
                                    @if($order->discount_amount > 0)
                                        <li><strong>Diskon:</strong> -Rp {{ number_format($order->discount_amount, 0, ',', '.') }}</li>
                                    @endif

                                    @if($order->delivery_fee > 0)
                                        <li><strong>Ongkir:</strong> Rp {{ number_format($order->delivery_fee, 0, ',', '.') }}</li>
                                    @endif
                                </ul>

                            </div>
                        </div>
                        <!-- END MODAL -->
                    </div>
                @endforeach

            </div>
        @endif
    </div>
</section>
@endsection
