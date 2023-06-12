<?php
session_start();
require_once('vendor/autoload.php');

use Dompdf\Dompdf;

$dompdf = new Dompdf();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];

// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'db_takaful');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$font = "adelia.ttf";
$image = imagecreatefrompng("./src/sertif/Certificate.png");
$textColour = imagecolorallocate($image, 0, 0, 0);
$name = $username = $_SESSION['username'];
$coords = imagettfbbox(100, 0, $font, $name); // Mengubah ukuran teks menjadi 100

$width = imagesx($image); // Lebar gambar
$textWidth = $coords[2] - $coords[0]; // Lebar teks

// Menghitung koordinat X agar teks berada di tengah gambar
$x = ($width - $textWidth) / 2;

imagettftext($image, 100, 0, $x, 600, $textColour, $font, $name); // Mengubah ukuran teks menjadi 100

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
