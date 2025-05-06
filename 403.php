<?php
header("HTTP/1.1 403 Forbidden");
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erişim Reddedildi - 403</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-image: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }
        .error-container {
            text-align: center;
            padding: 3rem;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            max-width: 500px;
            width: 90%;
        }
        .error-icon {
            font-size: 5rem;
            color: #dc3545;
            margin-bottom: 1.5rem;
        }
        h1 {
            color: #dc3545;
            font-size: 2.5rem;
            margin-bottom: 1rem;
            font-weight: 700;
        }
        p {
            color: #6c757d;
            font-size: 1.1rem;
            margin-bottom: 2rem;
            line-height: 1.6;
        }
        .btn-primary {
            padding: 0.8rem 2rem;
            font-size: 1.1rem;
            border-radius: 50px;
            background-color: #007bff;
            border: none;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .error-code {
            font-size: 0.9rem;
            color: #adb5bd;
            margin-top: 1rem;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-icon">🚫</div>
        <h1>Erişim Reddedildi</h1>
        <p>Bu sayfaya erişim izniniz bulunmamaktadır. Lütfen ana sayfaya dönün veya sistem yöneticinize başvurun.</p>
        <a href="/yardimlas/index.php" class="btn btn-primary">Ana Sayfaya Dön</a>
        <div class="error-code">Hata Kodu: 403 Forbidden</div>
    </div>
</body>
</html> 