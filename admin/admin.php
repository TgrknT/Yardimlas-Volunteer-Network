<?php
include "../config.php"; // Veritabanı bağlantısını yapıyoruz
session_start();

// Kullanıcı oturumunu kontrol et
if (!isset($_SESSION['username'])) {
    header("Location: ../login/login.php");
    exit;
}

$username = $_SESSION['username'];

try {
    // Veritabanından kullanıcının rolünü kontrol et
    $stmt = $db->prepare("SELECT role FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Kullanıcı rolü kontrolü: sadece admin ve superadmin izinli
    if (!$user || ($user['role'] !== 'admin' && $user['role'] !== 'superadmin')) {
        header("Location: ../home/home.php"); // Yetkisi olmayanlar ana sayfaya yönlendirilsin
        exit;
    }

} catch (PDOException $e) {
    echo "Veritabanı hatası: " . $e->getMessage();
}

// Onaylama ve reddetme işlemi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $request_id = $_POST['request_id'];  // Formdan gelen request_id

    if (isset($_POST['approve'])) {
        // Talebi onaylama işlemi
        $stmt = $db->prepare("UPDATE ihtiyackayitlari SET status = 'approved' WHERE id = ?");
        $stmt->execute([$request_id]);
        
        // Sayfayı yenileme
        header("Location: admin.php");
        exit;
    } elseif (isset($_POST['reject'])) {
        // Talebi reddetme işlemi
        $stmt = $db->prepare("UPDATE ihtiyackayitlari SET status = 'rejected' WHERE id = ?");
        $stmt->execute([$request_id]);
        
        // Sayfayı yenileme
        header("Location: admin.php");
        exit;
    }
}

// Pending kayıtları almak için sorgu
try {
    $query = $db->prepare("SELECT id, isim_soyisim, ihtiyac, il, ilce FROM ihtiyackayitlari WHERE status = 'pending'");
    $query->execute();
    $pendingRequests = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>


<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Paneli - Yardımlaş</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <?php include "adminbar.php"; ?>

    <div class="main-content">
        <div class="header">
            <h2>Bağış Talepleri</h2>
        </div>

        <div class="request-list">
            <?php if (!empty($pendingRequests)): ?>
                <?php foreach ($pendingRequests as $request): ?>
                    <div class="request-card">
                        <h3><?php echo htmlspecialchars($request['ihtiyac']); ?></h3>
                        <p><?php echo htmlspecialchars($request['isim_soyisim']); ?> - <?php echo htmlspecialchars($request['il']); ?> / <?php echo htmlspecialchars($request['ilce']); ?></p>
                        <form action="admin.php" method="post">
                            <input type="hidden" name="request_id" value="<?php echo $request['id']; ?>">
                            <button type="submit" name="approve" class="approve">Onayla</button>
                            <button type="submit" name="reject" class="reject">Reddet</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Bekleyen bağış talebi yok.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
