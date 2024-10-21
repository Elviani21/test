<?php
// Panggil koneksi database
include 'db_connect.php'; 

// Cek apakah ada id_belajar dari URL
if (isset($_GET['id_belajar'])) {
    $id_belajar = intval($_GET['id_belajar']); 

    // Ambil data sesi belajar dari database
    $query = "SELECT * FROM tbl_belajar WHERE id_belajar = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_belajar);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $sesi = $result->fetch_assoc();
    } else {
        echo "Sesi belajar tidak ditemukan.";
        exit;
    }
} else {
    echo "ID sesi belajar tidak valid.";
    exit;
}

// Proses form jika disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $file_tugas = $_FILES['file_tugas']['name'];
    $file_tmp = $_FILES['file_tugas']['tmp_name'];
    
    // Validasi file upload
    $target_dir = "uploads/"; // Pastikan folder uploads sudah ada
    $target_file = $target_dir . basename($file_tugas);

    // Pindahkan file ke folder uploads
    if (move_uploaded_file($file_tmp, $target_file)) {
        // Update status sesi menjadi selesai dan simpan file tugas
        $update_query = "UPDATE tbl_belajar SET status = 1, file_tugas = ? WHERE id_belajar = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param("si", $file_tugas, $id_belajar);
        $update_stmt->execute();

        if ($update_stmt->affected_rows > 0) {
            echo "Sesi belajar berhasil diselesaikan dan file tugas diupload.";
            // Redirect ke halaman sesi.php
            header("Location: sesi.php?status=updated");
            exit;
        } else {
            echo "Gagal memperbarui status sesi.";
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
    <title>Manajemen Waktu - Selesai Sesi</title>
</head>
<body>
    <div class="container mt-4">
        <h1>Selesaikan Sesi Belajar</h1>
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="judul" class="form-label">Nama Sesi</label>
                <input type="text" class="form-control" id="judul" name="judul" value="<?= htmlspecialchars($sesi['judul']) ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal</label>
                <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= htmlspecialchars($sesi['tanggal']) ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="file_tugas" class="form-label">Upload File Tugas</label>
                <input type="file" class="form-control" id="file_tugas" name="file_tugas" required>
            </div>
            <button type="submit" class="btn btn-primary">Selesaikan Sesi</button>
        </form>
    </div>
</body>
</html>
