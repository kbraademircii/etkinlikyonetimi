<?php
session_start();
include("baglanti.php");

$hata = "";

if (isset($_POST["giris"])) {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $sorgu = "SELECT * FROM users WHERE email='$email'";
    $sonuc = mysqli_query($baglanti, $sorgu);

    if ($sonuc && mysqli_num_rows($sonuc) > 0) {
        $kullanici = mysqli_fetch_assoc($sonuc);
        if (password_verify($password, $kullanici["password"])) {
            $_SESSION["kullanici_id"] = $kullanici["id"];
            $_SESSION["email"] = $kullanici["email"];
            $_SESSION["rol"] = $kullanici["role"];
            $_SESSION["onay"] = $kullanici["is_approved"];
            if ($kullanici["role"] === "admin") {
                header("Location: admin_paneli.php");
            } else {
                header("Location: anasayfa.php");
            }
            exit();
        } else {
            $hata = "Şifre yanlış.";
        }
    } else {
        $hata = "Kullanıcı bulunamadı.";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Giriş Yap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="card shadow p-4" style="width: 100%; max-width: 400px;">
        <h2 class="text-center mb-4">Giriş Yap</h2>

        <?php if (!empty($hata)) echo "<div class='alert alert-danger'>$hata</div>"; ?>

        <form method="post">
            <div class="mb-3">
                <label class="form-label">E-posta</label>
                <input type="email" name="email" class="form-control" required />
            </div>
            <div class="mb-3">
                <label class="form-label">Şifre</label>
                <input type="password" name="password" class="form-control" required />
            </div>
            <div class="d-grid">
                <button type="submit" name="giris" class="btn btn-primary">Giriş Yap</button>
            </div>
        </form>

        <div class="mt-3 text-center">
            <a href="register.php">Hesabınız yok mu? Kayıt Ol</a>
        </div>
    </div>
</div>

</body>
</html>
