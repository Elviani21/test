<?php
// Mulai session dan panggil koneksi database
session_start();
include 'db_connect.php';

// Inisialisasi variabel
$judul = '';
$mapel = '';
$tanggal = '';
$deskripsi = '';
$button_text = 'Tambahkan'; // Default tombol tambah
$action_url = 'insert_tugas.php'; // Default untuk menambahkan tugas

// Cek apakah ini mode edit
if (isset($_GET['id_tugas'])) {
    $id_tugas = $_GET['id_tugas'];
    // Query untuk mengambil data tugas berdasarkan id_tugas
    $query = "SELECT * FROM tbl_tugas WHERE id_tugas = $id_tugas";
    $result = $conn->query($query);
    
    if ($result->num_rows > 0) {
        // Ambil data tugas yang akan diedit
        $row = $result->fetch_assoc();
        $judul = $row['judul'];
        $mapel = $row['mapel'];
        $tanggal = $row['tanggal'];
        $deskripsi = $row['deskripsi'];
        
        // Ubah tombol dan action untuk mode edit
        $button_text = 'Ubah'; // Tombol diubah menjadi "Ubah"
        $action_url = "update_tugas.php"; // Action untuk update
    } else {
        echo 'Tugas tidak ditemukan!';
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
                        <p><?= isset($id_tugas) ? 'UBAH TUGAS' : 'TAMBAH TUGAS' ?></p>
                    </blockquote>
                    <figcaption class="blockquote-footer">
                        Form Tugas <cite title="Source Title">Manajemen Waktu</cite>
                    </figcaption>
                </figure>
            </h1>
        </div>

        <!-- Form untuk input tugas -->
        <div class="container table-container mt-3">
            <form action="<?= $action_url ?>" method="POST">
                <!-- Tambahkan input hidden untuk id_tugas -->
                <input type="hidden" name="id_tugas" value="<?= isset($id_tugas) ? $id_tugas : '' ?>">

                <div class="mb-3 row">
                    <label for="judul" class="col-sm-2 col-form-label">
                        NAMA TUGAS
                    </label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="judul" placeholder="Masukkan nama tugas" value="<?= $judul ?>" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="mapel" class="col-sm-2 col-form-label">
                        MATA PELAJARAN
                    </label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="mapel" placeholder="Masukkan mata pelajaran" value="<?= $mapel ?>" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="datetime" class="col-sm-2 col-form-label">
                        TANGGAL DAN WAKTU
                    </label>
                    <div class="col-sm-10">
                        <input type="datetime-local" class="form-control" name="tanggal" value="<?= date('Y-m-d\TH:i', strtotime($tanggal)) ?>" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="deskripsi" class="col-sm-2 col-form-label">
                        DESKRIPSI TUGAS
                    </label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="deskripsi" rows="5" placeholder="Masukkan deskripsi tugas" required><?= $deskripsi ?></textarea>
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col-sm-10 offset-sm-2">
                        <button type="submit" class="btn btn-primary mr-2">
                            <i class="fas fa-check"></i> <?= $button_text ?>
                            </button>
                      
                      <a href="tugas.php" class="btn btn-danger ml-2 mt-3">
                      <i class = "fa fa-times"></i>    
                      Batalkan
                    
                      </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
