<?php
session_start();
require_once 'config.php';

// --- TAMBAHKAN KODE INI ---
// Jika user sudah login, paksa langsung masuk ke home.php
if (isset($_SESSION['user_id'])) {
    header("Location: home.php");
    exit;
}
// --------------------------

$error_message = ""; 

// Proses Login
if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Cek apakah email ada di database
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        
        // Cek password
        if ($password === $row['password']) {
            
            // Set Session
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_email'] = $row['email'];
            $_SESSION['user_role'] = $row['role'];

            // Redirect ke halaman utama
            header("Location: home.php"); 
            exit;
        } else {
            $error_message = "Password yang Anda masukkan salah!";
        }
    } else {
        $error_message = "Email tidak terdaftar silahkan Register";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Candrasa Bakery</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        /* Sembunyikan scrollbar tapi tetap bisa scroll */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
        <script src="https://unpkg.com/feather-icons"></script>
</head>
<body class="flex h-screen w-full overflow-hidden bg-white font-sans">

    <div class="w-full lg:w-1/2 flex flex-col px-8 md:px-16 lg:px-20 justify-center relative overflow-y-auto no-scrollbar">
        
<div class="mb-4 mt-8 lg:mt-0">
    <a href="javascript:history.back()" class="flex items-center justify-center w-8 h-8 bg-[#000066] text-white rounded-full hover:bg-blue-900 transition shadow-sm active:scale-90">
        <i data-feather="arrow-left" style="width: 16px; height: 16px;"></i>
    </a>
</div>

        <div class="mb-6">
            <img src="assets/images/Logo candrasa.svg" alt="Logo Candrasa" class="h-10 object-contain" />
        </div>

        <div class="mb-6">
            <h1 class="text-2xl font-extrabold text-[#000066] leading-tight">Login sebelum membeli produk.</h1>
            <p class="text-gray-400 text-[10px] mt-1 font-bold uppercase tracking-wider">Pengguna Candrasa Bakery</p>
        </div>

        <?php if ($error_message): ?>
            <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 text-xs rounded-lg font-semibold">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <?php if (isset($success_message)): ?>
            <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 text-xs rounded-lg font-semibold">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>

        <form class="space-y-4" action="" method="POST">
            <div class="space-y-1">
                <label class="text-xs font-bold text-gray-700">Email <span class="text-red-500">*</span></label>
                <input 
                    type="email" 
                    name="email"
                    placeholder="exampleYTTA@gmail.com" 
                    class="w-full px-4 py-2.5 rounded-lg bg-[#EAEAEA] border-none outline-none focus:ring-2 focus:ring-[#5543FF] transition-all text-sm text-gray-600" 
                    required 
                />
            </div>

            <div class="space-y-1">
                <label class="text-xs font-bold text-gray-700">Password <span class="text-red-500">*</span></label>
                <input 
                    type="password" 
                    name="password"
                    placeholder="********" 
                    class="w-full px-4 py-2.5 rounded-lg bg-[#EAEAEA] border-none outline-none focus:ring-2 focus:ring-[#5543FF] transition-all text-sm text-gray-600" 
                    required 
                />
                <div class="text-left">
                    <a href="#" class="text-xs font-bold text-[#0099FF] hover:underline inline-block mt-1">Forgot Your Password?</a>
                </div>
            </div>

            <button 
                type="submit"
                name="login"
                class="w-full bg-[#000033] text-white py-3 rounded-lg font-bold text-sm tracking-[0.15em] shadow-lg hover:bg-black transition-all active:scale-95 mt-2">
                LOGIN
            </button>
        </form>

        <div class="relative flex py-6 items-center">
            <div class="flex-grow border-t border-gray-300"></div>
            <span class="flex-shrink mx-4 text-gray-500 text-[10px] font-bold uppercase">Or with</span>
            <div class="flex-grow border-t border-gray-300"></div>
        </div>

<div class="grid grid-cols-2 gap-3">
            <div class="relative group">
                <a href="#" class="flex items-center justify-center py-2 border border-gray-300 rounded-lg bg-[#EAEAEA] opacity-70 cursor-not-allowed transition-all">
                    <img src="assets/images/google.png" alt="Google" class="w-5 h-5 grayscale" />
                </a>
                <span class="absolute -bottom-5 left-1/2 -translate-x-1/2 text-[8px] font-bold text-gray-400 uppercase tracking-tighter opacity-0 group-hover:opacity-100 transition-opacity">Coming Soon</span>
            </div>

            <div class="relative group">
                <button type="button" class="w-full flex items-center justify-center py-2 border border-gray-300 rounded-lg bg-[#EAEAEA] opacity-70 cursor-not-allowed transition-all">
                    <img src="assets/images/facebook.png" alt="Facebook" class="w-5 h-5 grayscale" />
                </button>
                <span class="absolute -bottom-5 left-1/2 -translate-x-1/2 text-[8px] font-bold text-gray-400 uppercase tracking-tighter opacity-0 group-hover:opacity-100 transition-opacity">Coming Soon</span>
            </div>
        </div>

        <div class="mt-8 text-center pb-6">
            <p class="text-xs font-bold text-gray-800 tracking-wide uppercase">
                Tidak Punya Akun?
                <a href="register.php" class="text-[#0099FF] hover:underline ml-1 font-bold">Register</a>
            </p>
        </div>
    </div>

<div class="hidden lg:flex lg:w-1/2 bg-[#5543FF] relative items-center justify-center overflow-hidden">
    <div class="relative z-20 w-full px-4 flex flex-col items-center">
        <img 
            src="assets/images/Revisi-Login-pict.svg" 
            alt="Bakery Illustration" 
            class="w-[105%] max-w-none h-auto drop-shadow-2xl " 
        />
    </div>
</div>
<script>
    feather.replace();
</script>
</body>
</html>