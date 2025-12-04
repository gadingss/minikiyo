@extends('layouts.app')
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

                    <!-- Tombol Ambil Lokasi -->
                    <button 
                        onclick="getLocationHero()" 
                        class="mt-6 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-full flex items-center space-x-2 shadow"
                    >
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Gunakan Lokasi Saya</span>
                    </button>

                    <!-- Tempat menampilkan alamat -->
                    <div id="alamatBox" class="mt-4 text-gray-900 font-semibold">
                        {{ session('user_address') }}
                    </div>



                    <!-- Hasil Alamat -->
                    <p id="user-address" class="mt-4 text-white text-sm bg-black bg-opacity-30 p-3 rounded-lg hidden">
                        Mendeteksi lokasi...
                    </p>

                </div>

                <!-- Right Content - Product Image with Rating -->
                <div class="relative">
                    <img src="{{ asset('images/dimsum_mentai.jpg') }}" alt="Dimsum Mentai" class="w-full h-48 object-cover" loading="lazy">
                    
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

    @if($recommendedProducts->count())
    <section class="py-8 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Rekomendasi Untukmu</h2>
            <div class="flex gap-6 overflow-x-auto pb-4 scrollbar-hide snap-x snap-mandatory">
                @foreach($recommendedProducts as $product)
                <div class="flex-none w-64 snap-center bg-white rounded-2xl overflow-hidden shadow-lg relative">
                    <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-40 object-cover">
                    <div class="p-4">
                        <span class="text-xs text-orange-500 font-medium">RESTORAN</span>
                        <h3 class="font-bold text-lg text-gray-900">{{ $product->name }}</h3>
                        <p class="text-sm text-gray-500">Rp {{ number_format($product->price,0,',','.') }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif



    <!-- Promotional Banners -->
    <!-- <section class="py-8 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-6">
                <!-- First Order Discount -->
                <!-- <div class="relative bg-gradient-to-r from-purple-600 to-purple-800 rounded-2xl p-6 text-white overflow-hidden">
                    <div class="discount-badge absolute top-4 right-4 text-white px-3 py-1 rounded-full text-sm font-bold">-40%</div>
                    <h3 class="text-xl font-bold mb-2">First Order Discount</h3>
                    <p class="text-sm opacity-90">Dapatkan diskon hingga 40% untuk pesanan pertama</p>
                    <button class="mt-4 bg-white text-purple-600 px-4 py-2 rounded-lg font-medium">
                        <i class="fas fa-plus mr-2"></i>Claim
                    </button>
                </div> -->

                <!-- Vegan Discount -->
                <!-- <div class="relative bg-gradient-to-r from-green-500 to-green-700 rounded-2xl p-6 text-white overflow-hidden">
                    <div class="discount-badge absolute top-4 right-4 text-white px-3 py-1 rounded-full text-sm font-bold">-25%</div>
                    <h3 class="text-xl font-bold mb-2">Vegan Discount</h3>
                    <p class="text-sm opacity-90">Menu vegetarian dengan diskon spesial</p>
                    <button class="mt-4 bg-white text-green-600 px-4 py-2 rounded-lg font-medium">
                        <i class="fas fa-plus mr-2"></i>Claim
                    </button>
                </div> -->

                <!-- Free Ice Cream -->
                <!-- <div class="relative bg-gradient-to-r from-blue-500 to-blue-700 rounded-2xl p-6 text-white overflow-hidden">
                    <div class="discount-badge absolute top-4 right-4 text-white px-3 py-1 rounded-full text-sm font-bold">200%</div>
                    <h3 class="text-xl font-bold mb-2">Free Ice Cream Offer</h3>
                    <p class="text-sm opacity-90">Es krim gratis untuk setiap pembelian</p>
                    <button class="mt-4 bg-white text-blue-600 px-4 py-2 rounded-lg font-medium">
                        <i class="fas fa-plus mr-2"></i>Claim
                    </button>
                </div>
            </div>
        </div>
    </section> --> -->

    <!-- <main class="py-8 bg-white" wire:ignore>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @foreach($menuData as $category => $items)
                <section id="{{ $category }}-section" class="menu-section mb-12">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ ucfirst($category) }}</h2>
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6" id="{{ $category }}-items"></div>
                </section>
            @endforeach
        </div>
    </main> -->


    <!-- Toast Notification -->
    <div id="toast"
        class="hidden bg-orange-500 text-white px-4 py-3 rounded-lg shadow-lg transition-all duration-300">
    </div>
{{-- Livewire Menu List (Daftar Produk) --}}
<livewire:menu-list :menuData="$menuData" />

