<div>
    {{-- Search --}}
    <input 
        type="text" 
        wire:model.live.debounce.300ms="search"

        placeholder="Cari menu..."
        class="border p-2 rounded w-full"
    />

    {{-- Category Buttons --}}
    <div class="flex gap-2 mt-4 overflow-x-auto">
        <button wire:click="setCategory('all')" 
            class="@if($category=='all') bg-orange-500 text-white @else bg-gray-200 @endif px-4 py-2 rounded-full">
            Semua
        </button>

        @foreach($menuData as $cat => $items)
            <button wire:click="setCategory('{{ $cat }}')" 
                class="@if($category==$cat) bg-orange-500 text-white @else bg-gray-200 @endif px-4 py-2 rounded-full">
                {{ ucfirst($cat) }}
            </button>
        @endforeach
    </div>

    {{-- Menu Items --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
        @foreach($menus as $cat => $items)
            @foreach($items as $item)
                <div class="border p-4 rounded-xl shadow">

                    <img 
                        src="{{ $item['image'] }}" 
                        class="w-full h-64 object-cover rounded-lg mb-3"
                    />


                    <h3 class="font-bold">{{ $item['name'] }}</h3>

                    @if($item['is_active'] == 0)
                        <span class="text-red-600 font-bold">SOLD OUT</span>
                    @endif

                    <div class="mt-3 flex justify-between items-center">
                        <span class="text-orange-500 font-bold">
                            Rp {{ number_format($item['price'],0,',','.') }}
                        </span>

                        @if($item['is_active'])
                            <button 
                                wire:click="$dispatch('add-to-cart', { id: {{ $item['id'] }} });
                                            $dispatch('showCartSidebar')"

                                class="bg-orange-500 text-white px-4 py-2 rounded-full">
                                Tambah
                            </button>

                        @else
                            <button 
                                class="bg-gray-400 text-white px-4 py-2 rounded-full cursor-not-allowed">
                                Tidak tersedia
                            </button>
                        @endif
                    </div>

                </div>
            @endforeach
        @endforeach
    </div>
</div>

