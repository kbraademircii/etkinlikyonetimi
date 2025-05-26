<?php
session_start();
include("baglanti.php");

if (!isset($_SESSION['kullanici_id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($baglanti, $_POST["title"]);
    $description = mysqli_real_escape_string($baglanti, $_POST["description"]);
    $location = mysqli_real_escape_string($baglanti, $_POST["location"]);
    $date = $_POST["date"];
    $time = $_POST["time"];
    $seats = intval($_POST["seats"]);

    
    $sorgu = mysqli_query($baglanti, "INSERT INTO events (title, description, location, date, time, available_seats) 
                                       VALUES ('$title', '$description', '$location', '$date', '$time', $seats)");

    if ($sorgu) {
        $event_id = mysqli_insert_id($baglanti);

        
        if (isset($_POST["category"]) && isset($_POST["price"])) {
            $kategoriler = $_POST["category"];
            $fiyatlar = $_POST["price"];

            for ($i = 0; $i < count($kategoriler); $i++) {
                $kategori = mysqli_real_escape_string($baglanti, $kategoriler[$i]);
                $fiyat = intval($fiyatlar[$i]);

                if (!empty($kategori) && $fiyat > 0) {
                    mysqli_query($baglanti, "INSERT INTO tickets (event_id, category, price) 
                                             VALUES ($event_id, '$kategori', $fiyat)");
                }
            }
        }

        echo "<script>alert('Etkinlik başarıyla eklendi!'); window.location.href='admin_paneli.php';</script>";
        exit();
    } else {
        echo "<script>alert('Etkinlik eklenirken bir hata oluştu.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Etkinlik Ekle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
        }
        .container-custom {
            max-width: 700px;
            margin: auto;
            margin-top: 40px;
        }
    </style>
</head>
<body>
<div class="container container-custom">
    <div class="card shadow p-4">
        <h2 class="text-center text-primary mb-4">📌 Etkinlik Ekle</h2>
        <form method="post">
            <div class="mb-3">
                <label class="form-label">Etkinlik Başlığı</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Açıklama</label>
                <textarea name="description" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Etkinlik Yeri</label>
                <input type="text" name="location" class="form-control" placeholder="Örn: Kongre Merkezi" required>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label class="form-label">Tarih</label>
                    <input type="date" name="date" class="form-control" required>
                </div>
                <div class="col">
                    <label class="form-label">Saat</label>
                    <input type="time" name="time" class="form-control" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Kontenjan</label>
                <input type="number" name="seats" class="form-control" required>
            </div>

            <hr>
            <h5 class="text-primary mb-3">🎟️ Bilet Kategorileri ve Fiyatları</h5>
            <div id="biletAlani">
                <div class="row mb-2">
                    <div class="col">
                        <input type="text" name="category[]" class="form-control" placeholder="Kategori (Örn: Standart)">
                    </div>
                    <div class="col">
                        <input type="number" name="price[]" class="form-control" placeholder="Fiyat (₺)">
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-sm btn-outline-secondary mb-3" onclick="kategoriEkle()">+ Kategori Ekle</button>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Etkinliği Kaydet</button>
            </div>
        </form>
        <div class="text-center mt-3">
            <a href="admin_paneli.php" class="btn btn-outline-secondary">← Yönetici Paneline Dön</a>
        </div>
    </div>
</div>

<script>
function kategoriEkle() {
    const alan = document.getElementById("biletAlani");
    const satir = document.createElement("div");
    satir.className = "row mb-2";
    satir.innerHTML = `
        <div class="col">
            <input type="text" name="category[]" class="form-control" placeholder="Kategori (Örn: Standart)">
        </div>
        <div class="col">
            <input type="number" name="price[]" class="form-control" placeholder="Fiyat (₺)">
        </div>
    `;
    alan.appendChild(satir);
}
</script>
</body>
</html>
