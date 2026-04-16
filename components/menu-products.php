<?php
// Ambil 5 produk tambahan dari database (offset agar tidak duplikat dengan produk utama)
$query_menu = mysqli_query($conn, "SELECT * FROM products LIMIT 5 OFFSET 8");
?>

<div class="menu-product flex flex-col bg-[#F8F9FA] px-4 md:px-13 py-7 gap-6">
    <div>
        <p class="font-bold font-inter text-[#030075] text-[20px] max-[425px]:text-[14px]">
            Menu Lainnya
        </p>
    </div>

    <div class="flex gap-4 overflow-x-auto pb-2 md:grid md:grid-cols-5 md:overflow-visible scrollbar-hide">
        <?php if (mysqli_num_rows($query_menu) > 0) : ?>
            <?php while ($product = mysqli_fetch_assoc($query_menu)) : ?>
                <div class="bg-white p-3 rounded-xl flex flex-col gap-2.5 min-w-[160px] max-w-[160px] md:min-w-0 md:max-w-none shadow-sm hover:shadow-md transition-all duration-300 group">
                    
                    <div class="relative w-full h-32 md:h-36 overflow-hidden border-2 rounded-lg">
                        <img src="assets/images/<?= $product['gambar'] ?>" 
                             alt="<?= $product['nama_produk'] ?>" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                             onerror="this.src='https://via.placeholder.com/200x150?text=Menu'">
                        
                        <?php if ($product['rating'] >= 4.5) : ?>
                            <div class="absolute left-2 top-1.5 w-4">
                                <span>🔥</span>
                            </div>
                        <?php endif; ?>

                        <p class="absolute font-inter rounded-2xl flex items-center justify-center right-2 bottom-2 text-white text-[9px] px-1.5 py-0.5 
                            <?= ($product['status_stok'] == 'Ready') ? 'bg-green-600' : 'bg-red-700' ?>">
                            <?= $product['status_stok'] ?>
                        </p>
                    </div>

                    <div class="description flex justify-between items-center gap-1.5">
                        <div class="left min-w-0">
                            <p class="font-poppins font-semibold tracking-wider text-[12px] md:text-[14px] truncate text-[#030075]">
                                <?= $product['nama_produk'] ?>
                            </p>
                            
                            <p class="font-inter text-[10px] md:text-xs font-bold bg-[#FFCC00] w-16 md:w-18 text-center rounded-full py-0.5">
                                Rp <?= number_format($product['harga'], 0, ',', '.') ?>
                            </p>
                            
                            <div class="flex gap-1 items-center">
                                <p class="text-[#5543FF] text-[12px] md:text-[14px] font-black">
                                    ★
                                </p>
                                <p class="font-inter text-[9px] md:text-[11px] mt-0.5 font-medium hidden sm:block text-[#030075]">
                                    <?= number_format($product['rating'], 1) ?>/5.0
                                </p>
                            </div>
                            
                            <p class="text-[8px] md:text-[10px] line-clamp-2 text-gray-500">
                                <?= $product['deskripsi'] ?>
                            </p>
                        </div>

                        <div class="shrink-0 bg-[#5543FF] rounded-lg p-2 md:p-2.5 transition-all ease-in-out duration-200 hover:bg-[#FFCC00] cursor-pointer group/icon">
                            <img src="assets/images/IconBelanja.png" 
                                 alt="Iconbelanja" 
                                 class="w-5 md:w-7 filter brightness-0 invert group-hover/icon:invert-0">
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else : ?>
            <p class="text-xs text-gray-400 italic">Menu tambahan belum tersedia.</p>
        <?php endif; ?>
    </div>
</div>