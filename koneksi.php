<?php
// Koneksi ke database
$conn = new mysqli('localhost', 'id20902853_root', '@Mantapjiwa1213', 'id20902853_db_takaful');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
