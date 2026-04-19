<?php
session_start();
require_once '../config.php';

// Cek sesi login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit;
}

$id = $_SESSION['user_id'];

// Proses Simpan Data
if (isset($_POST['simpan'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $bio = mysqli_real_escape_string($conn, $_POST['bio']);
    $lokasi = mysqli_real_escape_string($conn, $_POST['lokasi']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $jk = mysqli_real_escape_string($conn, $_POST['jk']);
    $hp = mysqli_real_escape_string($conn, $_POST['hp']);
    $tgl_lahir = mysqli_real_escape_string($conn, $_POST['tgl_lahir']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $kodepos = mysqli_real_escape_string($conn, $_POST['kodepos']);

    // Proses Upload Foto jika ada
    $foto_query = "";
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $foto_name = time() . '_' . basename($_FILES['foto']['name']);
        $target_dir = "../assets/images/";
        if (move_uploaded_file($_FILES['foto']['tmp_name'], $target_dir . $foto_name)) {
            $foto_query = ", foto='$foto_name'";
            $_SESSION['user_foto'] = $foto_name;
        }
    }

    $query_update = "UPDATE users SET 
        nama='$nama', bio='$bio', lokasi='$lokasi', email='$email', 
        jk='$jk', hp='$hp', tgl_lahir='$tgl_lahir', password='$password', 
        alamat='$alamat', kodepos='$kodepos' 
        $foto_query
        WHERE id='$id'";

    mysqli_query($conn, $query_update);
    $_SESSION['user_nama'] = $nama;

    header("Location: index.php");
    exit;
}

// Ambil data user terbaru
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id='$id'"));

// QUERY JUMLAH PESANAN
$query_pesanan = mysqli_query($conn, "SELECT COUNT(*) as total FROM pesanan WHERE user_id='$id'");
$data_pesanan = mysqli_fetch_assoc($query_pesanan);
$jumlah_pesanan = $data_pesanan['total'];

function renderEditableField($field_id, $label, $value, $type = "text", $is_select = false, $options = []) {
    $display_value = ($type == 'password') ? str_repeat('•', 12) : htmlspecialchars($value);
    ?>
    <div class="flex items-center justify-between cursor-pointer group py-1" onclick="enableEdit('<?= $field_id ?>')">
        <div class="w-full pr-4">
            <label class="block font-bold text-[#030075] text-[14px] md:text-[15px] mb-1"><?= $label ?></label>
            <span id="display_<?= $field_id ?>" class="text-[13px] text-gray-500 block"><?= $display_value ?: '<span class="text-gray-300 italic">Belum diisi</span>' ?></span>
            <?php if ($is_select): ?>
                <select id="input_<?= $field_id ?>" name="<?= $field_id ?>" class="hidden w-full text-[13px] text-[#030075] font-semibold border-b-2 border-[#5543FF] bg-transparent outline-none pb-1 mt-1">
                    <?php foreach ($options as $opt): ?>
                        <option value="<?= $opt ?>" <?= ($value == $opt) ? 'selected' : '' ?>><?= $opt ?></option>
                    <?php endforeach; ?>
                </select>
            <?php else: ?>
                <input id="input_<?= $field_id ?>" type="<?= $type ?>" name="<?= $field_id ?>" value="<?= htmlspecialchars($value) ?>" class="hidden w-full text-[13px] text-[#030075] font-semibold border-b-2 border-[#5543FF] bg-transparent outline-none pb-1 mt-1">
            <?php endif; ?>
        </div>
        <svg id="icon_<?= $field_id ?>" class="w-2 h-3 text-[#030075] opacity-50 group-hover:opacity-100 shrink-0 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 8 14">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1l6 6-6 6"></path>
        </svg>
    </div>
    <?php
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - Candrasa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #F8F9FA; }
        select { -webkit-appearance: none; -moz-appearance: none; appearance: none; }
    </style>
</head>
<body class="text-[#030075] pb-24">

    <?php include '../components/navbar.php'; ?>

    <main class="max-w-[1100px] mx-auto mt-10 px-4">
        <form method="POST" action="" enctype="multipart/form-data" id="profileForm">

            <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 overflow-hidden mb-8">

                <div class="h-36 sm:h-44 bg-[#5543FF] relative w-full overflow-hidden flex items-center justify-center">
                    <img src="../assets/images/Banner2.svg" alt="Banner Profile" class="absolute inset-0 w-full h-full object-cover z-0">
                    <div class="absolute inset-0 opacity-40 z-0" style="background-image: radial-gradient(circle at 20px 20px, rgba(255,255,255,0.2) 2px, transparent 0); background-size: 40px 40px;"></div>
                </div>

                <div class="p-6 md:p-8 lg:p-10 flex flex-col lg:flex-row gap-8 lg:gap-10">

                    <div class="flex flex-col items-center shrink-0 -mt-20 z-10 w-full lg:w-48">
                        
                        <div class="relative flex flex-col items-center group cursor-pointer pb-2">
                            
                            <input type="file" name="foto" id="upload_foto" accept="image/*" 
                                class="absolute inset-0 w-full h-full opacity-0 z-50 cursor-pointer" title="Ganti Foto">

                            <div class="block relative w-36 h-36 rounded-full mb-3 select-none">
                                <?php
                                $foto_src = (!empty($user['foto']) && $user['foto'] != 'default.jpg')
                                    ? "../assets/images/" . $user['foto']
                                    : "https://ui-avatars.com/api/?name=" . urlencode($user['nama']) . "&size=200&background=random&color=fff";
                                ?>
                                <img id="preview_img" src="<?= $foto_src ?>" class="w-full h-full object-cover rounded-full border-4 border-white shadow-lg bg-white" alt="Avatar">

                                <div class="foto-overlay absolute inset-0 rounded-full bg-black/40 flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                    <svg class="w-7 h-7 text-white mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span class="text-white text-[10px] font-semibold">Ganti Foto</span>
                                </div>
                            </div>

                            <div class="bg-gray-100 text-[#5543FF] font-semibold text-[11px] px-4 py-1.5 rounded-full transition-all shadow-sm flex items-center gap-1 select-none group-hover:bg-gray-200">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Ubah Foto Profile
                            </div>

                        </div>

                        <p id="foto_status" class="text-[11px] text-green-600 font-bold mt-2 hidden text-center w-full">✓ Foto siap disimpan</p>
                    </div>

                    <div class="flex-1 lg:border-r border-gray-200 lg:pr-10">
                        <div class="flex items-center gap-2 mb-6">
                            <h3 class="text-[#5543FF] font-bold text-sm">Info Profil</h3>
                        </div>
                        <div class="space-y-6">
                            <?php renderEditableField("nama", "Nama Lengkap", $user['nama'] ?? ''); ?>
                            <?php renderEditableField("bio", "Bio", $user['bio'] ?? ''); ?>
                            <?php renderEditableField("lokasi", "Lokasi", $user['lokasi'] ?? ''); ?>
                        </div>
                    </div>

                    <div class="flex-1 space-y-7 mt-4 lg:mt-11">
                        <div>
                            <p class="font-bold text-[#030075] text-[15px] mb-1">Rating ke toko</p>
                            <p class="text-[13px] text-gray-500 flex items-center gap-2">
                                <span class="text-[#FFCC00] text-lg">★★★★<span class="text-gray-300">★</span></span> 4.0/5.0
                            </p>
                        </div>
                        <div>
                            <p class="font-bold text-[#030075] text-[15px] mb-1">Jumlah Pesanan</p>
                            <p class="text-[13px] text-gray-500"><?= $jumlah_pesanan ?> Pesanan</p>
                        </div>
                        <div>
                            <p class="font-bold text-[#030075] text-[15px] mb-1">Tanggal Bergabung</p>
                            <p class="text-[13px] text-gray-500"><?= date('d F Y', strtotime($user['created_at'])) ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 p-6 md:p-8 lg:p-10 mb-8">
                <div class="mb-8">
                    <h3 class="text-[#5543FF] font-bold text-sm">Info Pribadi</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-16 gap-y-8">

                    <div>
                        <label class="block font-bold text-[#030075] text-[15px] mb-1">User ID</label>
                        <p class="text-[13px] text-gray-500">21021902190<?= $user['id'] ?></p>
                    </div>

                    <?php renderEditableField("email", "Email", $user['email'] ?? '', "email"); ?>
                    <?php renderEditableField("jk", "Jenis Kelamin", $user['jk'] ?? 'Pria', "text", true, ["Pria", "Wanita"]); ?>
                    <?php renderEditableField("hp", "Nomor HP", $user['hp'] ?? '', "tel"); ?>
                    <?php renderEditableField("tgl_lahir", "Tanggal Lahir", $user['tgl_lahir'] ?? '', "date"); ?>
                    <?php renderEditableField("password", "Password", $user['password'] ?? '', "password"); ?>

                    <div class="mt-0 md:mt-4">
                        <label class="block font-bold text-[#030075] text-[15px] mb-2">Alamat</label>
                        <input type="text" name="alamat" value="<?= htmlspecialchars($user['alamat'] ?? '') ?>" placeholder="Masukkan alamat lengkap..." class="w-full border border-gray-300 rounded-lg px-4 py-3 text-[13px] text-gray-700 outline-none focus:border-[#5543FF] focus:ring-1 focus:ring-[#5543FF] transition-all">
                    </div>

                    <div class="mt-0 md:mt-4">
                        <label class="block font-bold text-[#030075] text-[15px] mb-2">Kode Pos <span class="font-normal text-gray-400">(Opsional)</span></label>
                        <input type="text" name="kodepos" value="<?= htmlspecialchars($user['kodepos'] ?? '') ?>" placeholder="Contoh: 16411" class="w-full border border-gray-300 rounded-lg px-4 py-3 text-[13px] text-gray-700 outline-none focus:border-[#5543FF] focus:ring-1 focus:ring-[#5543FF] transition-all">
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between px-2 gap-5">
                <button type="submit" name="simpan"
                    class="w-full sm:w-auto bg-[#5543FF] text-white px-10 py-3.5 rounded-xl font-bold text-[15px] flex justify-center items-center gap-3 hover:bg-[#4030d9] active:scale-95 transition-all shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Simpan Perubahan
                </button>
                <a href="../logout.php" class="text-red-500 font-bold text-[15px] hover:text-red-700 transition-colors">
                    Log Out
                </a>
            </div>

        </form>
    </main>

    <script>
        // ===================== EDIT FIELD =====================
        function enableEdit(id) {
            const display = document.getElementById('display_' + id);
            const icon = document.getElementById('icon_' + id);
            const input = document.getElementById('input_' + id);

            display.classList.add('hidden');
            icon.classList.add('hidden');
            input.classList.remove('hidden');
            input.focus();
        }

        // ===================== PREVIEW FOTO =====================
        document.getElementById('upload_foto').addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (!file) return;

            // Validasi tipe file
            if (!file.type.startsWith('image/')) {
                alert('File harus berupa gambar (JPG, PNG, dll).');
                this.value = '';
                return;
            }

            // Validasi ukuran maks 5MB
            if (file.size > 5 * 1024 * 1024) {
                alert('Ukuran foto maksimal 5MB.');
                this.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function (ev) {
                document.getElementById('preview_img').src = ev.target.result;
                document.getElementById('foto_status').classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        });
    </script>
</body>
</html>