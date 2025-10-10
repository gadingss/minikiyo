<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset
            <!-- Page Content -->
            <main>
                @yield('content')
            </main>
        </div>
    </body>
    <script>
    function showCartModal() {
        fetch('{{ route('cart.list') }}')
            .then(res => res.json())
            .then(data => {
                const cartItemsContainer = document.getElementById('cart-items');
                const totalEl = document.getElementById('cart-modal-total');
                
                if (Object.keys(data.cart).length === 0) {
                    cartItemsContainer.innerHTML = `<p class="text-center text-gray-500">Keranjang masih kosong</p>`;
                    totalEl.innerText = 'Rp 0';
                } else {
                    cartItemsContainer.innerHTML = Object.values(data.cart).map(item => `
                        <div class="flex justify-between items-center border-b py-2">
                            <div>
                                <p class="font-semibold">${item.name}</p>
                                <p class="text-sm text-gray-500">Qty: ${item.quantity}</p>
                            </div>
                            <div class="text-right">
                                <p>Rp ${(item.unit_price * item.quantity).toLocaleString('id-ID')}</p>
                            </div>
                        </div>
                    `).join('');
                    totalEl.innerText = 'Rp ' + data.total.toLocaleString('id-ID');
                }

                const modal = document.getElementById('cart-modal');
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            })
            .catch(err => console.error(err));
    }

    function hideCartModal() {
        const modal = document.getElementById('cart-modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
    </script>
</html>
