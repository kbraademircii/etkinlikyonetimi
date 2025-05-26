<?php
session_start();
include("baglanti.php");

if (!isset($_SESSION["kullanici_id"]) || $_SESSION["rol"] !== "admin") {
    header("Location: login.php");
    exit();
}

$mesaj = "";
$id = intval($_GET["id"]);
$etkinlik = mysqli_fetch_assoc(mysqli_query($baglanti, "SELECT * FROM events WHERE id = $id"));

if (isset($_POST["guncelle"])) {
    $title = trim($_POST["title"]);
    $description = trim($_POST["description"]);
    $date = $_POST["date"];
    $time = $_POST["time"];
    $available_seats = intval($_POST["available_seats"]);

    $sorgu = "UPDATE events SET 
              title = '$title', 
              description = '$description', 
              date = '$date', 
              time = '$time', 
              available_seats = $available_seats 
              WHERE id = $id";

    if (mysqli_query($baglanti, $sorgu)) {
        $mesaj = "Etkinlik başarıyla güncellendi.";
        $etkinlik = mysqli_fetch_assoc(mysqli_query($baglanti, "SELECT * FROM events WHERE id = $id"));
    } else {
        $mesaj = "Güncelleme sırasında hata oluştu.";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Etkinlik Düzenle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5" style="max-width: 600px;">
    <div class="card shadow p-4">
        <h2 class="mb-4 text-center text-primary">🛠️ Etkinlik Düzenle</h2>

        <?php if ($mesaj) echo "<div class='alert alert-info'>$mesaj</div>"; ?>

        <form method="post">
            <div class="mb-3">
                <label class="form-label">Başlık</label>
                <input type="text" name="title" class="form-control" value="<?php echo $etkinlik['title']; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Açıklama</label>
                <textarea name="description" class="form-control" rows="3" required><?php echo $etkinlik['description']; ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Tarih</label>
                <input type="date" name="date" class="form-control" value="<?php echo $etkinlik['date']; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Saat</label>
                <input type="time" name="time" class="form-control" value="<?php echo $etkinlik['time']; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Kontenjan</label>
                <input type="number" name="available_seats" class="form-control" value="<?php echo $etkinlik['available_seats']; ?>" required>
            </div>
            <div class="d-grid">
                <button type="submit" name="guncelle" class="btn btn-primary">Kaydet</button>
            </div>
        </form>

        <div class="mt-4 text-center">
            <a href="etkinlik_listele.php" class="btn btn-outline-secondary">← Listeye Geri Dön</a>
        </div>
    </div>
</div>
</body>
</html>

