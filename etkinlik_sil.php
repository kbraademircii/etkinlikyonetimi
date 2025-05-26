<?php
session_start();
include("baglanti.php");

if (!isset($_SESSION["kullanici_id"]) || $_SESSION["rol"] !== "admin") {
    header("Location: login.php");
    exit();
}

if (isset($_GET["id"])) {
    $id = intval($_GET["id"]);

    
    mysqli_query($baglanti, "DELETE FROM orders WHERE event_id = $id");

    
    mysqli_query($baglanti, "DELETE FROM cart WHERE event_id = $id");

    
    mysqli_query($baglanti, "DELETE FROM events WHERE id = $id");
}

header("Location: etkinlik_listele.php?silindi=1");
exit();

