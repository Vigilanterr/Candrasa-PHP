<?php
// Pastikan variabel user_id sudah ada (jika user login)
$id_user = $_SESSION['user_id'] ?? 0;

// 1. Ambil 2 pesanan terakhir untuk Riwayat (di mockup ada 2 item, kita ambil maksimal 2)
$query_riwayat = mysqli_query($conn, "SELECT * FROM pesanan WHERE user_id='$id_user' ORDER BY created_at DESC LIMIT 2");
$ada_riwayat = $query_riwayat && mysqli_num_rows($query_riwayat) > 0;

// 2. Hitung total seluruh belanjaan user untuk ditampilkan di 'Status Pesanan'
$query_total = mysqli_query($conn, "SELECT SUM(total_harga) as total FROM pesanan WHERE user_id='$id_user'");
$data_total = $query_total ? mysqli_fetch_assoc($query_total) : ['total' => 0];
$total_belanja = $data_total['total'] ?? 0;
?>

<section class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-12 px-4 md:px-10 lg:px-20 py-8">
    
    <div class="lg:col-span-2 h-[350px] md:h-[420px] rounded-[32px] overflow-hidden relative shadow-sm group">
        <img src="assets/images/Banner1.svg" alt="Banner Candrasa" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" onerror="this.src='https://images.unsplash.com/photo-1509440159596-0249088772ff?q=80&w=1000&auto=format&fit=crop'">
        <div class="absolute inset-0 bg-black/5 transition-opacity duration-300 group-hover:bg-transparent"></div>
    </div>

    <div class="flex flex-col gap-6 h-[350px] md:h-[420px]">
        
        <div class="bg-white rounded-[24px] p-6 shadow-sm border border-gray-100 flex justify-between items-center relative overflow-hidden h-1/2">
            <div class="z-10 flex flex-col justify-between h-full w-full">
                <div>
                    <h3 class="font-bold text-black text-[14px] mb-4">Status Pesanan</h3>
                    <div class="flex items-center gap-10">
                        <p class="text-[10px] font-medium text-[#030075]">
                            Total: <span class="<?= $total_belanja > 0 ? 'text-[#030075] font-bold' : 'text-[#030075]' ?>"><?= $total_belanja > 0 ? 'Rp ' . number_format($total_belanja, 0, ',', '.') : '---' ?></span>
                        </p>
                        <p class="text-[10px] font-medium text-[#030075]">
                            WIB: <span class="text-[#030075]"><?= $total_belanja > 0 ? date('H:i') : '---' ?></span>
                        </p>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="keranjang.php" class="inline-block text-center text-[9px] font-bold border border-[#030075] text-[#030075] px-6 py-1.5 rounded-lg hover:bg-[#030075] hover:text-white transition-all duration-300 w-fit">
                        See More
                    </a>
                </div>
            </div>
            <div class="w-32 h-32 bg-[#5543FF] rounded-2xl opacity-90 rotate-[15deg] absolute -right-8 top-4"></div>
        </div>

        <div class="bg-[#F9FAFB] rounded-[24px] p-6 shadow-sm h-1/2 flex flex-col relative overflow-hidden">
            <h3 class="font-bold text-[15px] text-black mb-5">Riwayat Pemesananan</h3>
            
            <div class="flex-1 overflow-hidden flex flex-col gap-4">
                <?php if ($ada_riwayat) : ?>
                    <?php while($riwayat = mysqli_fetch_assoc($query_riwayat)): ?>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <img src="assets/images/roti-placeholder.jpg" class="w-12 h-12 rounded-md object-cover border border-gray-200" onerror="this.src='https://images.unsplash.com/photo-1598128558393-70ff21433be0?w=100'">
                                <div>
                                    <p class="text-[11px] font-bold text-[#030075] mb-0.5">Order #<?= $riwayat['id'] ?></p>
                                    <p class="text-[10px] text-black">Total: Rp <?= number_format($riwayat['total_harga'], 0, ',', '.') ?></p>
                                </div>
                            </div>
                            <svg class="w-4 h-4 text-black hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"></path></svg>
                            <div class="text-right flex flex-col items-end">
                                <p class="text-[9px] text-black mb-1 font-medium"><?= date('d M Y', strtotime($riwayat['created_at'])) ?></p>
                                <span class="bg-[#FFCC00] text-black text-[9px] font-bold px-4 py-[2px] rounded-full inline-block text-center min-w-[60px]"><?= htmlspecialchars($riwayat['status']) ?></span>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else : ?>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-white border border-black rounded-sm"></div>
                            <div>
                                <p class="text-[11px] font-bold text-[#030075] mb-0.5">---</p>
                                <p class="text-[10px] text-black">Total: ---</p>
                            </div>
                        </div>
                        <svg class="w-4 h-4 text-black hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"></path></svg>
                        <div class="text-right flex flex-col items-end">
                            <p class="text-[9px] text-black mb-1 font-medium">DD/MM/YYYY</p>
                            <span class="bg-[#FFCC00] text-black text-[9px] font-bold px-4 py-[2px] rounded-full inline-block text-center min-w-[60px]">---</span>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            
 <div class="mt-auto w-full flex justify-center">
    <span class="bg-gray-200 text-gray-500 text-[10px] font-bold py-1.5 px-6 rounded-full flex items-center gap-1 cursor-not-allowed select-none">
        Coming Soon
    </span>
</div>

        </div>
    </div>
</section>