<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

require_once "koneksi.php";

$username = $_SESSION['username'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Mendefinisikan folder untuk menyimpan foto
    $folder = './src/img_profil_user/';

    $nama_fotoprofil = $_FILES["profileImage"]["name"];
    $sumber_fotoprofil = $_FILES["profileImage"]["tmp_name"];

    move_uploaded_file($sumber_fotoprofil, $folder . $nama_fotoprofil);

    $update_stmt = $conn->prepare("UPDATE users SET foto_profil = ? WHERE username = ?");
    $update_stmt->bind_param("ss", $nama_fotoprofil, $username);

    if ($update_stmt->execute()) {
        $update_stmt->close();
        $conn->close();
        header("Location: profilepage.php");
        exit();
    } else {
        $update_stmt->close();
        $conn->close();
        $error_message = "Failed to change profile";
    }
}
