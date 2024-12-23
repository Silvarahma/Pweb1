<?php
// File data untuk menyimpan input
$file = 'data_alumni.txt';

// Mendapatkan index data yang akan dihapus dari form
$index = $_POST['index'];

// Membaca data dari file
$data = file($file, FILE_IGNORE_NEW_LINES);

// Menghapus data berdasarkan index
unset($data[$index]);

// Menyimpan kembali data yang sudah diubah ke file
file_put_contents($file, implode("\n", $data) . "\n");

// Redirect kembali ke halaman utama
header('Location: index.php');
exit();
?>