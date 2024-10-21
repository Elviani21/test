<?php
// Panggil koneksi ke database
include 'db_connect.php';

// Aktifkan laporan kesalahan PHP untuk debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Cek apakah id_tugas dikirim melalui URL
if (isset($_GET['id_tugas'])) {
    $id_tugas = $_GET['id_tugas'];

    // Validasi bahwa id_tugas adalah integer
    if (filter_var($id_tugas, FILTER_VALIDATE_INT) === false) {
        echo "ID Tugas tidak valid!";
        exit;
    }

    // Query untuk menghapus tugas berdasarkan id_tugas
    $query = "DELETE FROM tbl_tugas WHERE id_tugas = ?";

    // Prepare statement untuk menghindari SQL Injection
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        die('Prepare failed: ' . $conn->error);
    }

    // Bind parameter
    $stmt->bind_param("i", $id_tugas);

    // Eksekusi query
    if ($stmt->execute()) {
        // Jika berhasil, redirect ke halaman tugas.php dengan pesan sukses
        header("Location: tugas.php?pesan=delete_success");
        exit();
    } else {
        // Jika gagal, tampilkan pesan error
        echo "Error: " . $stmt->error;
    }

    // Tutup statement
    $stmt->close();
} else {
    // Jika id_tugas tidak ditemukan di URL, redirect kembali ke tugas.php
    header("Location: tugas.php?pesan=invalid_id");
    exit();
}
?>
