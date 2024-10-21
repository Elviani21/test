<?php
$host = 'localhost';  // Sesuaikan dengan server MySQL
$db = 'db_alarm';  // Ganti dengan nama database kamu
$user = 'root';  // Sesuaikan dengan username MySQL kamu
$pass = '';  // Sesuaikan dengan password MySQL kamu

$conn = new mysqli($host, $user, $pass, $db);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
} else {
    echo "Koneksi berhasil!";
}
?>
