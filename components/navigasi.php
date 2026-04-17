<?php
$active_category = isset($_GET['category']) ? $_GET['category'] : 'Roti Manis';

// Data kategori sesuai file images kamu
$categories = [
    ['nama' => 'Roti Manis', 'img' => 'assets/images/RotimANIS.PNG'], 
    ['nama' => 'Roti Gurih', 'img' => 'assets/images/ROTIgurih.png'],
    ['nama' => 'Biskuit & Snack', 'img' => 'assets/images/bikuit.png'],
    ['nama' => 'Dessert', 'img' => 'assets/images/desert.png'],
    ['nama' => 'Paket', 'img' => 'assets/images/Paket.png'], // Tambahan sesuai foto
];
?>

<div class="flex justify-between md:justify-center items-center gap-12 md:gap-40 my-16 px-10 md:px-32 overflow-x-auto no-scrollbar">
    <?php foreach ($categories as $cat) : ?>
        <?php 
            $is_active = ($active_category == $cat['nama']);
            $opacity = $is_active ? 'opacity-100' : 'opacity-100'; 
        ?>
        
        <a href="?category=<?= urlencode($cat['nama']) ?>" class="flex flex-col items-center gap-4 shrink-0 group transition-all duration-300 <?= $opacity ?>">
            
            <div class="w-12 h-12 md:w-10 md:h-10 flex items-center justify-center transition-transform group-hover:scale-110">
                <img src="<?= $cat['img'] ?>" alt="<?= $cat['nama'] ?>" class="w-full h-full object-contain">
            </div>
            
            <div class="flex flex-col items-center">
                <span class="text-[8px] md:text-[12px] font-[700] font-poppins text-black mb-1">
                    <?= $cat['nama'] ?>
                </span>
                <div class="h-[3px] w-12 rounded-full transition-all <?= $is_active ? 'bg-[#5543FF]' : 'bg-transparent' ?>"></div>
            </div>
        </a>
    <?php endforeach; ?>
</div>

<style>
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>