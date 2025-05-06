<?php
include "../config.php";
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../login/login.php");
    exit;
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// İhtiyaç detaylarını çek
$need = null;
if ($id > 0) {
    try {
        $stmt = $db->prepare("SELECT username, isim_soyisim, il, ilce, mahalle, ihtiyac, aciklama, latitude, longitude, created_at FROM ihtiyackayitlari WHERE id = ?");
        $stmt->execute([$id]);
        $need = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Hata: " . $e->getMessage();
    }
}

if (!$need) {
    echo "Geçersiz ID";
    exit;
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İhtiyaç Detayları</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAs8PxoTvmpRquHtBdLFUTenMFLQbEuJBI&callback=initMap" defer></script>
</head>
<body>
<?php
    include "../sidebar.php";
    ?>
    <div class="main-content container">
        <div class="header text-center my-4">
            <h1>İhtiyaç Detayları</h1>
        </div>
        <div class="details card mb-4">
            <div class="card-body">
                <h2 class="card-title"><?php echo htmlspecialchars($need['ihtiyac']); ?></h2>
                <p><i class="fas fa-user"></i> <strong>Kullanıcı:</strong> <?php echo htmlspecialchars($need['username']); ?></p>
                <p><i class="fas fa-id-badge"></i> <strong>İsim Soyisim:</strong> <?php echo htmlspecialchars($need['isim_soyisim']); ?></p>
                <p><i class="fas fa-map-marker-alt"></i> <strong>İl:</strong> <?php echo htmlspecialchars($need['il']); ?></p>
                <p><i class="fas fa-map-marker-alt"></i> <strong>İlçe:</strong> <?php echo htmlspecialchars($need['ilce']); ?></p>
                <p><i class="fas fa-map-marker-alt"></i> <strong>Mahalle:</strong> <?php echo htmlspecialchars($need['mahalle']); ?></p>
                <p><i class="fas fa-align-left"></i> <strong>Açıklama:</strong> <?php echo htmlspecialchars($need['aciklama']); ?></p>
                <p><i class="fas fa-calendar-alt"></i> <strong>Oluşturulma Tarihi:</strong> <?php echo htmlspecialchars($need['created_at']); ?></p>
            </div>
        </div>
        <div id="map" class="mb-4" style="height: 500px;"></div>
    </div>
</body>
</html>
<script>
function initMap() {
    var mapOptions = {
        center: { lat: parseFloat("<?php echo $need['latitude']; ?>"), lng: parseFloat("<?php echo $need['longitude']; ?>") },
        zoom: 10, // Yakınlaştırma seviyesi
        zoomControl: false,
        mapTypeControl: false,
        scaleControl: false,
        streetViewControl: false,
        rotateControl: false,
        fullscreenControl: true,
        mapTypeControlOptions: {
            mapTypeIds: ['roadmap', 'satellite', 'hybrid', 'terrain']
        }
    };

    var map = new google.maps.Map(document.getElementById("map"), mapOptions);

    var marker = new google.maps.Marker({
        position: { lat: parseFloat("<?php echo $need['latitude']; ?>"), lng: parseFloat("<?php echo $need['longitude']; ?>") },
        map: map,
        title: "<?php echo htmlspecialchars($need['ihtiyac']); ?>"
    });

    var infowindow = new google.maps.InfoWindow({
        content: `<div style="width:200px; text-align:center;">
                    <h3><?php echo htmlspecialchars($need['ihtiyac']); ?></h3>
                    <p><?php echo htmlspecialchars($need['aciklama']); ?></p>
                  </div>`
    });

    marker.addListener("click", function() {
        infowindow.open(map, marker);
    });
}
</script>
