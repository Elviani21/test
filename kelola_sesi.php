<?php
// Mulai session dan panggil koneksi database
session_start();
include 'db_connect.php';

// Inisialisasi variabel
$judul = '';
$tanggal = '';
$jam_mulai = '';
$jam_akhir = '';
$button_text = 'Tambahkan'; // Default tombol tambah
$action_url = 'proses_tambah_sesi.php'; // Default untuk menambahkan sesi

// Cek apakah ini mode edit
if (isset($_GET['id_belajar'])) {
    $id_belajar = $_GET['id_belajar'];
    // Query untuk mengambil data sesi belajar berdasarkan id_belajar
    $query = "SELECT * FROM tbl_belajar WHERE id_belajar = $id_belajar";
    $result = $conn->query($query);
    
    if ($result->num_rows > 0) {
        // Ambil data sesi yang akan diedit
        $row = $result->fetch_assoc();
        $judul = $row['judul'];
        $tanggal = $row['tanggal'];
        $jam_mulai = $row['jam_mulai'];
        $jam_akhir = $row['jam_akhir'];
        
        // Ubah tombol dan action untuk mode edit
        $button_text = 'Ubah'; // Tombol diubah menjadi "Ubah"
        $action_url = "update_sesi.php"; // Action untuk update
    } else {
        echo 'Sesi belajar tidak ditemukan!';
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js"></script>
    <link href="sendiri.css" rel="stylesheet">
    <link href="fontawesome/css/solid.css" rel="stylesheet">
    <link href="fontawesome/css/fontawesome.css" rel="stylesheet">
    <title>Manajemen Waktu</title>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand ms-2">Manajemen Waktu</a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <div class="container mt-4 ms-2">
            <h1 class="mt-3">
                <figure>
                    <blockquote class="blockquote">
                        <p><?= isset($id_belajar) ? 'UBAH SESI BELAJAR' : 'TAMBAH SESI BELAJAR' ?></p>
                    </blockquote>
                    <figcaption class="blockquote-footer">
                        Form Sesi Belajar <cite title="Source Title">Manajemen Waktu</cite>
                    </figcaption>
                </figure>
            </h1>
        </div>

        <!-- Form untuk input sesi belajar -->
        <div class="container table-container mt-3">
        <form action="<?= $action_url ?>" method="POST">
                <div class="mb-3 row">
                    <label for="judul" class="col-sm-2 col-form-label">Judul</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="judul" name="judul" value="<?= $judul ?>" required placeholder="Masukkan Judul">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="tanggal" class="col-sm-2 col-form-label">Tanggal</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= $tanggal ?>" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="jam_mulai" class="col-sm-2 col-form-label">Jam Mulai</label>
                    <div class="col-sm-10">
                         <input type="time" class="form-control" id="jam_mulai" name="jam_mulai" value="<?= $jam_mulai ?>" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="jam_akhir" class="col-sm-2 col-form-label">Jam Akhir</label>
                    <div class="col-sm-10">
                        <input type="time" class="form-control" id="jam_akhir" name="jam_akhir" value="<?= $jam_akhir ?>" required>
                    </div>
                </div>
                
                <!-- Tombol untuk simpan dan batalkan -->
                <button type="submit" class="btn btn-primary"><?= $button_text ?> Sesi Belajar</button>
                <a href="sesi.php" class="btn btn-danger ml-2 mt-3">Batalkan</a>
        </form>
        </div>
    </div>
</body>
</html>
