<?php
session_start();
include("baglanti.php");

if (!isset($_SESSION["kullanici_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["kullanici_id"];
$sepet = mysqli_query($baglanti, "SELECT * FROM cart WHERE user_id = $user_id");
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Sepetim</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body class="bg-light">
<div class="container py-5">
    <h2 class="mb-4 text-center text-primary">🛒 Sepetim</h2>

    <table class="table table-bordered bg-white">
        <thead>
            <tr>
                <th>Etkinlik</th>
                <th>Kategori</th>
                <th>Fiyat (₺)</th>
                <th>Adet</th>
                <th>Sil</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $bos = true;
        while ($satir = mysqli_fetch_assoc($sepet)):
            $bos = false;
            $event = mysqli_fetch_assoc(mysqli_query($baglanti, "SELECT title FROM events WHERE id = " . $satir["event_id"]));
        ?>
            <tr>
                <td><?php echo htmlspecialchars($event["title"]); ?></td>
                <td><?php echo htmlspecialchars($satir["ticket_category"]); ?></td>
                <td><?php echo $satir["ticket_price"]; ?> ₺</td>
                <td><?php echo $satir["adet"]; ?></td>
                <td>
                    <a href="sepetten_sil.php?id=<?php echo $satir["id"]; ?>" class="btn btn-danger btn-sm">
                        <i class="bi bi-trash"></i>
                    </a>
                </td>
            </tr>
        <?php endwhile; ?>

        <?php if ($bos): ?>
            <tr>
                <td colspan="5" class="text-center text-muted">Sepetinizde hiç ürün bulunmamaktadır.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>

    <div class="text-center mt-3">
        <a href="etkinlikler.php" class="btn btn-outline-primary">← Etkinliklere Dön</a>
        <a href="anasayfa.php" class="btn btn-outline-secondary">← Ana Sayfaya Dön</a>
        <?php if (!$bos): ?>
            <a href="satinal.php" class="btn btn-primary text-white">Satın Al</a>
        <?php endif; ?>
    </div>
</div>
</body>
</html>


   







