<?php
session_start();
include "../config.php"; // Veritabanı bağlantısını yapıyoruz

// Kullanıcı kontrolü, sadece admin ve superadmin erişebilir
if (!isset($_SESSION['username']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'superadmin')) {
    header("Location: ../home/home.php");
    exit;
}

// Arama kriteri varsa, o kritere göre filtreleme yapalım
$search = '';
$searchQuery = '';
$params = [];

if (isset($_GET['search'])) {
    $search = htmlspecialchars(trim($_GET['search']));
    $searchQuery = " AND isim_soyisim LIKE ?";
    $params[] = '%' . $search . '%'; // Arama parametresi
}

// Approved istekleri listeleme
try {
    $stmt = $db->prepare("SELECT id, isim_soyisim, ihtiyac, il, ilce, aciklama FROM ihtiyackayitlari WHERE status = 'approved'" . $searchQuery);
    $stmt->execute($params); // Parametreyi burada geçiriyoruz
    $approvedRequests = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Veritabanı hatası: " . $e->getMessage();
}

// Silme işlemi
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $request_id = $_POST['request_id']; // Silinecek isteğin ID'si
    try {
        $stmt = $db->prepare("DELETE FROM ihtiyackayitlari WHERE id = ?");
        $stmt->execute([$request_id]);
        header("Location: entrycontrol.php"); // Sayfayı yenileme
        exit;
    } catch (PDOException $e) {
        echo "Silme işlemi sırasında bir hata oluştu: " . $e->getMessage();
    }
}

// Güncelleme işlemi
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $request_id = $_POST['request_id'];
    $isim_soyisim = $_POST['isim_soyisim'];
    $ihtiyac = $_POST['ihtiyac'];
    $il = $_POST['il'];
    $ilce = $_POST['ilce'];
    $aciklama = $_POST['aciklama'];

    try {
        $stmt = $db->prepare("UPDATE ihtiyackayitlari SET isim_soyisim = ?, ihtiyac = ?, il = ?, ilce = ?, aciklama = ? WHERE id = ?");
        $stmt->execute([$isim_soyisim, $ihtiyac, $il, $ilce, $aciklama, $request_id]);
        header("Location: entrycontrol.php");
        exit;
    } catch (PDOException $e) {
        echo "Güncelleme işlemi sırasında bir hata oluştu: " . $e->getMessage();
    }
}

// AJAX ile istek detaylarını çekme işlemi
if (isset($_GET['ajax']) && isset($_GET['id'])) {
    $request_id = intval($_GET['id']);

    try {
        $stmt = $db->prepare("SELECT isim_soyisim, ihtiyac, il, ilce, aciklama FROM ihtiyackayitlari WHERE id = ?");
        $stmt->execute([$request_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            echo json_encode($result);
        } else {
            echo json_encode(["error" => "Kayıt bulunamadı."]);
        }
    } catch (PDOException $e) {
        echo json_encode(["error" => "Veritabanı hatası: " . $e->getMessage()]);
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Onaylanmış İstekler - Admin Paneli</title>
    <link rel="stylesheet" href="entrystyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <?php include "adminbar.php"; ?> <!-- Sidebar alanı -->

    <div class="main-content">
        <div class="header">
            <h1>Onaylanmış İstekler</h1>
            <!-- Arama Alanı -->
            <form method="GET" action="entrycontrol.php" class="search-bar">
                <input type="text" name="search" placeholder="İsim soyisim ile arayın..." value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit">Ara</button>
            </form>
        </div>

        <div class="table-container">
            <table class="approved-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>İsim Soyisim</th>
                        <th>İhtiyaç</th>
                        <th>İl</th>
                        <th>İlçe</th>
                        <th>Açıklama</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($approvedRequests)): ?>
                        <?php foreach ($approvedRequests as $request): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($request['id']); ?></td>
                            <td><?php echo htmlspecialchars($request['isim_soyisim']); ?></td>
                            <td><?php echo htmlspecialchars($request['ihtiyac']); ?></td>
                            <td><?php echo htmlspecialchars($request['il']); ?></td>
                            <td><?php echo htmlspecialchars($request['ilce']); ?></td>
                            <td><?php echo htmlspecialchars($request['aciklama']); ?></td>
                            <td>
                                <button class="btn edit" onclick="openModal(<?php echo $request['id']; ?>)">Düzenle</button>
                                <form method="post" action="entrycontrol.php" style="display:inline;">
                                    <input type="hidden" name="request_id" value="<?php echo $request['id']; ?>">
                                    <button type="submit" name="delete" class="btn delete">Sil</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7">Onaylanmış istek bulunamadı.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <form method="post" action="entrycontrol.php" class="edit-form">
                <input type="hidden" name="request_id" id="editRequestId">
                <label for="isim_soyisim">İsim Soyisim:</label>
                <input type="text" name="isim_soyisim" id="editIsimSoyisim">

                <label for="ihtiyac">İhtiyaç:</label>
                <input type="text" name="ihtiyac" id="editIhtiyac">

                <label for="il">İl:</label>
                <input type="text" name="il" id="editIl">

                <label for="ilce">İlçe:</label>
                <input type="text" name="ilce" id="editIlce">

                <label for="aciklama">Açıklama:</label>
                <textarea name="aciklama" id="editAciklama" rows="4"></textarea>

                <button type="submit" name="update" class="btn update">Güncelle</button>
            </form>
        </div>
    </div>

    <script>
        // Modal işlemleri
        var modal = document.getElementById("editModal");
        var closeModal = document.getElementsByClassName("close")[0];

        // Modalı aç
        function openModal(id) {
            modal.style.display = "block";
            document.getElementById("editRequestId").value = id;

            // AJAX ile mevcut verileri çek
            fetch('entrycontrol.php?ajax=1&id=' + id)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                    } else {
                        document.getElementById("editIsimSoyisim").value = data.isim_soyisim;
                        document.getElementById("editIhtiyac").value = data.ihtiyac;
                        document.getElementById("editIl").value = data.il;
                        document.getElementById("editIlce").value = data.ilce;
                        document.getElementById("editAciklama").value = data.aciklama;
                    }
                })
                .catch(error => {
                    console.error('Hata:', error);
                });
        }

        // Modalı kapat
        closeModal.onclick = function() {
            modal.style.display = "none";
        }

        // Eğer modal dışına tıklanırsa, kapat
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>
