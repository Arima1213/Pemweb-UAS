<?php
session_start();
require_once('vendor/autoload.php');
require_once "koneksi.php";

use Dompdf\Dompdf;

$dompdf = new Dompdf();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];

$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nama = $row['nama'];
}

$font = "adelia.ttf";
$image = imagecreatefrompng("./src/sertif/Certificate.png");
$textColour = imagecolorallocate($image, 0, 0, 0);
$name = $nama;
$coords = imagettfbbox(100, 0, $font, $name); // Mengubah ukuran teks menjadi 100

$width = imagesx($image); // Lebar gambar
$textWidth = $coords[2] - $coords[0]; // Lebar teks

// Menghitung koordinat X agar teks berada di tengah gambar
$x = ($width - $textWidth) / 2;

imagettftext($image, 100, 0, $x, 620, $textColour, $font, $name); // Mengubah ukuran teks menjadi 100

// Menyimpan gambar sertifikat dalam format PNG
$imagePath = "./src/sertif/" . $name . ".png";
imagepng($image, $imagePath);
imagedestroy($image);

$html = '<html>
<head>
<style>
    @page {
        margin: 0;
    }
    body {
        margin: 0;
    }
    img {
        width: 100%;
        height: auto;
    }
</style>
</head>
<body>
    <img  <img src="data:image/png;base64,' . base64_encode(file_get_contents($imagePath)) . '" alt="">
</body>
</html>';

$dompdf->load_html($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render(); // Memanggil fungsi render untuk memproses pembuatan PDF
$dompdf->stream("sertifikat_" . $name . ".pdf");

header('Location: index.php');
exit();
