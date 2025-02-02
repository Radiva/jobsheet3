<?php
include 'koneksi.php';

// Ambil data wali murid berdasarkan ID
if (isset($_GET['id'])) {
    $id_wali = $_GET['id'];
    $query = "SELECT * FROM wali_murid WHERE id_wali = $id_wali";
    $result = mysqli_query($koneksi, $query);
    $wali = mysqli_fetch_assoc($result);
}

// Proses update data wali murid
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_wali = $_POST['nama_wali'];
    $kontak = $_POST['kontak'];
    
    $query_update = "UPDATE wali_murid SET nama_wali='$nama_wali', kontak='$kontak' WHERE id_wali=$id_wali";

    if (mysqli_query($koneksi, $query_update)) {
        header("Location: wali_murid.php");
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
    <title>Edit Wali Murid</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Edit Data Wali Murid</h2>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Nama Wali</label>
                <input type="text" name="nama_wali" class="form-control" value="<?php echo $wali['nama_wali']; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Nomor HP</label>
                <input type="text" name="kontak" class="form-control" value="<?php echo $wali['no_hp']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="wali_murid.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
