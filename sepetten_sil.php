<?php
session_start();
include("baglanti.php");


if (!isset($_SESSION["kullanici_id"])) {
    header("Location: login.php");
    exit();
}


if (isset($_GET["id"])) {
    $sepet_id = intval($_GET["id"]);
    $user_id = $_SESSION["kullanici_id"];

    
    $sorgu = "DELETE FROM cart WHERE id = $sepet_id AND user_id = $user_id";
    mysqli_query($baglanti, $sorgu);
}


header("Location: sepetim.php");
exit();

