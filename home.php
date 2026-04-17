<?php
session_start();
require_once 'config.php';
if (!isset($_SESSION['user_id'])) { header("Location: index.php"); exit; }
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candrasa Bakery - Beranda</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700;800&family=Poppins:wght@600;700&display=swap" rel="stylesheet">
     <link rel="icon" type="image/x-icon" href="./assets/images/logo candrasa putih.svg">
</head>
<body class="bg-[#F8F9FA] font-sans">

    <?php include 'components/navbar.php'; ?>

    <main>
        <?php include 'components/hero.php'; ?>
        <?php include 'components/navigasi.php'; ?>
                <?php include 'components/products.php'; ?>
        <?php include 'components/menu-products.php'; ?>

        <?php include 'components/feedback.php'; ?>
    </main>

    <?php include 'components/footer.php'; ?>
</body>
</html>