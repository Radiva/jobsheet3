<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id_kelas = $_GET['id'];

    // Cek apakah ada siswa yang terdaftar dalam kelas ini
    $cek_query = "SELECT COUNT(*) AS total FROM siswa WHERE id_kelas = $id_kelas";
    $cek_result = mysqli_query($koneksi, $cek_query);
    $cek_row = mysqli_fetch_assoc($cek_result);

    if ($cek_row['total'] > 0) {
        echo "<script>
                alert('Tidak dapat menghapus kelas karena masih ada siswa yang terdaftar.');
                window.location.href='kelas.php';
              </script>";
        exit();
    }

    // Jika tidak ada siswa, hapus kelas
    $query = "DELETE FROM kelas WHERE id_kelas = $id_kelas";
    if (mysqli_query($koneksi, $query)) {
        header("Location: kelas.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
} else {
    header("Location: kelas.php");
    exit();
}
?>
