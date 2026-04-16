<?php
// Mendapatkan nama file saat ini untuk menentukan link aktif
$current_page = basename($_SERVER['PHP_SELF']);
?>

<div class="bg-[#030075] text-white font-sans sticky top-0 z-30">
    <div class="flex items-center justify-between px-4 sm:px-6 lg:px-8 py-3.5">

        <div class="shrink-0">
            <img src="assets/images/Candrasa Putih.svg" alt="logocandrasa" class="w-24 sm:w-28 lg:w-32" onerror="this.src='https://via.placeholder.com/150x50?text=CANDRASA'">
        </div>

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

        <ul class="hidden lg:flex items-center gap-7">
            <?php 
            $menus = [
                ['label' => 'Beranda', 'href' => 'home.php'],
                ['label' => 'Lokasi', 'href' => '#'],
                ['label' => 'News & Promo', 'href' => '#'],
            ];
            foreach ($menus as $m): 
                $active = ($current_page == $m['href']) ? 'text-white' : 'text-white/60 hover:text-white';
                $line = ($current_page == $m['href']) ? 'w-3' : 'w-0 group-hover:w-3';
            ?>
                <li>
                    <a href="<?= $m['href'] ?>" class="group relative inline-block text-[11px] font-medium tracking-widest uppercase transition-all duration-200 ease-in-out hover:scale-105 <?= $active ?>">
                        <?= $m['label'] ?>
                        <span class="absolute left-1/2 -translate-x-1/2 -bottom-1 h-px bg-white transition-all duration-300 ease-out <?= $line ?>"></span>
                    </a>
                </li>
            <?php endforeach; ?>
            
            <span class="bg-white/20 w-px h-3"></span>
            
            <li><a href="#" class="text-[11px] font-medium tracking-widest uppercase text-white/60 hover:text-white transition-all">FAQ</a></li>
            <li><a href="#" class="text-[11px] font-medium tracking-widest uppercase text-white/60 hover:text-white transition-all">About</a></li>
        </ul>

        <div class="flex items-center gap-4 sm:gap-5">
            <div class="hidden lg:flex items-center gap-5">
                <a href="#" class="inline-block opacity-50 hover:opacity-100 transition-opacity duration-200">
                    <img src="assets/images/IconBelanja.png" alt="Belanja" class="w-4">
                </a>
                <a href="#" class="inline-block opacity-50 hover:opacity-100 transition-opacity duration-200">
                    <img src="assets/images/IconSettings.png" alt="Settings" class="w-4">
                </a>
            </div>

            <div class="hidden lg:flex items-center gap-5">
                <div class="w-px h-3 bg-white/20"></div>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <a href="logout.php" class="text-[11px] font-medium tracking-widest uppercase text-white/60 hover:text-white">Logout</a>
                <?php else: ?>
                    <a href="index.php" class="flex items-center gap-2 text-[11px] font-medium tracking-widest uppercase text-white/60 hover:text-white transition-colors duration-200">
                        Login
                        <img src="assets/images/IconLogin.png" alt="Login" class="w-6 opacity-60">
                    </a>
                <?php endif; ?>
            </div>

            <div class="flex items-center gap-4 lg:hidden">
                <a href="index.php" class="opacity-50 hover:opacity-100 transition-opacity duration-200">
                    <img src="assets/images/IconLogin.png" alt="Login" class="w-7">
                </a>
                <button onclick="toggleMobileMenu(true)" class="opacity-50 hover:opacity-100 transition-opacity duration-200 focus:outline-none">
                    <img src="assets/images/HamburgerIcon.png" alt="Menu" class="w-5 hover:w-6 transition-all duration-200 ease-in-out">
                </button>
            </div>
        </div>
    </div>

    <div class="h-px bg-white/10"></div>
</div>

<div id="mobileBackdrop" onclick="toggleMobileMenu(false)" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 transition-opacity duration-300 lg:hidden opacity-0 pointer-events-none"></div>

