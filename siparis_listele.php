<?php
session_start();
include("baglanti.php");

if (!isset($_SESSION["kullanici_id"]) || $_SESSION["rol"] !== "admin") {
    header("Location: login.php");
    exit();
}


$sorgu = mysqli_query($baglanti, "
    SELECT 
        users.email,
        events.title,
        orders.quantity,
        orders.order_date
    FROM orders
    JOIN users ON orders.user_id = users.id
    JOIN events ON orders.event_id = events.id
    ORDER BY orders.order_date DESC
");
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Sipariş Listesi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <h2 class="mb-4 text-center text-primary">🎟️ Satın Alınan Biletler</h2>

    <?php if (mysqli_num_rows($sorgu) > 0): ?>
        <table class="table table-bordered bg-white shadow-sm">
            <thead class="table-success">
                <tr>
                    <th>Kullanıcı (E-posta)</th>
                    <th>Etkinlik</th>
                    <th>Adet</th>
                    <th>Sipariş Tarihi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($siparis = mysqli_fetch_assoc($sorgu)) { ?>
                    <tr>
                        <td><?php echo $siparis["email"]; ?></td>
                        <td><?php echo $siparis["title"]; ?></td>
                        <td><?php echo $siparis["quantity"]; ?></td>
                        <td><?php echo $siparis["order_date"]; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info text-center">Henüz hiç sipariş yok.</div>
    <?php endif; ?>

    <div class="text-center mt-4">
        <a href="admin_paneli.php" class="btn btn-outline-secondary">← Yönetici Paneline Dön</a>
    </div>
</div>

</body>
</html>
