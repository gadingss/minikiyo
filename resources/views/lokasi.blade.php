<!DOCTYPE html>
<html>
<head>
    <title>Lokasi Minikiyo</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: pulse 15s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
            font-weight: 700;
            position: relative;
            z-index: 1;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }

        .header p {
            font-size: 1.1em;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }

        .content {
            padding: 40px;
        }

        .info-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }

        .card-icon {
            font-size: 2em;
            margin-bottom: 10px;
        }

        .card h3 {
            color: #667eea;
            margin-bottom: 10px;
            font-size: 1.2em;
        }

        .card p {
            color: #555;
            line-height: 1.6;
        }

        #map {
            height: 500px;
            width: 100%;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            margin-bottom: 30px;
        }

        .map-controls {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 25px;
            font-size: 1em;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            background: white;
            color: #667eea;
            border: 2px solid #667eea;
        }

        .btn-secondary:hover {
            background: #667eea;
            color: white;
        }

        .footer {
            background: #f8f9fa;
            padding: 30px;
            text-align: center;
            color: #666;
        }

        .footer a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }

        .custom-popup .leaflet-popup-content-wrapper {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 10px;
        }

        .custom-popup .leaflet-popup-tip {
            background: #764ba2;
        }

        .popup-content {
            text-align: center;
            padding: 10px;
        }

        .popup-content h3 {
            margin-bottom: 10px;
            font-size: 1.3em;
        }

        @media (max-width: 768px) {
            .header h1 {
                font-size: 1.8em;
            }
            
            .content {
                padding: 20px;
            }
            
            #map {
                height: 350px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>🏪 Lokasi Outlet Minikiyo</h1>
        <p>Temukan kami di peta dan kunjungi outlet terdekat Anda!</p>
    </div>

    <div class="content">
        <div class="info-cards">
            <div class="card">
                <div class="card-icon">📍</div>
                <h3>Lokasi Strategis</h3>
                <p>Outlet kami berada di lokasi yang mudah dijangkau dengan akses transportasi yang baik</p>
            </div>
            <div class="card">
                <div class="card-icon">⏰</div>
                <h3>Buka Setiap Hari</h3>
                <p>Senin - Minggu<br>09:00 - 21:00 WIB</p>
            </div>
            <div class="card">
                <div class="card-icon">🎯</div>
                <h3>Mudah Ditemukan</h3>
                <p>Gunakan GPS atau aplikasi maps favorit Anda untuk navigasi langsung</p>
            </div>
        </div>

        <div class="map-controls">
            <button class="btn btn-primary" onclick="openGoogleMaps()">📱 Buka di Google Maps</button>
            <button class="btn btn-secondary" onclick="resetMapView()">🔄 Reset View</button>
            <button class="btn btn-secondary" onclick="toggleSatellite()">🛰️ Satelit</button>
        </div>

        <div id="map"></div>
    </div>

    <div class="footer">
        <p>© 2024 Minikiyo. Semua hak dilindungi.</p>
        <p>Butuh bantuan? Hubungi kami di <a href="tel:+62">+62 xxx-xxxx-xxxx</a> atau <a href="mailto:info@minikiyo.com">info@minikiyo.com</a></p>
    </div>
</div>

<script>
    // Koordinat default (ganti dengan {{ $lat }}, {{ $lng }} di Laravel)
    var lat = -7.8333;
    var lng = 112.0;
    
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

    // Custom icon untuk marker
    var customIcon = L.divIcon({
        className: 'custom-marker',
        html: '<div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); width: 40px; height: 40px; border-radius: 50% 50% 50% 0; transform: rotate(-45deg); box-shadow: 0 5px 15px rgba(0,0,0,0.3); display: flex; align-items: center; justify-content: center;"><span style="transform: rotate(45deg); font-size: 20px;">🏪</span></div>',
        iconSize: [40, 40],
        iconAnchor: [20, 40]
    });

    var marker = L.marker([lat, lng], {icon: customIcon}).addTo(map);

    var popupContent = `
        <div class="popup-content">
            <h3>🏪 Outlet Minikiyo</h3>
            <p>Kunjungi kami sekarang!</p>
            <button onclick="openGoogleMaps()" style="margin-top: 10px; padding: 8px 15px; background: white; color: #667eea; border: none; border-radius: 20px; cursor: pointer; font-weight: 600;">Navigasi</button>
        </div>
    `;

    marker.bindPopup(popupContent, {
        className: 'custom-popup'
    }).openPopup();

    // Tambahkan circle untuk radius area
    var circle = L.circle([lat, lng], {
        color: '#667eea',
        fillColor: '#667eea',
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

</body>
</html>