<div>
    <!-- Overlay -->
    <div 
        @class([
            'fixed inset-0 bg-black bg-opacity-50 z-[9998] transition-opacity duration-300 lg:hidden',
            'opacity-0 pointer-events-none' => !$isOpen,
            'opacity-100' => $isOpen
        ])
        wire:click.self="close"
    ></div>

    <!-- Sidebar Cart -->
    <div 
        @class([
            'fixed top-0 right-0 h-full w-80 bg-white dark:bg-gray-800 shadow-2xl z-[9999] transition-transform duration-300 flex flex-col',
            'translate-x-full' => !$isOpen,
            'translate-x-0' => $isOpen
        ])
    >
        <!-- HEADER -->
        <div class="flex justify-between items-center p-4 border-b">
            <h2 class="text-lg font-bold text-gray-900">Keranjang</h2>
            <button wire:click="close" class="text-gray-500 hover:text-gray-700 p-2">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- CART ITEMS -->
        <div class="flex-1 overflow-y-auto p-4">
            @forelse($cart as $id => $item)
                <div class="flex justify-between items-start border-b pb-3 mb-3">
                    <div class="flex-1">
                        <p class="font-semibold text-sm text-gray-900">
                            {{ $item['name'] ?? 'Produk' }}
                        </p>
                        <p class="text-xs text-gray-500 mt-1">
                            Rp {{ number_format($item['unit_price'] ?? 0, 0, ',', '.') }}
                        </p>
                    </div>

                    <!-- Quantity + Remove -->
                    <div class="text-right ml-2">
                        <p class="font-semibold text-sm mb-2 text-orange-500">
                            Rp {{ number_format(($item['unit_price'] ?? 0) * ($item['quantity'] ?? 0), 0, ',', '.') }}
                        </p>

                        <div class="flex gap-1 items-center">
                            <button 
                                wire:click="decrease('{{ $id }}')"
                                wire:loading.attr="disabled"
                                class="w-6 h-6 bg-gray-200 hover:bg-gray-300 rounded text-xs flex items-center justify-center"
                            >-</button>

                            <span class="px-2 text-sm font-medium">
                                {{ $item['quantity'] ?? 0 }}
                            </span>

                            <button 
                                wire:click="increase('{{ $id }}')"
                                wire:loading.attr="disabled"
                                class="w-6 h-6 bg-gray-200 hover:bg-gray-300 rounded text-xs flex items-center justify-center"
                            >+</button>

                            <button 
                                wire:click="remove('{{ $id }}')"
                                wire:loading.attr="disabled"
                                class="w-6 h-6 bg-red-500 hover:bg-red-600 text-white rounded text-xs flex items-center justify-center ml-1"
                            >
                                <i class="fas fa-trash text-xs"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-8">
                    <i class="fas fa-shopping-cart text-gray-300 text-4xl mb-2"></i>
                    <p class="text-gray-500 text-sm">Keranjang kosong</p>
                </div>
            @endforelse
        </div>

        <!-- FOOTER -->
        @if(count($cart) > 0)
            <div class="p-4 border-t">

                <!-- PROMO CODE -->
                <div class="mb-4">
                    <p class="text-sm font-medium text-gray-700 mb-2">Kode Promo:</p>

                    @if($cartSummary['promo_code'])
                        <div class="flex justify-between items-center p-3 bg-green-50 rounded-lg">
                            <div>
                                <p class="text-sm font-medium text-green-800">
                                    Kode Promo: {{ $cartSummary['promo_code'] }}
                                </p>
                                <p class="text-xs text-green-600">
                                    Diskon: Rp {{ number_format($cartSummary['discount'], 0, ',', '.') }}
                                </p>
                            </div>

                            <button wire:click="removePromoCode" class="text-red-500 hover:text-red-700">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    @else
                        <div class="flex space-x-2">
                            <input 
                                type="text"
                                wire:model="promoCodeInput"
                                wire:keydown.enter="applyPromoCode"
                                placeholder="Masukkan kode promo"
                                class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm"
                            >

                            <button 
                                wire:click="applyPromoCode"
                                class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg text-sm"
                            >
                                Apply
                            </button>
                        </div>
                    @endif
                </div>

                @if($deliveryOption === 'delivery')
                <div class="mb-4">
                    <p class="text-sm font-medium text-gray-700 mb-1">📍 Lokasi Anda:</p>

                    @if(session('user_address'))
                        <div id="user-address" class="p-3 bg-blue-50 rounded-lg text-xs text-gray-700">
                            {{ session('user_address') }}
                        </div>
                    @else
                        <div id="user-address" class="hidden p-3 bg-blue-50 rounded-lg text-xs text-gray-700"></div>

                        <button
                            onclick="getLocationHero()"
                            class="text-xs text-blue-600 underline mt-1"
                        >
                            Ambil Lokasi
                        </button>
                    @endif
                </div>
                @endif

                <!-- DELIVERY OPTION -->
                <div class="mb-4">
                    <p class="text-sm font-medium text-gray-700 mb-2">Pilihan Pengiriman:</p>

                    <div class="space-y-2">
                        <label class="flex items-center">
                            <input 
                                type="radio"
                                name="delivery"
                                value="takeaway"
                                wire:model="deliveryOption"
                                wire:change="updateDeliveryOption"
                                class="mr-2"
                            >
                            <span class="text-sm">Ambil di Toko (Gratis)</span>
                        </label>

                        <label class="flex items-center">
                            <input 
                                type="radio"
                                name="delivery"
                                value="delivery"
                                wire:model="deliveryOption"
                                wire:change="updateDeliveryOption"
                                class="mr-2"
                            >
                            <span class="text-sm">Kirim ke Rumah</span>
                        </label>
                    </div>

                    <div class="mt-2 text-sm">
                        @if($deliveryOption === 'takeaway')
                            <p class="text-green-600">✓ Ambil di toko - Gratis</p>
                        @else
                            @if($cartSummary['delivery_fee'] === 0)
                                <p class="text-green-600">✓ Gratis ongkir</p>
                            @else
                                <p class="text-orange-600">
                                    Ongkir: Rp {{ number_format($cartSummary['delivery_fee'], 0, ',', '.') }}
                                </p>
                            @endif
                        @endif
                    </div>
                </div>
                <!-- ORDER NOTE -->
                <div class="mb-4">
                    <p class="text-sm font-medium text-gray-700 mb-1">Catatan Pesanan:</p>

                    <textarea
                        wire:model="note"
                        rows="2"
                        placeholder="Contoh: tanpa cabe / sambal banyak / pisah ya"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"
                    ></textarea>
                </div>


                <!-- SUMMARY -->
                <div class="border-t border-gray-200 pt-4 space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Sub Total:</span>
                        <span class="font-medium">
                            Rp {{ number_format($cartSummary['subtotal'], 0, ',', '.') }}
                        </span>
                    </div>

                    @if($cartSummary['discount'] > 0)
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Discount:</span>
                        <span class="font-medium text-green-600">
                            -Rp {{ number_format($cartSummary['discount'], 0, ',', '.') }}
                        </span>
                    </div>
                    @endif

                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Delivery Fee:</span>
                        <span class="font-medium">
                            Rp {{ number_format($cartSummary['delivery_fee'], 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="flex justify-between text-lg font-bold mt-2 pt-2 border-t">
                        <span>Total:</span>
                        <span class="text-orange-500">
                            Rp {{ number_format($cartSummary['total'], 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                <!-- ACTION BUTTONS -->
                <div class="space-y-2 mt-4">
                    <button 
                        wire:click="close"
                        class="w-full bg-gray-200 hover:bg-gray-300 text-gray-700 py-3 rounded-lg font-medium transition-colors"
                    >
                        Tutup
                    </button>

                    <button 
                        wire:click="goToCart"
                        class="block w-full bg-orange-500 hover:bg-orange-600 text-white text-center py-3 rounded-lg font-medium transition-colors"
                    >
                        Pesan Sekarang
                    </button>

                </div>
            </div>
        @endif
    </div>
</div>
