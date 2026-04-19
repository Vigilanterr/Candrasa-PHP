<?php
// Mendapatkan nama file saat ini untuk menentukan link aktif
$current_page = basename($_SERVER['PHP_SELF']);

// Deteksi apakah navbar dipanggil dari dalam subfolder (misal: folder 'profil')
$in_subfolder = (basename(dirname($_SERVER['PHP_SELF'])) == 'profil');
$path_prefix = $in_subfolder ? '../' : '';

// Ambil data nama user dari session jika sudah login
$nama_display = isset($_SESSION['user_nama']) ? $_SESSION['user_nama'] : (isset($_SESSION['user_email']) ? explode('@', $_SESSION['user_email'])[0] : 'Guest');

// Ambil foto profil dari session
if (isset($_SESSION['user_foto']) && !empty($_SESSION['user_foto']) && $_SESSION['user_foto'] != 'default.jpg') {
    $foto_display = $path_prefix . "assets/images/" . $_SESSION['user_foto'];
} else {
    $foto_display = "https://ui-avatars.com/api/?name=" . urlencode($nama_display) . "&background=random&color=fff";
}

// MENGHITUNG JUMLAH ITEM DI KERANJANG
$cart_count = 0;
if (isset($_SESSION['user_id'])) {
    $uid = $_SESSION['user_id'];
    $q_cart = mysqli_query($conn, "SELECT SUM(qty) as total FROM keranjang WHERE user_id='$uid'");
    if ($q_cart) {
        $d_cart = mysqli_fetch_assoc($q_cart);
        $cart_count = $d_cart['total'] ?? 0;
    }
}
?>

