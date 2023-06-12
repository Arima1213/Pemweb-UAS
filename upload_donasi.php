<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_takaful";

require_once "koneksi.php";
// Memproses data yang dikirim melalui form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Validasi jika data telah terisi
  if (!empty($_POST["title"]) && !empty($_POST["target_donasi"]) && 0 >= ($_POST["uang_donasi"]) && !empty($_POST["target_hari"]) && !empty($_POST["deskripsi1"])) {

    $title = $_POST["title"];
    $target_donasi = $_POST["target_donasi"];
    $uang_donasi = $_POST["uang_donasi"];
    $target_hari = $_POST["target_hari"];
    $deskripsi1 = $_POST["deskripsi1"];
    $tgl_dibuat = date("Y-m-d");

    // Mendefinisikan folder untuk menyimpan gambar
    $folder_thumnail = './src/img_upload/thumbnail/';
    $folder_images = './src/img_upload/images/';

    $nama_thumbnail = $_FILES['thumbnail']['name'];
    $nama_gambar1 = $_FILES["gambar1"]["name"];
    $nama_gambar2 = $_FILES["gambar2"]["name"];
    $nama_gambar3 = $_FILES["gambar3"]["name"];
    $nama_gambar4 = $_FILES["gambar4"]["name"];

    // Mengambil data gambar yang diunggah
    $sumber_thumbnail = $_FILES['thumbnail']['tmp_name'];
    $sumber_gambar1 = $_FILES["gambar1"]["tmp_name"];
    $sumber_gambar2 = $_FILES["gambar2"]["tmp_name"];
    $sumber_gambar3 = $_FILES["gambar3"]["tmp_name"];
    $sumber_gambar4 = $_FILES["gambar4"]["tmp_name"];

    move_uploaded_file($sumber_thumbnail, $folder_thumnail . $nama_thumbnail);
    move_uploaded_file($sumber_gambar1, $folder_images . $nama_gambar1);
    move_uploaded_file($sumber_gambar2, $folder_images . $nama_gambar2);
    move_uploaded_file($sumber_gambar3, $folder_images . $nama_gambar3);
    move_uploaded_file($sumber_gambar4, $folder_images . $nama_gambar4);

    // Memeriksa apakah data sudah ada sebelumnya
    $stmt_check = $conn->prepare("SELECT * FROM open_donasi WHERE title = ?");
    $stmt_check->bind_param("s", $title);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
      $notification = "Data sudah ada.";
    } else {
      // Memasukkan data ke dalam tabel open_donasi
      $stmt = $conn->prepare("INSERT INTO open_donasi (thumbnail, title, target_donasi, uang_donasi, target_hari, deskripsi1, gambar1, gambar2, gambar3, gambar4, tgl_dibuat) 
          VALUES ('$nama_thumbnail', '$title', $target_donasi, $uang_donasi, $target_hari, '$deskripsi1', '$nama_gambar1', '$nama_gambar2', '$nama_gambar3', '$nama_gambar4','$tgl_dibuat')");

      if ($stmt->execute()) {
        $notification = "Data berhasil disimpan.";
      } else {
        $notification = "Terjadi kesalahan: " . $stmt->error;
      }

      $stmt->close();
    }

    $stmt_check->close();
  } else {
    $notification = "Semua field harus diisi.";
  }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="bootstrap/dist/css/bootstrap.min.css" />
  <title>Input Data</title>
</head>

<body>
  <div class="container my-5">
    <div class="row">
      <div class="col-md-6 offset-md-3">
        <?php if (isset($notification)) : ?>
          <div class="alert alert-info mt-3">
            <?php echo $notification; ?>
          </div>
        <?php endif; ?>
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="thumbnail" class="form-label">Thumbnail</label>
            <input class="form-control" type="file" name="thumbnail" required>
          </div>
          <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" name="title" required>
          </div>
          <div class="mb-3">
            <label for="target_donasi" class="form-label">Target Donasi</label>
            <input type="number" class="form-control" name="target_donasi" required>
          </div>
          <div class="mb-3">
            <label for="uang_donasi" class="form-label">Uang Donasi</label>
            <input type="number" class="form-control" name="uang_donasi" required>
          </div>
          <div class="mb-3">
            <label for="target_hari" class="form-label">Target Hari</label>
            <input type="date" class="form-control" name="target_hari" required>
          </div>
          <div class="mb-3">
            <label for="deskripsi1" class="form-label">Deskripsi 1</label>
            <textarea class="form-control" name="deskripsi1" rows="3" required></textarea>
          </div>
          <div class="mb-3">
            <label for="gambar1" class="form-label">Gambar 1</label>
            <input class="form-control" type="file" name="gambar1" required>
          </div>
          <div class="mb-3">
            <label for="gambar2" class="form-label">Gambar 2</label>
            <input class="form-control" type="file" name="gambar2" required>
          </div>
          <div class="mb-3">
            <label for="gambar3" class="form-label">Gambar 3</label>
            <input class="form-control" type="file" name="gambar3" required>
          </div>
          <div class="mb-3">
            <label for="gambar4" class="form-label">Gambar 4</label>
            <input class="form-control" type="file" name="gambar4" required>
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </div>
  <script src="bootstrap/dist/js/bootstrap.min.js"></script>
</body>

</html>