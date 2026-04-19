<?php
session_start();
require_once '../config.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit;
}

$id = $_SESSION['user_id'];

// 1. Ambil data User
$user_query = mysqli_query($conn, "SELECT * FROM users WHERE id='$id'");
$user = mysqli_fetch_assoc($user_query);

// 2. Hitung Jumlah Pesanan User
$query_pesanan = mysqli_query($conn, "SELECT COUNT(id) as total FROM pesanan WHERE user_id='$id'");
$data_pesanan = $query_pesanan ? mysqli_fetch_assoc($query_pesanan) : ['total' => 0];
$total_pesanan = $data_pesanan['total'];

// 3. Hitung Rating yang diberikan User ke Toko
// Menggunakan @ agar tidak error jika tabel feedbacks belum ada
$query_rating = @mysqli_query($conn, "SELECT AVG(rating_val) as rata_rata FROM feedbacks WHERE nama='".$user['nama']."'");
$data_rating = $query_rating ? mysqli_fetch_assoc($query_rating) : ['rata_rata' => 0];
$rating_user = $data_rating['rata_rata'] ?? 0;

// Logika Bintang
$bintang_penuh = floor($rating_user);
$bintang_kosong = 5 - $bintang_penuh;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - Candrasa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Poppins', sans-serif; background-color: #F8F9FA; }</style>
</head>
<body class="text-[#030075] pb-20">

    <?php include '../components/navbar.php'; ?>
    
    <main class="max-w-[1100px] mx-auto mt-10 px-4">
        
<div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden mb-8">
            <div class="h-44 bg-[#5543FF] relative w-full overflow-hidden flex items-center justify-center">
                
                <img src="../assets/images/Banner2.svg" alt="Banner Profile" class="absolute inset-0 w-full h-full object-cover z-0">

                <div class="absolute inset-0 opacity-40 z-0" style="background-image: radial-gradient(circle at 20px 20px, rgba(255, 255, 255, 0.2) 2px, transparent 0); background-size: 40px 40px;"></div>
                
            </div>

            <div class="p-8 md:p-10 flex flex-col md:flex-row gap-10 md:gap-16">
                <div class="w-full md:w-1/3 flex flex-col items-center">
                    
                    <?php 
                        $foto_src = (!empty($user['foto']) && $user['foto'] != 'default.jpg') 
                                    ? "../assets/images/" . $user['foto'] 
                                    : "https://ui-avatars.com/api/?name=" . urlencode($user['nama'] ?? 'User') . "&size=200&background=random"; 
                    ?>
                    <img src="<?= $foto_src ?>" alt="Foto Profil" class="w-40 h-40 rounded-full border-4 border-white shadow-xl -mt-28 mb-8 object-cover bg-white relative z-10">
                    
                    <div class="w-full space-y-6 px-4">
                        <div class="border-b border-gray-50 pb-3">
                            <p class="text-gray-400 text-[13px] mb-1">Nama Lengkap</p>
                            <p class="font-bold text-[#030075] text-[15px]"><?= htmlspecialchars($user['nama']) ?></p>
                        </div>
                        <div class="border-b border-gray-50 pb-3">
                            <p class="text-gray-400 text-[13px] mb-1">Bio</p>
                            <p class="font-bold text-[#030075] text-[15px]"><?= htmlspecialchars($user['bio']) ?></p>
                        </div>
                        <div class="pb-3">
                            <p class="text-gray-400 text-[13px] mb-1">Lokasi</p>
                            <p class="font-bold text-[#030075] text-[15px]"><?= htmlspecialchars($user['lokasi']) ?></p>
                        </div>
                    </div>
                </div>
                
                <div class="w-full md:w-2/3 space-y-4 md:space-y-6 mt-6 md:mt-0 md:pl-6">
                    
                    <div class="border-b border-gray-100 py-4 flex items-center justify-between">
                        <div>
                            <p class="font-bold text-[#030075] text-base mb-1">Rating ke toko</p>
                            <p class="text-[13px] text-gray-500 flex items-center gap-2">
                                <span class="text-[#5543FF] text-lg tracking-widest">
                                    <?= str_repeat('★', $bintang_penuh) ?><span class="text-gray-300"><?= str_repeat('★', $bintang_kosong) ?></span>
                                </span> 
                                <span class="font-semibold text-[#030075]"><?= number_format($rating_user, 1) ?>/5.0</span>
                            </p>
                        </div>
                        <svg class="w-6 h-6 text-[#030075] opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                    </div>
                    
                    <div class="border-b border-gray-100 py-4 flex items-center justify-between">
                        <div>
                            <p class="font-bold text-[#030075] text-base mb-1">Jumlah Pesanan</p>
                            <p class="text-[13px] text-gray-500">
                                <?= $total_pesanan > 0 ? "<span class='text-green-600 font-semibold'>Pelanggan Gacor!!</span>" : "Belum ada pesanan" ?> / <span class="font-bold text-[#030075]"><?= $total_pesanan ?> Pesanan</span>
                            </p>
                        </div>
                        <svg class="w-6 h-6 text-[#030075] opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </div>

                    <div class="py-4 flex items-center justify-between">
                        <div>
                            <p class="font-bold text-[#030075] text-base mb-1">Tanggal Bergabung</p>
                            <p class="text-[13px] font-semibold text-gray-500">
                                <?= date('d F Y', strtotime($user['created_at'])) ?>
                            </p>
                        </div>
                        <svg class="w-6 h-6 text-[#030075] opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between px-2 mt-4">
            <a href="edit.php" class="bg-[#5543FF] text-white px-10 py-3 rounded-xl font-bold text-[15px] flex items-center gap-3 hover:bg-[#4030d9] transition-all shadow-md active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                Edit Profil
            </a>

            <a href="../logout.php" class="text-red-600 font-bold text-[16px] flex items-center gap-3 hover:opacity-70 transition-all">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M16 13v-2H7V8l-5 4 5 4v-3h9zM20 3h-9c-1.103 0-2 .897-2 2v4h2V5h9v14h-9v-4H9v4c0 1.103.897 2 2 2h9c1.103 0 2-.897 2-2V5c0-1.103-.897-2-2-2z"></path></svg>
                Log Out
            </a>
        </div>

    </main>

</body>
</html>