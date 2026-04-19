<?php
session_start();
require_once 'config.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$id_user = $_SESSION['user_id'];

// --- LOGIKA UPDATE & HAPUS KERANJANG ---
if (isset($_GET['action']) && isset($_GET['cart_id'])) {
    $cart_id = (int)$_GET['cart_id'];
    $action = $_GET['action'];

    if ($action == 'plus') {
        mysqli_query($conn, "UPDATE keranjang SET qty = qty + 1 WHERE id = $cart_id AND user_id = $id_user");
    } elseif ($action == 'minus') {
        // Jangan sampai qty kurang dari 1
        mysqli_query($conn, "UPDATE keranjang SET qty = GREATEST(qty - 1, 1) WHERE id = $cart_id AND user_id = $id_user");
    } elseif ($action == 'delete') {
        mysqli_query($conn, "DELETE FROM keranjang WHERE id = $cart_id AND user_id = $id_user");
    }
    header("Location: cart.php");
    exit;
}

// --- AMBIL DATA KERANJANG ---
$query_cart = mysqli_query($conn, "
    SELECT k.id as cart_id, k.qty, p.nama_produk, p.harga, p.gambar, p.kategori 
    FROM keranjang k 
    JOIN products p ON k.product_id = p.id 
    WHERE k.user_id = '$id_user' 
    ORDER BY k.created_at DESC
");

$cart_items = [];
$subtotal = 0;
while ($row = mysqli_fetch_assoc($query_cart)) {
    $cart_items[] = $row;
    $subtotal += ($row['harga'] * $row['qty']);
}

// Pajak & Biaya Admin (Opsional, saya buat statis untuk UI)
$tax = $subtotal > 0 ? $subtotal * 0.11 : 0; // PPN 11%
$admin_fee = $subtotal > 0 ? 2000 : 0;
$total_bayar = $subtotal + $tax + $admin_fee;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - Candrasa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #F8F9FA; }
        /* Menyembunyikan radio button asli */
        input[type="radio"]:checked + div {
            border-color: #5543FF;
            background-color: #F3F0FF;
        }
        input[type="radio"]:checked + div .check-icon {
            opacity: 1;
            transform: scale(1);
        }
    </style>
</head>
<body class="text-[#030075] pb-20">

    <?php include 'components/navbar.php'; ?>

    <main class="max-w-[1100px] mx-auto mt-10 px-4 md:px-6">
        
        <div class="flex items-center gap-3 mb-8">
            <a href="home.php" class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-sm border border-gray-100 hover:bg-gray-50 transition">
                <svg class="w-5 h-5 text-[#030075]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <h1 class="text-2xl font-extrabold tracking-tight">Keranjang Belanja</h1>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2 space-y-5">
                
                <?php if (count($cart_items) > 0): ?>
                    <?php foreach ($cart_items as $item): ?>
                    <div class="bg-white p-5 rounded-[24px] shadow-sm border border-gray-100 flex flex-col sm:flex-row items-start sm:items-center gap-5 transition-all hover:shadow-md">
                        <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-2xl overflow-hidden shrink-0 border border-gray-100 bg-gray-50">
                            <img src="assets/images/<?= htmlspecialchars($item['gambar']) ?>" alt="<?= htmlspecialchars($item['nama_produk']) ?>" class="w-full h-full object-cover" onerror="this.src='https://images.unsplash.com/photo-1598128558393-70ff21433be0?w=200'">
                        </div>
                        
                        <div class="flex-1 w-full">
                            <p class="text-[11px] font-bold text-[#5543FF] uppercase tracking-wider mb-1"><?= htmlspecialchars($item['kategori']) ?></p>
                            <h3 class="font-bold text-[16px] text-[#030075] leading-tight mb-2"><?= htmlspecialchars($item['nama_produk']) ?></h3>
                            <p class="font-extrabold text-[15px] text-black">Rp <?= number_format($item['harga'], 0, ',', '.') ?></p>
                        </div>
                        
                        <div class="flex sm:flex-col items-center justify-between w-full sm:w-auto gap-4 sm:gap-6 mt-2 sm:mt-0">
                            <a href="?action=delete&cart_id=<?= $item['cart_id'] ?>" onclick="return confirm('Hapus item ini dari keranjang?')" class="text-gray-400 hover:text-red-500 transition-colors sm:self-end">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </a>
                            
                            <div class="flex items-center bg-gray-50 border border-gray-200 rounded-full p-1">
                                <a href="?action=minus&cart_id=<?= $item['cart_id'] ?>" class="w-8 h-8 flex items-center justify-center rounded-full bg-white text-[#030075] font-bold shadow-sm hover:bg-gray-100 transition">-</a>
                                <span class="w-10 text-center text-[13px] font-bold"><?= $item['qty'] ?></span>
                                <a href="?action=plus&cart_id=<?= $item['cart_id'] ?>" class="w-8 h-8 flex items-center justify-center rounded-full bg-[#030075] text-white font-bold shadow-sm hover:bg-black transition">+</a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="bg-white p-10 rounded-[32px] shadow-sm border border-gray-100 flex flex-col items-center justify-center text-center h-80">
                        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        </div>
                        <h3 class="font-bold text-lg text-[#030075] mb-2">Keranjangmu Kosong</h3>
                        <p class="text-[13px] text-gray-400 mb-6 max-w-xs">Sepertinya kamu belum menambahkan roti apapun ke keranjang.</p>
                        <a href="home.php" class="bg-[#FFCC00] text-[#030075] px-8 py-3 rounded-full font-bold shadow-md hover:bg-[#e6b800] transition active:scale-95">Mulai Belanja</a>
                    </div>
                <?php endif; ?>
                
            </div>

            <div class="lg:col-span-1">
                <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 p-6 sm:p-8 sticky top-32">
                    <h3 class="font-extrabold text-[16px] text-[#030075] border-b border-gray-100 pb-4 mb-6">Ringkasan Pesanan</h3>
                    
                    <div class="space-y-4 mb-6 text-[13px] font-medium text-gray-500">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span class="text-[#030075] font-bold">Rp <?= number_format($subtotal, 0, ',', '.') ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span>PPN (11%)</span>
                            <span class="text-[#030075] font-bold">Rp <?= number_format($tax, 0, ',', '.') ?></span>
                        </div>
                        <div class="flex justify-between border-b border-gray-100 pb-4">
                            <span>Biaya Admin</span>
                            <span class="text-[#030075] font-bold">Rp <?= number_format($admin_fee, 0, ',', '.') ?></span>
                        </div>
                        <div class="flex justify-between items-center pt-2">
                            <span class="text-[15px] font-bold text-black">Total Bayar</span>
                            <span class="text-[18px] font-extrabold text-[#5543FF]">Rp <?= number_format($total_bayar, 0, ',', '.') ?></span>
                        </div>
                    </div>

                    <h3 class="font-bold text-[14px] text-[#030075] mb-4">Metode Pembayaran</h3>
                    
                    <div class="space-y-3 mb-8">
                        <label class="cursor-pointer block relative">
                            <input type="radio" name="payment" value="qris" class="peer sr-only" checked>
                            <div class="flex items-center justify-between p-4 rounded-2xl border-2 border-gray-100 transition-all">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-white rounded-xl shadow-sm border border-gray-100 flex items-center justify-center">
                                        <img src="assets/images/qris-logo.jpg" alt="QRIS" class="w-6" onerror="this.src='https://via.placeholder.com/24?text=Q'">
                                    </div>
                                    <div>
                                        <p class="font-bold text-[#030075] text-[13px]">QRIS</p>
                                        <p class="text-[10px] text-gray-400">Gopay, OVO, Dana, ShopeePay</p>
                                    </div>
                                </div>
                                <div class="check-icon w-5 h-5 rounded-full bg-[#5543FF] flex items-center justify-center opacity-0 scale-50 transition-all duration-300">
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                            </div>
                        </label>

                        <label class="cursor-pointer block relative">
                            <input type="radio" name="payment" value="cash" class="peer sr-only">
                            <div class="flex items-center justify-between p-4 rounded-2xl border-2 border-gray-100 transition-all">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-white rounded-xl shadow-sm border border-gray-100 flex items-center justify-center">
                                        <span class="text-xl">💵</span>
                                    </div>
                                    <div>
                                        <p class="font-bold text-[#030075] text-[13px]">Cash / Tunai</p>
                                        <p class="text-[10px] text-gray-400">Bayar di kasir toko</p>
                                    </div>
                                </div>
                                <div class="check-icon w-5 h-5 rounded-full bg-[#5543FF] flex items-center justify-center opacity-0 scale-50 transition-all duration-300">
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                            </div>
                        </label>
                    </div>

                    <?php if (count($cart_items) > 0): ?>
                        <div class="relative group w-full">
                            <a href="javascript:void(0)" class="w-full flex items-center justify-center gap-2 bg-[#030075] text-white py-4 rounded-2xl font-bold shadow-lg opacity-80 cursor-not-allowed transition-all hover:bg-black">
                                Checkout Sekarang
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                            <div class="absolute -top-12 left-1/2 -translate-x-1/2 bg-gray-800 text-white text-[11px] font-bold py-2 px-4 rounded-xl opacity-0 group-hover:opacity-100 group-hover:-top-14 transition-all duration-300 pointer-events-none whitespace-nowrap shadow-xl">
                                Fitur Checkout Coming Soon 🚀
                                <div class="absolute -bottom-1.5 left-1/2 -translate-x-1/2 w-3 h-3 bg-gray-800 rotate-45"></div>
                            </div>
                        </div>
                    <?php else: ?>
                        <button disabled class="w-full bg-gray-200 text-gray-400 py-4 rounded-2xl font-bold cursor-not-allowed">
                            Checkout Sekarang
                        </button>
                    <?php endif; ?>

                </div>
            </div>

        </div>
    </main>

</body>
</html>