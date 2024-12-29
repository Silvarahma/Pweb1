<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Alumni - Form Data Alumni</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Global styles */
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to bottom, #e0f7fa, #b3e5fc, #82b1ff);
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            padding: 2rem 1rem;
        }

        /* Header */
        header {
            background: linear-gradient(to right, #42a5f5, #1e88e5, #1565c0);
            color: #fff;
            text-align: center;
            padding: 4rem 1rem;
            border-bottom-left-radius: 50% 10%;
            border-bottom-right-radius: 50% 10%;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .header-title {
            font-size: 3.5rem;
            font-weight: 700;
            text-shadow: 3px 3px 8px rgba(0, 0, 0, 0.3);
            margin: 0;
        }

        header p {
            font-size: 1.5rem;
            margin-top: 1rem;
            text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.3);
        }

        /* Form Styles */
        form {
            background: linear-gradient(145deg, #ffffff, #f0f9ff);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        form h3 {
            font-size: 2rem;
            font-weight: bold;
            color: #1565c0;
            margin-bottom: 1rem;
        }

        form .form-control {
            border-radius: 15px;
            border: 1px solid #b3e5fc;
            padding: 10px;
            transition: all 0.3s ease;
        }

        form .form-control:focus {
            border-color: #42a5f5;
            box-shadow: 0 0 10px rgba(66, 165, 245, 0.6);
        }

        form button[type="submit"] {
            background: linear-gradient(to right, #1e88e5, #1565c0);
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 30px;
            font-weight: bold;
            transition: transform 0.3s, background-color 0.3s;
        }

        form button[type="submit"]:hover {
            background: #42a5f5;
            transform: scale(1.1);
        }

        /* Table Styles */
        table {
            background: linear-gradient(145deg, #ffffff, #e3f2fd);
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 100%;
        }

        table th, table td {
            padding: 10px;
            text-align: left;
        }

        table th {
            background: #1565c0;
            color: #fff;
        }

        table tr:nth-child(even) {
            background: #f4f9fd;
        }

        table tr:hover {
            background: #e3f2fd;
            transition: background-color 0.3s;
        }

        img {
            border-radius: 10px;
        }

        /* Footer */
        footer {
            background: linear-gradient(to left, #1565c0, #1e88e5, #42a5f5);
            color: #fff;
            padding: 2rem 1rem;
            text-align: center;
            margin-top: 2rem;
            border-top-left-radius: 50% 10%;
            border-top-right-radius: 50% 10%;
        }

        .footer-text {
            font-size: 1rem;
            margin: 0;
        }
    </style>
</head>
<body>
    <header>
        <h1 class="header-title">Form Data Alumni</h1>
        <p>Cari dan kelola informasi alumni dengan mudah</p>
    </header>

    <?php
    include 'Latihan_09_config.php'; // Memasukkan file konfigurasi database

    // Handle Pencarian Alumni
    $searchQuery = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
        $searchQuery = $_POST['search'];
    }

    // Menampilkan daftar alumni berdasarkan pencarian atau semua alumni
    $sql = "SELECT * FROM alumni";
    if ($searchQuery != "") {
        $sql .= " WHERE nama LIKE '%$searchQuery%'";
    }
    $result = $conn->query($sql);
    ?>

    <div class="container mt-3">
        <h2>Cari Alumni</h2>
        <form method="POST" action="">
            <div class="mb-3">
                <input type="text" class="form-control" name="search" placeholder="Cari nama alumni..." value="<?php echo htmlspecialchars($searchQuery); ?>">
            </div>
            <button type="submit" class="btn btn-primary">Cari</button>
        </form>
    </div>

    <div class="container mt-5">
        <h2>Daftar Alumni</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Tahun Lulus</th>
                    <th>Jurusan</th>
                    <th>Foto</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['tahun_lulus']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['jurusan']) . "</td>";
                        echo "<td><img src='" . htmlspecialchars($row['foto']) . "' width='50' height='50'></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>Tidak ada alumni ditemukan.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <?php
    $conn->close();
    ?>
    <footer>
        <p class="footer-text">&copy; 2024 Portal Alumni</p>
    </footer>
</body>
</html>
