<?php
session_start();
ob_start(); // Çıktı tamponlamayı başlat

include "./login.html";
include "../config.php";

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (isset($_POST["register"])) {
            $name = $_POST["name"];
            $email = $_POST["email"];
            $username = $_POST["username"];
            $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

            // Kullanıcı adı ve email benzersiz olmalı kontrolü
            $uniqueCheck = $db->prepare("SELECT COUNT(*) FROM users WHERE email = :email OR username = :username");
            $uniqueCheck->execute(array(
                ":email" => $email,
                ":username" => $username
            ));

            $uniqueCount = $uniqueCheck->fetchColumn();

            if (empty($name) || empty($email) || empty($username) || empty($password)) {
                $uyari = "Lütfen tüm alanları doldurun.";
            } else if ($uniqueCount > 0) {
                // Email veya kullanıcı adı daha önce kullanılmışsa
                $uyari = "Bu email veya kullanıcı adı daha önce kullanılmış.";
            } else {
                // Email ve kullanıcı adı benzersiz, yeni kayıt ekleniyor
                $ekle = $db->prepare("INSERT INTO users (name, email, username, password) VALUES (:name, :email, :username, :password)");

                $control = $ekle->execute(array(
                    ":name" => $name,
                    ":email" => $email,
                    ":username" => $username,
                    ":password" => $password
                ));

                if ($control) {
                    $uyari = "Kayıt başarıyla tamamlandı. Giriş yapabilirsiniz.";
                } else {
                    $uyari = "Kayıt sırasında bir hata oluştu.";
                    // Hata mesajını logla
                    error_log("Kayıt hatası: " . implode(", ", $ekle->errorInfo()), 3, "errors.log");
                }
            }
        } elseif (isset($_POST["login"])) {
            $username = htmlspecialchars(trim($_POST["username"]));
            $password = htmlspecialchars(trim($_POST["password"]));

            // Kullanıcı adı ve şifre kontrolü
            $sorgu = $db->prepare("SELECT * FROM users WHERE username = :username");
            $sorgu->execute(array(
                ":username" => $username
            ));

            if ($sorgu->rowCount() > 0) {
                $row = $sorgu->fetch(PDO::FETCH_ASSOC);

                // Kullanıcı banlı mı kontrolü
                if ($row['is_banned']) {
                    $uyari = "Hesabınız banlanmış durumda. Giriş yapamazsınız.";
                } else {
                    // Şifre doğrulama
                    if (password_verify($password, $row['password'])) {
                        $_SESSION["username"] = $username; // Kullanıcı adını oturum değişkenine atama
                        $_SESSION["role"] = $row['role'];  // Kullanıcının rolünü oturuma kaydetme

                        // Kullanıcının rolüne göre yönlendirme
                        if ($row['role'] === 'admin' || $row['role'] === 'superadmin') {
                            header("Location: ../admin/admin.php"); // Admin paneline yönlendirme
                            exit;
                        } else {
                            // Normal kullanıcıyı home.php'ye yönlendirme
                            header("Location: ../home/home.php");
                            exit;
                        }
                    } else {
                        $uyari = "Hatalı giriş bilgileri. Lütfen tekrar deneyin.";
                    }
                }
            } else {
                $uyari = "Kullanıcı adı bulunamadı.";
            }
        }
    }
} catch (PDOException $e) {
    $uyari = "Veritabanı hatası: " . $e->getMessage();
    error_log("Veritabanı hatası: " . $e->getMessage(), 3, "errors.log");
} catch (Exception $e) {
    $uyari = "Genel hata: " . $e->getMessage();
    error_log("Genel hata: " . $e->getMessage(), 3, "errors.log");
}

ob_end_flush(); // Çıktı tamponlamayı kapat

if (isset($uyari)) {
    echo "<p>$uyari</p>";
}
?>
