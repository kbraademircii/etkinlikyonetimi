<?php
session_start();

if (!isset($_SESSION["kullanici_id"])) {
    header("Location: login.php");
    exit();
}

$rol = $_SESSION["rol"] === "admin" ? "Yönetici" : "Kullanıcı";
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Ana Sayfa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="card shadow p-5 text-center" style="max-width: 600px; width: 100%;">
        <h2 class="mb-4 text-primary">Hoş Geldiniz 👋</h2>

        <p class="lead">
            <strong><?php echo $_SESSION["email"]; ?></strong> adresiyle <strong><?php echo $rol; ?></strong> olarak giriş yaptınız.
        </p>

        <?php if ($_SESSION["onay"] == 0): ?>
            <div class="alert alert-primary mt-3">
                Hesabınız henüz yönetici tarafından onaylanmadı.
            </div>
        <?php endif; ?>

        <div class="mt-4 d-flex justify-content-center gap-3">
            <a href="etkinlikler.php" class="btn btn-outline-primary">
                <i class="bi bi-calendar-event"></i> Etkinlikleri Gör
            </a>

            <?php if ($_SESSION["rol"] === "user"): ?>
            <a href="sepetim.php" class="btn btn-outline-secondary">
                <i class="bi bi-cart-fill"></i> Sepetim
            </a>
            <?php endif; ?>
        </div>

        <div class="mt-4">
            <a href="logout.php" class="btn btn-info text-white">Çıkış Yap</a>
        </div>
    </div>
</div>

</body>
</html>
