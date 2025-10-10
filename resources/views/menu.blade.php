<!-- <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - Minikiyo Wonton East Java</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .hero-bg {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.9) 0%, rgba(217, 119, 6, 0.9) 100%), 
                        url('data:image/svg+xml,%3Csvg width="100" height="100" xmlns="http://www.w3.org/2000/svg"%3E%3Cpath d="M0 0h100v100H0z" fill="%23f59e0b"/%3E%3C/svg%3E');
            background-size: cover;
            background-position: center;
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        .category-active {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
        }
        .category-inactive {
            background: rgba(245, 158, 11, 0.1);
            color: #d97706;
        }
        .rating-stars {
            color: #fbbf24;
        }
        .discount-badge {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        .floating-cart {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
        }
        .modal {
            display: none;
        }
        .modal.show {
            display: flex;
        }
        .fade-in {
            animation: fadeIn 0.3s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }
        .quantity-input {
            width: 60px;
        }
    </style>
</head>
<body class="bg-gray-50"> -->
@extends('layouts.navigation')
@section('content')
    <!-- Hero Section -->
    <section class="hero-bg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid lg:grid-cols-2 gap-8 items-center">
                <!-- Left Content -->
                <div class="text-white">
                    <p class="text-sm mb-2">Tim Santi Iri</p>
                    <h1 class="text-4xl lg:text-5xl font-bold mb-6">Minikiyo Wonton East Java</h1>
                    
                    <div class="flex items-center space-x-6 mb-6">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-clock"></i>
                            <span>Minimum Order 15.000</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-motorcycle"></i>
                            <span>Pengiriman Gratis (Min 35-150 Menit)</span>
                        </div>
                    </div>

                    <div class="bg-orange-600 text-white px-4 py-2 rounded-full inline-flex items-center space-x-2">
                        <i class="fas fa-percentage"></i>
                        <span>15% - Hemat hingga 15.000</span>
                    </div>
                </div>

                <!-- Right Content - Product Image with Rating -->
                <div class="relative">
                    <img src="{{ asset('images/dimsum_mentai.jpg') }}" alt="Dimsum Mentai" class="w-full h-48 object-cover">
                    
                    <!-- Rating Badge -->
                    <div class="absolute top-4 right-4 bg-white rounded-lg p-3 shadow-lg">
                        <div class="text-2xl font-bold text-gray-900">3.4</div>
                        <div class="flex rating-stars text-sm">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            <i class="far fa-star"></i>
                        </div>
                        <div class="text-xs text-gray-500">200+ rating</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

        <!-- Search & Category Tabs -->
    <section class="bg-white py-6 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <h2 class="text-2xl font-bold text-gray-900">
                    Semua Penawaran dari <span class="text-orange-500">Minikiyo Wonton</span>
                </h2>
                <div class="flex bg-gray-100 rounded-full p-1 w-full md:w-auto md:min-w-[300px]">
                    <input type="text" id="search-menu" placeholder="Cari menu..." class="flex-1 px-4 py-2 bg-transparent outline-none">
                    <button onclick="searchMenu()" class="bg-orange-500 hover:bg-orange-600 text-white p-2 rounded-full">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>

            <!-- Category Buttons (auto dari $menuData) -->
            <div class="flex space-x-2 mt-6 overflow-x-auto">
                <button onclick="filterCategory('all')" class="category-tab category-active px-6 py-3 rounded-full font-medium">Semua</button>
                @foreach($menuData as $category => $items)
                    <button onclick="filterCategory('{{ $category }}')" class="category-tab category-inactive px-6 py-3 rounded-full font-medium">
                        {{ ucfirst($category) }}
                    </button>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Promotional Banners -->
    <section class="py-8 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-6">
                <!-- First Order Discount -->
                <div class="relative bg-gradient-to-r from-purple-600 to-purple-800 rounded-2xl p-6 text-white overflow-hidden">
                    <div class="discount-badge absolute top-4 right-4 text-white px-3 py-1 rounded-full text-sm font-bold">-40%</div>
                    <h3 class="text-xl font-bold mb-2">First Order Discount</h3>
                    <p class="text-sm opacity-90">Dapatkan diskon hingga 40% untuk pesanan pertama</p>
                    <button class="mt-4 bg-white text-purple-600 px-4 py-2 rounded-lg font-medium">
                        <i class="fas fa-plus mr-2"></i>Claim
                    </button>
                </div>

                <!-- Vegan Discount -->
                <div class="relative bg-gradient-to-r from-green-500 to-green-700 rounded-2xl p-6 text-white overflow-hidden">
                    <div class="discount-badge absolute top-4 right-4 text-white px-3 py-1 rounded-full text-sm font-bold">-25%</div>
                    <h3 class="text-xl font-bold mb-2">Vegan Discount</h3>
                    <p class="text-sm opacity-90">Menu vegetarian dengan diskon spesial</p>
                    <button class="mt-4 bg-white text-green-600 px-4 py-2 rounded-lg font-medium">
                        <i class="fas fa-plus mr-2"></i>Claim
                    </button>
                </div>

                <!-- Free Ice Cream -->
                <div class="relative bg-gradient-to-r from-blue-500 to-blue-700 rounded-2xl p-6 text-white overflow-hidden">
                    <div class="discount-badge absolute top-4 right-4 text-white px-3 py-1 rounded-full text-sm font-bold">200%</div>
                    <h3 class="text-xl font-bold mb-2">Free Ice Cream Offer</h3>
                    <p class="text-sm opacity-90">Es krim gratis untuk setiap pembelian</p>
                    <button class="mt-4 bg-white text-blue-600 px-4 py-2 rounded-lg font-medium">
                        <i class="fas fa-plus mr-2"></i>Claim
                    </button>
                </div>
            </div>
        </div>
    </section>

        <!-- Menu Items (auto loop $menuData) -->
    <main class="py-8 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @foreach($menuData as $category => $items)
                <section id="{{ $category }}-section" class="menu-section mb-12">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ ucfirst($category) }}</h2>
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6" id="{{ $category }}-items"></div>
                </section>
            @endforeach
        </div>
    </main>

    <!-- Toast Notification -->
    <div id="toast"
        class="hidden bg-orange-500 text-white px-4 py-3 rounded-lg shadow-lg transition-all duration-300">
    </div>







    <!-- Cart Modal
    <div id="cart-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 justify-center items-center">
        <div class="bg-white rounded-2xl p-6 w-96 relative">
            <button onclick="hideCartModal()" class="absolute top-3 right-3 text-gray-500">&times;</button>
            <h2 class="text-xl font-bold mb-4">Keranjang Belanja</h2>
            <div id="cart-items" class="space-y-2 mb-4"></div>
            <div class="flex justify-between font-bold text-lg">
                <span>Total:</span>
                <span id="cart-modal-total">Rp 0</span>
            </div>
            <button onclick="proceedToCheckout()" 
                    class="w-full mt-4 bg-orange-500 text-white py-2 rounded-lg hover:bg-orange-600">
                Checkout
            </button>
        </div>
    </div> -->

    <!-- Floating Cart Button -->
