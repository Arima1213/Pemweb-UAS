<?php
require_once "koneksi.php";

// Inisialisasi variabel error_message
$error_message = "";

// Cek apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Validasi input
  $username = mysqli_real_escape_string($conn, $_POST["username"]);
  $password = mysqli_real_escape_string($conn, $_POST["password"]);
  $nama = mysqli_real_escape_string($conn, $_POST["nama"]);
  $nomor_telepon = mysqli_real_escape_string($conn, $_POST["nomor_telepon"]);

  // Mendefinisikan folder untuk menyimpan foto
  $folder = './src/img_profil_user/';

  $nama_fotoprofil = $_FILES["fotoprofil"]["name"];
  $sumber_fotoprofil = $_FILES["fotoprofil"]["tmp_name"];

  move_uploaded_file($sumber_fotoprofil, $folder . $nama_fotoprofil);

  // Query untuk memeriksa apakah username sudah ada di database
  $check_username_stmt = mysqli_prepare($conn, "SELECT username FROM users WHERE username = ?");
  mysqli_stmt_bind_param($check_username_stmt, "s", $username);
  mysqli_stmt_execute($check_username_stmt);
  mysqli_stmt_store_result($check_username_stmt);

  if (mysqli_stmt_num_rows($check_username_stmt) > 0) {
    // Jika username sudah ada, tampilkan notifikasi
    $error_message = "Username already exists";
  } else {
    // Query INSERT ke dalam tabel "users"
    $insert_stmt = mysqli_prepare($conn, "INSERT INTO users (username, password, nama, nomor_telepon, foto_profil) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($insert_stmt, "sssss", $username, $password, $nama, $nomor_telepon, $nama_fotoprofil);

    if (mysqli_stmt_execute($insert_stmt)) {
      // Redirect ke halaman login.php
      header("Location: login.php");
      exit();
    } else {
      $error_message = "Failed to create account";
    }

    mysqli_stmt_close($insert_stmt);
  }

  mysqli_stmt_close($check_username_stmt);
}


mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="bootstrap/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="css/loginstyle.css" />
  <title>Document</title>
</head>
<style>
  .login-page {
    position: relative;
  }

  .login-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    /* From https://css.glass */
    border-radius: 16px;
    box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
    backdrop-filter: blur(4.9px);
    -webkit-backdrop-filter: blur(4.9px);
    /* Warna lapisan gelap */
  }

  .login-card,
  .form-control {
    background-color: rgba(255, 255, 255, 0.7);
    backdrop-filter: blur(4.9px);
    /* Transparansi pada card dan input text */
  }
</style>
</head>

<body>
  <div class="login-overlay"></div> <!-- Lapisan blur -->
  <div class="container-fluid login-page">
    <div class="row justify-content-center align-items-center h-100">
      <div class="col-md-6 col-sm-12">
        <div class="card login-card  my-5">
          <div class="card-body">
            <h1 class="text-center mb-5"><i class="fab fa-instagram"></i>Register</h1>
            <form method="POST" enctype="multipart/form-data">
              <?php if ($error_message) : ?>
                <div class="alert alert-danger" role="alert">
                  <?php echo $error_message; ?>
                </div>
              <?php endif; ?>
              <div class="mb-3">
                <label for="username" class="form-label">Username :</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Username" required />
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Password :</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required />
              </div>
              <div class="mb-3">
                <label for="nama" class="form-label">Nama Lengkap :</label>
                <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Lengkap" required />
              </div>
              <div class="mb-3">
                <label for="nomor_telepon" class="form-label">Nomor Telepon :</label>
                <input type="number" class="form-control" id="nomor_telepon" name="nomor_telepon" placeholder="Nomor Telepon" required />
              </div>
              <div class="mb-3">
                <label for="fotoprofil" class="form-label">Foto Profil :</label>
                <input class="form-control" type="file" name="fotoprofil" id="fotoprofil" required>
              </div>
              <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Register</button>
              </div>
            </form>
            <div class="mt-4 text-center">
              <p>Already have an account? <a href="login.php" class="link-primary">Login</a></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="bootstrap/dist/js/bootstrap.min.js"></script>
</body>

</html>