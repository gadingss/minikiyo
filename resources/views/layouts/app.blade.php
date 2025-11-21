<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/menu.css') }}">

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Livewire -->
    @livewireStyles
</head>

<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">
    
    @include('layouts.navigation')

    @isset($header)
        <header class="bg-white dark:bg-gray-800 shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endisset

    <main>
        @yield('content')
    </main>


    <!-- ============================= -->
    <!--   STATIC CART UI UPDATE JS   -->
    <!-- ============================= -->
    <script>
        function updateCartUI(subtotal, discount, deliveryFee, total, promoCode) {

            const elements = {
                subtotal: document.getElementById('static-cart-subtotal'),
                discount: document.getElementById('static-cart-discount'),
                discountRow: document.getElementById('discount-row'),
                delivery: document.getElementById('static-cart-delivery'),
                total: document.getElementById('static-cart-total')
            };

            if (elements.subtotal) {
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

            if (elements.delivery) {
                elements.delivery.textContent = `Rp ${deliveryFee.toLocaleString('id-ID')}`;
            }

            if (elements.total) {
                elements.total.textContent = `Rp ${total.toLocaleString('id-ID')}`;
            }
        }
    </script>


    <!-- =========================== -->
    <!--   LIVEWIRE GLOBAL EVENTS   -->
    <!-- =========================== -->
    @livewireScripts

    <script>
        document.addEventListener("DOMContentLoaded", () => {

            // -------------------------------------
            // LISTENER UNTUK UPDATE BADGE CART
            // -------------------------------------
            Livewire.on('updateCartBadge', (data) => {
                const badge = document.getElementById('cart-badge');
                if (!badge) return;

                const count = data.count ?? 0;

                badge.textContent = count;
                badge.classList.toggle('hidden', count === 0);
            });
        });
    </script>

</body>
</html>
