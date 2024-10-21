<?php
// logout.php
session_start(); // Memulai sesi

// Menghapus semua variabel sesi
session_unset();

// Menghancurkan sesi
session_destroy();

// Mengarahkan pengguna kembali ke halaman login atau beranda
header("Location: login.php");
exit();
?>
