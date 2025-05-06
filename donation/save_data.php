<?php
include "../config.php";
session_start();

$response = array('status' => 'error', 'message' => 'Bilinmeyen bir hata oluştu');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['username'])) {
        $response['message'] = 'Bağış isteğinde bulunmak için giriş yapmalısınız.';
        $response['redirect'] = '../login.php';
        echo json_encode($response);
        exit;
    }

    $username = htmlspecialchars($_SESSION['username']);
    try {
        // PDO Hata Modunu Ayarla
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Kullanıcı adı ile eşleşen isim ve soyisim bilgisini oturumdan çek
        $name = 'Anonim Kullanıcı';
        $stmt = $db->prepare("SELECT name FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $name = htmlspecialchars($result['name']);
        }

        // Son bir ay içindeki bağış isteklerini say
        $stmt = $db->prepare("SELECT COUNT(*) as count FROM ihtiyackayitlari WHERE username = ? AND created_at >= DATE_SUB(NOW(), INTERVAL 1 MONTH)");
        $stmt->execute([$username]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result['count'] < 5) {
            // Form verilerini al ve doğrula
            $city = isset($_POST['city']) ? htmlspecialchars($_POST['city']) : null;
            $district = isset($_POST['district']) ? htmlspecialchars($_POST['district']) : null;
            $neighborhood = isset($_POST['neighborhood']) ? htmlspecialchars($_POST['neighborhood']) : null;
            $need = isset($_POST['need']) ? htmlspecialchars($_POST['need']) : null;
            $description = isset($_POST['description']) ? htmlspecialchars($_POST['description']) : null;
            $latitude = isset($_POST['latitude']) ? htmlspecialchars($_POST['latitude']) : null;
            $longitude = isset($_POST['longitude']) ? htmlspecialchars($_POST['longitude']) : null;

            if ($city && $district && $neighborhood && $need && $description && $latitude && $longitude) {
                // Veritabanına ekle
                $stmt = $db->prepare("INSERT INTO ihtiyackayitlari (username, isim_soyisim, ihtiyac, latitude, longitude, aciklama, il, ilce, mahalle, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
                $stmt->execute([$username, $name, $need, $latitude, $longitude, $description, $city, $district, $neighborhood]);

                if ($stmt->rowCount() > 0) {
                    $response['status'] = 'success';
                    $response['message'] = 'Bağış isteği başarıyla eklendi.';
                    $response['redirect'] = '../index.php';
                } else {
                    $response['message'] = 'Bağış isteği eklenemedi.';
                }
            } else {
                $response['message'] = 'Tüm form alanlarını doldurmanız gerekmektedir.';
            }
        } else {
            $response['message'] = 'Bir ay içinde en fazla 5 bağış isteğinde bulunabilirsiniz.';
        }
    } catch (PDOException $e) {
        $response['message'] = 'Hata: ' . $e->getMessage();
    }
}

echo json_encode($response);
?>
