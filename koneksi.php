<?php
// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'db_takaful');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
