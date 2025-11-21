const { isLoggedIn, menuData, routes, csrf } = window.appData;
let cart = [];
let currentCategory = 'all';

document.addEventListener('DOMContentLoaded', function() {
    loadMenuItems();
    updateCartCount();
});

// === Load menu items per kategori ===
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
                        <span class="text-xl font-bold text-orange-500">
                            Rp ${(item.price).toLocaleString('id-ID')}
                        </span>
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

// === Filter kategori ===
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

// === Pencarian menu ===
function searchMenu() {
    const searchTerm = document.getElementById('search-menu').value;
    loadMenuItems(currentCategory, searchTerm);
}

// === Tambah ke keranjang ===
function addToCart(id, category) {
    if (!isLoggedIn) {
        showToast('Silakan login terlebih dahulu untuk menambah pesanan.', 'bg-red-500');
        setTimeout(() => window.location.href = routes.login, 1500);
        return;
    }

    const item = Object.values(menuData).flat().find(m => m.id === id);
    if (!item) return console.error('Item tidak ditemukan:', id);

    fetch(routes.add, {
        method: 'POST',
        credentials: 'include',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrf
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
        updateCartBadge(data.cart_count);
        setTimeout(updateCartModal, 300);
    })
    .catch(err => console.error(err));
}

function updateCartBadge(count) {
    const cartBadge = document.getElementById('cart-count');
    const floatingBadge = document.getElementById('floating-cart-count');
    cartBadge.innerText = count;
    floatingBadge.innerText = count;

    if (count > 0) {
        cartBadge.classList.remove('hidden');
        floatingBadge.classList.remove('hidden');
    } else {
        cartBadge.classList.add('hidden');
        floatingBadge.classList.add('hidden');
    }
}

// === Tampilkan modal keranjang ===
function showCartModal() {
    fetch(routes.list)
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
            document.getElementById('cart-modal').classList.replace('hidden', 'flex');
        })
        .catch(err => console.error(err));
}

function hideCartModal() {
    const modal = document.getElementById('cart-modal');
    modal.classList.remove('flex');
    modal.classList.add('hidden');
}

function updateCartModal() {
    fetch(routes.html)
        .then(res => res.json())
        .then(data => {
            document.getElementById('cart-items').innerHTML = data.html;
            document.getElementById('cart-modal-total').innerText =
                'Rp ' + data.cart_total.toLocaleString('id-ID');
            updateCartBadge(data.cart_count);
        })
        .catch(err => console.error('Gagal update modal:', err));
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
    fetch(routes.list)
        .then(res => res.json())
        .then(data => {
            const count = data.length || 0;
            document.getElementById('floating-cart-count').innerText = count;
            const cartCount = document.getElementById('cart-count');
            if (cartCount) cartCount.innerText = count;
        })
        .catch(err => console.error('Gagal ambil cart list:', err));
}
