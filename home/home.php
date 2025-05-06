<?php
session_start();
include "../config.php";

if (!isset($_SESSION['username'])) {
    header("Location: ../login/login.php");
    exit;
}
$username = $_SESSION['username'];

try {
    $db = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $dbusername, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

$search = '';
if (isset($_GET['search'])) {
    $search = $_GET['search'];
}

// Sorguya 'status = approved' koşulunu ekliyoruz
$query = $db->prepare("SELECT id, isim_soyisim, ihtiyac FROM ihtiyackayitlari 
                        WHERE (ihtiyac LIKE ? OR il LIKE ?) AND status = 'approved'");
$query->execute(['%' . $search . '%', '%' . $search . '%']);
$results = $query->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yardımlaş</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<?php include "../sidebar.php"; ?>
<div class="main-content">
    <div class="header">
        <form method="GET" action="">
            <input type="text" name="search" placeholder="ARAMA YAP" value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit">Ara</button>
        </form>
        <span>Hoşgeldin <?php echo htmlspecialchars($username); ?></span>
    </div>
    <div class="cards-container">
        <?php if ($results): ?>
            <?php foreach ($results as $row): ?>
                <div class="card">
                    <h3><?php echo htmlspecialchars($row['ihtiyac']); ?></h3>
                    <p><?php echo htmlspecialchars($row['isim_soyisim']); ?></p>
                    <button onclick="window.location.href='../need/need_details.php?id=<?php echo $row['id']; ?>'">İletişime Geç</button>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aramanızla eşleşen kayıt bulunamadı.</p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
