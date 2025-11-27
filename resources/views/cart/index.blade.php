@extends('layouts.app')

@section('content')



<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Keranjang Anda</h1>

    @if (empty($cart))
        <p>Keranjang kosong.</p>
    @else
        <div class="bg-white rounded-lg shadow p-6">

            {{-- LIST ITEM --}}
            @foreach ($cart as $item)
                <div class="flex justify-between items-center border-b py-2">
                    <div>
                        <p class="font-semibold">{{ $item['name'] }}</p>
                        <p class="text-sm text-gray-500">Qty: {{ $item['quantity'] }}</p>
                    </div>

                    <div>
                        Rp {{ number_format(($item['unit_price'] ?? 0) * $item['quantity'], 0, ',', '.') }}
                    </div>
                </div>
            @endforeach

            {{-- TOTAL KERANJANG --}}
            @php 
                $total = array_sum(array_map(
                    fn($i) => ($i['unit_price'] ?? 0) * $i['quantity'], 
                    $cart
                ));
            @endphp

            <div class="flex justify-between items-center mt-4 font-bold">
                <span>Total:</span>
                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>

            {{-- DETAIL PESANAN (SUMMARY) --}}
            @if (!empty($summary))
            <div class="mt-6 bg-gray-50 p-4 rounded-lg shadow">

                <h2 class="font-semibold text-lg mb-3">Detail Pesanan</h2>

                {{-- ALAMAT PENGGUNA (FLASH) --}}
                @if (session('user_address'))
                    <div class="bg-blue-50 p-3 rounded text-sm mb-4">
                        <strong>Alamat Pengiriman:</strong><br>
                        {{ session('user_address') }}
                    </div>
                @endif

                {{-- METODE PENGIRIMAN --}}
                <div class="mb-2">
                    <p class="text-sm text-gray-600">Metode Pengiriman:</p>
                    <p class="font-medium text-gray-900">
                        {{ $summary['delivery_option'] === 'delivery' ? 'Diantar ke Rumah' : 'Ambil di Toko' }}
                    </p>
                </div>

                {{-- ONGKIR --}}
                @php
                    $delivery_fee = $summary['delivery_fee'] ?? session('checkout_summary.delivery_fee');
                @endphp

                @if ($delivery_fee)
                    <div class="mb-2 flex justify-between">
                        <span class="text-sm text-gray-600">Biaya Pengiriman:</span>
                        <span class="font-medium">
                            Rp {{ number_format($delivery_fee, 0, ',', '.') }}
                        </span>
                    </div>
                @endif

                {{-- DISKON --}}
                @if (($summary['discount'] ?? 0) > 0)
                <div class="mb-2 flex justify-between">
                    <span class="text-sm text-gray-600">Diskon ({{ $summary['promo_code'] }}):</span>
                    <span class="font-medium text-green-600">
                        -Rp {{ number_format($summary['discount'], 0, ',', '.') }}
                    </span>
                </div>
                @endif

                {{-- SUBTOTAL --}}
                <div class="mb-2 flex justify-between">
                    <span class="text-sm text-gray-600">Subtotal:</span>
                    <span class="font-medium">
                        Rp {{ number_format($summary['subtotal'], 0, ',', '.') }}
                    </span>
                </div>
                {{-- NOTE / CATATAN PESANAN --}}
                @if (!empty($summary['note']))
                <div class="mb-2">
                    <p class="text-sm text-gray-600">Catatan Pesanan:</p>
                    <p class="font-medium text-gray-800 whitespace-pre-line break-words">
                        {{ $summary['note'] }}
                    </p>
                </div>
                @endif


                {{-- TOTAL BAYAR --}}
                <div class="mt-3 pt-3 border-t flex justify-between font-bold text-orange-600">
                    <span>Total Bayar:</span>
                    <span>
                        Rp {{ number_format($summary['total'], 0, ',', '.') }}
                    </span>
                </div>
            </div>
            @endif

            {{-- TOMBOL CHECKOUT --}}
            <form id="checkout-form" class="mt-6">
                @csrf
                <button type="button" id="pay-button"
                    class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-full">
                    Proses Pesanan
                </button>
            </form>

        </div>
    @endif
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

<script>
let checkoutSummary = @json($summary ?? []);

document.getElementById('pay-button').addEventListener('click', function (e) {
    e.preventDefault();

    fetch('{{ route('cart.checkout') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            delivery_option: checkoutSummary.delivery_option,
            discount_amount: checkoutSummary.discount ?? 0,
            promo_code_id: checkoutSummary.promo_code_id ?? null
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.snap_token) {
            snap.pay(data.snap_token, {
                onSuccess: function(result){ window.location.href = "{{ route('orders.riwayat') }}"; },
                onPending: function(result){ window.location.href = "{{ route('orders.riwayat') }}"; },
                onError: function(){ alert('Terjadi kesalahan saat pembayaran.'); },
                onClose: function(){ alert('Kamu menutup popup pembayaran.'); }
            });
        } else {
            alert('Gagal mendapatkan Snap token!');
        }
    })
    .catch(err => console.error('Fetch error:', err));
});
</script>

@endsection
