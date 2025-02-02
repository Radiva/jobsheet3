<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id_wali = $_GET['id'];

    // Hapus data wali murid dari database
    $query = "DELETE FROM wali_murid WHERE id_wali = $id_wali";
    if (mysqli_query($koneksi, $query)) {
        header("Location: wali_murid.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
} else {
    header("Location: wali_murid.php");
    exit();
}
?>
