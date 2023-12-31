<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

require_once "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['hapus_donasi'])) {
    $donasi_id = $_POST['hapus_donasi'];

    // Query untuk menghapus data berdasarkan donasi_id
    $sql = "DELETE FROM open_donasi WHERE donasi_id = $donasi_id";
    if ($conn->query($sql) === TRUE) {
    } else {
    }
}

$batas = 10; // Jumlah data per halaman

// Menghitung jumlah data
$sqlCount = "SELECT COUNT(*) AS total FROM riwayat_donasi";
$resultCount = $conn->query($sqlCount);
$rowCount = $resultCount->fetch_assoc();
$totalData = $rowCount['total'];

// Menghitung jumlah halaman
$totalHalaman = ceil($totalData / $batas);

// Mendapatkan halaman aktif dari parameter URL
$halamanAktif = isset($_GET['halaman']) ? $_GET['halaman'] : 1;
$mulaiData = ($halamanAktif - 1) * $batas;

// Query untuk mengambil data dengan batasan dan halaman yang sesuai
$sqlData = "SELECT riwayat_id, user_id, nama, nominal, tgl_lengkap, donasi_id, metode_pembayaran, bukti_transfer, doa FROM riwayat_donasi LIMIT $mulaiData, $batas";
$resultData = $conn->query($sqlData);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Bootstrap demo</title>
    <link rel="stylesheet" href="bootstrap/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/styleindex.css" />
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="login.php"><span class="text-warning">TAKAFUL</span>INDONESIA</a>
            <button aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler" data-bs-target="#navbarSupportedContent" data-bs-toggle="collapse" type="button">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#list">Riwayat</a>
                    </li>
                    <li class="nav-item">
                        <a href="login.php">
                            <button class="btn btn-danger">Log Out</button>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <div class="container" style="margin-top: 80px;" id="home">
        <div class=" row">
            <?php if (isset($notification)) : ?>
                <div class="alert alert-info mt-3">
                    <?php echo $notification; ?>
                </div>
            <?php endif; ?>

            <h3>List projek Donasi</h3>
            <?php
            require_once "koneksi.php";

            // Mengambil data dari tabel open_donasi
            $sql = "SELECT * FROM open_donasi ";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Looping untuk setiap baris data
                while ($row = $result->fetch_assoc()) {
                    $donasi_id = $row["donasi_id"];
                    $thumbnail = $row["thumbnail"];
                    $title = $row["title"];
                    $target_donasi = $row["target_donasi"];
                    $uang_donasi = $row["uang_donasi"];
                    $target_hari = $row["target_hari"];
                    $tgl_sekarang = date("Y-m-d");
                    $sisa_hari = floor((strtotime($target_hari) - strtotime($tgl_sekarang)) / (60 * 60 * 24));
                    $progress = ($uang_donasi / $target_donasi) * 100;

                    // Tampilkan card untuk setiap data
                    echo '<div class="col-4 px-2 my-3">';
                    echo '<div class="card px-3">';
                    echo '<form action="admin.php" method="post">';
                    echo '<input name="donasi_id" type="text" hidden value="' . $donasi_id . '">';
                    echo '<img src="./src/img_upload/thumbnail/' . $thumbnail . '" class="card-img-top mt-3 rounded" alt="Thumbnail">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . $title . '</h5>';
                    echo '<div class="progress">';
                    echo '<div class="progress-bar" role="progressbar" style="width: ' . $progress . '%;" aria-valuenow="' . $progress . '" aria-valuemin="0" aria-valuemax="100">' . $progress . '%</div>';
                    echo '</div>';
                    echo '<p class="card-text">Target Donasi: ' . $uang_donasi . '/' . $target_donasi . ' <br> Sisa Hari: ' . $sisa_hari . ' </p>';
                    echo '<button type="submit" name="hapus_donasi" value="' . $donasi_id . '" class="btn btn-danger">Hapus</button>';
                    echo '</div>';
                    echo '</form>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "<div class='my-5 mx-auto'><p>Tidak ada data yang ditemukan.</p></div>";
            }
            $conn->close();

            ?>
            <div class="col-4 px-2 my-3">
                <div class="card px-3" style="width: 330px; height: 350px;">
                    <div class="card-body" style="display: flex; justify-content: center; align-items: center;">
                        <button id="tombol-tambah" class=" btn btn-primary">Projek Baru</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="container" id="list">
            <h3 class="my-4">List projek Donasi</h3>
            <?php

            // Menampilkan tabel data
            if ($resultData->num_rows > 0) {
                echo '<table class="table">';
                echo '<tr>
            <th>Riwayat ID</th>
            <th>User ID</th>
            <th>Nama</th>
            <th>Nominal</th>
            <th>Tanggal</th>
            <th>Donasi ID</th>
            <th>Metode Pembayaran</th>
          </tr>';
                while ($row = $resultData->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . $row["riwayat_id"] . '</td>';
                    echo '<td>' . $row["user_id"] . '</td>';
                    echo '<td>' . $row["nama"] . '</td>';
                    echo '<td>' . $row["nominal"] . '</td>';
                    echo '<td>' . $row["tgl_lengkap"] . '</td>';
                    echo '<td>' . $row["donasi_id"] . '</td>';
                    echo '<td>' . $row["metode_pembayaran"] . '</td>';
                    echo '</tr>';
                }
                echo '</table>';
            } else {
                echo "<p>Tidak ada data riwayat donasi yang ditemukan.</p>";
            }

            // Menampilkan navigasi halaman
            echo '<div class="pagination">';
            for ($i = 1; $i <= $totalHalaman; $i++) {
                $isActive = $i == $halamanAktif ? 'active' : '';
                echo '<a class="' . $isActive . '" href="?halaman=' . $i . '">' . $i . '</a>';
            }
            echo '</div>';

            ?>
        </div>

        <!-- Modal -->
        <div id="modal-form" class="modal" tabindex="-1" role="dialog" style="overflow: auto;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Input Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="upload_donasi.php" method="post" enctype="multipart/form-data">
                            <div class="form-group mb-3">
                                <label for="thumbnail" class="form-label">Thumbnail</label>
                                <input class="form-control" type="file" name="thumbnail" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" name="title" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="target_donasi" class="form-label">Target Donasi</label>
                                <input type="number" class="form-control" name="target_donasi" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="uang_donasi" class="form-label">Uang Donasi</label>
                                <input type="number" class="form-control" name="uang_donasi" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Target Hari</label>
                                <input type="date" name="target_hari" class="form-control" />
                            </div>
                            <div class="form-group mb-3">
                                <label for="deskripsi1" class="form-label">Deskripsi 1</label>
                                <textarea class="form-control" name="deskripsi1" rows="3" required></textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label for="gambar1" class="form-label">Gambar 1</label>
                                <input class="form-control" type="file" name="gambar1" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="gambar2" class="form-label">Gambar 2</label>
                                <input class="form-control" type="file" name="gambar2" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="gambar3" class="form-label">Gambar 3</label>
                                <input class="form-control" type="file" name="gambar3" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="gambar4" class="form-label">Gambar 4</label>
                                <input class="form-control" type="file" name="gambar4" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="bootstrap/dist/js/bootstrap.min.js"></script>
        <script>
            // Smooth scroll to anchor links
            document.querySelectorAll('nav a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    document.querySelector(this.getAttribute('href')).scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            });


            document.getElementById('tombol-tambah').addEventListener('click', function() {
                var modal = document.getElementById('modal-form');
                modal.style.display = 'block';
            });

            var modal = document.getElementById('modal-form');
            var closeButton = document.querySelector('#modal-form .btn-close');

            closeButton.addEventListener('click', function() {
                modal.style.display = 'none';
            });

            window.addEventListener('click', function(event) {
                if (event.target === modal) {
                    modal.style.display = 'none';
                }
            });
        </script>
</body>

</html>