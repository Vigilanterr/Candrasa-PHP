<?php
// config.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ... sisa konfigurasi database kamu
// Ganti ke 'false' saat diupload ke InfinityFree
$is_localhost = true; 

if ($is_localhost) {
    $host = "localhost";
    $user = "root"; // Default XAMPP
    $pass = "";     // Default XAMPP
    $db   = "candrasa_bakery";
} else {
    // Sesuaikan dengan data MySQL di Control Panel InfinityFree
    $host = "sqlxxx.epizy.com"; 
    $user = "epiz_xxxxxxx";
    $pass = "password_infinityfree_kamu";
    $db   = "epiz_xxxxxxx_candrasa_bakery";
}

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>