{{-- Livewire Sidebar Cart --}}
<livewire:menu-cart-sidebar />
<script>
async function getLocationHero() {
    const box = document.getElementById("alamatBox");

    if (!navigator.geolocation) {
        box.innerText = "Browser Anda tidak mendukung GPS.";
        return;
    }

    navigator.geolocation.getCurrentPosition(async (pos) => {
        const lat = pos.coords.latitude;
        const lon = pos.coords.longitude;

        box.innerText = "Mengambil alamat...";

        // Reverse Geocode
        const res = await fetch("/reverse-geocode", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ lat, lon })
        });

        const data = await res.json();
        const alamat = data.display_name ?? "Alamat tidak ditemukan";

        // Tampilkan
        box.innerText = alamat;

        // Simpan ke session untuk cart
        await fetch("/save-location", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ address: alamat })
        });

    }, (err) => {
        box.innerText = "Gagal mengambil lokasi: " + err.message;
    });
}
</script>






<!-- <script>
    const isLoggedIn = {{ auth()->check() ? 'true' : 'false' }};
    const menuData = @json($menuData);
    let currentCategory = 'all';

    document.addEventListener('DOMContentLoaded', function() {
        loadMenuItems();
        updateCartCount();
        initializeEventListeners();
    });

    // ========================
    // 🔹 Initialize Event Listeners
    // ========================
    function initializeEventListeners() {
        // Search input
        const searchInput = document.getElementById('search-menu');
        if (searchInput) {
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') searchMenu();
            });
        }

        // Delivery options
        const deliveryOptions = document.querySelectorAll('input[name="delivery"]');
        deliveryOptions.forEach(option => {
            option.addEventListener('change', function() {
                updateDeliveryOption(this.value);
            });
        });

        // Promo code input
        const promoInput = document.getElementById('promo-code-input');
        if (promoInput) {
            promoInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') applyPromoCode();
            });
        }

        // Livewire events
        if (typeof Livewire !== 'undefined') {
            // Event ketika Livewire update cart summary
            Livewire.on('cartSummaryUpdated', (event) => {
                console.log('Cart summary updated from Livewire:', event);
                updateCartUI(
                    event.summary.subtotal,
                    event.summary.discount,
                    event.summary.delivery_fee,
                    event.summary.total,
                    event.summary.promo_code
                );
            });

            // Event ketika cart dibuka
            Livewire.on('cartOpened', () => {
                adjustLayoutForCart(true);
            });
            
            Livewire.on('cartClosed', () => {
                adjustLayoutForCart(false);
            });

            Livewire.on('updateCartBadge', (event) => {
                updateBadges(event.count);
            });
        }
    }

    // ========================
    // 🔹 Adjust layout when cart opens/closes
    // ========================
    function adjustLayoutForCart(open) {
        const mainContainer = document.getElementById('main-container');
        const menuContainer = document.getElementById('menu-container');
        const mainGrid = document.getElementById('main-grid');
        
        if (open) {
            // Saat cart terbuka, geser seluruh layout ke kiri
            if (mainContainer) {
                mainContainer.style.transform = 'translateX(-96px)';
                mainContainer.style.transition = 'transform 0.3s ease';
            }
            
            // Menu jadi 3/4 width
            if (menuContainer && mainGrid) {
                menuContainer.className = 'lg:col-span-3 transition-all duration-300';
                mainGrid.className = 'grid grid-cols-1 lg:grid-cols-4 gap-8 transition-all duration-300';
            }
        } else {
            // Saat cart tertutup, kembalikan ke posisi semula
            if (mainContainer) {
                mainContainer.style.transform = 'translateX(0)';
            }
            
            // Menu full width
            if (menuContainer && mainGrid) {
                menuContainer.className = 'lg:col-span-4 transition-all duration-300';
                mainGrid.className = 'grid grid-cols-1 lg:grid-cols-1 gap-8 transition-all duration-300';
            }
        }
    }

    // ========================
    // 🔹 Load menu items
    // ========================
    function loadMenuItems(category = 'all', searchTerm = '') {
        const categories = category === 'all' ? Object.keys(menuData) : [category];
        categories.forEach(cat => {
            const items = menuData[cat] || [];
            const filteredItems = searchTerm
                ? items.filter(item => item.name.toLowerCase().includes(searchTerm.toLowerCase()))
                : items;

            const container = document.getElementById(`${cat}-items`);
            if (container) {
                container.innerHTML = filteredItems.map(item => {
                    const isSoldOut = item.is_active === 0;

                    return `
                        <div class="card-hover bg-white rounded-2xl shadow-lg overflow-hidden p-4 ${isSoldOut ? 'opacity-50 pointer-events-none' : ''}">
                            <img src="${item.image}" alt="${item.name}" class="w-full h-40 object-cover rounded-lg mb-4">

                            ${isSoldOut ? `
                                <div class="absolute top-2 left-2 bg-red-600 text-white px-3 py-1 rounded-full text-xs font-bold">
                                    SOLD OUT
                                </div>
                            ` : ''}

                            <h3 class="font-bold text-lg text-gray-900 mb-2">${item.name}</h3>
                            <p class="text-gray-600 text-sm mb-3">${item.description ?? ''}</p>

                            <div class="flex items-center justify-between">
                                <span class="text-xl font-bold text-orange-500">
                                    Rp ${(item.price).toLocaleString('id-ID')}
                                </span>

                                ${
                                    isSoldOut
                                    ? `<button class="bg-gray-400 text-white px-4 py-2 rounded-full cursor-not-allowed">Tidak Tersedia</button>`
                                    : `<button onclick="addToCart(${item.id}, '${cat}')" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-full"><i class="fas fa-plus"></i> Tambah</button>`
                                }
                            </div>
                        </div>
                    `;
                }).join('');
            }

            const section = document.getElementById(`${cat}-section`);
            if (section) {
                section.style.display = (category === 'all' || category === cat) ? 'block' : 'none';
            }
        });
    }

    // ========================
    // 🔹 Filter category
    // ========================
    function filterCategory(category) {
        currentCategory = category;
        loadMenuItems(category);
        
        // Update active state
        document.querySelectorAll('.category-tab').forEach(btn => {
            btn.classList.remove('category-active');
            btn.classList.add('category-inactive');
        });
        event.target.classList.remove('category-inactive');
        event.target.classList.add('category-active');
    }

    // ========================
    // 🔹 Search menu
    // ========================
    function searchMenu() {
        const searchTerm = document.getElementById('search-menu').value;
        loadMenuItems(currentCategory, searchTerm);
    }

    // ========================
    // 🔹 Tambah ke keranjang
    // ========================
    function addToCart(id, category) {
        if (!isLoggedIn) {
            showToast('Silakan login terlebih dahulu untuk menambah pesanan.', 'bg-red-500');
            setTimeout(() => window.location.href = '{{ route('login') }}', 1500);
            return;
        }

        const item = Object.values(menuData).flat().find(m => m.id === id);
        if (!item) {
            console.error('Item tidak ditemukan:', id);
            return;
        }

        fetch('{{ route('cart.add') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
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
            if (data.success) {
                showToast(data.message || 'Berhasil ditambahkan ke keranjang');
                updateBadges(data.cart_count || 0);
                updateCartSummary();
                
                // Trigger Livewire untuk buka sidebar
                if (typeof Livewire !== 'undefined') {
                    Livewire.dispatch('cartUpdated');
                    Livewire.dispatch('showCartSidebar');
                }
            } else {
                showToast(data.message || 'Gagal menambah ke keranjang', 'bg-red-500');
            }
        })
        .catch(err => {
            console.error('Error addToCart:', err);
            showToast('Terjadi kesalahan saat menambahkan ke keranjang', 'bg-red-500');
        });
    }

    // ========================
    // 🔹 Update cart summary
    // ========================
    function updateCartSummary() {
        fetch('{{ route('cart.list') }}')
            .then(res => res.json())
            .then(data => {
                const subtotal = data.cart_total || 0;
                const discount = data.discount_amount || 0;
                const deliveryFee = data.delivery_fee || 0;
                const total = data.total_amount || 0;
                const promoCode = data.promo_code || null;

                // Update UI elements
                updateCartUI(subtotal, discount, deliveryFee, total, promoCode);
                
                // Update delivery info
                updateDeliveryInfo(subtotal, deliveryFee);
            })
            .catch(err => console.error('Error update summary:', err));
    }

    // ========================
    // 🔹 Update cart UI
    // ========================
    function updateCartUI(subtotal, discount, deliveryFee, total, promoCode) {
        console.log('Updating UI with:', { subtotal, total });
        
        const elements = {
            subtotal: document.getElementById('static-cart-subtotal'),
            discount: document.getElementById('static-cart-discount'),
            discountRow: document.getElementById('discount-row'),
            delivery: document.getElementById('static-cart-delivery'),
            total: document.getElementById('static-cart-total')
        };

        // Only update if elements exist and values are valid
        if (elements.subtotal && !isNaN(subtotal)) {
            elements.subtotal.textContent = `Rp ${subtotal.toLocaleString('id-ID')}`;
        }
        
        if (elements.discount && elements.discountRow) {
            if (discount > 0) {
                elements.discount.textContent = `-Rp ${discount.toLocaleString('id-ID')}`;
                elements.discountRow.classList.remove('hidden');
            } else {
                elements.discountRow.classList.add('hidden');
            }
        }
        
        if (elements.delivery && !isNaN(deliveryFee)) {
            elements.delivery.textContent = `Rp ${deliveryFee.toLocaleString('id-ID')}`;
        }
        
        if (elements.total && !isNaN(total)) {
            elements.total.textContent = `Rp ${total.toLocaleString('id-ID')}`;
        }
    }

    // ========================
    // 🔹 Apply promo code
    // ========================
    function applyPromoCode() {
        const promoCode = document.getElementById('promo-code-input')?.value.trim();
        
        if (!promoCode) {
            showToast('Masukkan kode promo', 'bg-yellow-500');
            return;
        }

        fetch('{{ route('cart.apply-promo') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                promo_code: promoCode
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showToast(data.message, 'bg-green-500');
                updateCartSummary();
            } else {
                showToast(data.message, 'bg-red-500');
            }
        })
        .catch(err => {
            console.error('Error apply promo:', err);
            showToast('Terjadi kesalahan', 'bg-red-500');
        });
    }

    // ========================
    // 🔹 Remove promo code
    // ========================
    function removePromoCode() {
        fetch('{{ route('cart.remove-promo') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showToast(data.message, 'bg-blue-500');
                updateCartSummary();
            }
        })
        .catch(err => {
            console.error('Error remove promo:', err);
            showToast('Terjadi kesalahan', 'bg-red-500');
        });
    }

    // ========================
    // 🔹 Update promo code UI
    // ========================
    function updatePromoCodeUI(promoCode, discountAmount) {
        const promoSection = document.getElementById('promo-section');
        if (promoSection) {
            promoSection.innerHTML = `
                <div class="flex justify-between items-center p-3 bg-green-50 rounded-lg">
                    <div>
                        <p class="text-sm font-medium text-green-800">Kode Promo: ${promoCode}</p>
                        <p class="text-xs text-green-600">Diskon: Rp ${discountAmount.toLocaleString('id-ID')}</p>
                    </div>
                    <button 
                        onclick="removePromoCode()" 
                        class="text-red-500 hover:text-red-700"
                    >
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
        }
    }

    // ========================
    // 🔹 Reset promo code UI
    // ========================
    function resetPromoCodeUI() {
        const promoSection = document.getElementById('promo-section');
        if (promoSection) {
            promoSection.innerHTML = `
                <div class="flex space-x-2">
                    <input 
                        type="text" 
                        id="promo-code-input"
                        placeholder="Masukkan kode promo" 
                        class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm"
                    >
                    <button 
                        onclick="applyPromoCode()"
                        class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg text-sm"
                    >
                        Apply
                    </button>
                </div>
            `;

            // Re-attach event listener
            const promoInput = document.getElementById('promo-code-input');
            if (promoInput) {
                promoInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') applyPromoCode();
                });
            }
        }
    }

    // ========================
    // 🔹 Update delivery option
    // ========================
    function updateDeliveryOption(option) {
        fetch('{{ route('cart.update-delivery') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                delivery_option: option
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                updateCartSummary();
            }
        })
        .catch(err => console.error('Error update delivery:', err));
    }

    // ========================
    // 🔹 Update delivery info
    // ========================
    function updateDeliveryInfo(subtotal, deliveryFee) {
        const deliveryInfo = document.getElementById('delivery-info');
        if (!deliveryInfo) return;

        const deliveryOption = document.querySelector('input[name="delivery"]:checked')?.value;
        
        if (deliveryOption === 'takeaway') {
            deliveryInfo.innerHTML = '<p class="text-green-600 text-sm">✓ Ambil di toko - Gratis</p>';
        } else if (deliveryFee === 0 && subtotal > 0) {
            deliveryInfo.innerHTML = '<p class="text-green-600 text-sm">✓ Gratis ongkir (order ≥ Rp 35.000)</p>';
        } else if (deliveryOption === 'delivery') {
            const needed = 35000 - subtotal;
            if (needed > 0) {
                deliveryInfo.innerHTML = `<p class="text-orange-600 text-sm">+Rp ${needed.toLocaleString('id-ID')} lagi untuk gratis ongkir</p>`;
            } else {
                deliveryInfo.innerHTML = '<p class="text-green-600 text-sm">✓ Gratis ongkir</p>';
            }
        }
    }

    // ========================
    // 🔹 Checkout
    // ========================
    function checkout() {
        const deliveryOption = document.querySelector('input[name="delivery"]:checked')?.value || 'takeaway';

        fetch('{{ route('cart.checkout') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                delivery_option: deliveryOption
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success && data.snap_token) {
                // Redirect ke pembayaran Midtrans
                if (typeof snap !== 'undefined') {
                    snap.pay(data.snap_token, {
                        onSuccess: function(result) {
                            window.location.href = '/orders/' + data.order_id;
                        },
                        onPending: function(result) {
                            window.location.href = '/orders/' + data.order_id;
                        },
                        onError: function(result) {
                            showToast('Pembayaran gagal!', 'bg-red-500');
                        }
                    });
                } else {
                    // Fallback jika Snap.js tidak tersedia
                    window.location.href = '/cart/payment?snap_token=' + data.snap_token;
                }
            } else {
                showToast(data.message || 'Checkout gagal', 'bg-red-500');
            }
        })
        .catch(err => {
            console.error('Error checkout:', err);
            showToast('Terjadi kesalahan', 'bg-red-500');
        });
    }

    // ========================
    // 🔹 Update badge count
    // ========================
    function updateBadges(count) {
        const cartBadge = document.getElementById('cart-badge');
        if (cartBadge) {
            cartBadge.innerText = count;
            cartBadge.classList.toggle('hidden', count === 0);
        }
    }

    // ========================
    // 🔹 Update count dari server (saat load)
    // ========================
    function updateCartCount() {
        fetch('{{ route('cart.list') }}')
            .then(res => res.json())
            .then(data => {
                updateBadges(data.cart_count || 0);
                updateCartUI(
                    data.cart_total || 0,
                    data.discount_amount || 0,
                    data.delivery_fee || 0,
                    data.total_amount || 0,
                    data.promo_code || null
                );
                updateDeliveryInfo(data.cart_total || 0, data.delivery_fee || 0);
            })
            .catch(err => console.error('Gagal ambil cart list:', err));
    }

    // ========================
    // 🔹 Scroll to cart section
    // ========================
    function scrollToCart() {
        const cartSection = document.querySelector('.lg\\:col-span-1');
        if (cartSection) {
            cartSection.scrollIntoView({ 
                behavior: 'smooth',
                block: 'start'
            });
        }
    }

    // ========================
    // 🔹 Toast helper
    // ========================
    function showToast(message, color = 'bg-orange-500') {
        const toast = document.getElementById('toast');
        if (!toast) return;
        
        toast.textContent = message;
        toast.className = `fixed top-5 right-5 z-50 ${color} text-white px-6 py-3 rounded-lg shadow-lg transition-all duration-300`;
        toast.classList.remove('hidden');
        toast.style.opacity = 1;

        setTimeout(() => {
            toast.style.opacity = 0;
            setTimeout(() => toast.classList.add('hidden'), 300);
        }, 3000);
    }

    // ========================
    // 🔹 Toggle cart sidebar
    // ========================
    function toggleCartSidebar() {
        if (typeof Livewire !== 'undefined') {
            Livewire.dispatch('showCartSidebar');
        } else {
            console.warn('Livewire not loaded');
        }
    }

    function getLocationHero() {
        if (!navigator.geolocation) {
            alert("Browser Anda tidak mendukung Geolocation.");
            return;
        }

        navigator.geolocation.getCurrentPosition(async (pos) => {
            const lat = pos.coords.latitude;
            const lon = pos.coords.longitude;

            const addressBox = document.getElementById("user-address");
            addressBox.classList.remove("hidden");
            addressBox.innerText = "Mengambil alamat...";

            // Reverse Geocoding (pakai API Nominatim gratis)
            const url = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`;

            try {
                const res = await fetch(url);
                const data = await res.json();

                if (data.display_name) {
                    addressBox.innerText = data.display_name;
                } else {
                    addressBox.innerText = "Alamat tidak ditemukan.";
                }

                // SIMPAN ALAMAT DI SESSION via Livewire
                Livewire.dispatch('userLocationSelected', {
                    address: data.display_name,
                    lat: lat,
                    lon: lon
                });

            } catch (e) {
                addressBox.innerText = "Gagal memuat alamat.";
            }

        }, () => {
            alert("Izin lokasi ditolak.");
        });
    }
</script> -->



@endsection