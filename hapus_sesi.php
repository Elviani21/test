<?php
// Mulai session dan panggil koneksi database
session_start();
include 'db_connect.php';

// Cek apakah id_belajar dikirim melalui URL
if (isset($_GET['id_belajar'])) {
    $id_belajar = $_GET['id_belajar'];

    // Query untuk menghapus sesi belajar berdasarkan id_belajar
    $query = "DELETE FROM tbl_belajar WHERE id_belajar = '$id_belajar'";

    // Eksekusi query
    if ($conn->query($query) === TRUE) {
        // Redirect kembali ke halaman sesi.php dengan status sukses
        header("Location: sesi.php?status=deleted");
        exit();
    } else {
        // Tampilkan pesan error jika terjadi kesalahan
        echo "Error: " . $conn->error;
    }
} else {
    // Jika tidak ada id_belajar yang dikirim, redirect kembali ke sesi.php
    header("Location: sesi.php");
    exit();
}
?>
