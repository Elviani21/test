<?php
// Mulai session dan panggil koneksi database
session_start();
include 'db_connect.php';

// Cek apakah form sudah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $judul = $_POST['judul'];
    $tanggal = $_POST['tanggal'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_akhir = $_POST['jam_akhir'];
    $id_user = $_SESSION['id_user']; // Pastikan pengguna sudah login dan id_user tersimpan di session

    // Validasi input jika diperlukan (misalnya cek format tanggal atau waktu)

    // Query untuk menambahkan data sesi belajar ke tabel tbl_belajar
    $query = "INSERT INTO tbl_belajar (judul, tanggal, jam_mulai, jam_akhir, id_user) 
              VALUES ('$judul', '$tanggal', '$jam_mulai', '$jam_akhir', '$id_user')";

    // Eksekusi query
    if ($conn->query($query) === TRUE) {
        // Redirect ke halaman lain setelah berhasil menambah sesi
        header("Location: sesi.php?status=sukses");
        exit();
    } else {
        // Tampilkan pesan error jika gagal
        echo "Error: " . $query . "<br>" . $conn->error;
    }
}
?>

