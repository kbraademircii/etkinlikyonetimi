<?php
session_start();
include("baglanti.php");


if (!isset($_SESSION["kullanici_id"])) {
    header("Location: login.php");
    exit();
}


$etkinlikler = mysqli_query($baglanti, "SELECT * FROM events ORDER BY date ASC");
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Etkinlikler</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        .card {
            margin-bottom: 20px;
        }
    </style>
</head>
<body class="bg-light">

<div class="container py-4">
    <h2 class="mb-4 text-center text-primary">🎉 Etkinlikler</h2>

    <div class="row">
        <?php while ($etkinlik = mysqli_fetch_assoc($etkinlikler)): ?>
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($etkinlik["title"]); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($etkinlik["description"]); ?></p>
                        <p>
                            <strong>📅</strong> <?php echo $etkinlik["date"]; ?> &nbsp;
                            <strong>🕒</strong> <?php echo $etkinlik["time"]; ?>
                        </p>
                        <p><strong>👥 Kalan Kontenjan:</strong> <?php echo $etkinlik["available_seats"]; ?></p>

                        
                        <?php
                        $event_id = $etkinlik["id"];
                        $biletler = mysqli_query($baglanti, "SELECT * FROM tickets WHERE event_id = $event_id");
                        if (mysqli_num_rows($biletler) > 0): ?>
                            <div class="mb-2">
                                <strong>🎟️ Bilet Kategorileri:</strong>
                                <ul class="list-unstyled mb-0">
                                    <?php while ($bilet = mysqli_fetch_assoc($biletler)): ?>
                                        <li>- <?php echo $bilet["category"]; ?>: <strong><?php echo $bilet["price"]; ?>₺</strong></li>
                                    <?php endwhile; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        
                        <form action="sepete_ekle.php" method="post" class="mt-3">
                            <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">

                            <div class="mb-2">
                                <select name="kategori_fiyat" class="form-select" required>
                                    <option value="">Bilet Kategorisi Seçiniz</option>
                                    <?php
                                    $kategoriSorgu = mysqli_query($baglanti, "SELECT * FROM tickets WHERE event_id = $event_id");
                                    while ($kat = mysqli_fetch_assoc($kategoriSorgu)) {
                                        $kategori = $kat["category"];
                                        $fiyat = $kat["price"];
                                        echo "<option value='$kategori|$fiyat'>$kategori - $fiyat₺</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="d-flex">
                                <input type="number" name="adet" value="1" min="1" class="form-control w-25 me-2" required>
                                <button type="submit" class="btn btn-info text-white">🛒 Sepete Ekle</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <div class="text-center mt-4">
        <a href="anasayfa.php" class="btn btn-outline-secondary">← Ana Sayfaya Dön</a>
    </div>
</div>

</body>
</html>

                 
          
