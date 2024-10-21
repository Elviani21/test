<?php
// Mulai session
session_start();
include 'db_connect.php'; // Pastikan nama file koneksi sudah benar

// Inisialisasi variabel error
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'];
    $mapel = $_POST['mapel'];
    $datetime = $_POST['tanggal']; // Pastikan ini sesuai dengan name di form
    $deskripsi = $_POST['deskripsi'];

    // Ambil id_user dari session
    if (isset($_SESSION['id_user'])) {
        $id_user = $_SESSION['id_user'];
    } else {
        // Jika id_user tidak ada di session, arahkan pengguna ke halaman login
        header('Location: login.php');
        exit();
    }

    // Validasi input
    if (empty($judul) || empty($mapel) || empty($datetime) || empty($deskripsi)) {
        $error = "Semua field harus diisi.";
    } else {
        // Insert data ke database
        $query = "INSERT INTO tbl_tugas (judul, mapel, tanggal, deskripsi, id_user) VALUES ('$judul', '$mapel', '$datetime', '$deskripsi', '$id_user')";

        if ($conn->query($query)) {
            // Jika berhasil, tampilkan alert dan redirect ke index
            echo '<script>
                    alert("Tugas berhasil ditambahkan!");
                    window.location.href = "tugas.php"; // Ganti dengan halaman index yang sesuai
                  </script>';
            exit();
        } else {
            // Tampilkan pesan error dari database
            $error = "Gagal menambahkan tugas: " . $conn->error;
        }
    }
}
?>
