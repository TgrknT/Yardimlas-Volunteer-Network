# Yardımlaş Platformu

Bu proje, afet durumlarında ve acil ihtiyaç hallerinde yardım taleplerini ve bağışları yönetmek için geliştirilmiş bir web platformudur.

## Özellikler

- Kullanıcı yönetimi (kayıt, giriş, profil)
- Yardım talebi oluşturma ve yönetme
- Bağış yapma ve yönetme
- Harita üzerinde konum bazlı arama
- Admin paneli ile sistem yönetimi
- Güvenlik önlemleri (403 hata sayfası, .htaccess yapılandırması)

## Sistem Gereksinimleri

- PHP 7.4 veya üzeri
- MySQL 5.7 veya üzeri
- Apache Web Sunucusu
- mod_rewrite Apache modülü

## Kurulum

1. Projeyi web sunucunuzun kök dizinine kopyalayın
2. `config.php` dosyasını düzenleyerek veritabanı bağlantı bilgilerinizi girin
3. `database.sql` dosyasını MySQL veritabanınıza import edin
4. `.htaccess` dosyasının doğru çalıştığından emin olun
5. Apache'yi yeniden başlatın

## Dizin Yapısı

- `/admin` - Yönetici paneli
- `/donation` - Bağış işlemleri
- `/home` - Ana sayfa ve genel içerikler
- `/login` - Kullanıcı girişi ve kayıt
- `/maps` - Harita işlemleri
- `/need` - Yardım talepleri
- `/profile` - Kullanıcı profili yönetimi

## Güvenlik

- Tüm hassas dosyalar `.htaccess` ile korunmaktadır
- 403 hata sayfası özelleştirilmiştir
- SQL injection ve XSS saldırılarına karşı koruma mevcuttur

## Katkıda Bulunma

1. Bu depoyu fork edin
2. Yeni bir branch oluşturun (`git checkout -b feature/yeniOzellik`)
3. Değişikliklerinizi commit edin (`git commit -am 'Yeni özellik eklendi'`)
4. Branch'inizi push edin (`git push origin feature/yeniOzellik`)
5. Pull Request oluşturun

## Lisans

Bu proje MIT lisansı altında lisanslanmıştır. Detaylar için `LICENSE` dosyasına bakın.

## İletişim

Sorularınız veya önerileriniz için lütfen iletişime geçin. 