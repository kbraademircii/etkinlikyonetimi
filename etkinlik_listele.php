<?php
session_start();
include("baglanti.php");

if (!isset($_SESSION["kullanici_id"]) || $_SESSION["rol"] !== "admin") {
    header("Location: login.php");
    exit();
}

$etkinlikler = mysqli_query($baglanti, "SELECT * FROM events ORDER BY date ASC");
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Etkinlik Listesi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <h2 class="mb-4 text-center text-primary">🎯 Etkinlik Listesi</h2>

        <?php if (isset($_GET['silindi']) && $_GET['silindi'] == 1): ?>
            <div class="alert alert-success text-center">Etkinlik başarıyla silindi.</div>
        <?php endif; ?>

        <table class="table table-bordered bg-white shadow-sm">
            <thead class="text-white bg-primary">
                <tr>
                    <th>Başlık</th>
                    <th>Tarih</th>
                    <th>Saat</th>
                    <th>Kontenjan</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($etkinlik = mysqli_fetch_assoc($etkinlikler)) { ?>
                <tr>
                    <td><?php echo $etkinlik["title"]; ?></td>
                    <td><?php echo $etkinlik["date"]; ?></td>
                    <td><?php echo $etkinlik["time"]; ?></td>
                    <td><?php echo $etkinlik["available_seats"]; ?></td>
                    <td>
                        <a href="etkinlik_duzenle.php?id=<?php echo $etkinlik["id"]; ?>" class="btn btn-sm btn-primary">Düzenle</a>
                        <a href="etkinlik_sil.php?id=<?php echo $etkinlik["id"]; ?>" 
                           class="btn btn-sm btn-danger"
                           onclick="return confirm('Bu etkinliği silmek istediğinize emin misiniz?');">
                           Sil
                        </a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>

        <div class="text-center mt-4">
            <a href="admin_paneli.php" class="btn btn-outline-secondary">← Yönetici Paneline Dön</a>
        </div>
    </div>
</body>
</html>
