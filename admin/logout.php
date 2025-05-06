<?php
session_start(); // Oturumu başlat

// Tüm oturum değişkenlerini temizleyelim
$_SESSION = array();

// Oturum cookiesini de silmek istiyorsanız (isteğe bağlı)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Oturumu tamamen yok edelim
session_destroy();

// Kullanıcıyı login sayfasına yönlendirelim
header("Location: ../login/login.html");
exit;
