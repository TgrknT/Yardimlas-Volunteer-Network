-- Veritabanını oluştur
CREATE DATABASE IF NOT EXISTS yardimlas CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE yardimlas;

-- Kullanıcılar tablosu
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin', 'superadmin') DEFAULT 'user',
    is_banned BOOLEAN DEFAULT FALSE,
    phone VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- İhtiyaç kayıtları tablosu
CREATE TABLE IF NOT EXISTS ihtiyackayitlari (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    isim_soyisim VARCHAR(100) NOT NULL,
    ihtiyac VARCHAR(100) NOT NULL,
    latitude DECIMAL(10, 8),
    longitude DECIMAL(11, 8),
    aciklama TEXT,
    il VARCHAR(50) NOT NULL,
    ilce VARCHAR(50) NOT NULL,
    mahalle VARCHAR(100) NOT NULL,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (username) REFERENCES users(username) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Varsayılan admin kullanıcısı oluştur (şifre: admin123)
INSERT INTO users (username, name, email, password, role) VALUES 
('admin', 'Admin User', 'admin@example.com', '$2y$10$2/B7RMCZvJh1hOOQDXTnj.VEVI/zDl9lC58dcb5F7Qn8suqtInECC', 'superadmin'); 