<?php
if (isset($_GET['page'])) {
    $hal = $_GET['page'];

    switch ($hal) {
        case 'home':
            include 'home.php';
            break;
        case 'admin':
            include 'user.php';
            break;
        case 'logout':
            include 'logout.php';
            break;
        case 'bidang':
            include 'bidang/index.php';
            break;
        case 'usaha':
            include 'usaha.php';
            break;
        case 'toko':
            include 'toko.php';
            break;
        case 'perhitungan':
            include 'templates/index.php';
            break;
        // Tambah case lain sesuai kebutuhan

        default:
            echo '<center><h1>ERROR! Halaman tidak ditemukan</h1></center>';
            break;
    }
} else {
    // Default jika tidak ada parameter
    include 'home.php'; // Bisa juga diganti ke index.php jika diinginkan
}
?>
