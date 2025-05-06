<?php
session_start();
include "../config.php"; // Veritabanı bağlantısını yapıyoruz

// Kullanıcı kontrolü, sadece admin ve superadmin erişebilir
if (!isset($_SESSION['username']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'superadmin')) {
    header("Location: ../home/home.php");
    exit;
}

// Superadmin kendi kendini banlayamaz veya silemez
$current_username = $_SESSION['username']; // Oturumdaki kullanıcının adı

// Banlama, silme ve rol değiştirme işlemi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id']; // İşlem yapılacak kullanıcı ID'si
    $user_to_modify = $_POST['username']; // İşlem yapılacak kullanıcının adı

    // Eğer işlem yapılacak kullanıcı superadmin ise kontrol
    if ($current_username === $user_to_modify && $_SESSION['role'] === 'superadmin') {
        $uyari = "Superadmin kendi üzerinde işlem yapamaz.";
    } else {
        if (isset($_POST['ban'])) {
            // Kullanıcıyı banla
            $stmt = $db->prepare("UPDATE users SET is_banned = 1 WHERE id = ?");
            $stmt->execute([$user_id]);
            header("Location: usercontrol.php");
            exit;
        } elseif (isset($_POST['unban'])) {
            // Kullanıcıyı banı kaldır
            $stmt = $db->prepare("UPDATE users SET is_banned = 0 WHERE id = ?");
            $stmt->execute([$user_id]);
            header("Location: usercontrol.php");
            exit;
        } elseif (isset($_POST['delete'])) {
            // Kullanıcıyı sil
            $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
            $stmt->execute([$user_id]);
            header("Location: usercontrol.php");
            exit;
        } elseif (isset($_POST['new_role']) && $_SESSION['role'] === 'superadmin') {
            // Sadece superadmin rol değiştirme işlemi yapabilir
            $new_role = $_POST['new_role'];
            if ($new_role !== 'superadmin') {
                $stmt = $db->prepare("UPDATE users SET role = ? WHERE id = ?");
                $stmt->execute([$new_role, $user_id]);
                header("Location: usercontrol.php");
                exit;
            }
        }
    }
}

// Kullanıcıları veritabanından çek (arama sorgusu varsa)
$searchQuery = '';
$params = [];

// Eğer adminse, sadece normal kullanıcıları göster, aramada admin ve superadmin gösterilmesin
$roleCondition = ' WHERE role != "superadmin" AND role != "admin"';

// Eğer giriş yapan superadmin ise tüm kullanıcılar gösterilebilir
if ($_SESSION['role'] === 'superadmin') {
    $roleCondition = ' WHERE 1=1'; // Superadmin tüm kullanıcıları görebilir
}

// Arama yapılıyorsa sorguyu düzenle
if (isset($_GET['search'])) {
    $search = htmlspecialchars($_GET['search']); // Arama terimini temizle
    $searchQuery = " AND (id LIKE ? OR username LIKE ? OR email LIKE ? OR role LIKE ?)"; // Arama sorgusu
    $params = ['%' . $search . '%', '%' . $search . '%', '%' . $search . '%', '%' . $search . '%']; // Arama parametreleri
}

try {
    // SQL sorgusu: Eğer arama varsa sorguya eklenir
    $stmt = $db->prepare("SELECT id, username, name, email, role, is_banned FROM users" . $roleCondition . $searchQuery);
    
    // Sorguyu çalıştır
    $stmt->execute($params);

    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Veritabanı hatası: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kullanıcı Yönetimi</title>
    <link rel="stylesheet" href="userstyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- CSS Stil Eklendi -->
    <style>
        /* Daha sade ve şık dropdown stili */
        select {
            padding: 10px;
            font-size: 14px;
            border-radius: 8px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
            width: 150px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            appearance: none;
        }

        select:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
            outline: none;
        }

        /* Daha hoş görünüm için butonlar */
        .btn {
            padding: 8px 12px;
            font-size: 14px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn.ban {
            background-color: #dc3545;
            color: #fff;
        }

        .btn.ban:hover {
            background-color: #c82333;
            transform: scale(1.05);
        }

        .btn.unban {
            background-color: #28a745;
            color: #fff;
        }

        .btn.unban:hover {
            background-color: #218838;
            transform: scale(1.05);
        }

        .btn.delete {
            background-color: #ffc107;
            color: #fff;
        }

        .btn.delete:hover {
            background-color: #e0a800;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
   
<?php include "adminbar.php"; ?>

    <!-- Main Content -->
    <div class="main-content">
        <div class="header">
            <h1>Kullanıcı Yönetimi</h1>
            <!-- Arama Alanı -->
            <form class="search-bar" method="GET" action="">
                <input type="text" name="search" placeholder="Kullanıcı adı, E-mail veya Rol arayın..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" />
                <button type="submit">Ara</button>
            </form>
        </div>

        <div class="table-container">
            <table class="user-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Kullanıcı Adı</th>
                        <th>İsim</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Durum</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['id']); ?></td>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td><?php echo htmlspecialchars($user['name']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            
                            <td>
                                <?php if ($_SESSION['role'] === 'superadmin'): ?>
                                    <!-- Eğer superadmin ise rol değiştirebilir -->
                                    <form method="post" action="usercontrol.php">
                                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                        <input type="hidden" name="username" value="<?php echo $user['username']; ?>">
                                        <select name="new_role" onchange="this.form.submit();">
                                            <option value="user" <?php echo ($user['role'] === 'user') ? 'selected' : ''; ?>>User</option>
                                            <option value="admin" <?php echo ($user['role'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
                                        </select>
                                    </form>
                                <?php else: ?>
                                    <!-- Adminler sadece rolü görebilir -->
                                    <?php echo htmlspecialchars($user['role']); ?>
                                <?php endif; ?>
                            </td>
                            
                            <td><?php echo $user['is_banned'] ? '<span class="banned">Banlı</span>' : '<span class="active">Aktif</span>'; ?></td>
                            <td>
                                <form action="usercontrol.php" method="post" class="action-form">
                                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                    <?php if ($user['is_banned']): ?>
                                        <button type="submit" name="unban" class="btn unban">Banı Kaldır</button>
                                    <?php else: ?>
                                        <button type="submit" name="ban" class="btn ban">Banla</button>
                                    <?php endif; ?>
                                    <button type="submit" name="delete" class="btn delete" onclick="return confirm('Bu kullanıcıyı silmek istediğinizden emin misiniz?')">Sil</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7">Kullanıcı bulunamadı.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Font Awesome için -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>
