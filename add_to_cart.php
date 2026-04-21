<?php
session_start();
require_once 'config.php';

header('Content-Type: application/json');

// 1. Cek Login
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'login']);
    exit;
}

if (isset($_GET['id'])) {
    $product_id = (int)$_GET['id'];
    $user_id = $_SESSION['user_id'];

    $cek_keranjang = mysqli_query($conn, "SELECT * FROM keranjang WHERE user_id='$user_id' AND product_id='$product_id'");
    if (mysqli_num_rows($cek_keranjang) > 0) {
        mysqli_query($conn, "UPDATE keranjang SET qty = qty + 1 WHERE user_id='$user_id' AND product_id='$product_id'");
    } else {
        mysqli_query($conn, "INSERT INTO keranjang (user_id, product_id, qty) VALUES ('$user_id', '$product_id', 1)");
    }

    // 3. Hitung jumlah total item di keranjang saat ini
    $q_cart = mysqli_query($conn, "SELECT SUM(qty) as total FROM keranjang WHERE user_id='$user_id'");
    $d_cart = mysqli_fetch_assoc($q_cart);
    $total_qty = $d_cart['total'] ?? 0;

    // 4. Kirim balasan JSON
    echo json_encode(['status' => 'success', 'cart_count' => $total_qty]);
    exit;
}
?>