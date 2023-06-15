<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];

require_once "koneksi.php";

$donasi_id = $_POST['donasi_id'];

// Query untuk mengambil data dari database
$query = "SELECT nominal, tgl_lengkap FROM riwayat_donasi where donasi_id = $donasi_id";
$result = $conn->query($query);

// Inisialisasi array untuk menyimpan data
$dataFromDatabase = array();

// Memasukkan data dari database ke dalam array
while ($row = $result->fetch_assoc()) {
    $dataFromDatabase[] = $row;
}

$sql = "SELECT * FROM open_donasi WHERE donasi_id = '$donasi_id'";
$resultTampil = $conn->query($sql);

$stmtOrangBaik = $conn->prepare("SELECT riwayat_id, user_id, nama, nominal, tgl_lengkap, donasi_id, metode_pembayaran, bukti_transfer, doa FROM riwayat_donasi where donasi_id = '$donasi_id'");
$stmtOrangBaik->execute();
$resultOrangBaik = $stmtOrangBaik->get_result();

$stmtDonatur = $conn->prepare("SELECT ri.nama, ri.nominal, u.foto_profil  FROM riwayat_donasi ri join users u on ri.user_id = u.user_id where donasi_id = '$donasi_id'");
$stmtDonatur->execute();
$resultDonatur = $stmtDonatur->get_result();

if ($resultTampil->num_rows > 0) {
    // Mendapatkan data baris pertama
    $row = $resultTampil->fetch_assoc();

    // Mengambil nilai kolom
    $donasi_id = $row["donasi_id"];
    $thumbnail = $row["thumbnail"];
    $title = $row["title"];
    $target_donasi = $row["target_donasi"];
    $uang_donasi = $row["uang_donasi"];
    $target_hari = $row["target_hari"];
    $deskripsi = $row["deskripsi1"];
    $gambar1 = $row["gambar1"];
    $gambar2 = $row["gambar2"];
    $gambar3 = $row["gambar3"];
    $gambar4 = $row["gambar4"];
    $tgl_sekarang = date("Y-m-d");
    $sisa_hari = floor((strtotime($target_hari) - strtotime($tgl_sekarang)) / (60 * 60 * 24));
    $progress = ($uang_donasi / $target_donasi) * 100;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validasi jika data telah terisi
    if (!empty($_POST["nominal"]) && !empty($_POST["metode"]) && !empty($_POST["doa"])) {
        // Query untuk mengambil data user_id dan nama dari tabel users berdasarkan username
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $user_id = $row['user_id'];
            $nama = $row['nama'];
            $nominal = $_POST["nominal"];
            $metode = $_POST["metode"];
            $doa = $_POST["doa"];
            $donasi_id = $_POST["donasi_id"];
            $tgl_dibuat = date("Y-m-d");

            // Mendefinisikan folder untuk menyimpan foto
            $folder = './src/bukti_transfer/';

            $nama_foto = $_FILES["foto"]["name"];
            $sumber_foto = $_FILES["foto"]["tmp_name"];
            move_uploaded_file($sumber_foto, $folder . $nama_foto);

            // Memasukkan data ke dalam tabel riwayat_donasi
            $stmt = $conn->prepare("INSERT INTO db_takaful.riwayat_donasi
            (user_id, nama, nominal, tgl_lengkap, donasi_id, metode_pembayaran, bukti_transfer, doa) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssss", $user_id, $nama, $nominal, $tgl_dibuat, $donasi_id, $metode, $nama_foto, $doa);

            if ($stmt->execute()) {
                $notification = "Data berhasil disimpan.";

                // Update tabel open_donasi untuk menambahkan nilai nominal sebelumnya
                $stmt = $conn->prepare("UPDATE db_takaful.open_donasi SET uang_donasi = uang_donasi + ? WHERE donasi_id = ?");
                $stmt->bind_param("si", $nominal, $donasi_id);
                $stmt->execute();

                $stmt = $conn->prepare("UPDATE db_takaful.users SET total_donasi = total_donasi + ? WHERE username = ?");
                $stmt->bind_param("si", $nominal, $username);
                $stmt->execute();
                header("Location: index.php#urgent");
                exit();
            } else {
                $notification = "Terjadi kesalahan: " . $stmt->error;
            }
        } else {

            $notification = "Tidak ada data";
        }
    } else {
    }
}



