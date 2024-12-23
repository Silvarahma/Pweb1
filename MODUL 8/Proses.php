<?php
// File data untuk menyimpan input
$file = 'data_alumni.txt';

// Mendapatkan data dari form
$nama = $_POST['nama'];
$tahun_lulus = $_POST['tahun_lulus'];
$pekerjaan = $_POST['pekerjaan'];

// Format data untuk disimpan
$data_baru = "{$nama}|{$tahun_lulus}|{$pekerjaan}\n";

// Menambahkan data ke file teks
file_put_contents($file, $data_baru, FILE_APPEND);

// Redirect kembali ke halaman utama
header('Location: index.php');
exit();
?>