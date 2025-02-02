<?php
include 'koneksi.php';

// Ambil data kelas berdasarkan ID
if (isset($_GET['id'])) {
    $id_kelas = $_GET['id'];
    $query = "SELECT * FROM kelas WHERE id_kelas = $id_kelas";
    $result = mysqli_query($koneksi, $query);
    $kelas = mysqli_fetch_assoc($result);
}

// Proses update data kelas
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_kelas = $_POST['nama_kelas'];

    $query_update = "UPDATE kelas SET nama_kelas='$nama_kelas' WHERE id_kelas=$id_kelas";

    if (mysqli_query($koneksi, $query_update)) {
        header("Location: kelas.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kelas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Edit Data Kelas</h2>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Nama Kelas</label>
                <input type="text" name="nama_kelas" class="form-control" value="<?php echo $kelas['nama_kelas']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="index.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
