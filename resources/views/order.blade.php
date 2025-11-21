@extends('layouts.app')
@section('content')
    <!-- Hero Section -->
    <section class="hero-bg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid lg:grid-cols-2 gap-6 items-center">
                <div class="text-white">
                    <p class="text-sm mb-2">Deep flavours with a blend of Italian aesthetics</p>
                    <h1 class="text-4xl font-bold mb-4">Wonton</h1>
                    <div class="flex items-center space-x-4 mb-3">
                        <div class="flex items-center space-x-2 bg-white bg-opacity-20 px-3 py-1 rounded-full">
                            <i class="fas fa-shopping-bag"></i>
                            <span class="text-sm">Minimum Order 15.000</span>
                        </div>
                        <div class="flex items-center space-x-2 bg-white bg-opacity-20 px-3 py-1 rounded-full">
                            <i class="fas fa-motorcycle"></i>
                            <span class="text-sm">Delivery in 20-25 Minutes</span>
                        </div>
                    </div>
                    <div class="bg-red-600 text-white px-3 py-1 rounded-full inline-flex items-center space-x-2 text-sm">
                        <i class="fas fa-tag"></i>
                        <span>Buka mulai pukul 08.00</span>
                    </div>
                </div>

                <div class="relative">
                    <img src="data:image/svg+xml,%3Csvg width='400' height='200' xmlns='http://www.w3.org/2000/svg'%3E%3Crect width='400' height='200' fill='%23f59e0b'/%3E%3Ctext x='200' y='100' font-family='Arial' font-size='20' text-anchor='middle' fill='white'%3EDelicious Wonton%3C/text%3E%3C/svg%3E" alt="Wonton" class="w-full h-48 object-cover rounded-lg">
                    <div class="absolute top-4 right-4 bg-white rounded-lg p-3 shadow-lg">
                        <div class="text-2xl font-bold text-gray-900">3.4</div>
                        <div class="flex text-yellow-400 text-sm">
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

    <!-- Main Content -->
    <main class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Left Side - Menu -->
                <div class="lg:col-span-2">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Order di Minikiyo Wonton</h2>

                    <!-- Search Bar -->
                    <div class="mb-6">
                        <div class="relative">
                            <input type="text" id="search-input" placeholder="Cari..." class="w-full px-4 py-3 pr-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-700">
                            <i class="fas fa-search absolute right-3 top-4 text-gray-400"></i>
                        </div>
                    </div>

                    <!-- Category Sidebar & Menu Items -->
                    <div class="flex gap-6">
                        <!-- Category Sidebar -->
                        <div class="w-48 flex-shrink-0">
                            <div class="bg-gray-900 text-white p-4 rounded-t-lg">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-bars"></i>
                                    <span class="font-semibold">Menu</span>
                                </div>
                            </div>
                            <div class="bg-white border border-gray-200 rounded-b-lg overflow-hidden">
                                <button onclick="filterCategory('dimsum')" class="category-btn category-active w-full text-left px-4 py-3 hover:bg-gray-50 transition-colors flex items-center justify-between">
                                    <span>Dimsum</span>
                                    <span class="text-sm">(6)</span>
                                </button>
                                <button onclick="filterCategory('wonton')" class="category-btn category-inactive w-full text-left px-4 py-3 hover:bg-gray-50 transition-colors flex items-center justify-between border-t border-gray-200">
                                    <span>Wonton</span>
                                    <span class="text-sm">(5)</span>
                                </button>
                                <button onclick="filterCategory('dimsum-goreng')" class="category-btn category-inactive w-full text-left px-4 py-3 hover:bg-gray-50 transition-colors flex items-center justify-between border-t border-gray-200">
                                    <span>Dimsum Goreng</span>
                                    <span class="text-sm">(4)</span>
                                </button>
                            </div>
                        </div>

                        <!-- Menu Items -->
                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-4">
                                <h3 id="category-title" class="text-xl font-bold text-gray-900">Dimsum</h3>
                                <div class="flex items-center space-x-2 text-sm">
                                    <span class="text-gray-600">Sort by Pricing</span>
                                    <i class="fas fa-sort text-gray-400"></i>
                                </div>
                            </div>

                            <div id="menu-items" class="space-y-4">
                                <!-- Menu items will be populated by JavaScript -->
                            </div>
                        </div>
                    </div>

                    <!-- First Order Discount Banner -->
                    <div class="mt-8 bg-gradient-to-r from-gray-800 to-gray-900 rounded-lg p-6 text-white relative overflow-hidden">
                        <div class="absolute top-4 right-4 bg-orange-600 text-white px-3 py-1 rounded-full text-sm font-bold">-30%</div>
                        <h3 class="text-xl font-bold mb-2">First Order Discount</h3>
                        <p class="text-sm opacity-90 mb-4">Dapatkan diskon hingga 30% untuk pesanan pertama Anda</p>
                        <button class="bg-white text-gray-900 px-4 py-2 rounded-lg font-medium text-sm">
                            <i class="fas fa-question-circle mr-2"></i>Info
                        </button>
                    </div>
                </div>

                <!-- Right Side - Cart -->
                <div class="lg:col-span-1">
                    <div class="sticky top-24">
                        <!-- Cart Header -->
                        <div class="bg-orange-700 text-white p-4 rounded-t-lg flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-shopping-cart"></i>
                                <span class="font-semibold">Buka pukul 08.00</span>
                            </div>
                        </div>

                        <!-- Cart Items -->
                        <div class="bg-orange-50 p-4 border-x border-orange-200">
                            <div class="flex items-center space-x-3 mb-4">
                                <i class="fas fa-shopping-bag text-orange-700 text-2xl"></i>
                                <div>
                                    <h3 class="font-bold text-orange-900">Keranjang</h3>
                                    <p class="text-sm text-orange-700" id="cart-item-count">3 Item</p>
                                </div>
                            </div>

                            <div id="cart-items-list" class="space-y-3 max-h-96 overflow-y-auto">
                                <!-- Cart items will be populated by JavaScript -->
                            </div>
                        </div>

                        <!-- Cart Summary -->
                        <div class="bg-white border border-gray-200 rounded-b-lg p-4 space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Sub Total:</span>
                                <span class="font-medium" id="subtotal">72.000</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Discounts:</span>
                                <span class="font-medium text-green-600" id="discount">-0.00</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Delivery Fee:</span>
                                <span class="font-medium" id="delivery-fee">12.000</span>
                            </div>
                            <div class="border-t pt-3 flex justify-between">
                                <span class="font-bold text-lg">Total bayar</span>
                                <span class="font-bold text-lg text-orange-700" id="total">Rp. 84.000</span>
                            </div>

                            <button onclick="proceedToCheckout()" class="w-full bg-orange-500 hover:bg-orange-600 text-white py-3 rounded-lg font-medium transition-colors">
                                Pesan
                            </button>

                            <div class="grid grid-cols-2 gap-3 pt-3">
                                <div class="text-center p-3 bg-gray-50 rounded-lg">
                                    <i class="fas fa-utensils text-orange-700 mb-1"></i>
                                    <p class="text-xs font-medium">Diantar Ke Meja Anda</p>
                                </div>
                                <div class="text-center p-3 bg-gray-50 rounded-lg">
                                    <i class="fas fa-motorcycle text-orange-700 mb-1"></i>
                                    <p class="text-xs font-medium">Diantar Ke Kos-kosan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid md:grid-cols-3 gap-8">
                <div>
                    <h3 class="font-bold text-gray-900 mb-4">Dapatkan Penawaran Eksklusif di Email Anda</h3>
                    <div class="flex">
                        <input type="email" placeholder="youremail@gmail.com" class="flex-1 px-4 py-2 border border-gray-300 rounded-l-lg">
                        <button class="bg-orange-700 text-white px-6 py-2 rounded-r-lg">Subscribe</button>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Kami tidak akan spam kotak masuk Anda</p>
                </div>

                <div>
                    <h4 class="font-bold text-gray-900 mb-4">Legal Pages</h4>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li><a href="#" class="hover:text-orange-700">Syarat dan ketentuan</a></li>
                        <li><a href="#" class="hover:text-orange-700">Privacy</a></li>
                        <li><a href="#" class="hover:text-orange-700">Cookies</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-gray-900 mb-4">Important Links</h4>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li><a href="#" class="hover:text-orange-700">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-orange-700">Hubungi Kami</a></li>
                        <li><a href="#" class="hover:text-orange-700">Daftar untuk Mengirim</a></li>
                    </ul>
                </div>
            </div>

            <div class="flex justify-center space-x-4 mt-8">
                <a href="#" class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center hover:bg-orange-700 hover:text-white transition-colors">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center hover:bg-orange-700 hover:text-white transition-colors">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="#" class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center hover:bg-orange-700 hover:text-white transition-colors">
                    <i class="fab fa-tiktok"></i>
                </a>
            </div>
        </div>
    </footer>

    <script>
        // Menu data
        const menuData = {
            dimsum: [
                { id: 1, name: "Dimsum Mentai Lite", description: "Dimsum dengan saus mentai ala Jepang", price: 15000, sizes: ["small", "sweet", "mix"], category: "dimsum" },
                { id: 2, name: "Dimsum Mentai Keju Lite", description: "Dimsum dengan mentai dan keju lumer", price: 18000, sizes: ["small", "sweet", "mix"], category: "dimsum" },
                { id: 3, name: "Dimsum Mentai Mix Lite", description: "Mix dimsum dengan berbagai rasa", price: 20000, sizes: ["small", "sweet", "mix"], category: "dimsum" },
                { id: 4, name: "Dimsum Mentai", description: "Dimsum mentai premium", price: 22000, sizes: ["small", "sweet", "mix"], category: "dimsum" },
                { id: 5, name: "Dimsum Mentai Keju", description: "Dimsum mentai keju premium", price: 25000, sizes: ["small", "sweet", "mix"], category: "dimsum" },
                { id: 6, name: "Dimsum Mentai Mix", description: "Mix dimsum premium", price: 28000, sizes: ["small", "sweet", "mix"], category: "dimsum" }
            ],
            wonton: [
                { id: 7, name: "Wonton Goreng", description: "Wonton goreng renyah dengan daging ayam", price: 16000, sizes: ["level1", "level2", "level3"], category: "wonton" },
                { id: 8, name: "Wonton Kuah", description: "Wonton dalam kuah kaldu ayam", price: 18000, sizes: ["level1", "level2", "level3"], category: "wonton" },
                { id: 9, name: "Wonton Mix", description: "Kombinasi wonton goreng dan kuah", price: 20000, sizes: ["level1", "level2", "level3"], category: "wonton" },
                { id: 10, name: "Wonton Spesial", description: "Wonton dengan isian spesial", price: 24000, sizes: ["level1", "level2", "level3"], category: "wonton" },
                { id: 11, name: "Wonton Premium", description: "Wonton premium dengan topping", price: 28000, sizes: ["level1", "level2", "level3"], category: "wonton" }
            ],
            'dimsum-goreng': [
                { id: 12, name: "Dimsum Goreng Original", description: "Dimsum goreng original crispy", price: 14000, sizes: ["small", "sweet", "mix"], category: "dimsum-goreng" },
                { id: 13, name: "Dimsum Goreng Keju", description: "Dimsum goreng dengan keju", price: 17000, sizes: ["small", "sweet", "mix"], category: "dimsum-goreng" },
                { id: 14, name: "Dimsum Goreng Spicy", description: "Dimsum goreng pedas", price: 16000, sizes: ["small", "sweet", "mix"], category: "dimsum-goreng" },
                { id: 15, name: "Dimsum Goreng Mix", description: "Mix dimsum goreng berbagai rasa", price: 19000, sizes: ["small", "sweet", "mix"], category: "dimsum-goreng" }
            ]
        };

        // Cart state
        let cart = [];
        let currentCategory = 'dimsum';

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            loadMenuItems('dimsum');
            updateCartDisplay();
        });

        // Filter by category
        function filterCategory(category) {
            currentCategory = category;
            
            // Update active category button
            document.querySelectorAll('.category-btn').forEach(btn => {
                btn.classList.remove('category-active');
                btn.classList.add('category-inactive');
            });
            event.target.classList.remove('category-inactive');
            event.target.classList.add('category-active');
            
            // Update title
            const titles = {
                'dimsum': 'Dimsum',
                'wonton': 'Wonton',
                'dimsum-goreng': 'Dimsum Goreng'
            };
            document.getElementById('category-title').textContent = titles[category];
            
            loadMenuItems(category);
        }

        // Load menu items
        function loadMenuItems(category) {
            const items = menuData[category] || [];
            const container = document.getElementById('menu-items');
            
            container.innerHTML = items.map(item => `
                <div class="card-hover bg-white border border-gray-200 rounded-lg p-4">
                    <div class="flex gap-4">
                        <img src="data:image/svg+xml,%3Csvg width='120' height='120' xmlns='http://www.w3.org/2000/svg'%3E%3Crect width='120' height='120' fill='%23f59e0b' rx='8'/%3E%3Ctext x='60' y='60' font-family='Arial' font-size='12' text-anchor='middle' dy='4' fill='white'%3E${item.name}%3C/text%3E%3C/svg%3E" alt="${item.name}" class="w-24 h-24 object-cover rounded-lg">
                        <div class="flex-1">
                            <h4 class="font-bold text-gray-900 mb-1">${item.name}</h4>
                            <p class="text-sm text-gray-600 mb-3">${item.description}</p>
                            
                            <div class="flex flex-wrap gap-2 mb-3">
                                ${item.sizes.map(size => `
                                    <button class="size-option size-btn-inactive px-3 py-1 rounded text-xs font-medium transition-colors" 
                                            data-item-id="${item.id}" 
                                            data-size="${size}">
                                        ${size}
                                    </button>
                                `).join('')}
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-orange-700">Rp ${item.price.toLocaleString('id-ID')}</span>
                                <button onclick="addToCart(${item.id})" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-1 rounded text-sm transition-colors">
                                    <i class="fas fa-plus mr-1"></i>Add
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `).join('');
            
            // Add event listeners for size buttons
            document.querySelectorAll('.size-option').forEach(btn => {
                btn.addEventListener('click', function() {
                    const itemId = this.dataset.itemId;
                    document.querySelectorAll(`[data-item-id="${itemId}"]`).forEach(b => {
                        b.classList.remove('size-btn-active', 'level-btn-active');
                        b.classList.add('size-btn-inactive', 'level-btn-inactive');
                    });
                    this.classList.remove('size-btn-inactive', 'level-btn-inactive');
                    this.classList.add(currentCategory === 'wonton' ? 'level-btn-active' : 'size-btn-active');
                });
            });
        }

        // Add to cart
        function addToCart(itemId) {
            const item = findMenuItem(itemId);
            if (!item) return;
            
            const sizeBtn = document.querySelector(`[data-item-id="${itemId}"].size-btn-active, [data-item-id="${itemId}"].level-btn-active`);
            const size = sizeBtn ? sizeBtn.dataset.size : item.sizes[0];
            
            const existingItem = cart.find(cartItem => cartItem.id === itemId && cartItem.size === size);
            if (existingItem) {
                existingItem.quantity += 1;
            } else {
                cart.push({
                    id: item.id,
                    name: item.name,
                    price: item.price,
                    size: size,
                    quantity: 1
                });
            }
            
            updateCartDisplay();
            showNotification('Item ditambahkan ke keranjang!');
        }

        // Find menu item
        function findMenuItem(id) {
            for (const category in menuData) {
                const item = menuData[category].find(item => item.id === id);
                if (item) return item;
            }
            return null;
        }

        // Update cart display
        function updateCartDisplay() {
            const cartItemsList = document.getElementById('cart-items-list');
            const cartItemCount = document.getElementById('cart-item-count');
            
            if (cart.length === 0) {
                cartItemsList.innerHTML = `
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-shopping-cart text-3xl mb-2"></i>
                        <p class="text-sm">Keranjang kosong</p>
                    </div>
                `;
                cartItemCount.textContent = '0 Item';
            } else {
                cartItemsList.innerHTML = cart.map((item, index) => `
                    <div class="bg-white rounded-lg p-3 flex items-center justify-between">
                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-2">
                                <span class="bg-orange-100 text-orange-700 px-2 py-1 rounded-full text-xs font-bold">${index + 1}</span>
                                <button onclick="removeFromCart(${index})" class="text-red-500 hover:text-red-700">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </div>
                            <h4 class="font-semibold text-sm text-gray-900">${item.name}</h4>
                            <p class="text-xs text-gray-500">${item.size}</p>
                        </div>
                        <div class="ml-3 text-right">
                            <div class="flex items-center space-x-2 mb-1">
                                <button onclick="decreaseQuantity(${index})" class="w-6 h-6 bg-gray-200 hover:bg-gray-300 rounded flex items-center justify-center">
                                    <i class="fas fa-minus text-xs"></i>
                                </button>
                                <span class="w-6 text-center text-sm font-medium">${item.quantity}</span>
                                <button onclick="increaseQuantity(${index})" class="w-6 h-6 bg-orange-500 hover:bg-orange-600 text-white rounded flex items-center justify-center">
                                    <i class="fas fa-plus text-xs"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `).join('');
                
                const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
                cartItemCount.textContent = `${totalItems} Item`;
            }
            
            updateCartSummary();
        }

        // Update cart summary
        function updateCartSummary() {
            const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            const discount = 0;
            const deliveryFee = 12000;
            const total = subtotal - discount + deliveryFee;
            
            document.getElementById('subtotal').textContent = subtotal.toLocaleString('id-ID');
            document.getElementById('discount').textContent = `-${discount.toLocaleString('id-ID')}`;
            document.getElementById('delivery-fee').textContent = deliveryFee.toLocaleString('id-ID');
            document.getElementById('total').textContent = `Rp. ${total.toLocaleString('id-ID')}`;
        }

        // Increase quantity
        function increaseQuantity(index) {
            cart[index].quantity += 1;
            updateCartDisplay();
        }

        // Decrease quantity
        function decreaseQuantity(index) {
            if (cart[index].quantity > 1) {
                cart[index].quantity -= 1;
            } else {
                cart.splice(index, 1);
            }
            updateCartDisplay();
        }

        // Remove from cart
        function removeFromCart(index) {
            cart.splice(index, 1);
            updateCartDisplay();
            showNotification('Item dihapus dari keranjang');
        }

        // Proceed to checkout
        function proceedToCheckout() {
            if (cart.length === 0) {
                showNotification('Keranjang belanja kosong!');
                return;
            }
            
            showNotification('Memproses pesanan...');
            console.log('Checkout with items:', cart);
            
            // Simulate order processing
            setTimeout(() => {
                const orderId = 'MKW-' + Date.now().toString().slice(-6);
                showNotification(`Pesanan berhasil! ID: #${orderId}`);
                // Keep cart for demo purposes
            }, 1500);
        }

        // Search functionality
        document.getElementById('search-input').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const items = menuData[currentCategory] || [];
            const filteredItems = items.filter(item => 
                item.name.toLowerCase().includes(searchTerm) || 
                item.description.toLowerCase().includes(searchTerm)
            );
            
            const container = document.getElementById('menu-items');
            if (filteredItems.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-search text-3xl mb-2"></i>
                        <p>Tidak ada menu yang ditemukan</p>
                    </div>
                `;
            } else {
                // Re-render filtered items (reuse the same rendering logic)
                container.innerHTML = filteredItems.map(item => `
                    <div class="card-hover bg-white border border-gray-200 rounded-lg p-4">
                        <div class="flex gap-4">
                            <img src="data:image/svg+xml,%3Csvg width='120' height='120' xmlns='http://www.w3.org/2000/svg'%3E%3Crect width='120' height='120' fill='%23f59e0b' rx='8'/%3E%3Ctext x='60' y='60' font-family='Arial' font-size='12' text-anchor='middle' dy='4' fill='white'%3E${item.name}%3C/text%3E%3C/svg%3E" alt="${item.name}" class="w-24 h-24 object-cover rounded-lg">
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-900 mb-1">${item.name}</h4>
                                <p class="text-sm text-gray-600 mb-3">${item.description}</p>
                                
                                <div class="flex flex-wrap gap-2 mb-3">
                                    ${item.sizes.map(size => `
                                        <button class="size-option size-btn-inactive px-3 py-1 rounded text-xs font-medium transition-colors" 
                                                data-item-id="${item.id}" 
                                                data-size="${size}">
                                            ${size}
                                        </button>
                                    `).join('')}
                                </div>
                                
                                <div class="flex items-center justify-between">
                                    <span class="font-bold text-orange-700">Rp ${item.price.toLocaleString('id-ID')}</span>
                                    <button onclick="addToCart(${item.id})" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-1 rounded text-sm transition-colors">
                                        <i class="fas fa-plus mr-1"></i>Add
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `).join('');
                
                // Re-attach event listeners
                document.querySelectorAll('.size-option').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const itemId = this.dataset.itemId;
                        document.querySelectorAll(`[data-item-id="${itemId}"]`).forEach(b => {
                            b.classList.remove('size-btn-active', 'level-btn-active');
                            b.classList.add('size-btn-inactive', 'level-btn-inactive');
                        });
                        this.classList.remove('size-btn-inactive', 'level-btn-inactive');
                        this.classList.add(currentCategory === 'wonton' ? 'level-btn-active' : 'size-btn-active');
                    });
                });
            }
        });

        // Notification system
        function showNotification(message) {
            const existingNotification = document.querySelector('.notification');
            if (existingNotification) {
                existingNotification.remove();
            }

            const notification = document.createElement('div');
            notification.className = 'notification fixed top-20 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transition-all duration-300 transform translate-x-full';
            notification.textContent = message;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 100);
            
            setTimeout(() => {
                notification.classList.add('translate-x-full');
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.parentNode.removeChild(notification);
                    }
                }, 300);
            }, 3000);
        }

        // Load cart from localStorage (if you want persistence across pages)
        function loadCartFromStorage() {
            const savedCart = localStorage.getItem('minikyoCart');
            if (savedCart) {
                try {
                    cart = JSON.parse(savedCart);
                    updateCartDisplay();
                } catch (e) {
                    console.error('Error loading cart:', e);
                }
            }
        }

        // Save cart to localStorage
        function saveCartToStorage() {
            localStorage.setItem('minikyoCart', JSON.stringify(cart));
        }

        // Update the addToCart, increaseQuantity, decreaseQuantity, and removeFromCart functions to save cart
        const originalAddToCart = addToCart;
        addToCart = function(itemId) {
            originalAddToCart(itemId);
            saveCartToStorage();
        };

        const originalIncreaseQuantity = increaseQuantity;
        increaseQuantity = function(index) {
            originalIncreaseQuantity(index);
            saveCartToStorage();
        };

        const originalDecreaseQuantity = decreaseQuantity;
        decreaseQuantity = function(index) {
            originalDecreaseQuantity(index);
            saveCartToStorage();
        };

        const originalRemoveFromCart = removeFromCart;
        removeFromCart = function(index) {
            originalRemoveFromCart(index);
            saveCartToStorage();
        };

        // Load cart on page load
        // loadCartFromStorage(); // Uncomment this if you want cart persistence
    </script>
@endsection