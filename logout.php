<?php
// Mulai session
session_start();

// Hapus semua data session
$_SESSION = array();

// Hancurkan session
session_destroy();

// Alihkan pengguna ke halaman login.php
header("Location: login.php");
exit;
