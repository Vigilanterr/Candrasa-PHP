<?php
// Ambil data feedback dari database
$query_feedback = mysqli_query($conn, "SELECT * FROM feedbacks LIMIT 3");
?>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 px-4 md:px-13 py-10 bg-white">
    <?php if (mysqli_num_rows($query_feedback) > 0) : ?>
        <?php while ($feedback = mysqli_fetch_assoc($query_feedback)) : ?>
            <div class="flex flex-col bg-[#F8F9FA] p-4 sm:p-4.5 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300">
                <div class="flex flex-col gap-3">
                    <div class="flex gap-4 sm:gap-5 items-center">
                        <div class="w-12 h-12 sm:w-15 sm:h-15 overflow-hidden rounded-full shrink-0 border-2 border-[#5543FF]">
                            <img src="assets/images/<?= $feedback['profile_img'] ?>" 
                                 alt="<?= $feedback['nama'] ?>" 
                                 class="w-full h-full object-cover"
                                 onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($feedback['nama']) ?>&background=random'">
                        </div>
                        <div class="">
                            <p class="font-poppins font-bold text-[#030075] text-sm sm:text-base"><?= htmlspecialchars($feedback['nama']) ?></p>
                            <p class="font-inter font-light text-[#030075] text-[11px] sm:text-[13px]"><?= htmlspecialchars($feedback['bio']) ?></p>
                        </div>
                    </div>
                    <div class="center text-sm sm:text-base text-gray-700 italic">
                        "<?= htmlspecialchars($feedback['deskripsi']) ?>"
                    </div>
                </div>

                <div class="bottom mt-4">
                    <div class="flex gap-2 sm:gap-2.5 items-center">
                        <div class="text">
                            <p class="text-xl sm:text-2xl text-[#FFCC00]">
                                <?php 
                                    // Menampilkan bintang statis sesuai rating
                                    echo str_repeat('★', floor($feedback['rating_val'])); 
                                ?>
                            </p>
                        </div>
                        <p class="font-inter font-semibold mt-1.5 text-sm sm:text-base text-[#030075]">
                            <?= number_format($feedback['rating_val'], 1) ?>/5.0
                        </p>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else : ?>
        <p class="col-span-full text-center text-gray-400 italic">Belum ada ulasan dari pelanggan.</p>
    <?php endif; ?>
</div>