<!-- Floating Cart Icon -->
    <div id="floating-cart" 
        onclick="showCartModal()" 
        class="fixed bottom-6 right-6 bg-orange-500 text-white rounded-full p-4 shadow-lg cursor-pointer">
        <i class="fas fa-shopping-cart"></i>
        <span id="floating-cart-count" class="ml-2">0</span>
    </div>
    <!-- <pre>{{ json_encode($menuData, JSON_PRETTY_PRINT) }}</pre> -->

    <script>
        const isLoggedIn = {{ auth()->check() ? 'true' : 'false' }};
        const menuData = @json($menuData); // object by category
        let cart = [];
        let currentCategory = 'all';

        document.addEventListener('DOMContentLoaded', function() {
            loadMenuItems();
        });

        // Load menu items per kategori
        function loadMenuItems(category = 'all', searchTerm = '') {
            const categories = category === 'all' ? Object.keys(menuData) : [category];
            categories.forEach(cat => {
                const items = menuData[cat] || [];
                const filteredItems = searchTerm
                    ? items.filter(item => item.name.toLowerCase().includes(searchTerm.toLowerCase()))
                    : items;

                const container = document.getElementById(`${cat}-items`);
                if (container) {
                    container.innerHTML = filteredItems.map(item => `
                        <div class="card-hover bg-white rounded-2xl shadow-lg overflow-hidden p-4">
                            <img src="${item.image}" alt="${item.name}" class="w-full h-40 object-cover rounded-lg mb-4">
                            <h3 class="font-bold text-lg text-gray-900 mb-2">${item.name}</h3>
                            <p class="text-gray-600 text-sm mb-3">${item.description ?? ''}</p>
                            <div class="flex items-center justify-between">
                                <span class="text-xl font-bold text-orange-500">Rp ${(item.price).toLocaleString('id-ID')}</span>
                                <button onclick="addToCart(${item.id}, '${cat}')" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-full">
                                    <i class="fas fa-plus"></i> Tambah
                                </button>
                            </div>
                        </div>
                    `).join('');
                }

                const section = document.getElementById(`${cat}-section`);
                if (section) {
                    section.style.display = (category === 'all' || category === cat) ? 'block' : 'none';
                }
            });
        }

        // Filter kategori
        function filterCategory(category, event) {
            currentCategory = category;
            document.querySelectorAll('.category-tab').forEach(tab => {
                tab.classList.remove('category-active');
                tab.classList.add('category-inactive');
            });
            if (event) {
                event.target.classList.add('category-active');
            }
            loadMenuItems(category);
        }

        // Pencarian menu
        function searchMenu() {
            const searchTerm = document.getElementById('search-menu').value;
            loadMenuItems(currentCategory, searchTerm);
        }

        // ✅ Tambah ke keranjang
        function addToCart(id, category) {
            if (!isLoggedIn) {
                showToast('Silakan login terlebih dahulu untuk menambah pesanan.', 'bg-red-500');
                setTimeout(() => {
                    window.location.href = '{{ route('login') }}';
                }, 1500);
                return;
            }
            const item = Object.values(menuData)
                .flat()
                .find(m => m.id === id);

            if (!item) {
                console.error('Item tidak ditemukan:', id);
                return;
            }

            fetch('{{ route('cart.add') }}', {
                method: 'POST',
                credentials: 'include',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    product_id: item.id,
                    name: item.name,
                    price: item.price,
                    quantity: 1
                })
            })
            .then(res => res.json())
            .then(data => {
                showToast(data.message);
                if (data.cart_count !== undefined) {
                    document.getElementById('cart-count').innerText = data.cart_count;
                    document.getElementById('floating-cart-count').innerText = data.cart_count;
                }
            })
            .catch(err => console.error(err));
        }

        // ✅ Checkout
        function proceedToCheckout() {
            fetch('{{ route('cart.checkout') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ cart })
            })
            .then(res => res.json())
            .then(data => {
                alert(data.message);
                if (data.success) {
                    cart = [];
                    document.getElementById('cart-count').innerText = 0;
                    document.getElementById('floating-cart-count').innerText = 0;
                    document.getElementById('cart-modal-total').innerText = 'Rp 0';
                    hideCartModal();
                }
            })
            .catch(err => console.error(err));
        }

        // ✅ Tampilkan modal keranjang
        function showCartModal() {
            fetch('{{ route('cart.list') }}')
                .then(res => res.json())
                .then(data => {
                    const cartItemsContainer = document.getElementById('cart-items');
                    const totalEl = document.getElementById('cart-modal-total');
                    
                    cartItemsContainer.innerHTML = Object.values(data.cart).map(item => `
                        <div class="flex justify-between items-center border-b py-2">
                            <div>
                                <p class="font-semibold">${item.name}</p>
                                <p class="text-sm text-gray-500">Qty: ${item.quantity}</p>
                            </div>
                            <div class="text-right">
                                <p>Rp ${(item.price * item.quantity).toLocaleString('id-ID')}</p>
                            </div>
                        </div>
                    `).join('');

                    totalEl.innerText = 'Rp ' + data.total.toLocaleString('id-ID');

                    const modal = document.getElementById('cart-modal');
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                })
                .catch(err => console.error(err));
        }

        // ✅ Tutup modal
        function hideCartModal() {
            const modal = document.getElementById('cart-modal');
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }

        // ✅ Render cart lokal (jika tanpa backend)
        function renderCartItems() {
            const container = document.getElementById('cart-items');
            container.innerHTML = '';
            let total = 0;

            cart.forEach(item => {
                total += item.price * item.quantity;
                container.innerHTML += `
                    <div class="flex justify-between items-center">
                        <span>${item.name} x ${item.quantity}</span>
                        <span>Rp ${(item.price * item.quantity).toLocaleString('id-ID')}</span>
                    </div>
                `;
            });

            document.getElementById('cart-modal-total').innerText = `Rp ${total.toLocaleString('id-ID')}`;
        }

        function showToast(message, color = 'bg-orange-500') {
            const toast = document.getElementById('toast');
            toast.textContent = message;
            toast.className = `fixed top-5 right-5 ${color} text-white px-4 py-3 rounded-lg shadow-lg transition-all duration-300 fade-in`;
            toast.classList.remove('hidden');
            toast.style.opacity = 1;

            setTimeout(() => {
                toast.style.opacity = 0;
                setTimeout(() => toast.classList.add('hidden'), 300);
            }, 2000);
        }

        function updateCartCount() {
            fetch('{{ route('cart.list') }}')
                .then(res => res.json())
                .then(data => {
                    // pastikan controller list() mengembalikan array cart
                    const count = data.length || 0;
                    document.getElementById('floating-cart-count').innerText = count;

                    const cartCount = document.getElementById('cart-count');
                    if (cartCount) cartCount.innerText = count;
                })
                .catch(err => console.error('Gagal ambil cart list:', err));
        }

        document.addEventListener('DOMContentLoaded', function() {
            loadMenuItems();       // sudah ada
            updateCartCount();     // tambahkan ini ✅
        });
        




    </script>

@endsection