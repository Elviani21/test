<?php
// koneksi database
include 'db_connect.php'; // Pastikan koneksi database sudah diatur di db_connect.php

// Ambil id_tugas dari query string
$id_tugas = $_GET['id_tugas'];

// Ambil data tugas dari database
$query = "SELECT * FROM tbl_tugas WHERE id_tugas = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_tugas);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $tugas = $result->fetch_assoc();
} else {
    echo "Tugas tidak ditemukan.";
    exit;
}

// Proses form upload file
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $file_tugas = $_FILES['file_tugas']['name'];
    $file_tmp = $_FILES['file_tugas']['tmp_name'];
    
    // Validasi file upload
    $target_dir = "uploads/"; // Pastikan folder uploads sudah ada
    $target_file = $target_dir . basename($file_tugas);

    // Pindahkan file ke folder uploads
    if (move_uploaded_file($file_tmp, $target_file)) {
        // Update status tugas dan file_tugas di database
        $update_query = "UPDATE tbl_tugas SET status = 1, file_tugas = ? WHERE id_tugas = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param("si", $file_tugas, $id_tugas);
        $update_stmt->execute();
        
        if ($update_stmt->affected_rows > 0) {
            echo "Tugas berhasil diselesaikan dan file diupload.";
            // Redirect ke halaman index.php atau halaman yang diinginkan
            header("Location: selesai.php");
            exit;
        } else {
            echo "Gagal memperbarui status tugas.";
        }
    } else {
        echo "Gagal mengupload file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="sendiri.css" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js"></script>
    <title>Manajemen Waktu - Selesai Tugas</title>
</head>
<body>
    <div class="container mt-4">
        <h1>Detail Tugas</h1>
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="judul" class="form-label">Nama Tugas</label>
                <input type="text" class="form-control" id="judul" name="judul" value="<?= htmlspecialchars($tugas['judul']) ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="mapel" class="form-label">Mata Pelajaran</label>
                <input type="text" class="form-control" id="mapel" name="mapel" value="<?= htmlspecialchars($tugas['mapel']) ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="datetime" class="form-label">Tanggal dan Waktu</label>
                <input type="datetime-local" class="form-control" id="datetime" name="datetime" value="<?= date('Y-m-d\TH:i', strtotime($tugas['tanggal'])) ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi Tugas</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5" readonly><?= htmlspecialchars($tugas['deskripsi']) ?></textarea>
            </div>
             <div class="mb-3">
                <label for="file_tugas" class="form-label">Upload File Hasil Belajar</label>
                <input type="file" class="form-control" id="file_tugas" name="file_tugas" required>
            </div>
            <!-- <button type="submit" class="btn btn-primary">Selesaikan Tugas</button> -->
            
    <!-- Tombol batalkan -->
    <button type="submit" class="btn btn-primary"> Selesaikan Tugas</button>
                <a href="tugas.php" class="btn btn-danger ml-2 mt-3">Batalkan</a>

        </form>
    </div>
</body>
</html>
