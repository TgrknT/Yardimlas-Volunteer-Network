<?php
session_start();
include "../config.php"; // Veritabanı bağlantısını yapıyoruz

// Kullanıcı kontrolü, sadece admin ve superadmin erişebilir
if (!isset($_SESSION['username']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'superadmin' )) {
    header("Location: ../home/home.php");
    exit;
}

// Onaylama ve reddetme işlemi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $request_id = $_POST['request_id'];  // Formdan gelen request_id

    if (isset($_POST['approve'])) {
        // Talebi onaylama işlemi
        $stmt = $db->prepare("UPDATE ihtiyackayitlari SET status = 'approved' WHERE id = ?");
        $stmt->execute([$request_id]);
        
        // Sayfayı yenileme
        header("Location: reject.php");
        exit;
    } elseif (isset($_POST['reject'])) {
        // Talebi silme işlemi (DELETE)
        $stmt = $db->prepare("DELETE FROM ihtiyackayitlari WHERE id = ?");
        $stmt->execute([$request_id]);
        
        // Sayfayı yenileme
        header("Location: reject.php");
        exit;
    }
}

// Pending kayıtları almak için sorgu
try {
    $query = $db->prepare("SELECT id, isim_soyisim, ihtiyac, il, ilce FROM ihtiyackayitlari WHERE status = 'rejected'");
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
                        <form action="reject.php" method="post">
                            <input type="hidden" name="request_id" value="<?php echo $request['id']; ?>">
                            <button type="submit" name="approve" class="approve">Onayla</button>
                            <button type="submit" name="reject" class="reject">Reddet</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Reddedilmiş İstek Bulunmuyor.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
