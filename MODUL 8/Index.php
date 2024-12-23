<?php
$file = 'data_alumni.txt';
$data = [];

// Memeriksa apakah file ada dan dapat dibaca
if (file_exists($file)) {
    // Membaca file dan mengabaikan baris kosong
    $data = file($file, FILE_IGNORE_NEW_LINES);
}

// Menangani pencarian
$searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';

// Memfilter data berdasarkan pencarian
if ($searchQuery) {
    $data = array_filter($data, function($row) use ($searchQuery) {
        // Memisahkan data alumni dengan separator '|'
        list($nama, $tahun_lulus, $pekerjaan) = explode('|', $row);
        
        // Menggunakan stripos untuk pencocokan case-insensitive
        return stripos($nama, $searchQuery) !== false || stripos($pekerjaan, $searchQuery) !== false;
    });
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracer Alumni</title>
    <style>
          /* Global Styles */
          body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f8ff;
            color: #333;
        }

        header {
            background-color: #007BFF;
            color: white;
            text-align: center;
            padding: 15px 0;
            font-size: 1.5rem;
            margin-bottom: 20px;
        }

        main {
            width: 90%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background: white;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        h2 {
            font-size: 1.5rem;
            color: #0056b3;
            margin-bottom: 10px;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-size: 0.9rem;
            color: #555;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input:focus {
            border-color: #007BFF;
            outline: none;
        }

        button {
            display: inline-block;
            padding: 10px 15px;
            border: none;
            background-color: #007BFF;
            color: white;
            font-size: 1rem;
            cursor: pointer;
            border-radius: 5px;
        }

        button:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #007BFF;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #e9f4ff;
        }

        tr:hover {
            background-color: #d6ebff;
        }

        .no-data {
            text-align: center;
            color: #555;
            font-size: 0.9rem;
            padding: 10px;
        }

        .btn-hapus {
            background-color: #DC3545;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-hapus:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <header>
        Tracer Alumni
    </header>

    <main>
        <h2>Input Data Alumni</h2>
        <form action="proses.php" method="POST">
            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="nama" required>

            <label for="tahun_lulus">Tahun Lulus:</label>
            <input type="number" id="tahun_lulus" name="tahun_lulus" required>

            <label for="pekerjaan">Pekerjaan:</label>
            <input type="text" id="pekerjaan" name="pekerjaan" required>

            <button type="submit">Simpan Data</button>
        </form>

        <!-- Form Pencarian -->
        <h2>Cari Alumni</h2>
        <form action="index.php" method="GET">
            <input type="text" name="search" placeholder="Cari nama atau pekerjaan" value="<?= htmlspecialchars($searchQuery) ?>">
            <button type="submit">Cari</button>
        </form>

        <h2>Data Alumni</h2>
        <table>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Tahun Lulus</th>
                <th>Pekerjaan</th>
                <th>Aksi</th>
            </tr>
            <?php
            // Memeriksa jika data ada dan tidak kosong
            if (!empty($data)) {
                $no = 1;
                foreach ($data as $index => $row) {
                    // Memeriksa apakah data pada baris dapat diproses dengan benar
                    if (!empty($row)) {
                        list($nama, $tahun_lulus, $pekerjaan) = explode('|', $row);
                        echo "<tr>
                                <td>{$no}</td>
                                <td>" . htmlspecialchars($nama) . "</td>
                                <td>" . htmlspecialchars($tahun_lulus) . "</td>
                                <td>" . htmlspecialchars($pekerjaan) . "</td>
                                <td>
                                    <form action='hapus.php' method='POST'>
                                        <input type='hidden' name='index' value='{$index}'>
                                        <button type='submit' class='btn-hapus'>Hapus</button>
                                    </form>
                                </td>
                              </tr>";
                        $no++;
                    }
                }
            } else {
                echo "<tr><td colspan='5' class='no-data'>Belum ada data yang sesuai.</td></tr>";
            }
            ?>
        </table>
    </main>
</body>
</html>
