<?php

require_once "koneksi.php";

// Memproses data yang dikirim melalui form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Validasi jika data telah terisi
  if (!empty($_POST["title"]) && !empty($_POST["target_donasi"]) && $_POST["uang_donasi"] >= 0  && !empty($_POST["deskripsi1"])) {
    $title = $_POST["title"];
    $target_donasi = $_POST["target_donasi"];
    $uang_donasi = $_POST["uang_donasi"];

    $target_hari = $_POST["target_hari"];
    $target_hari_sql = date("Y-m-d", strtotime($target_hari));

    $deskripsi1 = $_POST["deskripsi1"];
    $tgl_dibuat = date("Y-m-d");

    // Mendefinisikan folder untuk menyimpan gambar
    $folder_thumbnail = './src/img_upload/thumbnail/';
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

    move_uploaded_file($sumber_thumbnail, $folder_thumbnail . $nama_thumbnail);
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
      echo "Data sudah ada.";
    } else {
      // Memasukkan data ke dalam tabel open_donasi
      $query = "INSERT INTO db_takaful.open_donasi (thumbnail, title, target_donasi, uang_donasi, target_hari, deskripsi1, gambar1, gambar2, gambar3, gambar4, tgl_dibuat)
                VALUES('$nama_thumbnail', '$title', $target_donasi, $uang_donasi, '$target_hari_sql', '$deskripsi1', '$nama_gambar1', '$nama_gambar2', '$nama_gambar3', '$nama_gambar4', '$tgl_dibuat')";
      $query_run = mysqli_query($conn, $query);

      if ($query_run) {
        echo "Data berhasil disimpan.";
        header('Location: admin.php');
        exit();
      } else {
        echo "Terjadi kesalahan: " . $stmt->error;
      }

      $stmt->close();
    }

    $stmt_check->close();
  } else {
    echo "Semua field harus diisi.";
  }
}