<div class="bg-[#030075] text-white font-sans sticky top-0 z-30 shadow-md">
    <div class="flex items-center justify-between px-4 sm:px-6 lg:px-8 py-3.5">

        <!-- LOGO -->
        <div class="shrink-0">
            <img src="<?= $path_prefix ?>assets/images/CandrasaPutih.svg" alt="logocandrasa" class="w-24 sm:w-28 lg:w-32" onerror="this.src='https://via.placeholder.com/150x50?text=CANDRASA'">
        </div>

        <!-- SEARCHBAR DESKTOP ONLY -->
        <div class="hidden lg:block">
            <div class="searchbar">
                <form class="relative w-full md:w-64 lg:w-80">
                    <input type="text" placeholder="Search products..." class="w-full rounded-full bg-white/10 backdrop-blur-md border border-white/20 px-4 py-2 pl-10 text-sm text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-white/40 focus:bg-white/20 transition-all duration-300" />
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-white/50">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                    </svg>
                </form>
            </div>
        </div>

        <!-- NAV LINKS DESKTOP -->
        <ul class="hidden lg:flex items-center gap-7">
            <li>
                <a href="<?= $path_prefix ?>home.php" class="group relative inline-block text-[11px] font-medium tracking-widest uppercase transition-all duration-200 ease-in-out hover:scale-105 <?= ($current_page == 'home.php') ? 'text-white' : 'text-white/60 hover:text-white' ?>">
                    Beranda
                    <span class="absolute left-1/2 -translate-x-1/2 -bottom-1 h-px bg-white transition-all duration-300 ease-out <?= ($current_page == 'home.php') ? 'w-3' : 'w-0 group-hover:w-3' ?>"></span>
                </a>
            </li>

            <li class="relative group">
                <a href="javascript:void(0)" class="inline-block text-[11px] font-medium tracking-widest uppercase text-white/40 cursor-not-allowed">Lokasi</a>
                <div class="absolute top-6 left-1/2 -translate-x-1/2 bg-white text-[#030075] text-[9px] font-bold py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-all pointer-events-none whitespace-nowrap shadow-lg">
                    Coming Soon 🚀
                    <div class="absolute -top-1 left-1/2 -translate-x-1/2 w-2 h-2 bg-white rotate-45"></div>
                </div>
            </li>

            <li class="relative group">
                <a href="javascript:void(0)" class="inline-block text-[11px] font-medium tracking-widest uppercase text-white/40 cursor-not-allowed">News & Promo</a>
                <div class="absolute top-6 left-1/2 -translate-x-1/2 bg-white text-[#030075] text-[9px] font-bold py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-all pointer-events-none whitespace-nowrap shadow-lg">
                    Coming Soon 🚀
                    <div class="absolute -top-1 left-1/2 -translate-x-1/2 w-2 h-2 bg-white rotate-45"></div>
                </div>
            </li>

            <span class="bg-white/20 w-px h-3"></span>

            <li class="relative group">
                <a href="javascript:void(0)" class="inline-block text-[11px] font-medium tracking-widest uppercase text-white/40 cursor-not-allowed">FAQ</a>
                <div class="absolute top-6 left-1/2 -translate-x-1/2 bg-white text-[#030075] text-[9px] font-bold py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-all pointer-events-none whitespace-nowrap shadow-lg">
                    Coming Soon 🚀
                    <div class="absolute -top-1 left-1/2 -translate-x-1/2 w-2 h-2 bg-white rotate-45"></div>
                </div>
            </li>

            <li class="relative group">
                <a href="javascript:void(0)" class="inline-block text-[11px] font-medium tracking-widest uppercase text-white/40 cursor-not-allowed">About</a>
                <div class="absolute top-6 left-1/2 -translate-x-1/2 bg-white text-[#030075] text-[9px] font-bold py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-all pointer-events-none whitespace-nowrap shadow-lg">
                    Coming Soon 🚀
                    <div class="absolute -top-1 left-1/2 -translate-x-1/2 w-2 h-2 bg-white rotate-45"></div>
                </div>
            </li>
        </ul>

        <!-- KANAN: CART + PROFIL (DESKTOP) | CART + FOTO + HAMBURGER (MOBILE) -->
        <div class="flex items-center gap-4 sm:gap-5">

            <!-- CART ICON — tampil di SEMUA ukuran layar -->
            <a href="<?= $path_prefix ?>cart.php" class="relative inline-block opacity-80 hover:opacity-100 transition-all duration-200 hover:scale-110">
                <img src="<?= $path_prefix ?>assets/images/IconBelanja.png" alt="Belanja" class="w-4 lg:w-4">
                <span id="cart-badge" class="<?= $cart_count > 0 ? '' : 'hidden' ?> absolute -top-2.5 -right-3.5 bg-red-500 text-white text-[9px] font-bold w-4 h-4 flex items-center justify-center rounded-full border border-[#030075] shadow-sm animate-pulse">
                    <?= $cart_count ?>
                </span>
            </a>

            <!-- DESKTOP ONLY: Settings + Profil lengkap -->
            <div class="hidden lg:flex items-center gap-6">

                <!-- Settings Icon Desktop -->
                <div class="relative group">
                    <a href="javascript:void(0)" class="inline-block opacity-40 cursor-not-allowed">
                        <img src="<?= $path_prefix ?>assets/images/IconSettings.png" alt="Settings" class="w-4">
                    </a>
                    <div class="absolute top-8 left-1/2 -translate-x-1/2 bg-white text-[#030075] text-[9px] font-bold py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-all pointer-events-none whitespace-nowrap shadow-lg">
                        Coming Soon 🚀
                        <div class="absolute -top-1 left-1/2 -translate-x-1/2 w-2 h-2 bg-white rotate-45"></div>
                    </div>
                </div>

                <!-- Profil Desktop (nama + foto) -->
                <a href="<?= $path_prefix ?>profil/index.php" class="flex items-center gap-3 border-l border-white/20 pl-6 cursor-pointer group">
                    <div class="flex flex-col items-end">
                        <span class="text-xs font-bold tracking-tight"><?= htmlspecialchars($nama_display) ?></span>
                        <span class="text-[10px] text-white/50 uppercase tracking-tighter">Pengguna</span>
                    </div>
                    <div class="w-9 h-9 rounded-full bg-gray-400 overflow-hidden border-2 border-white/20 group-hover:border-white/50 transition-all">
                        <img src="<?= $foto_display ?>" alt="Profile" class="w-full h-full object-cover">
                    </div>
                </a>

            </div>

            <!-- MOBILE ONLY: Foto profil mini + Hamburger -->
            <div class="flex items-center gap-3 lg:hidden">

                <!-- Foto profil mini mobile -->
                <a href="<?= $path_prefix ?>profil/index.php" class="shrink-0">
                    <div class="w-8 h-8 rounded-full overflow-hidden border-2 border-white/30 hover:border-white/60 transition-all">
                        <img src="<?= $foto_display ?>" alt="Profile" class="w-full h-full object-cover">
                    </div>
                </a>

                <!-- Hamburger (tanpa dot merah — cart sudah ada sendiri) -->
                <button onclick="toggleMobileMenu(true)" class="opacity-60 hover:opacity-100 transition-opacity duration-200 focus:outline-none">
                    <img src="<?= $path_prefix ?>assets/images/HamburgerIcon.png" alt="Menu" class="w-5 hover:w-6 transition-all duration-200 ease-in-out">
                </button>

            </div>
        </div>
    </div>
