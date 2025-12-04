<header class="bg-white shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            
            {{-- Logo --}}
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-orange-500 rounded-full flex items-center justify-center">
                    <i class="fas fa-bowl-rice text-white text-lg"></i>
                </div>
                <h1 class="text-xl font-bold text-gray-900">Minikiyo Wonton</h1>
            </div>

            {{-- Menu --}}
            <nav class="hidden lg:flex items-center space-x-6">
                <x-nav-link href="{{ route('beranda') }}" :active="request()->routeIs('beranda')">Beranda</x-nav-link>
                <x-nav-link href="{{ route('menu') }}" :active="request()->routeIs('menu')">Menu</x-nav-link>
                <!-- <x-nav-link href="{{ route('order') }}" :active="request()->routeIs('order')">Order</x-nav-link> -->
                <x-nav-link href="{{ route('orders.riwayat') }}" :active="request()->routeIs('orders.riwayat')">Pesanan</x-nav-link>
                <x-nav-link href="{{ route('kontak') }}" :active="request()->routeIs('kontak')">Kontak</x-nav-link>
                <x-nav-link href="{{ route('lokasi') }}" :active="request()->routeIs('lokasi')">Lokasi</x-nav-link>
            </nav>

            {{-- Cart Button --}}
            <div class="flex items-center space-x-3">
                <button 
                    type="button"
                    class="relative cursor-pointer"
                    onclick="Livewire.dispatch('showCartSidebar')"
                >
                    <i class="fas fa-shopping-cart text-gray-600 text-lg"></i>

                    @php $cartCount = array_sum(array_column(session('cart', []), 'quantity')); @endphp
                    
                    <span 
                        id="cart-badge"
                        class="absolute -top-2 -right-2 bg-orange-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center {{ $cartCount > 0 ? '' : 'hidden' }}"
                    >
                        {{ $cartCount }}
                    </span>
                </button>

                @auth
                    <span class="text-sm">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="bg-gray-200 px-3 py-2 rounded-full text-sm hover:bg-gray-300">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="bg-orange-500 text-white px-4 py-2 rounded-full text-sm hover:bg-orange-600">
                        Login
                    </a>
                @endauth
            </div>
        </div>
    </div>


</header>

<script>
    // Listen untuk update badge dari Livewire
    if (typeof Livewire !== 'undefined') {
        Livewire.on('updateCartBadge', (event) => {
            const badge = document.getElementById('cart-badge');
            if (badge && event.count !== undefined) {
                badge.textContent = event.count;
                badge.classList.toggle('hidden', event.count === 0);
            }
        });
    }
</script>