<?php
session_start();
include("baglanti.php");

if (!isset($_SESSION["kullanici_id"])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION["kullanici_id"];
    $event_id = intval($_POST["event_id"]);
    $adet = intval($_POST["adet"]);

    if (isset($_POST["kategori_fiyat"])) {
        list($kategori, $fiyat) = explode('|', $_POST["kategori_fiyat"]);
        $kategori = mysqli_real_escape_string($baglanti, $kategori);
        $fiyat = intval($fiyat);
    } else {
        $_SESSION["hata"] = "Kategori seçilmedi!";
        header("Location: etkinlikler.php");
        exit();
    }

    $kontrol = mysqli_query($baglanti, "SELECT * FROM cart WHERE user_id = $user_id AND event_id = $event_id AND ticket_category = '$kategori'");
    if (mysqli_num_rows($kontrol) > 0) {
        mysqli_query($baglanti, "UPDATE cart SET adet = adet + $adet WHERE user_id = $user_id AND event_id = $event_id AND ticket_category = '$kategori'");
    } else {
        mysqli_query($baglanti, "INSERT INTO cart (user_id, event_id, ticket_category, ticket_price, adet)
                                 VALUES ($user_id, $event_id, '$kategori', $fiyat, $adet)");
    }

    header("Location: sepetim.php");
    exit();
}
?>



