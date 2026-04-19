<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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
}

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Set timezone MySQL ke WIB (+07:00)
mysqli_query($conn, "SET time_zone = '+07:00'");
?>