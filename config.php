<?php
$servername = "localhost";
$dbusername = "root";  // Burada kullanıcı adını değiştirdik
$password = "";
$dbname = "yardimlas";

try {
    $db = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $dbusername, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
