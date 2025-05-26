<?php
include("baglanti.php");

$mesaj = "";

if (isset($_POST["kayit"])) {
    $fullname = trim($_POST["fullname"]);
    $email = trim($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $kontrol = "SELECT * FROM users WHERE email='$email'";
    $sonuc = mysqli_query($baglanti, $kontrol);

    if (mysqli_num_rows($sonuc) > 0) {
        $mesaj = "Bu e-posta adresi zaten kayıtlı.";
    } else {
        $ekle = "INSERT INTO users (email, password, role, is_approved) 
                 VALUES ('$email', '$password', 'user', 0)";
        if (mysqli_query($baglanti, $ekle)) {
            $mesaj = "Kayıt başarılı! Lütfen giriş yapınız.";
        } else {
            $mesaj = "Kayıt sırasında bir hata oluştu.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Kayıt Ol</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="card shadow p-4" style="width: 100%; max-width: 400px;">
        <h2 class="text-center mb-4">Kayıt Ol</h2>

        <?php if (!empty($mesaj)) echo "<div class='alert alert-info'>$mesaj</div>"; ?>

        <form method="post">
            <div class="mb-3">
                <label class="form-label">Ad Soyad</label>
                <input type="text" name="fullname" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">E-posta</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Şifre</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="d-grid">
                <button type="submit" name="kayit" class="btn btn-primary">Kayıt Ol</button>
            </div>
        </form>

        <div class="mt-3 text-center">
            <a href="login.php">Zaten hesabınız var mı? Giriş Yap</a>
        </div>
    </div>
</div>

</body>
</html>
