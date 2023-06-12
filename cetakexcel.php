<?php

require_once "koneksi.php";

require 'vendorExcel/autoload.php'; // Memasukkan library PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["donasi_id"])) {
        $donasi_id = $_POST["donasi_id"];



        // Query untuk mengambil data riwayat donasi berdasarkan donasi_id
        $stmt = $conn->prepare("SELECT riwayat_id, user_id, nama, nominal, tgl_lengkap, donasi_id, metode_pembayaran FROM db_takaful.riwayat_donasi WHERE donasi_id = ?");
        $stmt->bind_param("i", $donasi_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Membuat objek Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Menambahkan header kolom
        $sheet->setCellValue('A1', 'Riwayat ID');
        $sheet->setCellValue('B1', 'User ID');
        $sheet->setCellValue('C1', 'Nama');
        $sheet->setCellValue('D1', 'Nominal');
        $sheet->setCellValue('E1', 'Tanggal Lengkap');
        $sheet->setCellValue('F1', 'Donasi ID');
        $sheet->setCellValue('G1', 'Metode Pembayaran');

        // Mengisi data pada baris-baris selanjutnya
        $row = 2;
        while ($row_data = $result->fetch_assoc()) {
            $sheet->setCellValue('A' . $row, $row_data['riwayat_id']);
            $sheet->setCellValue('B' . $row, $row_data['user_id']);
            $sheet->setCellValue('C' . $row, $row_data['nama']);
            $sheet->setCellValue('D' . $row, $row_data['nominal']);
            $sheet->setCellValue('E' . $row, $row_data['tgl_lengkap']);
            $sheet->setCellValue('F' . $row, $row_data['donasi_id']);
            $sheet->setCellValue('G' . $row, $row_data['metode_pembayaran']);
            $row++;
        }

        // Mengatur lebar kolom
        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(10);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(10);
        $sheet->getColumnDimension('G')->setWidth(20);

        // Membuat objek Writer dan menyimpan Spreadsheet ke dalam file Excel
        $tgl_sekarang = date("Y-m-d");
        $writer = new Xlsx($spreadsheet);
        $filename = 'riwayat_donasi_' . $donasi_id . '_' . $tgl_sekarang . '.xlsx'; // Nama file Excel yang akan disimpan
        $filepath = 'excel/' . $filename; // Path lengkap ke folder excel

        $writer->save($filepath);

        // Mengirim file Excel sebagai respons ke browser
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');

        // Menambahkan script JavaScript untuk kembali ke halaman donationspage.php setelah file Excel diunduh
        echo '<script>window.location.href = "donationspage.php";</script>';

        header("Location: cetakexcel.php?donasi_id=" . $donasi_id);
        exit;
    } else {
        echo 'Data kosong';
    }
}
