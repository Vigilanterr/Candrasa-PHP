<?php
require_once 'config.php';

$error_message = "";
$success_message = "";

if (isset($_POST['register'])) {
    $first_name      = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name       = mysqli_real_escape_string($conn, $_POST['last_name']);
    $full_name       = $first_name . " " . $last_name;
    $email           = mysqli_real_escape_string($conn, $_POST['email']);
    $password        = $_POST['password'];
    $repeat_password = $_POST['repeat_password'];

    // 1. Validasi: Apakah email sudah terdaftar?
    $check_email = mysqli_query($conn, "SELECT email FROM users WHERE email = '$email'");
    
    if (mysqli_num_rows($check_email) > 0) {
        $error_message = "Email sudah terdaftar! Gunakan email lain.";
    } 
    // 2. Validasi: Apakah password dan repeat password cocok?
    else if ($password !== $repeat_password) {
        $error_message = "Konfirmasi password tidak cocok!";
    }
    // 3. Validasi: Minimal panjang password (opsional tapi disarankan)
    else if (strlen($password) < 6) {
        $error_message = "Password minimal harus 6 karakter!";
    }
    else {
        // Insert ke database
        $query = "INSERT INTO users (nama, email, password, role) VALUES ('$full_name', '$email', '$password', 'customer')";
        
        if (mysqli_query($conn, $query)) {
            $success_message = "Berhasil Daftar! Silakan Login.";
            header("refresh:2;url=index.php");
        } else {
            $error_message = "Gagal mendaftar: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Candrasa Bakery</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: { extend: { fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'] } } }
        }
    </script>
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="flex h-screen w-full bg-white font-sans overflow-hidden">
    
    <div class="w-full lg:w-1/2 flex flex-col px-8 md:px-16 lg:px-20 py-10 overflow-y-auto no-scrollbar relative">
        
        <div class="mb-4">
            <a href="index.php" class="flex items-center justify-center w-8 h-8 bg-[#000066] text-white rounded-full hover:bg-blue-900 transition shadow-sm active:scale-95">
                <i data-feather="arrow-left" style="width: 16px; height: 16px;"></i>
            </a>
        </div>

        <div class="mb-6 text-left">
            <img src="assets/images/Logo candrasa.svg" alt="Logo" class="h-10 object-contain" />
        </div>

        <div class="mb-6">
            <h1 class="text-2xl font-extrabold text-[#000066] leading-tight">Buat Akun Baru</h1>
            <p class="text-gray-400 text-[10px] mt-1 font-bold uppercase tracking-wider">Ayo buat akun untuk menjelajahi web kami!</p>
        </div>

        <?php if($error_message): ?>
            <div class="mb-4 p-3 bg-red-100 text-red-700 text-xs rounded-lg font-bold border border-red-200"><?= $error_message ?></div>
        <?php endif; ?>
        
        <?php if($success_message): ?>
            <div class="mb-4 p-3 bg-green-100 text-green-700 text-xs rounded-lg font-bold border border-green-200"><?= $success_message ?></div>
        <?php endif; ?>

        <form class="space-y-4" action="" method="POST">
            <div class="space-y-1">
                <label class="text-xs font-bold text-gray-700">Name <span class="text-red-500">*</span></label>
                <div class="grid grid-cols-2 gap-4">
                    <input type="text" name="first_name" placeholder="First Name" class="w-full px-4 py-2.5 rounded-lg bg-[#EAEAEA] border-none outline-none focus:ring-2 focus:ring-[#5543FF] transition-all text-sm text-gray-600" required />
                    <input type="text" name="last_name" placeholder="Last Name" class="w-full px-4 py-2.5 rounded-lg bg-[#EAEAEA] border-none outline-none focus:ring-2 focus:ring-[#5543FF] transition-all text-sm text-gray-600" />
                </div>
            </div>

            <div class="space-y-1">
                <label class="text-xs font-bold text-gray-700">Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" placeholder="@exampleytta@gmail.com" class="w-full px-4 py-2.5 rounded-lg bg-[#EAEAEA] border-none outline-none focus:ring-2 focus:ring-[#5543FF] transition-all text-sm text-gray-600" required />
            </div>

            <div class="space-y-1">
                <label class="text-xs font-bold text-gray-700">Password <span class="text-red-500">*</span></label>
                <input type="password" name="password" placeholder="********" class="w-full px-4 py-2.5 rounded-lg bg-[#EAEAEA] border-none outline-none focus:ring-2 focus:ring-[#5543FF] transition-all text-sm text-gray-600" required />
            </div>

            <div class="space-y-1">
                <label class="text-xs font-bold text-gray-700">Confirm Password <span class="text-red-500">*</span></label>
                <input type="password" name="repeat_password" placeholder="********" class="w-full px-4 py-2.5 rounded-lg bg-[#EAEAEA] border-none outline-none focus:ring-2 focus:ring-[#5543FF] transition-all text-sm text-gray-600" required />
            </div>

            <button type="submit" name="register" class="w-full bg-[#000033] text-white py-3 rounded-lg font-bold text-sm tracking-[0.15em] shadow-lg hover:bg-black transition-all active:scale-95 mt-2 uppercase">
                REGISTER
            </button>
        </form>

        <div class="relative flex py-6 items-center">
            <div class="flex-grow border-t border-gray-300"></div>
            <span class="flex-shrink mx-4 text-gray-500 text-[10px] font-bold uppercase">Or with</span>
            <div class="flex-grow border-t border-gray-300"></div>
        </div>

        <div class="grid grid-cols-2 gap-3">
            <div class="relative group">
                <button type="button" class="w-full flex items-center justify-center py-2 border border-gray-300 rounded-lg bg-[#EAEAEA] cursor-not-allowed">
                    <img src="assets/images/google.png" alt="Google" class="w-5 h-5 grayscale opacity-70" />
                </button>
                <span class="absolute -bottom-4 left-1/2 -translate-x-1/2 text-[7px] text-gray-400 opacity-0 group-hover:opacity-100 transition">Coming Soon</span>
            </div>
            <div class="relative group">
                <button type="button" class="w-full flex items-center justify-center py-2 border border-gray-300 rounded-lg bg-[#EAEAEA] cursor-not-allowed">
                    <img src="assets/images/facebook.png" alt="Facebook" class="w-5 h-5 grayscale opacity-70" />
                </button>
                <span class="absolute -bottom-4 left-1/2 -translate-x-1/2 text-[7px] text-gray-400 opacity-0 group-hover:opacity-100 transition">Coming Soon</span>
            </div>
        </div>

        <div class="mt-8 text-center pb-10"> 
            <p class="text-xs font-bold text-gray-800 tracking-wide uppercase">
                Udah Punya Akun? <a href="index.php" class="text-[#0099FF] hover:underline ml-1 font-bold">Login</a>
            </p>
        </div>
    </div>

<<<<<<< HEAD
<div class="hidden lg:flex lg:w-1/2 bg-[#5543FF] relative items-center justify-center overflow-hidden">
    <div class="relative z-20 w-full px-4 flex flex-col items-center">
        <img 
            src="assets/images/Revisi-Login-pict.svg" 
            alt="Bakery Illustration" 
            class="w-[105%] max-w-none h-auto drop-shadow-2xl " 
        />
    </div>
</div>
=======
    <div class="hidden lg:flex lg:w-1/2 bg-[#5543FF] relative items-center justify-center overflow-hidden">
        <div class="relative z-10 w-full px-12 flex flex-col items-center">
            <img src="assets/images/Revisi Login pict.svg" alt="Bakery Illustration" class="max-w-[125%] h-auto drop-shadow-2xl" />
        </div>
    </div>
>>>>>>> 32ffd7f8c204e0f46471282ddea2f6122a0418d3

    <script>feather.replace();</script>
</body>
</html>