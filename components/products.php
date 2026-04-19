<?php
// Cek apakah variabel koneksi $conn ada, jika tidak panggil config
if (!isset($conn)) {
<<<<<<< HEAD
    require_once 'config.php';
}

=======
    require_once '../config.php';
}

// Ambil data produk dari database MySQL
// Kita urutkan berdasarkan yang terbaru agar produk yang baru diinput di kelola.php muncul di atas
>>>>>>> 32ffd7f8c204e0f46471282ddea2f6122a0418d3
$query_products = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC LIMIT 8");
?>

<div class="product flex flex-col bg-[#F8F9FA] px-4 md:px-13 py-7 gap-6">
    <div>
        <p class="font-bold font-inter text-[#030075] text-[18px] max-[425px]:text-[12px]">
            Roti lembut dengan berbagai isian manis untuk menemani hari Anda.
        </p>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-8">
<<<<<<< HEAD
        <?php if ($query_products && mysqli_num_rows($query_products) > 0) : ?>
=======
        <?php if (mysqli_num_rows($query_products) > 0) : ?>
>>>>>>> 32ffd7f8c204e0f46471282ddea2f6122a0418d3
            <?php while ($product = mysqli_fetch_assoc($query_products)) : ?>
                <div class="bg-white p-3 rounded-xl flex flex-col gap-2.5 shadow-sm hover:shadow-md transition-all duration-300 group">
                    
                    <div class="relative w-full h-40 overflow-hidden border-2 rounded-lg max-[580px]:h-35 max-[465px]:h-27 max-[420px]:h-24">
                        <img src="assets/images/<?= $product['gambar'] ?>" 
                             alt="<?= $product['nama_produk'] ?>" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                             onerror="this.src='https://via.placeholder.com/300x200?text=Candrasa+Bakery'">
                        
                        <?php if ($product['is_popular'] == 1 || $product['rating'] >= 4.5) : ?>
                            <div class="absolute left-3 top-1.5 w-5 max-[580px]:w-4 max-[420px]:w-3 max-[420px]:left-2">
                                <span class="text-lg drop-shadow-md">🔥</span>
                            </div>
                        <?php endif; ?>

                        <p class="absolute font-inter rounded-2xl flex items-center justify-center right-2 bottom-2 text-white text-[10px] md:text-xs px-2 py-0.5 max-[580px]:text-[9px] max-[420px]:text-[8px] max-[420px]:bottom-1.5 
                            <?= ($product['status_stok'] == 'Ready') ? 'bg-green-600' : 'bg-red-700' ?>">
                            <?= $product['status_stok'] ?>
                        </p>
                    </div>

                    <div class="description flex justify-between items-center gap-2">
                        <div class="left min-w-0">
                            <p class="font-poppins font-semibold tracking-wider text-[15px] md:text-[18px] truncate max-[580px]:text-[13px] max-[420px]:text-[11px] text-[#030075]">
                                <?= htmlspecialchars($product['nama_produk']) ?>
                            </p>
                            
                            <p class="font-inter text-[10px] md:text-xs font-bold bg-[#FFCC00] w-fit px-3 text-center rounded-full py-0.5 max-[580px]:text-[9px] max-[420px]:text-[8px]">
                                Rp <?= number_format($product['harga'], 0, ',', '.') ?>
                            </p>
                            
                            <div class="flex gap-2 items-center">
<<<<<<< HEAD
                                <p class="text-[#5543FF] text-[18px] md:text-[20px] font-black max-[580px]:text-[13px] max-[420px]:text-[12px]">★</p>
=======
                                <p class="text-[#5543FF] text-[18px] md:text-[20px] font-black max-[580px]:text-[13px] max-[420px]:text-[12px]">
                                    ★
                                </p>
>>>>>>> 32ffd7f8c204e0f46471282ddea2f6122a0418d3
                                <p class="font-inter text-[11px] md:text-[13px] mt-1 font-medium max-[420px]:text-[10px] max-[380px]:hidden text-[#030075]">
                                    <?= number_format($product['rating'], 1) ?>/5.0
                                </p>
                            </div>

                            <p class="text-[11px] md:text-[12px] line-clamp-2 max-[580px]:text-[8px] max-[420px]:text-[7px] max-[380px]:text-[6px] text-gray-500 leading-tight">
                                <?= htmlspecialchars($product['deskripsi']) ?>
                            </p>
                        </div>

<<<<<<< HEAD
                        <?php if ($product['status_stok'] == 'Ready') : ?>
                            <button onclick="addToCart(event, this, <?= $product['id'] ?>, 'assets/images/<?= $product['gambar'] ?>')" class="shrink-0 overflow-hidden bg-[#5543FF] rounded-[10px] p-2.5 md:p-3.5 group transition-all ease-in-out duration-200 hover:bg-[#FFCC00] cursor-pointer shadow-sm active:scale-90 block border-none outline-none">
                                <img src="assets/images/IconBelanja.png" alt="Iconbelanja" class="w-6 md:w-8 max-[420px]:w-5 filter brightness-0 invert group-hover:invert-0 transition-all">
                            </button>
                        <?php else : ?>
                            <div class="shrink-0 overflow-hidden bg-gray-300 rounded-[10px] p-2.5 md:p-3.5 cursor-not-allowed shadow-sm block">
                                <img src="assets/images/IconBelanja.png" class="w-6 md:w-8 max-[420px]:w-5 filter brightness-0 invert opacity-50">
                            </div>
                        <?php endif; ?>