<div id="mobileDrawer" class="fixed top-0 right-0 h-full w-72 bg-[#000033] z-50 flex flex-col transition-transform duration-300 ease-in-out lg:hidden shadow-2xl translate-x-full">
    <div class="flex items-center justify-between px-6 py-4 border-b border-white/10">
        <img src="assets/images/logo-web-full.png" alt="logocandrasa" class="w-28">
        <button onclick="toggleMobileMenu(false)" class="text-white/60 hover:text-white">
            <svg viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
    </div>

    <div class="px-6 py-4 border-b border-white/10">
        <form class="relative w-full">
            <input type="text" placeholder="Search..." class="w-full rounded-full bg-white/10 border border-white/20 px-4 py-2 text-sm text-white">
        </form>
    </div>

<nav class="bg-[#030075] text-white font-sans sticky top-0 z-30">
    <div class="flex items-center justify-between px-4 sm:px-6 lg:px-8 py-3.5">
        <div class="shrink-0">
            <img src="assets/images/logo-web-full.png" alt="logocandrasa" class="w-24 sm:w-28 lg:w-32">
        </div>

        <div class="hidden lg:block">
            <form class="relative w-full md:w-64 lg:w-80">
                <input type="text" placeholder="Search products..." class="w-full rounded-full bg-white/10 backdrop-blur-md border border-white/20 px-4 py-2 pl-10 text-sm text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-white/40 transition-all duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-white/50"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" /></svg>
            </form>
        </div>

        <ul class="hidden lg:flex items-center gap-7">
            <li><a href="home.php" class="text-[11px] font-medium tracking-widest uppercase text-white hover:scale-105 transition-all">Beranda</a></li>
            <li><a href="#" class="text-[11px] font-medium tracking-widest uppercase text-white/60 hover:text-white transition-all">Lokasi</a></li>
            <li><a href="#" class="text-[11px] font-medium tracking-widest uppercase text-white/60 hover:text-white transition-all">News & Promo</a></li>
            <span class="bg-white/20 w-px h-3"></span>
            <li><a href="#" class="text-[11px] font-medium tracking-widest uppercase text-white/60 hover:text-white transition-all">FAQ</a></li>
            <li><a href="#" class="text-[11px] font-medium tracking-widest uppercase text-white/60 hover:text-white transition-all">About</a></li>
        </ul>

        <div class="flex items-center gap-4 sm:gap-5">
            <div class="hidden lg:flex items-center gap-5">
                <img src="assets/images/IconBelanja.png" alt="Belanja" class="w-4 opacity-50 hover:opacity-100 cursor-pointer">
                <img src="assets/images/IconSettings.png" alt="Settings" class="w-4 opacity-50 hover:opacity-100 cursor-pointer">
            </div>
            <div class="hidden lg:flex items-center gap-5 border-l border-white/20 pl-5">
                <a href="logout.php" class="flex items-center gap-2 text-[11px] font-medium tracking-widest uppercase text-white/60 hover:text-white">
                    Logout <img src="assets/images/IconLogin.png" alt="Logout" class="w-6 opacity-60">
                </a>
            </div>
            <button onclick="toggleMobileMenu(true)" class="lg:hidden opacity-50 hover:opacity-100">
                <img src="assets/images/HamburgerIcon.png" alt="Menu" class="w-5">
            </button>
        </div>
    </div>
</nav>

    <div class="px-6 py-5 border-t border-white/10">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-5">
                <img src="assets/images/IconBelanja.png" class="w-5 opacity-50" alt="">
                <img src="assets/images/IconSettings.png" class="w-5 opacity-50" alt="">
            </div>
            <a href="index.php" class="flex items-center gap-2 text-[11px] font-medium tracking-widest uppercase text-white/60">
                Login <img src="assets/images/IconLogin.png" class="w-5 opacity-60" alt="">
            </a>
        </div>
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