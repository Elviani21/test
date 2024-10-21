<?php
session_start(); // Memulai sesi

// Cek apakah user sudah login
if (!isset($_SESSION['id_user'])) {
    echo "<script>alert('Silakan login terlebih dahulu!'); window.location.href = 'login.php';</script>";
    exit;
}

// Panggil koneksi database
include 'db_connect.php';

// Ambil data tugas yang telah selesai berdasarkan id_user
$id_user = $_SESSION['id_user'];
$query = "SELECT * FROM tbl_tugas WHERE status = 1 AND id_user = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $id_user);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="sendiri.css" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js"></script>
    <link href="fontawesome/css/solid.css" rel="stylesheet">
    <link href="fontawesome/css/fontawesome.css" rel="stylesheet">
    <title>Manajemen Waktu</title>
</head>
<body>
  
    <!-- Sidebar -->
    <?php include 'sidebar.php' ?>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container mt-4 ms-2">
            <h1 class="mt-3">
                <figure>
                    <blockquote class="blockquote">
                        <p>DAFTAR TUGAS SELESAI</p>
                    </blockquote>
                    <figcaption class="blockquote-footer">
                        Daftar Tugas Selesai <cite title="Source Title">Manajemen Waktu</cite>
                    </figcaption>
                </figure>
            </h1>
        </div>

        <!-- Tabel Tugas -->
        <div class="container table-container mt-3">
            <table class="table table-striped table-hover table-bordered table-sm shadow-sm mt-2">
                <thead>
                    <tr>
                        <th class="col-no">No.</th>
                        <th class="col-title">Judul Tugas</th>
                        <th class="col-mata-pelajaran">Mata Pelajaran</th>
                        <th class="col-desc">Deskripsi</th>
                        <th class="col-deadline">Tanggal & Jam Deadline</th>
                        <th class="col-action">Hasil Tugas</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Cek apakah ada tugas yang selesai
                    if ($result->num_rows > 0) {
                        $no = 1;
                        while ($tugas = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$no}</td>
                                    <td>" . htmlspecialchars($tugas['judul']) . "</td>
                                    <td>" . htmlspecialchars($tugas['mapel']) . "</td>
                                    <td>" . htmlspecialchars($tugas['deskripsi']) . "</td>
                                    <td>" . date('d-m-Y H:i', strtotime($tugas['tanggal'])) . "</td>
                                    <td>
                                        <a href='uploads/" . htmlspecialchars($tugas['file_tugas']) . "' class='btn btn-info btn-sm' target='_blank' title='Lihat Hasil Tugas'>
                                            <i class='fa-solid fa-eye'></i>
                                        </a>
                                    </td>
                                  </tr>";
                            $no++;
                        }
                    } else {
                        echo "<tr>
                                <td colspan='6' class='text-center'>Tidak ada tugas selesai.</td>
                              </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
