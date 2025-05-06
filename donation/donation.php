<?php
include "../config.php";
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../login/login.php");
    exit;
}

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
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yardımlaş</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAs8PxoTvmpRquHtBdLFUTenMFLQbEuJBI&callback=initMap" defer></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
<?php include "../sidebar.php"; ?>
<div class="main-content">
    <div class="header">
        <h1>Bağış Kayıt Alanı</h1>
        <div id="message" class="alert alert-info" style="display: none;"></div>
        <form class="registration-form" id="ihtiyacForm" method="post">
        <div class="form-group">
            <label for="username">Kullanıcı Adı</label>
            <input type="text" id="username" name="username" value="<?php echo $username; ?>" disabled>
        </div>
        <div class="form-group">
            <label for="name">İsim Soyisim</label>
            <input type="text" id="name" name="name" value="<?php echo $name; ?>" disabled>
        </div>
            <div class="form-group">
                <label for="city">İl</label>
                <select id="city" name="city" onchange="updateDistricts()" required>
                    <option value="">Seçiniz</option>
                </select>
            </div>
            <div class="form-group">
                <label for="district">İlçe</label>
                <select id="district" name="district" onchange="updateNeighborhoods()" required>
                    <option value="">Seçiniz</option>
                </select>
            </div>
            <div class="form-group">
                <label for="neighborhood">Mahalle</label>
                <select id="neighborhood" name="neighborhood" required>
                    <option value="">Seçiniz</option>
                </select>
            </div>
            <div class="form-group">
                <label for="need">İhtiyaç</label>
                <select id="need" name="need" required>
                    <option value="">Seçiniz</option>
                    <option value="Yemek">Yemek</option>
                    <option value="Isınma">Isınma</option>
                </select>
            </div>
            <div class="form-group">
                <label for="description">Açıklama Giriniz</label>
                <textarea id="description" name="description" placeholder="Bu bağışa şundan dolayı ihtiyacım var." required></textarea>
            </div>
            <input type="hidden" id="latitude" name="latitude">
            <input type="hidden" id="longitude" name="longitude">
            <div class="form-group">
                <button type="submit">Onayla</button>
            </div>
        </form>
        <div id="map" style="height: 500px; width: 100%; margin-top: 20px;"></div>

</div>
<script src="donation.js"></script>
<script>
$(document).ready(function() {
    $('#ihtiyacForm').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: 'save_data.php',
            type: 'POST',
            data: $('#ihtiyacForm').serialize(),
            dataType: 'json',
            success: function(response) {
                $('html, body').animate({ scrollTop: 0 }, 'slow');
                const messageElement = $('#message');
                messageElement.text(response.message).show();
                if (response.status === 'success') {
                    messageElement.removeClass('alert-info alert-danger').addClass('alert-success');
                } else {
                    messageElement.removeClass('alert-success alert-danger').addClass('alert-info');
                }
                setTimeout(() => {
                    messageElement.fadeOut('slow');
                }, 5000);
                if (response.status === 'success') {
                    $('#ihtiyacForm')[0].reset();
                    if (marker) {
                        marker.setMap(null);
                        marker = null;
                    }
                    map.setCenter({ lat: 39.9334, lng: 32.8597 });
                    map.setZoom(7);
                }
            },
            error: function(xhr, status, error) {
                $('html, body').animate({ scrollTop: 0 }, 'slow');
                const messageElement = $('#message');
                messageElement.text('Bir hata oluştu: ' + error).addClass('alert-danger').show();
                setTimeout(() => {
                    messageElement.fadeOut('slow');
                }, 5000);
            }
        });
    });
});
</script>
</body>
</html>
