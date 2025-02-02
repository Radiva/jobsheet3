<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id_siswa = $_GET['id'];

    // Hapus data siswa dari database
    $query = "DELETE FROM siswa WHERE id_siswa = $id_siswa";
    if (mysqli_query($koneksi, $query)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
} else {
    header("Location: index.php");
    exit();
}
?>
