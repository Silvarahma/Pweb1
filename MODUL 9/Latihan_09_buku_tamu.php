<?php
// File data buku tamu
$data_file = 'data.txt';

// Fungsi untuk menyimpan data ke file
function simpanData($nama, $email, $pesan) {
    global $data_file;
    $entry = "$nama|$email|$pesan\n";
    file_put_contents($data_file, $entry, FILE_APPEND);
}

// Fungsi untuk membaca data dari file
function bacaData() {
    global $data_file;
    if (!file_exists($data_file)) {
        return [];
    }
    $lines = file($data_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $entries = [];
    foreach ($lines as $line) {
        list($nama, $email, $pesan) = explode('|', $line);
        $entries[] = ['nama' => $nama, 'email' => $email, 'pesan' => $pesan];
    }
    return $entries;
}

// Proses data dari form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = htmlspecialchars($_POST['nama']);
    $email = htmlspecialchars($_POST['email']);
    $pesan = htmlspecialchars($_POST['pesan']);
    simpanData($nama, $email, $pesan);
    header('Location: ' . $_SERVER['PHP_SELF']); // Refresh halaman
    exit;
}

// Ambil data buku tamu
$entries = bacaData();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buku Tamu</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; margin: 20px; }
        form { margin-bottom: 20px; }
        input, textarea { display: block; margin-bottom: 10px; width: 100%; padding: 8px; }
        textarea { height: 100px; }
        .entry { margin-bottom: 20px; padding: 10px; border: 1px solid #ddd; background-color: #f9f9f9; }
    </style>
</head>
<body>
    <h1>Buku Tamu</h1>
    <form method="post">
        <label for="nama">Nama:</label>
        <input type="text" name="nama" id="nama" required>
        
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        
        <label for="pesan">Pesan:</label>
        <textarea name="pesan" id="pesan" required></textarea>
        
        <button type="submit">Kirim</button>
    </form>

    <h2>Daftar Buku Tamu</h2>
    <?php if (empty($entries)): ?>
        <p>Belum ada pesan.</p>
    <?php else: ?>
        <?php foreach ($entries as $entry): ?>
            <div class="entry">
                <strong>Nama:</strong> <?= htmlspecialchars($entry['nama']) ?><br>
                <strong>Email:</strong> <?= htmlspecialchars($entry['email']) ?><br>
                <strong>Pesan:</strong> <?= nl2br(htmlspecialchars($entry['pesan'])) ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>
