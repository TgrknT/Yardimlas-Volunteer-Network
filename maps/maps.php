<?php
include "../config.php";
session_start();

// Kullanıcı adı oturum değişkenini kontrol et
$username = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Anonim';

// Veritabanından kullanıcı adıyla eşleşen isim ve soyisim bilgisini çekme
$name = 'Anonim Kullanıcı';
if ($username !== 'Anonim') {
    try {
        // Kullanıcı adı ile eşleşen kayıtları seç
        $stmt = $db->prepare("SELECT name FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $name = htmlspecialchars($result['name']);
        }
    } catch (PDOException $e) {
        echo "Hata: " . $e->getMessage();
    }
}

// Sadece onaylanmış (approved) ihtiyaç verilerini çek
$needs = [];
try {
    $stmt = $db->prepare("SELECT id, ihtiyac AS title, latitude, longitude, aciklama AS content, il AS city 
                          FROM ihtiyackayitlari 
                          WHERE status = 'approved'"); // Sadece approved olan kayıtları çekiyoruz
    $stmt->execute();
    $needs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Hata: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yardımlaş</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAs8PxoTvmpRquHtBdLFUTenMFLQbEuJBI&callback=initMap" defer></script>
</head>
<body>
<?php
    include "../sidebar.php";
?>
    <div class="main-content">
        <div class="header">
            <form id="searchForm">
                <input type="text" id="searchInput" placeholder="ARAMA YAP">
                <button type="submit">Ara</button>
            </form>
        </div>
        <div id="map" style="height: 500px;"></div>
    </div>
</body>
</html>
<script>
function initMap() {
    var mapOptions = {
        center: { lat: 39.9334, lng: 32.8597 }, // Türkiye'nin merkezi (Ankara)
        zoom: 7,
        zoomControl: false, // Sadece büyütme kontrolünü etkinleştir
        mapTypeControl: false, // Harita tipi kontrolünü devre dışı bırak
        scaleControl: false, // Ölçek kontrolünü devre dışı bırak
        streetViewControl: false, // Street View kontrolünü devre dışı bırak
        rotateControl: false, // Döndürme kontrolünü devre dışı bırak
        fullscreenControl: true,
        mapTypeControlOptions: {
            mapTypeIds: ['roadmap', 'satellite', 'hybrid', 'terrain', 'styled_map']
        },
        restriction: {
            latLngBounds: {
                north: 43,
                south: 34,
                west: 24,
                east: 45
            },
            strictBounds: true
        } // Tam ekran kontrolünü devre dışı bırak
    };

    var map = new google.maps.Map(document.getElementById("map"), mapOptions);

    // İhtiyaç verilerini PHP'den al
    var locations = <?php echo json_encode($needs); ?>;
    var markers = [];

    locations.forEach(location => {
        var marker = new google.maps.Marker({
            position: { lat: parseFloat(location.latitude), lng: parseFloat(location.longitude) },
            map: map,
            title: location.title.toLowerCase(), // İhtiyaç başlığı
            city: location.city.toLowerCase() // Şehir bilgisi
        });

        var infowindow = new google.maps.InfoWindow({
            content: `<div style="width:150px; text-align:center;">
                        <h3>${location.title}</h3>
                        <p><a href="../need/need_details.php?id=${location.id}">Detayları Görüntüle</a></p>
                      </div>`
        });

        marker.addListener("click", function() {
            infowindow.open(map, marker);
        });

        markers.push(marker);
    });

    // Arama kutusundaki değeri dinle ve filtre uygula
    document.getElementById("searchForm").addEventListener("submit", function(e) {
        e.preventDefault();
        var query = document.getElementById("searchInput").value.toLowerCase();
        markers.forEach(marker => {
            if (marker.city.includes(query) || marker.title.includes(query)) {
                marker.setMap(map);
            } else {
                marker.setMap(null);
            }
        });
    });
}
</script>
