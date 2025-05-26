<?php
session_start();

if (!isset($_SESSION["kullanici_id"]) || $_SESSION["rol"] !== "admin") {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Yönetici Paneli</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
        }
        .panel {
            max-width: 600px;
            margin: auto;
            margin-top: 80px;
            border: 2px solid #0d6efd; /* primary mavi */
        }
        .btn-block {
            padding: 15px;
            font-size: 1.1rem;
            color: #0d6efd !important;
            border-color: #0d6efd !important;
        }
        .btn-block:hover {
            background-color: #0d6efd !important;
            color: #fff !important;
        }
    </style>
</head>
<body>

<div class="panel card shadow p-4">
    <h2 class="text-center mb-4 text-primary">Yönetici Paneli 👑</h2>

    <div class="d-grid gap-3">
        <a href="etkinlik_ekle.php" class="btn btn-outline-primary btn-block">📌 Etkinlik Ekle</a>
        <a href="etkinlik_listele.php" class="btn btn-outline-primary btn-block">📋 Etkinlikleri Gör / Düzenle</a>
        <a href="siparis_listele.php" class="btn btn-outline-primary btn-block">🎟️ Satın Alınan Biletleri Gör</a>
        <a href="kullanici_onayla.php" class="btn btn-outline-primary btn-block">👥 Kullanıcı Onayla</a>
        <a href="logout.php" class="btn btn-outline-primary btn-block">➡️ Çıkış Yap</a>
    </div>
</div>

</body>
</html>
