<?php
session_start();
include("baglanti.php");


if (!isset($_SESSION["kullanici_id"]) || $_SESSION["rol"] !== "admin") {
    header("Location: anasayfa.php");
    exit();
}


if (isset($_GET['onayla_id'])) {
    $id = intval($_GET['onayla_id']);
    mysqli_query($baglanti, "UPDATE users SET is_approved = 1 WHERE id = $id");
    header("Location: kullanici_onayla.php");
    exit();
}


$kullanicilar = mysqli_query($baglanti, "SELECT * FROM users ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Kullanıcı Onayı</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
        }
        .container-custom {
            max-width: 900px;
            margin: auto;
            margin-top: 40px;
        }
    </style>
</head>
<body>
<div class="container container-custom">
    <h2 class="mb-4 text-center text-primary">👥 Kullanıcı Onay Paneli</h2>

    <table class="table table-bordered bg-white shadow-sm">
        <thead class="bg-primary text-white">
            <tr>
                <th>ID</th>
                <th>E-posta</th>
                <th>Rol</th>
                <th>Onay Durumu</th>
                <th>İşlem</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($kullanici = mysqli_fetch_assoc($kullanicilar)) { ?>
                <tr>
                    <td><?php echo $kullanici["id"]; ?></td>
                    <td><?php echo $kullanici["email"]; ?></td>
                    <td><?php echo $kullanici["role"] === "admin" ? "Yönetici" : "Kullanıcı"; ?></td>
                    <td>
                        <?php echo $kullanici["is_approved"] ? "<span class='text-success'>Onaylı</span>" : "<span class='text-danger'>Bekliyor</span>"; ?>
                    </td>
                    <td>
                        <?php if ($kullanici["is_approved"] == 0) { ?>
                            <a href="kullanici_onayla.php?onayla_id=<?php echo $kullanici["id"]; ?>" class="btn btn-sm btn-primary">Onayla</a>
                        <?php } else { ?>
                            <span class="text-muted">Zaten Onaylı</span>
                        <?php } ?>
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

