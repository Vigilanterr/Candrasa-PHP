<?php
require_once 'config.php';

$error = "";
$success = "";

// 1. LOGIKA LOGIN ADMIN
if (isset($_POST['login_admin'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Mencari user dengan role admin
    $query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' AND role='admin'");
    $data = mysqli_fetch_assoc($query);

    if ($data && $password === $data['password']) {
        $_SESSION['admin_id'] = $data['id'];
        $_SESSION['admin_name'] = $data['nama'];
    } else {
        $error = "Email atau Password Admin salah!";
    }
}

// 2. LOGIKA LOGOUT
if (isset($_GET['logout'])) {
    unset($_SESSION['admin_id']);
    header("Location: kelola.php");
    exit;
}

// 3. LOGIKA TAMBAH PRODUK
if (isset($_POST['tambah_produk']) && isset($_SESSION['admin_id'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama_produk']);
    $harga = $_POST['harga'];
    $kategori = $_POST['kategori'];
    $rating = $_POST['rating'];
    $stok = $_POST['stok'];
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $is_popular = isset($_POST['is_popular']) ? 1 : 0;
    
    // Upload Gambar
    $filename = $_FILES['gambar']['name'];
    $tmp_name = $_FILES['gambar']['tmp_name'];
    
    if ($filename != "") {
        move_uploaded_file($tmp_name, "assets/images/" . $filename);
        
        $query_ins = "INSERT INTO products (nama_produk, harga, kategori, gambar, deskripsi, rating, status_stok, is_popular) 
                      VALUES ('$nama', '$harga', '$kategori', '$filename', '$deskripsi', '$rating', '$stok', '$is_popular')";
        
        if (mysqli_query($conn, $query_ins)) {
            $success = "Produk berhasil ditambahkan!";
        } else {
            $error = "Gagal input data: " . mysqli_error($conn);
        }
    } else {
        $error = "Pilih gambar produk terlebih dahulu!";
    }
}

// 4. LOGIKA HAPUS PRODUK (Opsional agar mudah kelola)
if (isset($_GET['hapus']) && isset($_SESSION['admin_id'])) {
    $id_hapus = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM products WHERE id = '$id_hapus'");
    header("Location: kelola.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Candrasa Bakery</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 text-[#030075]">

    <?php if (!isset($_SESSION['admin_id'])): ?>
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="bg-white p-8 rounded-[32px] shadow-2xl w-full max-w-md border border-gray-200">
            <div class="text-center mb-8">
                <img src="assets/images/Candrasa Putih.svg" alt="Logo" class="w-32 mx-auto mb-4 filter brightness-0">
                <h1 class="text-2xl font-black">ADMIN PANEL</h1>
                <p class="text-gray-400 text-[10px] uppercase tracking-[3px] mt-1">Kelola Produk & Stok</p>
            </div>
            
            <?php if($error): ?>
                <div class="bg-red-100 text-red-600 p-3 rounded-xl text-xs font-bold mb-4 border border-red-200">
                    <?= $error ?>
                </div>
            <?php endif; ?>

            <form action="" method="POST" class="space-y-5">
                <div>
                    <label class="text-[11px] font-bold text-gray-500 uppercase ml-1">Email Admin</label>
                    <input type="email" name="email" placeholder="admin@candrasa.com" class="w-full px-5 py-3 rounded-2xl bg-gray-50 border border-gray-200 focus:ring-2 focus:ring-[#030075] outline-none transition-all" required>
                </div>
                <div>
                    <label class="text-[11px] font-bold text-gray-500 uppercase ml-1">Password</label>
                    <input type="password" name="password" placeholder="••••••••" class="w-full px-5 py-3 rounded-2xl bg-gray-50 border border-gray-200 focus:ring-2 focus:ring-[#030075] outline-none transition-all" required>
                </div>
                <button type="submit" name="login_admin" class="w-full bg-[#030075] text-white py-4 rounded-2xl font-bold shadow-lg hover:bg-black transition-all active:scale-95">
                    LOGIN KE DASHBOARD
                </button>
            </form>
        </div>
    </div>

    <?php else: ?>
    <nav class="bg-[#030075] text-white p-5 flex justify-between items-center px-6 md:px-20 sticky top-0 z-50">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">🔥</div>
            <h2 class="font-bold tracking-tight">Admin Candrasa</h2>
        </div>
        <div class="flex items-center gap-6">
            <span class="text-xs font-medium opacity-80 uppercase tracking-widest">Halo, <?= $_SESSION['admin_name'] ?></span>
            <a href="?logout=1" class="bg-red-500 hover:bg-red-600 px-5 py-1.5 rounded-full text-[10px] font-bold transition-all shadow-lg">LOGOUT</a>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto py-10 px-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-1">
                <div class="bg-white p-6 rounded-[32px] shadow-sm border border-gray-200 sticky top-24">
                    <h2 class="text-lg font-black mb-6 border-b pb-3">Tambah Produk</h2>
                    
                    <?php if($success): ?>
                        <div class="bg-green-100 text-green-600 p-3 rounded-xl text-xs font-bold mb-4 border border-green-200"><?= $success ?></div>
                    <?php endif; ?>

                    <form action="" method="POST" enctype="multipart/form-data" class="space-y-4">
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 uppercase">Nama Produk</label>
                            <input type="text" name="nama_produk" class="w-full px-4 py-2.5 rounded-xl bg-gray-50 border text-sm outline-none" placeholder="Cheese Bread" required>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="text-[10px] font-bold text-gray-400 uppercase">Harga</label>
                                <input type="number" name="harga" class="w-full px-4 py-2.5 rounded-xl bg-gray-50 border text-sm outline-none" placeholder="45000" required>
                            </div>
                            <div>
                                <label class="text-[10px] font-bold text-gray-400 uppercase">Rating</label>
                                <input type="text" name="rating" class="w-full px-4 py-2.5 rounded-xl bg-gray-50 border text-sm outline-none" placeholder="4.5">
                            </div>
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 uppercase">Kategori</label>
                            <select name="kategori" class="w-full px-4 py-2.5 rounded-xl bg-gray-50 border text-sm outline-none">
                                <option value="Roti Manis">Roti Manis</option>
                                <option value="Roti Gurih">Roti Gurih</option>
                                <option value="Biskuit">Biskuit</option>
                                <option value="Dessert">Dessert</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 uppercase">Status Stok</label>
                            <select name="stok" class="w-full px-4 py-2.5 rounded-xl bg-gray-50 border text-sm outline-none">
                                <option value="Ready">Ready</option>
                                <option value="Sold Out">Sold Out</option>
                            </select>
                        </div>
                        <div class="flex items-center gap-3 p-3 bg-purple-50 rounded-xl border border-purple-100">
                            <input type="checkbox" name="is_popular" value="1" class="w-4 h-4 accent-[#5543FF]">
                            <label class="text-[10px] font-bold uppercase text-[#5543FF]">Tandai Populer 🔥</label>
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 uppercase">Gambar</label>
                            <input type="file" name="gambar" class="w-full text-[10px] mt-1" required>
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 uppercase">Deskripsi</label>
                            <textarea name="deskripsi" rows="2" class="w-full px-4 py-2.5 rounded-xl bg-gray-50 border text-sm outline-none"></textarea>
                        </div>
                        <button type="submit" name="tambah_produk" class="w-full bg-[#5543FF] text-white py-3 rounded-xl font-bold shadow-lg hover:bg-[#030075] transition-all">SIMPAN</button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-white rounded-[32px] shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-6 border-b">
                        <h2 class="text-lg font-black">Daftar Produk Terinput</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 text-[10px] uppercase tracking-widest text-gray-400">
                                    <th class="p-4">Produk</th>
                                    <th class="p-4">Kategori</th>
                                    <th class="p-4">Harga</th>
                                    <th class="p-4">Stok</th>
                                    <th class="p-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm">
                                <?php 
                                $list_query = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC");
                                while($row = mysqli_fetch_assoc($list_query)):
                                ?>
                                <tr class="border-b hover:bg-gray-50 transition">
                                    <td class="p-4 flex items-center gap-3">
                                        <img src="assets/images/<?= $row['gambar'] ?>" class="w-10 h-10 rounded-lg object-cover shadow-sm">
                                        <span class="font-bold text-[#030075]"><?= $row['nama_produk'] ?> <?= $row['is_popular'] ? '🔥' : '' ?></span>
                                    </td>
                                    <td class="p-4 text-xs"><?= $row['kategori'] ?></td>
                                    <td class="p-4 font-bold text-xs text-purple-600">Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                                    <td class="p-4">
                                        <span class="px-3 py-1 rounded-full text-[9px] font-bold <?= $row['status_stok'] == 'Ready' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' ?>">
                                            <?= $row['status_stok'] ?>
                                        </span>
                                    </td>
                                    <td class="p-4 text-center">
                                        <a href="?hapus=<?= $row['id'] ?>" onclick="return confirm('Yakin hapus produk ini?')" class="text-red-500 hover:text-red-700 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <?php endif; ?>

</body>
</html>