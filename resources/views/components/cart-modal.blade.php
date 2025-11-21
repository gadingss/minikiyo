<script>
    function showCartModal() {
        document.getElementById('cart-modal').classList.remove('hidden');
        document.getElementById('cart-modal').classList.add('flex');
    }
    function hideCartModal() {
        document.getElementById('cart-modal').classList.add('hidden');
        document.getElementById('cart-modal').classList.remove('flex');
    }

    document.getElementById('cart-items').addEventListener('click', function(e) {
        const id = e.target.dataset.id;
        if (!id) return;

        if (e.target.classList.contains('btn-increase')) {
            updateQty(id, 1);
        }
        if (e.target.classList.contains('btn-decrease')) {
            updateQty(id, -1);
        }
        if (e.target.classList.contains('btn-remove')) {
            removeItem(id);
        }
    });

    function removeItem(id) {
        fetch(`/cart/remove/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(res => res.json())
        .then(data => {
            // hapus item dari DOM
            const itemDiv = document.querySelector(`#cart-items [data-id='${id}']`);
            if (itemDiv) itemDiv.remove();

            // update total & cart icon
            document.getElementById('cart-total').innerText = formatRupiah(data.cart_total);
            document.getElementById('cart-modal-total').innerText = formatRupiah(data.cart_total);
            document.getElementById('cart-count').innerText = data.cart_count;

            if (data.cart_count <= 0) {
                document.getElementById('cart-count').classList.add('hidden');
                document.getElementById('cart-items').innerHTML = `<p class="text-center text-gray-500">Keranjang kosong.</p>`;
            }
        });
    }


    function updateQty(id, change) {
        const qtySpan = document.getElementById(`qty-${id}`);
        let newQty = parseInt(qtySpan.innerText) + change;

        if (newQty < 1) return; // jangan biarkan qty kurang dari 1

        fetch(`/cart/update/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ quantity: newQty })
        })
        .then(res => res.json())
        .then(data => {
            // update quantity & subtotal
            qtySpan.innerText = data.item_quantity;
            document.getElementById(`subtotal-${id}`).innerText = formatRupiah(data.item_subtotal);

            // update total & cart icon
            document.getElementById('cart-modal-total').innerText = formatRupiah(data.cart_total);
            document.getElementById('cart-total').innerText = formatRupiah(data.cart_total);
            document.getElementById('cart-count').innerText = data.cart_count;

            if (data.cart_count > 0) {
                document.getElementById('cart-count').classList.remove('hidden');
            } else {
                document.getElementById('cart-count').classList.add('hidden');
                // jika keranjang kosong, tampilkan pesan
                document.getElementById('cart-items').innerHTML = `<p class="text-center text-gray-500">Keranjang kosong.</p>`;
            }
        });
    }


    function formatRupiah(angka) {
        return 'Rp ' + angka.toLocaleString('id-ID');
    }
</script>