</div>

<!-- BACKDROP MOBILE -->
<div id="mobileBackdrop" onclick="toggleMobileMenu(false)" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 transition-opacity duration-300 lg:hidden opacity-0 pointer-events-none"></div>

<!-- DRAWER MOBILE -->
<div id="mobileDrawer" class="fixed top-0 right-0 h-full w-72 bg-[#000033] z-50 flex flex-col transition-transform duration-300 ease-in-out lg:hidden shadow-2xl translate-x-full">

    <!-- Header Drawer -->
    <div class="flex items-center justify-between px-6 py-4 border-b border-white/10">
        <img src="<?= $path_prefix ?>assets/images/CandrasaPutih.svg" alt="logocandrasa" class="w-28" onerror="this.src='https://via.placeholder.com/150x50?text=CANDRASA'">
        <button onclick="toggleMobileMenu(false)" class="text-white/60 hover:text-white transition-colors">
            <svg viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Nav Links Drawer — navigasi saja -->
    <nav class="flex-1 overflow-y-auto px-6 py-6">
        <ul class="flex flex-col gap-5 text-white">
            <li>
                <a href="<?= $path_prefix ?>home.php" class="text-[11px] font-medium tracking-widest uppercase <?= ($current_page == 'home.php') ? 'text-white' : 'text-white/60' ?>">
                    Beranda
                </a>
            </li>
            <li><a href="javascript:void(0)" class="text-[11px] font-medium tracking-widest uppercase text-white/40 cursor-not-allowed">Lokasi <span class="text-[9px]">— Soon</span></a></li>
            <li><a href="javascript:void(0)" class="text-[11px] font-medium tracking-widest uppercase text-white/40 cursor-not-allowed">News & Promo <span class="text-[9px]">— Soon</span></a></li>
            <div class="h-px bg-white/10 my-1"></div>
            <li><a href="javascript:void(0)" class="text-[11px] font-medium tracking-widest uppercase text-white/40 cursor-not-allowed">FAQ <span class="text-[9px]">— Soon</span></a></li>
            <li><a href="javascript:void(0)" class="text-[11px] font-medium tracking-widest uppercase text-white/40 cursor-not-allowed">About <span class="text-[9px]">— Soon</span></a></li>
        </ul>
    </nav>

    <!-- Footer Drawer: Profil saja -->
    <div class="px-6 py-5 border-t border-white/10">
        <a href="<?= $path_prefix ?>profil/index.php" class="flex items-center gap-3 group">
            <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-white/20 group-hover:border-white/50 transition-all shrink-0">
                <img src="<?= $foto_display ?>" alt="Profile" class="w-full h-full object-cover">
            </div>
            <div class="flex flex-col">
                <span class="text-xs font-bold tracking-tight text-white"><?= htmlspecialchars($nama_display) ?></span>
                <span class="text-[10px] text-white/50 uppercase tracking-tighter">Lihat Profil →</span>
            </div>
        </a>
    </div>
</div>

<script>
function toggleMobileMenu(open) {
    const backdrop = document.getElementById('mobileBackdrop');
    const drawer = document.getElementById('mobileDrawer');
    if (open) {
        backdrop.classList.remove('opacity-0', 'pointer-events-none');
        backdrop.classList.add('opacity-100', 'pointer-events-auto');
        drawer.classList.remove('translate-x-full');
        document.body.style.overflow = 'hidden';
    } else {
        backdrop.classList.add('opacity-0', 'pointer-events-none');
        backdrop.classList.remove('opacity-100', 'pointer-events-auto');
        drawer.classList.add('translate-x-full');
        document.body.style.overflow = '';
    }
}
</script>