<?php
session_start();
include("baglanti.php");

if (!isset($_SESSION["kullanici_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["kullanici_id"];
$sepet = mysqli_query($baglanti, "SELECT * FROM cart WHERE user_id = $user_id");

while ($satir = mysqli_fetch_assoc($sepet)) {
    $event_id = $satir["event_id"];
    $adet = $satir["adet"];
    $kategori = $satir["ticket_category"];
    $fiyat = $satir["ticket_price"];
    $toplam = $fiyat * $adet;

    mysqli_query($baglanti, "INSERT INTO orders (user_id, event_id, quantity, total_price, payment_method, order_date)
                              VALUES ($user_id, $event_id, $adet, $toplam, 'Kredi Kartı', NOW())");

    mysqli_query($baglanti, "UPDATE events SET available_seats = available_seats - $adet WHERE id = $event_id");
}

mysqli_query($baglanti, "DELETE FROM cart WHERE user_id = $user_id");


echo "
<!DOCTYPE html>
<html lang='tr'>
<head>
    <meta charset='UTF-8'>
    <title>Satın Alma Başarılı</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
    <meta http-equiv='refresh' content='3;url=anasayfa.php'>
</head>
<body class='bg-light'>
    <div class='container text-center mt-5'>
        <div class='alert alert-primary shadow-sm p-4'>
            <h4 class='mb-3'>🎉 Satın alma işleminiz başarıyla tamamlandı!</h4>
            <p>3 saniye içinde ana sayfaya yönlendirileceksiniz...</p>
            <a href='anasayfa.php' class='btn btn-primary'>← Ana Sayfaya Dön</a>
        </div>
    </div>
</body>
</html>";
?>




