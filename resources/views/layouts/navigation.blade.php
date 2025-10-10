<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minikiyo Wonton - Feast Your Senses, Fast and Fresh</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .hero-bg {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 50%, #92400e 100%);
        }
        .floating-animation {
            animation: float 3s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        .gradient-text {
            background: linear-gradient(45deg, #f59e0b, #d97706);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .notification-popup {
            animation: slideInRight 0.5s ease-out;
        }
        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        #toast {
            position: fixed !important;
            top: 80px; /* bisa ubah sesuai tinggi navbar */
            right: 20px;
            z-index: 999999 !important; /* paling tinggi */
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-orange-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-bowl-rice text-white text-lg"></i>
                    </div>
                    <h1 class="text-xl font-bold text-gray-900">Minikiyo Wonton</h1>
                </div>

                <!-- Alamat -->
                <div class="hidden md:flex items-center space-x-2 text-sm text-gray-600">
                    <i class="fas fa-map-marker-alt text-orange-500"></i>
                    <span>Tambakrejo, Gurah</span>
                </div>

                <!-- Navigasi -->
                <nav class="hidden lg:flex items-center space-x-6">
                    <a href="{{ route('beranda') }}" class="{{ request()->routeIs('beranda') ? 'bg-orange-500 text-white px-4 py-2 rounded-full text-sm font-medium' : 'text-gray-700 hover:text-orange-500 text-sm font-medium' }}">Beranda</a>
                    <a href="{{ route('menu') }}" class="{{ request()->routeIs('menu') ? 'bg-orange-500 text-white px-4 py-2 rounded-full text-sm font-medium' : 'text-gray-700 hover:text-orange-500 text-sm font-medium' }}">Menu</a>
                    <a href="{{ route('order') }}" class="{{ request()->routeIs('order') ? 'bg-orange-500 text-white px-4 py-2 rounded-full text-sm font-medium' : 'text-gray-700 hover:text-orange-500 text-sm font-medium' }}">Order</a>
                    <a href="{{ route('kontak') }}" class="{{ request()->routeIs('kontak') ? 'bg-orange-500 text-white px-4 py-2 rounded-full text-sm font-medium' : 'text-gray-700 hover:text-orange-500 text-sm font-medium' }}">Kontak</a>
                    <a href="{{ route('lokasi') }}" class="{{ request()->routeIs('lokasi') ? 'bg-orange-500 text-white px-4 py-2 rounded-full text-sm font-medium' : 'text-gray-700 hover:text-orange-500 text-sm font-medium' }}">Lokasi Pesanan</a>
                </nav>

                <!-- Keranjang & Login -->
                @php
                    $cart = session('cart', []);
                    $cartCount = array_sum(array_column($cart, 'quantity'));
                    $cartTotal = array_sum(array_column($cart, 'subtotal'));
                @endphp

                <div class="flex items-center space-x-3">
                    <!-- Icon Cart -->
                    <div class="relative cursor-pointer" onclick="showCartModal()">
                        <i class="fas fa-shopping-cart text-gray-600 text-lg"></i>
                        @if ($cartCount > 0)
                            <span id="cart-count" class="absolute -top-2 -right-2 bg-orange-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </div>

                    <!-- Total -->
                    <span id="cart-total" class="text-sm font-medium text-gray-700">
                        Rp {{ number_format($cartTotal, 0, ',', '.') }}
                    </span>

                    <!-- Login -->
                    <!-- Login / User -->
                    @auth
                        <div class="flex items-center space-x-3">
                            <span class="text-sm font-medium text-gray-700">
                                👋 {{ Auth::user()->name }}
                            </span>

                            <!-- Tombol Logout -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-3 py-2 rounded-full text-sm font-medium">
                                    Logout
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-full text-sm font-medium">
                            Login / Daftar
                        </a>
                    @endauth

                </div>
            </div>
        </div>
    </header>

    <!-- Modal Keranjang -->
    <div id="cart-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
        <div class="bg-white rounded-2xl shadow-lg w-11/12 max-w-md p-6">
            <h2 class="text-xl font-bold mb-4">Keranjang Belanja</h2>
            <div id="cart-items" class="space-y-3 max-h-64 overflow-y-auto">
                @if ($cartCount > 0)
                    @foreach ($cart as $item)
                        <div class="flex justify-between items-center border-b py-2">
                            <div>
                                <p class="font-semibold">{{ $item['name'] }}</p>
                                <p class="text-sm text-gray-500">Qty: {{ $item['quantity'] }}</p>
                            </div>
                            <div>Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</div>
                        </div>
                    @endforeach
                @else
                    <p class="text-center text-gray-500">Keranjang kosong.</p>
                @endif
            </div>

            <div class="mt-4 flex justify-between items-center border-t pt-3">
                <span class="font-semibold">Total:</span>
                <span id="cart-modal-total" class="text-lg font-bold text-orange-500">
                    Rp {{ number_format($cartTotal, 0, ',', '.') }}
                </span>
            </div>

            <div class="mt-6 flex justify-between">
                <button onclick="hideCartModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-full">
                    Tutup
                </button>
                <a href="{{ route('cart.index') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-full">
                    Lanjut ke Checkout
                </a>
            </div>
        </div>
    </div>

    <!-- Konten -->
    <main>
        @unless (request()->routeIs('cart.index'))
            @yield('content')
        @endunless
    </main>

    <!-- Script Modal -->
    <script>
        function showCartModal() {
            document.getElementById('cart-modal').classList.remove('hidden');
            document.getElementById('cart-modal').classList.add('flex');
        }
        function hideCartModal() {
            document.getElementById('cart-modal').classList.add('hidden');
            document.getElementById('cart-modal').classList.remove('flex');
        }
    </script>
</body>
</html>
