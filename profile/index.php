<?php
include "../config.php";
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../login/login.php");
    exit;
}

// Kullanıcı adı oturum değişkenini kontrol et
$username = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : '';

// Kullanıcı bilgilerini veritabanından çekme
$user = [];
if ($username) {
    try {
        $stmt = $db->prepare("SELECT username, name, email, phone FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Boş alanlar için varsayılan değerler ekleyin
        if (!isset($user['phone'])) {
            $user['phone'] = '';
        }
    } catch (PDOException $e) {
        echo "Hata: " . $e->getMessage();
    }
}

// Kullanıcı bilgilerini güncelleme
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);

    try {
        $stmt = $db->prepare("UPDATE users SET name = ?, email = ?, phone = ? WHERE username = ?");
        $stmt->execute([$name, $email, $phone, $username]);
        $user['name'] = $name;
        $user['email'] = $email;
        $user['phone'] = $phone;
        $message = "Bilgiler güncellendi.";
    } catch (PDOException $e) {
        echo "Hata: " . $e->getMessage();
    }
}

// Hesabı ve ihtiyaç (donate) verilerini silme
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    try {
        // Veritabanı işlemlerini başlat
        $db->beginTransaction();
        
        // 1. Adım: Kullanıcının ihtiyaç (donate) verilerini sil
        $stmt = $db->prepare("DELETE FROM ihtiyackayitlari WHERE username = ?");
        $stmt->execute([$username]);
        
        // 2. Adım: Kullanıcıyı sil
        $stmt = $db->prepare("DELETE FROM users WHERE username = ?");
        $stmt->execute([$username]);
        
        // İşlemi onayla
        $db->commit();

        session_destroy();
        header("Location:../login/login.php"); // Kullanıcı çıkış sayfasına yönlendirme
        exit;
    } catch (PDOException $e) {
        // Hata durumunda işlemi geri al (rollback)
        $db->rollBack();
        echo "Hata: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php
include "../sidebar.php";   
?>
    <div class="main-content container">
        <div class="header text-center my-4">
            <h1>Profil</h1>
        </div>
        <?php if (!empty($message)): ?>
            <div class="alert alert-success"><?php echo $message; ?></div>
        <?php endif; ?>
        <div class="profile card mb-4">
            <div class="card-body">
                <form method="post" action="">
                    <div class="form-group">
                        <label for="username">Kullanıcı Adı</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="name">İsim Soyisim</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="phone">Telefon Numarası</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>">
                    </div>
                    <button type="submit" name="update" class="btn btn-primary">Güncelle</button>
                    <button type="submit" name="delete" class="btn btn-danger">Hesabımı Sil</button>
                </form>
            </div>
        </div>
        <div class="text-center">
            <a href="../login/login.php" class="btn btn-secondary btn-lg"><i class="fas fa-sign-out-alt"></i> Çıkış Yap</a>
        </div>
    </div>
</body>
</html>