?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Bootstrap demo</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="bootstrap/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/styleindex.css" />
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.php"><span class="text-warning">TAKAFUL</span>INDONESIA</a>
            <button aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler" data-bs-target="#navbarSupportedContent" data-bs-toggle="collapse" type="button">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php#urgent">Urgent</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php#project">Project</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php#benefit">Benfits</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php#guide">Guide</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profilepage.php">
                            <?php echo  $username;
                            ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profilepage.php">
                            <?php

                            // Query untuk mengambil data user berdasarkan username
                            $stmt = $conn->prepare("SELECT foto_profil FROM db_takaful.users WHERE username = ?");
                            $stmt->bind_param("s", $username);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                $foto_profil = $row['foto_profil'];

                                // Gunakan nilai foto_profil dalam tag <img> atau tempat lain yang sesuai
                                echo '<img src="src/img_profil_user/' . $foto_profil . '" alt="Foto Profil" width="30" height="30" class="rounded-circle">';
                            } else {
                                echo "data tidak ada";
                            }
                            ?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>



    <?php if (isset($notification) && $_SERVER["REQUEST_METHOD"] == "POST") : ?>
        <div style="margin-top: 80px; margin-top: 90px;" id="notification" class="alert alert-info">
            <?php echo $notification; ?>
        </div>
    <?php endif; ?>



    <div class="container " style="margin-top: 80px;">
        <!-- Section 1: Thumbnail, Title, Donation Progress -->
        <section>
            <div class="row">
                <div class="col-md-6">
                    <!-- Thumbnail -->
                    <img src="src/img_upload/thumbnail/<?php echo $thumbnail; ?>" alt="Thumbnail" class="img-thumbnail" />
                </div>
                <div class="col-md-6">
                    <!-- Title -->
                    <h2><?php echo $title; ?></h2>
                    <!-- Donation and Target -->
                    <p><?php echo "Donation: Rp.$uang_donasi / Target:Rp.$target_donasi"; ?></p>
                    <!-- Progress Bar -->
                    <div class="progress">
                        <?php echo '<div class="progress-bar" role="progressbar" style=" width: ' . $progress . '%;" aria-valuenow="' . $progress . '" aria-valuemin="0" aria-valuemax="100">' . $progress . '%</div>'; ?>
                    </div>
                    <!-- Days Remaining -->
                    <p>Hari Tersisa : <?php echo $sisa_hari; ?></p>
                    <div class="row">
                        <div class="col">
                            <button style="width: 100%;" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalformdonasi">Donasi Sekarang</button>
                        </div>
                        <div class="col">
                            <form action="cetakexcel.php" method="POST">
                                <input type="hidden" name="donasi_id" value="<?php echo $donasi_id; ?>">
                                <button type="submit" class="btn btn-outline-info text-dark" style="width: 100%;">Riwayat Donasi</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>



        <!-- Section 4: Story Cards -->
        <section>
            <h2>Story</h2>
            <div class="row">
                <div class="col-3 my-2">
                    <div class="card">
                        <img src="src/img_upload/images/<?php echo $gambar1; ?>" class="card-img-top" alt="Story 1">
                    </div>
                </div>
                <div class="col-3 my-2">
                    <div class="card">
                        <img src="src/img_upload/images/<?php echo $gambar2; ?>" class="card-img-top" alt="Story 2">
                    </div>
                </div>
                <div class="col-3 my-2">
                    <div class="card">
                        <img src="src/img_upload/images/<?php echo $gambar3; ?>" class="card-img-top" alt="Story 3">
                    </div>
                </div>
                <div class="col-3 my-2">
                    <div class="card">
                        <img src="src/img_upload/images/<?php echo $gambar4; ?>" class="card-img-top" alt="Story 4">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <p><?php echo $deskripsi; ?></p>
                </div>
            </div>
        </section>

        <!-- Section 2: Donor Cards -->
        <section>
            <h2>Donatur</h2>
            <div class="row">
                <?php

                if ($resultDonatur->num_rows > 0) {
                    while ($row = $resultDonatur->fetch_assoc()) {
                        $nama = $row['nama'];
                        $foto_profil = $row['foto_profil'];
                        $nominal = $row['nominal'];

                        echo '<div class="col-4 my-2">';
                        echo '<div class="card">';
                        echo '<div class="row ">';
                        echo '<div class="col-md-4">';
                        echo '<div class="card-img-container">';
                        echo '<img src="src/img_profil_user/' . $foto_profil . '" class="card-img-top" alt="' . $nama . '">';
                        echo '</div>';
                        echo '</div>';
                        echo '<div class="col-8">';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">' . $nama . '</h5>';
                        echo '<p class="card-text">' . $nominal . '</p>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<h5>Belum Ada Donatur</h5>';
                }

                $stmtDonatur->close();
                ?>
            </div>
        </section>

        <!-- Section 3: Good People Cards -->
        <section>
            <h2>Doa Orang Baik</h2>
            <div class="row">
                <?php

                if ($resultOrangBaik->num_rows > 0) {
                    while ($row = $resultOrangBaik->fetch_assoc()) {
                        $nama = $row['nama'];
                        $doa = $row['doa'];

                        echo '<div class="col-4 my-2">';
                        echo '<div class="card">';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">' . $nama . '</h5>';
                        echo '<p class="card-text">' . $doa . '</p>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }

                    $stmtOrangBaik->close();
                } else {
                    echo '<h5>Belum Ada Donatur</h5>';
                }
                ?>
            </div>
        </section>


        <!-- Modal -->
        <div class="modal fade" id="modalformdonasi" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Form Donasi</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" enctype="multipart/form-data" method="post" id="donation-form" class="h-100 py-auto">
                            <input type="text" name="donasi_id" value="<?php echo $donasi_id; ?>" hidden>
                            <div class="mb-3">
                                <label for="nominal" class="form-label">Nominal Donasi</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="nominal" id="nominal1" value="300000" />
                                    <label class="form-check-label" for="nominal1">300.000</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="nominal" id="nominal2" value="500000" />
                                    <label class="form-check-label" for="nominal2">500.000</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="nominal" id="nominal3" value="1000000" />
                                    <label class="form-check-label" for="nominal3">1.000.000</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="nominal" id="nominal4" value="1500000" />
                                    <label class="form-check-label" for="nominal4">1.500.000</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="metode" class="form-label">Metode Pembayaran</label>
                                <select class="form-select" id="metode" name="metode">
                                    <option value="transfer">Transfer Bank</option>
                                    <option value="kartu_kredit">Kartu Kredit</option>
                                    <option value="ewallet">E-Wallet</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="doa" class="form-label">Doa</label>
                                <textarea class="form-control" id="doa" rows="3" placeholder="Tuliskan doa yang ingin disampaikan" name="doa"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="foto" class="form-label">Upload Foto</label>
                                <input class="form-control" type="file" id="foto" onchange="previewFoto" name="foto" />
                            </div>
                            <div class="mb-3">
                                <img src="" id="preview" alt="Preview Foto" style="max-width: 200px" />
                            </div>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <h4 class="my-4">Riwayat Donasi</h4>
            <canvas id="myChart"></canvas>
        </div>


    </div>
    <script>
        // Mengubah format tanggal menjadi array label
        const labels = <?php echo json_encode(array_column($dataFromDatabase, 'tgl_lengkap')); ?>;

        // Mengambil nilai nominal dari database
        const dataNominal = <?php echo json_encode(array_column($dataFromDatabase, 'nominal')); ?>;

        // Membuat data untuk chart
        const data = {
            labels: labels,
            datasets: [{
                label: 'Nominal',
                data: dataNominal,
                fill: false,
                backgroundColor: 'rgba(0, 123, 255, 1)',
                borderColor: 'rgba(0, 123, 255, 1)',
                tension: 0.1
            }]
        };

        // Membuat chart menggunakan Chart.js
        const ctx = document.getElementById('myChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: data,
            options: {}
        });


        function openFormDonasi() {
            $('#exampleModal').modal('hide');
            $('#formdonasi').css('display', 'block');
        }

        function previewFoto(event) {
            var input = event.target;
            var reader = new FileReader();

            reader.onload = function() {
                var imgElement = document.getElementById("preview");
                imgElement.src = reader.result;
            };

            reader.readAsDataURL(input.files[0]);
        }

        // Menghilangkan notifikasi setelah 3 detik
        setTimeout(function() {
            var notification = document.getElementById("notification");
            if (notification) {
                notification.style.display = "none";
            }
        }, 3000);

        feather.replace()
    </script>
    <script src="https://unpkg.com/@lottiefiles/lottie-player@1.5.7/dist/lottie-player.js"></script>
    <script src="bootstrap/dist/js/bootstrap.min.js"></script>

</body>

</html>