=======
                        <div class="shrink-0 overflow-hidden bg-[#5543FF] rounded-[10px] p-2.5 md:p-3.5 group transition-all ease-in-out duration-200 hover:bg-[#FFCC00] cursor-pointer shadow-sm active:scale-90">
                            <img src="assets/images/IconBelanja.png" 
                                 alt="Iconbelanja" 
                                 class="w-6 md:w-8 max-[420px]:w-5 filter brightness-0 invert group-hover:invert-0 transition-all">
                        </div>
>>>>>>> 32ffd7f8c204e0f46471282ddea2f6122a0418d3
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else : ?>
            <div class="col-span-full py-20 text-center">
                <p class="text-gray-400 font-medium">Belum ada produk yang tersedia.</p>
            </div>
        <?php endif; ?>
    </div>

    <div class="flex justify-center mt-6">
<<<<<<< HEAD
        <div class="relative group">
            <a href="javascript:void(0)" class="flex bg-[#030075] px-6 py-2.5 rounded-2xl w-44 justify-center items-center transition-all ease-in-out duration-300 hover:scale-105 hover:bg-black shadow-[0_5px_15px_rgba(3,0,117,0.3)] max-[525px]:w-37 opacity-80 cursor-not-allowed">
                <p class="font-poppins font-semibold text-white max-[525px]:text-[12px] tracking-wide">Lebih Banyak ‎ 》</p>
            </a>
            <div class="absolute -top-10 left-1/2 -translate-x-1/2 bg-gray-800 text-white text-[10px] font-bold py-1.5 px-3 rounded-lg opacity-0 group-hover:opacity-100 group-hover:-top-12 transition-all duration-300 pointer-events-none whitespace-nowrap shadow-lg">
                Coming Soon 🚀
                <div class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-2.5 h-2.5 bg-gray-800 rotate-45"></div>
            </div>
        </div>
    </div>
</div>

<script>
function addToCart(event, buttonElement, productId, imgSrc) {
    event.preventDefault();

    fetch(`add_to_cart.php?id=${productId}`)
    .then(response => response.json())
    .then(data => {
        if (data.status === 'error' && data.message === 'login') {
            alert('Ups! Kamu harus login terlebih dahulu untuk belanja.');
            window.location.href = 'index.php';
            return;
        }

        if (data.status === 'success') {
            let startPos = buttonElement.getBoundingClientRect();
            let targetIcon = window.innerWidth < 1024 ? document.getElementById('cart-icon-mobile') : document.getElementById('cart-icon-desktop');
            
            if(!targetIcon) return; // Jaga-jaga jika ID di navbar belum dipasang

            let endPos = targetIcon.getBoundingClientRect();

            let flyingImg = document.createElement('img');
            flyingImg.src = imgSrc;
            flyingImg.style.position = 'fixed';
            flyingImg.style.zIndex = '9999';
            flyingImg.style.width = '60px';
            flyingImg.style.height = '60px';
            flyingImg.style.borderRadius = '50%';
            flyingImg.style.objectFit = 'cover';
            flyingImg.style.boxShadow = '0 10px 25px rgba(0,0,0,0.3)';
            flyingImg.style.transition = 'all 0.8s cubic-bezier(0.25, 1, 0.5, 1)';
            
            flyingImg.style.top = startPos.top + 'px';
            flyingImg.style.left = startPos.left + 'px';
            
            document.body.appendChild(flyingImg);

            flyingImg.getBoundingClientRect();

            flyingImg.style.top = (endPos.top - 10) + 'px';
            flyingImg.style.left = endPos.left + 'px';
            flyingImg.style.width = '20px';
            flyingImg.style.height = '20px';
            flyingImg.style.opacity = '0';
            flyingImg.style.transform = 'scale(0.2)';

            setTimeout(() => {
                flyingImg.remove();
                
                // Update angka notifikasi di navbar
                updateBadge('cart-badge-desktop', data.cart_count);
                if(document.getElementById('cart-badge-mobile')) {
                    updateBadge('cart-badge-mobile', data.cart_count);
                }

                targetIcon.style.transform = 'scale(1.3)';
                setTimeout(() => targetIcon.style.transform = 'scale(1)', 200);

            }, 800);
        }
    })
    .catch(error => console.error('Error:', error));
}

function updateBadge(badgeId, count) {
    let badge = document.getElementById(badgeId);
    if (badge) {
        badge.innerText = count;
        badge.classList.remove('hidden');
    }
}
</script>
=======
        <a href="katalog.php" class="flex bg-[#030075] px-6 py-2.5 rounded-2xl w-44 justify-center items-center cursor-pointer group transition-all ease-in-out duration-300 hover:scale-105 hover:bg-black shadow-[0_5px_15px_rgba(3,0,117,0.3)] max-[525px]:w-37">
            <p class="font-poppins font-semibold text-white max-[525px]:text-[12px] tracking-wide">Lebih Banyak ‎ 》</p>
        </a>
    </div>
</div>
>>>>>>> 32ffd7f8c204e0f46471282ddea2f6122a0418d3
