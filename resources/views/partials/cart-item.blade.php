@if ($cartCount > 0)
    @foreach ($cart as $id => $item)
        <div class="flex justify-between items-center border-b py-2" data-id="{{ $id }}">
            <div>
                <p class="font-semibold">{{ $item['name'] }}</p>
                <button data-id="{{ $id }}" class="btn-decrease px-2 py-1 bg-gray-200 rounded-full hover:bg-gray-300">-</button>
                <span id="qty-{{ $id }}">{{ $item['quantity'] }}</span>
                <button data-id="{{ $id }}" class="btn-increase px-2 py-1 bg-gray-200 rounded-full hover:bg-gray-300">+</button>
                <button data-id="{{ $id }}" class="btn-remove px-2 py-1 bg-red-500 text-white rounded-full hover:bg-red-600 ml-2">Hapus</button>
            </div>
            <div id="subtotal-{{ $id }}" class="font-medium">
                Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
            </div>
        </div>

    @endforeach
@else
    <p class="text-center text-gray-500">Keranjang kosong.</p>
@endif
