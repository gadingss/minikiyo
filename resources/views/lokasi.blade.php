@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<style>
    .custom-popup .leaflet-popup-content-wrapper {
        background: linear-gradient(135deg, #ef4444 0%, #f97316 100%);
        color: white;
        border-radius: 15px;
        padding: 10px;
    }

    .custom-popup .leaflet-popup-tip {
        background: #f97316;
    }

    .popup-content {
        text-align: center;
        padding: 10px;
    }

    .popup-content h3 {
        margin-bottom: 10px;
        font-size: 1.3em;
    }
</style>

<div class="min-h-screen bg-gradient-to-br from-orange-50 via-red-50 to-yellow-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center space-x-3 mb-4">
                <div class="h-16 w-16 bg-gradient-to-br from-red-500 to-orange-500 rounded-full flex items-center justify-center shadow-lg">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
            </div>
            <h1 class="text-4xl font-extrabold text-gray-900 sm:text-5xl">
                Lokasi Outlet Minikiyo
            </h1>
            <p class="mt-4 text-xl text-gray-600">
                Temukan kami di peta dan kunjungi outlet terdekat Anda!
            </p>
        </div>

        <!-- Info Cards -->
        <div class="grid md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-2xl shadow-lg p-6 transform hover:scale-105 transition duration-200">
                <div class="flex items-center space-x-4">
                    <div class="h-12 w-12 bg-red-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-gray-900">Lokasi Strategis</h3>
                        <p class="text-sm text-gray-600 mt-1">Mudah dijangkau dengan akses transportasi yang baik</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6 transform hover:scale-105 transition duration-200">
                <div class="flex items-center space-x-4">
                    <div class="h-12 w-12 bg-orange-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="h-6 w-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-gray-900">Buka Setiap Hari</h3>
                        <p class="text-sm text-gray-600 mt-1">Senin - Minggu<br>09:00 - 21:00 WIB</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6 transform hover:scale-105 transition duration-200">
                <div class="flex items-center space-x-4">
                    <div class="h-12 w-12 bg-yellow-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-gray-900">Mudah Ditemukan</h3>
                        <p class="text-sm text-gray-600 mt-1">Gunakan GPS atau aplikasi maps favorit Anda</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Map Container -->
        <div class="bg-white rounded-2xl shadow-xl p-6 md:p-8">
            <!-- Map Controls -->
            <div class="flex flex-wrap gap-3 mb-6">
                <button onclick="openGoogleMaps()" 
                        class="flex items-center space-x-2 px-6 py-3 bg-gradient-to-r from-red-500 to-orange-500 text-white rounded-xl font-semibold hover:from-red-600 hover:to-orange-600 transition duration-200 transform hover:scale-105 shadow-lg">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                    </svg>
                    <span>Buka di Google Maps</span>
                </button>
                
                <button onclick="resetMapView()" 
                        class="flex items-center space-x-2 px-6 py-3 bg-white text-red-600 border-2 border-red-600 rounded-xl font-semibold hover:bg-red-50 transition duration-200">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    <span>Reset View</span>
                </button>
                
                <button onclick="toggleSatellite()" 
                        class="flex items-center space-x-2 px-6 py-3 bg-white text-gray-700 border-2 border-gray-300 rounded-xl font-semibold hover:bg-gray-50 transition duration-200">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Satelit</span>
                </button>
            </div>

            <!-- Map -->
            <div id="map" class="w-full h-96 md:h-[500px] rounded-xl shadow-inner"></div>

            <!-- Address Info -->
            <div class="mt-6 p-6 bg-gradient-to-r from-red-50 to-orange-50 rounded-xl border-2 border-red-100">
                <div class="flex items-start space-x-4">
                    <div class="h-10 w-10 bg-red-500 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Alamat Lengkap</h3>
                        <p class="text-gray-700 leading-relaxed">
                            Jl. Dimsum Raya No. 123<br>
                            Kecamatan Kota, Kediri<br>
                            Jawa Timur 64123
                        </p>
                        <div class="mt-4 flex flex-wrap gap-3">
                            <a href="tel:+6285736508439" 
                               class="inline-flex items-center space-x-2 text-red-600 hover:text-red-700 font-semibold">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                <span>+62 857-3650-8439</span>
                            </a>
                            <span class="text-gray-400">|</span>
                            <a href="mailto:info@minikiyo.com" 
                               class="inline-flex items-center space-x-2 text-red-600 hover:text-red-700 font-semibold">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <span>info@minikiyo.com</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Koordinat default (ganti dengan {{ $lat ?? -7.8333 }}, {{ $lng ?? 112.0 }} di Laravel)
    var lat = {{ $lat ?? -7.8333 }};
    var lng = {{ $lng ?? 112.0 }};
    
    var map = L.map('map').setView([lat, lng], 16);
    var currentLayer = 'street';

    var streetLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    var satelliteLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        maxZoom: 19,
        attribution: '© Esri'
    });

    // Custom icon untuk marker dengan tema Minikiyo
    var customIcon = L.divIcon({
        className: 'custom-marker',
        html: '<div style="background: linear-gradient(135deg, #ef4444 0%, #f97316 100%); width: 40px; height: 40px; border-radius: 50% 50% 50% 0; transform: rotate(-45deg); box-shadow: 0 5px 15px rgba(239, 68, 68, 0.4); display: flex; align-items: center; justify-content: center;"><span style="transform: rotate(45deg); font-size: 20px;">🥟</span></div>',
        iconSize: [40, 40],
        iconAnchor: [20, 40]
    });

    var marker = L.marker([lat, lng], {icon: customIcon}).addTo(map);

    var popupContent = `
        <div class="popup-content">
            <h3>🥟 Minikiyo Dimsum</h3>
            <p>Kunjungi outlet kami sekarang!</p>
            <button onclick="openGoogleMaps()" style="margin-top: 10px; padding: 8px 15px; background: white; color: #ef4444; border: none; border-radius: 20px; cursor: pointer; font-weight: 600; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">📍 Navigasi</button>
        </div>
    `;

    marker.bindPopup(popupContent, {
        className: 'custom-popup'
    }).openPopup();

    // Tambahkan circle untuk radius area dengan warna tema
    var circle = L.circle([lat, lng], {
        color: '#ef4444',
        fillColor: '#f97316',
        fillOpacity: 0.1,
        radius: 200
    }).addTo(map);

    function openGoogleMaps() {
        window.open(`https://www.google.com/maps/search/?api=1&query=${lat},${lng}`, '_blank');
    }

    function resetMapView() {
        map.setView([lat, lng], 16);
    }

    function toggleSatellite() {
        if (currentLayer === 'street') {
            map.removeLayer(streetLayer);
            map.addLayer(satelliteLayer);
            currentLayer = 'satellite';
        } else {
            map.removeLayer(satelliteLayer);
            map.addLayer(streetLayer);
            currentLayer = 'street';
        }
    }

    // Animasi marker bounce
    setTimeout(() => {
        marker.setLatLng([lat, lng]);
    }, 500);
</script>
@endsection