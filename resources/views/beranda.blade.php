@extends('layouts.app')
@section('content')
    <!-- Hero Section -->
    <section class="hero-bg relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div class="text-white space-y-6">
                    <h1 class="text-5xl lg:text-6xl font-bold leading-tight">
                        Feast Your Senses,<br>
                        <span class="text-yellow-300">Fast and Fresh</span>
                    </h1>
                    <p class="text-xl opacity-90">Enter a fresh new world of delicious food and great experiences!</p>
                    
                    <!-- Search Bar -->
                    <div class="flex bg-white rounded-full p-2 max-w-md">
                        <input type="text" placeholder="Cari Cita Rasa..." class="flex-1 px-4 py-2 text-gray-700 bg-transparent outline-none">
                        <button class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-full font-medium transition-colors">
                            Search
                        </button>
                    </div>
                </div>

                <!-- Right Content - Floating Elements -->
                <div class="relative">
                    <div class="floating-animation">
                        <img src="data:image/svg+xml,%3Csvg width='300' height='300' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='150' cy='150' r='100' fill='%23d97706' opacity='0.3'/%3E%3Ctext x='150' y='150' font-family='Arial' font-size='20' text-anchor='middle' dy='7' fill='white'%3EWonton Bowl%3C/text%3E%3C/svg%3E" alt="Wonton Bowl" class="w-64 h-64 mx-auto">
                    </div>
                    
                    <!-- Notification Cards -->
                    <div class="absolute top-10 right-0 notification-popup">
                        <div class="bg-white rounded-lg p-4 shadow-lg max-w-xs">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center">
                                    <i class="fas fa-utensils text-white text-xs"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900 text-sm">Minikiyo Wonton</p>
                                    <p class="text-xs text-gray-500">We delivered your order</p>
                                    <p class="text-xs text-gray-400">Tracking your order now</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="absolute bottom-20 left-0 notification-popup" style="animation-delay: 0.5s;">
                        <div class="bg-white rounded-lg p-4 shadow-lg max-w-xs">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                    <i class="fas fa-check text-white text-xs"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900 text-sm">Minikiyo Wonton</p>
                                    <p class="text-xs text-gray-500">Your order is waiting for you</p>
                                    <p class="text-xs text-gray-400">Pick it up now, Don't - get cold!</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Discount Section -->
    <!-- Discount Section -->
    <section class="py-8 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">
                Diskon Hingga <span class="gradient-text">-40%</span> 🔥 Penawaran Eksklusif Minikiyo Wonton
            </h2>

            <!-- Scrollable container -->
            <div class="flex gap-6 overflow-x-auto pb-4 scrollbar-hide snap-x snap-mandatory">
                
                <!-- Dimsum Mentai -->
                <div class="flex-none w-80 snap-center bg-white rounded-2xl overflow-hidden shadow-lg relative">
                    <div class="absolute top-4 left-4 bg-orange-500 text-white px-3 py-1 rounded-full text-sm font-bold">-40%</div>
                    <img src="{{ asset('images/dimsum_mentai.jpg') }}" alt="Dimsum Mentai" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <span class="text-xs text-orange-500 font-medium">RESTORAN</span>
                        <h3 class="font-bold text-lg text-gray-900">Dimsum Mentai</h3>
                    </div>
                </div>

                <!-- Wonton -->
                <div class="flex-none w-80 snap-center bg-white rounded-2xl overflow-hidden shadow-lg relative">
                    <div class="absolute top-4 left-4 bg-orange-500 text-white px-3 py-1 rounded-full text-sm font-bold">-35%</div>
                    <img src="{{ asset('images/wonton.jpg') }}" alt="Wonton" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <span class="text-xs text-orange-500 font-medium">RESTORAN</span>
                        <h3 class="font-bold text-lg text-gray-900">Wonton</h3>
                    </div>
                </div>

                <!-- Dimsum Goreng -->
                <div class="flex-none w-80 snap-center bg-white rounded-2xl overflow-hidden shadow-lg relative">
                    <div class="absolute top-4 left-4 bg-orange-500 text-white px-3 py-1 rounded-full text-sm font-bold">-17%</div>
                    <img src="{{ asset('images/dimsum_goreng.jpg') }}" alt="Dimsum Goreng" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <span class="text-xs text-orange-500 font-medium">RESTORAN</span>
                        <h3 class="font-bold text-lg text-gray-900">Dimsum Goreng</h3>
                    </div>
                </div>

                <div class="flex-none w-80 snap-center bg-white rounded-2xl overflow-hidden shadow-lg relative">
                    <div class="absolute top-4 left-4 bg-orange-500 text-white px-3 py-1 rounded-full text-sm font-bold">-17%</div>
                    <img src="{{ asset('images/dimsum_goreng.jpg') }}" alt="Dimsum Goreng" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <span class="text-xs text-orange-500 font-medium">RESTORAN</span>
                        <h3 class="font-bold text-lg text-gray-900">Dimsum Goreng</h3>
                    </div>
                </div>
                <div class="flex-none w-80 snap-center bg-white rounded-2xl overflow-hidden shadow-lg relative">
                    <div class="absolute top-4 left-4 bg-orange-500 text-white px-3 py-1 rounded-full text-sm font-bold">-17%</div>
                    <img src="{{ asset('images/dimsum_goreng.jpg') }}" alt="Dimsum Goreng" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <span class="text-xs text-orange-500 font-medium">RESTORAN</span>
                        <h3 class="font-bold text-lg text-gray-900">Dimsum Goreng</h3>
                    </div>
                </div>

                <!-- Tambahkan produk lain di sini -->
            </div>
        </div>
    </section>

    <!-- Hapus scrollbar untuk tampilan lebih clean -->
    <style>
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    </style>


    <!-- Popular Menu Section -->
    <section id="menu" class="py-12 bg-gray-50 scroll-mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">
                Kategori Populer <span class="text-orange-500">Minikiyo Wonton</span> 😋
            </h2>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mt-8">
                <!-- Dimsum Mental -->
                <div class="card-hover bg-white rounded-xl p-4 text-center shadow-sm">
                    <img src="{{ asset('images/dimsum_mentai.jpg') }}" alt="Dimsum Mentai" class="w-full h-48 object-cover">
                    <h3 class="font-semibold text-sm text-gray-900">Dimsum Mentai</h3>
                    <p class="text-xs text-gray-500">6 preparations</p>
                </div>

                <!-- Wonton Kukas -->
                <div class="card-hover bg-white rounded-xl p-4 text-center shadow-sm">
                    <img src="{{ asset('images/wonton_kukus.jpg') }}" alt="Wonton Kukus" class="w-full h-48 object-cover">
                    <h3 class="font-semibold text-sm text-gray-900">Wonton Kukus</h3>
                    <p class="text-xs text-gray-500">3 preparations</p>
                </div>

                <!-- Dimsum Keju -->
                <div class="card-hover bg-white rounded-xl p-4 text-center shadow-sm">
                    <img src="{{ asset('images/dimsum_keju.jpg') }}" alt="Dimsum Keju" class="w-full h-48 object-cover">
                    <p class="text-xs text-gray-500">4 preparations</p>
                </div>

                <!-- Dimsum Goreng Keju -->
                <div class="card-hover bg-white rounded-xl p-4 text-center shadow-sm">
                    <img src="{{ asset('images/dimsum_goreng.jpg') }}" alt="Dimsum Goreng Keju" class="w-full h-48 object-cover">
                    <h3 class="font-semibold text-sm text-gray-900">Dimsum Goreng Keju</h3>
                    <p class="text-xs text-gray-500">2 preparations</p>
                </div>

                <!-- Dimsum Mix Premium -->
                <div class="card-hover bg-white rounded-xl p-4 text-center shadow-sm">
                    <img src="{{ asset('images/dimsum_mix_premium.jpg') }}" alt="Dimsum Mix Premium" class="w-full h-48 object-cover">
                    <h3 class="font-semibold text-sm text-gray-900">Dimsum Mix Premium</h3>
                    <p class="text-xs text-gray-500">5 preparations</p>
                </div>

                <!-- Chili Oil -->
                <div class="card-hover bg-white rounded-xl p-4 text-center shadow-sm">
                    <img src="{{ asset('images/chili_oil.jpg') }}" alt="Chili Oil" class="w-full h-48 object-cover">
                    <h3 class="font-semibold text-sm text-gray-900">Chili Oil</h3>
                    <p class="text-xs text-gray-500">1 preparation</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Partnership Section -->
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-8">
                <!-- Earn more with lower fees -->
                <div class="bg-gray-900 rounded-2xl p-8 text-white relative overflow-hidden">
                    <div class="relative z-10">
                        <p class="text-orange-400 text-sm font-medium mb-2">Signup to get business</p>
                        <h3 class="text-3xl font-bold mb-4">Partner with us</h3>
                        <button class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                            Get Started
                        </button>
                    </div>
                    <div class="absolute right-0 top-0 h-full w-1/2 opacity-20">
                        <img src="data:image/svg+xml,%3Csvg width='200' height='200' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='100' cy='100' r='80' fill='%23f59e0b' opacity='0.3'/%3E%3Ctext x='100' y='100' font-family='Arial' font-size='16' text-anchor='middle' dy='7' fill='white'%3EChef%3C/text%3E%3C/svg%3E" alt="Chef" class="h-full object-cover">
                    </div>
                </div>

                <!-- Avail exclusive perks -->
                <div class="bg-yellow-400 rounded-2xl p-8 text-gray-900 relative overflow-hidden">
                    <div class="relative z-10">
                        <p class="text-gray-700 text-sm font-medium mb-2">Avail exclusive perks</p>
                        <h3 class="text-3xl font-bold mb-4">Ride with us</h3>
                        <button class="bg-gray-900 hover:bg-gray-800 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                            Get Started
                        </button>
                    </div>
                    <div class="absolute right-0 top-0 h-full w-1/2 opacity-20">
                        <img src="data:image/svg+xml,%3Csvg width='200' height='200' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='100' cy='100' r='80' fill='%23dc2626' opacity='0.3'/%3E%3Ctext x='100' y='100' font-family='Arial' font-size='16' text-anchor='middle' dy='7' fill='white'%3EDelivery%3C/text%3E%3C/svg%3E" alt="Delivery" class="h-full object-cover">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="py-12 bg-pink-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Pelajari lebih lanjut tentang kami!</h2>
                <div class="flex flex-wrap justify-center gap-6 text-sm">
                    <a href="#" class="text-gray-600 hover:text-orange-500">Pertanyaan Sering</a>
                    <a href="#" class="text-gray-600 hover:text-orange-500">Status Kontr</a>
                    <a href="#" class="text-gray-600 hover:text-orange-500">Program Kemitraan</a>
                    <a href="#" class="text-gray-600 hover:text-orange-500">Berkarir & Hubungan</a>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-8">
                <div class="grid md:grid-cols-3 gap-8 text-center">
                    <!-- Feature 1 -->
                    <div>
                        <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <img src="data:image/svg+xml,%3Csvg width='40' height='40' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='20' cy='20' r='15' fill='%23f59e0b'/%3E%3Ctext x='20' y='20' font-family='Arial' font-size='8' text-anchor='middle' dy='3' fill='white'%3E🍜%3C/text%3E%3C/svg%3E" alt="Food">
                        </div>
                        <h3 class="font-bold text-lg text-gray-900 mb-2">Pesan Makanan!</h3>
                        <p class="text-gray-600 text-sm">Pesan makanan website favorit dari restoran terdekat</p>
                    </div>

                    <!-- Feature 2 -->
                    <div>
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <img src="data:image/svg+xml,%3Csvg width='40' height='40' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='20' cy='20' r='15' fill='%233b82f6'/%3E%3Ctext x='20' y='20' font-family='Arial' font-size='8' text-anchor='middle' dy='3' fill='white'%3E🚀%3C/text%3E%3C/svg%3E" alt="Delivery">
                        </div>
                        <h3 class="font-bold text-lg text-gray-900 mb-2">Lacak Progress Pesanan!</h3>
                        <p class="text-gray-600 text-sm">Lacak status pada setiap pesanan! Estimasi pesanan waktu!</p>
                    </div>

                    <!-- Feature 3 -->
                    <div>
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <img src="data:image/svg+xml,%3Csvg width='40' height='40' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='20' cy='20' r='15' fill='%2310b981'/%3E%3Ctext x='20' y='20' font-family='Arial' font-size='8' text-anchor='middle' dy='3' fill='white'%3E✅%3C/text%3E%3C/svg%3E" alt="Confirm">
                        </div>
                        <h3 class="font-bold text-lg text-gray-900 mb-2">Terima Pesanan!</h3>
                        <p class="text-gray-600 text-sm">Terima pesanan dengan cepat!</p>
                    </div>
                </div>

                <div class="text-center mt-8">
                    <div class="bg-orange-500 text-white px-6 py-3 rounded-lg inline-block">
                        <p class="font-medium">Bagaimana cara kerja Minikiyo Wonton?</p>
                    </div>
                    <p class="text-gray-600 mt-4 max-w-3xl mx-auto">
                        Order Lift memeperluas jangkauan pemesanan makanan, online menu dengan bergabung film Hubungan favorit, kami bagi rapi yang produk pemasaran berkaitan karya ada stok oleh nama Anda sehingga berbagai pemasaran barang dan melakukan keahlian online dengan sempurna raya.
                    </p>
                    <p class="text-gray-600 mt-2">
                        Akini dapat dengan berterima masak perkerja resep.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Info Section -->
    <section id="contact" class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Delivery Information -->
                <div>
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-truck mr-3 text-orange-500"></i>
                        Delivery Information
                    </h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Monday:</span>
                            <span>12:00 AM–3:00 AM, 8:00 AM–3:00 AM</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tuesday:</span>
                            <span>8:00 AM–3:00 AM</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Wednesday:</span>
                            <span>8:00 AM–3:00 AM</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Thursday:</span>
                            <span>8:00 AM–3:00 AM</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Friday:</span>
                            <span>8:00 AM–3:00 AM</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Saturday:</span>
                            <span>8:00 AM–3:00 AM</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Sunday:</span>
                            <span>8:00 AM–12:00 AM</span>
                        </div>
                        <div class="mt-4">
                            <span class="text-gray-600">Estimated time until delivery:</span>
                            <span class="font-medium">20 min</span>
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div>
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-phone mr-3 text-orange-500"></i>
                        Contact Information
                    </h3>
                    <div class="space-y-4 text-sm">
                        <p class="text-gray-600">If you have allergies or other dietary restrictions, please contact the restaurant. The restaurant will provide food-specific information upon request.</p>
                        <div>
                            <span class="text-gray-600">Phone number</span>
                            <p class="font-medium">+934443-43</p>
                        </div>
                        <div>
                            <span class="text-gray-600">Website</span>
                            <p class="font-medium text-orange-500">http://minikiyowonton.me/</p>
                        </div>
                    </div>
                </div>

                <!-- Operational Times -->
                <div class="bg-gray-900 text-white p-6 rounded-2xl">
                    <h3 class="text-xl font-bold mb-6 flex items-center">
                        <i class="fas fa-clock mr-3 text-orange-500"></i>
                        Operational Times
                    </h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-300">Monday:</span>
                            <span>8:00 AM–3:00 AM</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-300">Tuesday:</span>
                            <span>8:00 AM–3:00 AM</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-300">Wednesday:</span>
                            <span>8:00 AM–3:00 AM</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-300">Thursday:</span>
                            <span>8:00 AM–3:00 AM</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-300">Friday:</span>
                            <span>8:00 AM–3:00 AM</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-300">Saturday:</span>
                            <span>8:00 AM–3:00 AM</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-300">Sunday:</span>
                            <span>8:00 AM–12:00 AM</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-3 gap-8 items-center">
                <!-- Restaurant Info Card -->
                <div class="bg-gray-900 text-white p-6 rounded-2xl">
                    <h3 class="text-2xl font-bold mb-2">Minikiyo Wonton</h3>
                    <p class="text-orange-400 mb-4">Fast food</p>
                    
                    <div class="space-y-3 text-sm">
                        <div>
                            <span class="text-gray-400">Gudah Kediri Jawa Timur</span>
                        </div>
                        <div>
                            <span class="text-gray-400">Phone number</span>
                            <p class="text-white font-medium">+934443-43</p>
                        </div>
                        <div>
                            <span class="text-gray-400">Website</span>
                            <p class="text-orange-400">http://minikiyowonton.me/</p>
                        </div>
                    </div>
                </div>

                <!-- Map Placeholder -->
                <div class="lg:col-span-2 bg-gray-200 rounded-2xl h-80 flex items-center justify-center relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-orange-400 to-orange-600 opacity-20"></div>
                    <div class="text-center z-10">
                        <i class="fas fa-map-marker-alt text-6xl text-orange-500 mb-4"></i>
                        <h4 class="text-xl font-bold text-gray-700">Minikiyo Wonton</h4>
                        <p class="text-gray-600">Karangjasa, Ngaliyan Kecit</p>
                        <p class="text-gray-600">Fast food</p>
                    </div>
                    
                    <!-- Map markers -->
                    <div class="absolute top-8 left-8 w-4 h-4 bg-red-500 rounded-full animate-pulse"></div>
                    <div class="absolute bottom-12 right-12 w-3 h-3 bg-blue-500 rounded-full"></div>
                    <div class="absolute top-16 right-8 w-2 h-2 bg-green-500 rounded-full"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Customer Reviews -->
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-3xl font-bold text-gray-900">Customer Reviews</h2>
                <div class="flex space-x-2">
                    <button class="w-10 h-10 bg-orange-500 text-white rounded-full flex items-center justify-center hover:bg-orange-600 transition-colors">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="w-10 h-10 bg-orange-500 text-white rounded-full flex items-center justify-center hover:bg-orange-600 transition-colors">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                <!-- Review 1 -->
                <div class="bg-gray-50 p-6 rounded-2xl">
                    <div class="flex items-center mb-4">
                        <img src="data:image/svg+xml,%3Csvg width='48' height='48' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='24' cy='24' r='20' fill='%23f59e0b'/%3E%3Ctext x='24' y='24' font-family='Arial' font-size='12' text-anchor='middle' dy='4' fill='white'%3ESG%3C/text%3E%3C/svg%3E" alt="St Glx" class="w-12 h-12 rounded-full mr-3">
                        <div>
                            <h4 class="font-semibold text-gray-900">St Glx</h4>
                            <p class="text-sm text-gray-500">South Kelapa</p>
                        </div>
                    </div>
                    <div class="flex text-yellow-400 mb-3">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <span class="ml-2 text-sm text-gray-600">24th September, 2023</span>
                    </div>
                    <p class="text-gray-700 text-sm">The positive aspect was undoubtedly the efficiency of the service. The space moved quickly, the staff was friendly, and the food was up to the usual McDonald's standards – not one admiring.</p>
                </div>

                <!-- Review 2 -->
                <div class="bg-gray-50 p-6 rounded-2xl">
                    <div class="flex items-center mb-4">
                        <img src="data:image/svg+xml,%3Csvg width='48' height='48' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='24' cy='24' r='20' fill='%23d97706'/%3E%3Ctext x='24' y='24' font-family='Arial' font-size='12' text-anchor='middle' dy='4' fill='white'%3ESG%3C/text%3E%3C/svg%3E" alt="St Glx" class="w-12 h-12 rounded-full mr-3">
                        <div>
                            <h4 class="font-semibold text-gray-900">St Glx</h4>
                            <p class="text-sm text-gray-500">South Kelapa</p>
                        </div>
                    </div>
                    <div class="flex text-yellow-400 mb-3">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <span class="ml-2 text-sm text-gray-600">24th September, 2023</span>
                    </div>
                    <p class="text-gray-700 text-sm">The positive aspect was undoubtedly the efficiency of the service. The space moved quickly, the staff was friendly, and the food was up to the usual McDonald's standards – not one admiring.</p>
                </div>

                <!-- Review 3 -->
                <div class="bg-gray-50 p-6 rounded-2xl">
                    <div class="flex items-center mb-4">
                        <img src="data:image/svg+xml,%3Csvg width='48' height='48' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='24' cy='24' r='20' fill='%23dc2626'/%3E%3Ctext x='24' y='24' font-family='Arial' font-size='12' text-anchor='middle' dy='4' fill='white'%3ESG%3C/text%3E%3C/svg%3E" alt="St Glx" class="w-12 h-12 rounded-full mr-3">
                        <div>
                            <h4 class="font-semibold text-gray-900">St Glx</h4>
                            <p class="text-sm text-gray-500">South Kelapa</p>
                        </div>
                    </div>
                    <div class="flex text-yellow-400 mb-3">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <span class="ml-2 text-sm text-gray-600">24th September, 2023</span>
                    </div>
                    <p class="text-gray-700 text-sm">The positive aspect was undoubtedly the efficiency of the service. The space moved quickly, the staff was friendly, and the food was up to the usual McDonald's standards – not one admiring.</p>
                </div>
            </div>

            <!-- Rating Summary -->
            <div class="text-center mt-12">
                <div class="text-6xl font-bold text-gray-900 mb-2">3.4</div>
                <div class="flex justify-center text-yellow-400 text-2xl mb-2">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star text-gray-300"></i>
                </div>
                <p class="text-gray-600">1,360 reviews</p>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Newsletter -->
                <div>
                    <h3 class="font-bold text-xl text-gray-900 mb-4">Dapatkan Penawaran Eksklusif di Email Anda</h3>
                    <div class="flex">
                        <input type="email" placeholder="youremail@gmail.com" class="flex-1 px-4 py-3 rounded-l-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-500">
                        <button class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-r-lg font-medium transition-colors">
                            Subscribe
                        </button>
                    </div>
                    <p class="text-sm text-gray-600 mt-2">Kami tidak akan spam, hanya memberikan email terbaik</p>
                </div>

                <!-- Legal Pages -->
                <div>
                    <h4 class="font-semibold text-gray-900 mb-4">Legal Pages</h4>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li><a href="#" class="hover:text-orange-500">Terms and conditions</a></li>
                        <li><a href="#" class="hover:text-orange-500">Privacy</a></li>
                    </ul>
                </div>

                <!-- Important Links -->
                <div>
                    <h4 class="font-semibold text-gray-900 mb-4">Important Links</h4>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li><a href="#" class="hover:text-orange-500">Add your restaurant</a></li>
                        <li><a href="#" class="hover:text-orange-500">Join a Courier</a></li>
                        <li><a href="#" class="hover:text-orange-500">Online customer service</a></li>
                    </ul>
                </div>
            </div>

            <!-- Social Media -->
            <div class="flex justify-center space-x-4 mt-8">
                <a href="#" class="w-10 h-10 bg-gray-700 hover:bg-orange-500 text-white rounded-full flex items-center justify-center transition-colors">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" class="w-10 h-10 bg-gray-700 hover:bg-orange-500 text-white rounded-full flex items-center justify-center transition-colors">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="#" class="w-10 h-10 bg-gray-700 hover:bg-orange-500 text-white rounded-full flex items-center justify-center transition-colors">
                    <i class="fab fa-twitter"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-orange-500 text-white py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center text-sm">
                <p>Copyright © 2024, Summa Uni Teknologi</p>
                <div class="flex space-x-6 mt-2 md:mt-0">
                    <span>Kebijakan Privasi</span>
                    <span>Syarat</span>
                    <span>Hukum</span>
                    <span>dengan situs Anda bagian informasi perusahaan privasi harga</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Mobile Menu Button (Hidden by default, would be shown on mobile) -->
    <div class="fixed bottom-4 right-4 lg:hidden">
        <button class="bg-orange-500 hover:bg-orange-600 text-white w-14 h-14 rounded-full shadow-lg flex items-center justify-center transition-colors">
            <i class="fas fa-bars text-xl"></i>
        </button>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const scrollContainer = document.getElementById('discountScroll');
            let scrollAmount = 0;
            let scrollDirection = 1; // 1 = kanan, -1 = kiri

            function autoScroll() {
                if (!scrollContainer) return;

                scrollContainer.scrollLeft += scrollDirection;

                // Jika sudah sampai ujung kanan
                if (scrollContainer.scrollLeft + scrollContainer.clientWidth >= scrollContainer.scrollWidth) {
                    scrollDirection = -1;
                }
                // Jika sudah sampai ujung kiri
                else if (scrollContainer.scrollLeft <= 0) {
                    scrollDirection = 1;
                }
            }

            // Jalankan setiap 30ms untuk efek halus
            let interval = setInterval(autoScroll, 30);

            // Hentikan auto scroll saat user interaksi manual
            scrollContainer.addEventListener('mouseenter', () => clearInterval(interval));
            scrollContainer.addEventListener('mouseleave', () => interval = setInterval(autoScroll, 30));
            scrollContainer.addEventListener('touchstart', () => clearInterval(interval));
            scrollContainer.addEventListener('touchend', () => interval = setInterval(autoScroll, 30));
        });
    </script>
@endsection