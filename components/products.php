<?php
// Ambil data produk dari database MySQL
$query_products = mysqli_query($conn, "SELECT * FROM products LIMIT 8");
?>

<div class="product flex flex-col bg-[#F8F9FA] px-4 md:px-13 py-7 gap-6">
    <div>
        <p class="font-bold font-inter text-[#030075] text-[18px] max-[425px]:text-[12px]">
            Roti lembut dengan berbagai isian manis untuk menemani hari Anda.
        </p>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-8">
        <?php if (mysqli_num_rows($query_products) > 0) : ?>
            <?php while ($product = mysqli_fetch_assoc($query_products)) : ?>
                <div class="bg-white p-3 rounded-xl flex flex-col gap-2.5 shadow-sm hover:shadow-md transition-all duration-300 group">
                    
                    <div class="relative w-full h-40 overflow-hidden border-2 rounded-lg max-[580px]:h-35 max-[465px]:h-27 max-[420px]:h-24">
                        <img src="assets/images/<?= $product['gambar'] ?>" 
                             alt="<?= $product['nama_produk'] ?>" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                             onerror="this.src='https://via.placeholder.com/300x200?text=Bread'">
                        
                        <?php if ($product['rating'] >= 4.5) : ?>
                            <div class="absolute left-3 top-1.5 w-5 max-[580px]:w-4 max-[420px]:w-3 max-[420px]:left-2">
                                <span>🔥</span>
                            </div>
                        <?php endif; ?>

                        <p class="absolute font-inter rounded-2xl flex items-center justify-center right-2 bottom-2 text-white text-xs px-2 py-0.5 max-[580px]:text-[9px] max-[420px]:text-[8px] max-[420px]:bottom-1.5 
                            <?= ($product['status_stok'] == 'Ready') ? 'bg-green-600' : 'bg-red-700' ?>">
                            <?= $product['status_stok'] ?>
                        </p>
                    </div>

                    <div class="description flex justify-between items-center gap-2">
                        <div class="left min-w-0">
                            <p class="font-poppins font-semibold tracking-wider text-[15px] md:text-[18px] truncate max-[580px]:text-[13px] max-[420px]:text-[11px] text-[#030075]">
                                <?= $product['nama_produk'] ?>
                            </p>
                            
                            <p class="font-inter text-xs font-bold bg-[#FFCC00] w-20 text-center rounded-full py-0.5 max-[580px]:text-[11px] max-[420px]:text-[10px] max-[420px]:w-18">
                                Rp <?= number_format($product['harga'], 0, ',', '.') ?>
                            </p>
                            
                            <div class="flex gap-2 items-center">
                                <p class="text-[#5543FF] text-[18px] md:text-[20px] font-black max-[580px]:text-[13px] max-[420px]:text-[12px]">
                                    ★
                                </p>
                                <p class="font-inter text-[11px] md:text-[13px] mt-1 font-medium max-[420px]:text-[10px] max-[380px]:hidden text-[#030075]">
                                    <?= number_format($product['rating'], 1) ?>/5.0
                                </p>
                            </div>

                            <p class="text-[11px] md:text-[12px] line-clamp-2 max-[580px]:text-[8px] max-[420px]:text-[7px] max-[380px]:text-[6px] text-gray-500">
                                <?= $product['deskripsi'] ?>
                            </p>
                        </div>

                        <div class="shrink-0 overflow-hidden bg-[#5543FF] rounded-[10px] p-2.5 md:p-3.5 group transition-all ease-in-out duration-200 hover:bg-[#FFCC00] cursor-pointer">
                            <img src="assets/images/IconBelanja.png" 
                                 alt="Iconbelanja" 
                                 class="w-7 md:w-10 max-[420px]:w-5 filter brightness-0 invert group-hover:invert-0">
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>

    <div class="flex justify-center mt-4">
        <div class="flex bg-[#030075] px-5 py-2 rounded-2xl w-44 justify-center items-center cursor-pointer group transition-all ease-in-out duration-300 hover:scale-105 shadow-[0_5px_10px_rgba(0,0,0,0.2)]">
            <p class="font-poppins font-semibold text-white max-[525px]:text-[12px]">Lebih Banyak ‎ 》</p>
        </div>
    </div>
</div>