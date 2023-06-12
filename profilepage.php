<?php
session_start();
if (!isset($_SESSION['username']) && !isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

require_once "koneksi.php";

// Mengambil nilai username dari session
$username = $_SESSION['username'];

// Query untuk mengambil user_id berdasarkan username
$queryUserId = "SELECT user_id FROM users WHERE username = '$username'";
$resultUserId = $conn->query($queryUserId);

// Memeriksa apakah query berhasil
if ($resultUserId->num_rows > 0) {
    $rowUserId = $resultUserId->fetch_assoc();
    $user_id = $rowUserId['user_id'];

    // Query untuk mengambil data dari riwayat_donasi berdasarkan user_id
    $query = "SELECT nominal, tgl_lengkap FROM riwayat_donasi WHERE user_id = '$user_id'";
    $result = $conn->query($query);

    // Inisialisasi array untuk menyimpan data
    $dataFromDatabase = array();

    // Memasukkan data dari database ke dalam array
    while ($row = $result->fetch_assoc()) {
        $dataFromDatabase[] = $row;
    }
}


// Mendapatkan user_id dari sesi atau pengiriman data POST
$username = $_SESSION['username']; // Ganti dengan cara Anda untuk mendapatkan username

// Mendapatkan data pengguna dari database
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $user_id = $row['user_id'];
    $username = $row['username'];
    $nama = $row['nama'];
    $nomor_telepon = $row['nomor_telepon'];
    $foto_profil = $row['foto_profil'];
} else {
    echo 'Data pengguna tidak ditemukan';
    exit;
}


// Mendapatkan data pengguna dari database
$stmtt = $conn->prepare("SELECT total_donasi FROM db_takaful.users WHERE username = ?");
$stmtt->bind_param("s", $username);
$stmtt->execute();
$result = $stmtt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_donasi = $row['total_donasi'];
} else {
    echo 'Data pengguna tidak ditemukan';
    exit;
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_nama = $_POST["nama"];
    $nomortelepon = $_POST["nomortelepon"];

    // Perbarui data profil pengguna di database
    $update_stmt = $conn->prepare("UPDATE users SET nama  = ? ,nomor_telepon = ? WHERE user_id = ?");
    $update_stmt->bind_param("ssi", $new_nama, $nomortelepon, $user_id);
    if ($update_stmt->execute()) {
        echo "Profil berhasil diperbarui";
        $nama = $new_nama;
        header("Location: login.php");
        exit();
    } else {
        echo "Terjadi kesalahan saat memperbarui profil: " . $update_stmt->error;
    }
}

$stmt->close();
$stmtt->close();


?>

<!DOCTYPE html>
<html>

<head>
    <title>Profil Pengguna</title>
    <link rel="stylesheet" href="bootstrap/dist/css/bootstrap.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .profile-img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <style>
        .profile-img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            cursor: pointer;
        }

        .modal-dialog-centered {
            display: flex;
            align-items: center;
            min-height: calc(100% - 1rem);
        }
    </style>
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
                            <a class="nav-link" href="index.php#testimoni">Testimoni</a>
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
                                require_once "koneksi.php";
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
                                    // Handle jika data user tidak ditemukan
                                }
                                $stmt->close();


                                ?>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>


        <div class="container">

            <div class="row" style="margin-top: 90px;">
                <div class="col-3">
                    <div class="text-center">
                        <?php
                        require_once "koneksi.php";
                        // Query untuk mengambil data user berdasarkan username
                        $stmt = $conn->prepare("SELECT foto_profil FROM db_takaful.users WHERE username = ?");
                        $stmt->bind_param("s", $username);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $foto_profil = $row['foto_profil'];

                            // Gunakan nilai foto_profil dalam tag <img> atau tempat lain yang sesuai
                            echo '<img class="profile-img mb-3" data-bs-toggle="modal" data-bs-target="#changeProfileModal" style="width: 260px; height: 260px; object-fit: cover; object-position: center;" alt="" src="src/img_profil_user/' . $foto_profil . '">';
                        } else {
                            echo "data tidak ada";
                            // Handle jika data user tidak ditemukan
                        }
                        $stmt->close();

                        ?>
                        <div style="display: flex; justify-content: space-around;">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">Edit Profile</button>
                            <form action="logout.php" method="post">
                                <button class="btn btn-danger" type="submit" value="Logout">Log Out</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-9">
                    <h3 class="mb-4">Selamat datang, <?php echo $nama; ?></h3>
                    <h4>Informasi Profil</h4>
                    <table class="table">
                        <tbody>
                            <tr>
                                <th>Username</th>
                                <td><?php echo $username; ?></td>
                            </tr>
                            <tr>
                                <th>Nama</th>
                                <td><?php echo $nama; ?></td>
                            </tr>
                            <tr>
                                <th>Nomor Telepon</th>
                                <td><?php echo $nomor_telepon; ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="print row">
                        <h4 class="my-4">Sertifikat</h4>
                        <div class="col-6">
                            <p><span class="text-danger">*</span>Untuk Mendapatkan Sertifikat Dari Takaful, Anda harus berdonasi minimal Rp300.000</p>
                            <p>Jumlah Nominal Donasi Saya : <?php echo $total_donasi; ?></p>
                            <?php
                            if ($total_donasi >= 300000) {
                                echo '<form action="importpdf.php" method="post">';
                                echo '<button class="btn btn-success" type="submit" value="Logout">Claim Sertifikat</button>';
                                echo '</form>';
                            } else {
                                echo '<button class="btn btn-outline-danger" type="submit" value="Logout" disabled>Claim Sertifikat</button>';
                            }

                            ?>
                        </div>
                        <div class="col-6">
                            <img src="src/sertif/Certificate.png" alt="" style="height: 200px;">
                        </div>
                    </div>
                    <div>
                        <h4 class="my-4">Donasi Saya</h4>
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
        </div>



        <!-- Modal untuk mengganti foto profil -->
        <div class="modal fade" id="changeProfileModal" tabindex="-1" aria-labelledby="changeProfileModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="changeProfileModalLabel">Ganti Foto Profil</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="simpanprofile.php" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="profileImage" class="form-label">Pilih Gambar</label>
                                <input type="file" class="form-control" id="profileImage" name="profileImage">
                            </div>
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal untuk mengedit profil -->
        <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProfileModalLabel">Edit Profil</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                            <div class="mb-3">
                                <label for="editUsername" class="form-label">Username</label>
                                <input type="text" class="form-control" id="editUsername" name="editUsername" value="<?php echo $username; ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="nomortelepon" class="form-label">Nomor Telepon</label>
                                <input type="number" class="form-control" id="nomortelepon" name="nomortelepon" value="<?php echo $nomor_telepon; ?>">
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </form>
                    </div>
                </div>
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
        </script>
        <script src="bootstrap/dist/js/bootstrap.min.js"></script>

    </body>

</html>