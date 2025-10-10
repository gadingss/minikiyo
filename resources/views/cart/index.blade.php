@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Keranjang Anda</h1>

    @if (empty($cart))
        <p>Keranjang kosong.</p>
    @else
        <div class="bg-white rounded-lg shadow p-6">
            @foreach ($cart as $item)
                <div class="flex justify-between items-center border-b py-2">
                    <div>
                        <p class="font-semibold">{{ $item['name'] }}</p>
                        <p class="text-sm text-gray-500">Qty: {{ $item['quantity'] }}</p>
                    </div>
                    <div>
                        Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                    </div>
                </div>
            @endforeach

            <div class="flex justify-between items-center mt-4 font-bold">
                <span>Total:</span>
                <span>Rp {{ number_format(array_sum(array_column($cart, 'subtotal')), 0, ',', '.') }}</span>
            </div>

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
document.getElementById('pay-button').addEventListener('click', function (e) {
    e.preventDefault();

    fetch('{{ route('cart.checkout') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({})
    })
    .then(res => res.json())
    .then(data => {
        if (data.snap_token) {
            snap.pay(data.snap_token, {
                onSuccess: function(result){ console.log(result); },
                onPending: function(result){ console.log(result); },
                onError: function(result){ console.log(result); },
                onClose: function(){ alert('Kamu menutup pembayaran.'); }
            });
        } else {
            alert('Gagal mendapatkan Snap token!');
            console.error(data);
        }
    })
    .catch(err => console.error('Fetch error:', err));
});
</script>
@endsection
