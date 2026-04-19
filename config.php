<?php
<<<<<<< HEAD
=======
// config.php
>>>>>>> 32ffd7f8c204e0f46471282ddea2f6122a0418d3
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

<<<<<<< HEAD
// Set timezone ke WIB sebelum koneksi
date_default_timezone_set('Asia/Jakarta');

// Deteksi otomatis apakah sedang di hosting atau lokal
if ($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == '127.0.0.1') {
    // Pengaturan Lokal (XAMPP)
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db   = "candrasa_bakery";
} else {
    // Pengaturan Hosting (InfinityFree)
    $host = "sql306.infinityfree.com"; 
    $user = "if0_41692078";
    $pass = "g6ZtH8uPGzi";
    $db   = "if0_41692078_candrasa_bakery";
=======
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
>>>>>>> 32ffd7f8c204e0f46471282ddea2f6122a0418d3
}

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
<<<<<<< HEAD

// Set timezone MySQL ke WIB (+07:00)
mysqli_query($conn, "SET time_zone = '+07:00'");
=======
>>>>>>> 32ffd7f8c204e0f46471282ddea2f6122a0418d3
?>