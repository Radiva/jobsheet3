<?php
include 'koneksi.php';

// Pagination
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Pencarian
$search = isset($_GET['search']) ? $_GET['search'] : '';
$search_query = $search ? "WHERE nama_siswa LIKE '%$search%'" : '';

// Ambil data siswa
$query = "SELECT siswa.*, kelas.nama_kelas, wali_murid.nama_wali FROM siswa
          LEFT JOIN kelas ON siswa.id_kelas = kelas.id_kelas
          LEFT JOIN wali_murid ON siswa.id_wali = wali_murid.id_wali
          $search_query LIMIT $start, $limit";
$result = mysqli_query($koneksi, $query);

// Hitung total data untuk pagination
$total_query = "SELECT COUNT(*) AS total FROM siswa $search_query";
$total_result = mysqli_query($koneksi, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total = $total_row['total'];
$total_pages = ceil($total / $limit);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <h2 class="mb-3">Data Siswa</h2>
        <div class="d-flex justify-content-between mb-3">
            <div>
                <a href="kelas.php" class="btn btn-primary">Kelola Kelas</a>
                <a href="wali_murid.php" class="btn btn-primary">Kelola Wali Murid</a>
            </div>
            <form method="GET" class="d-flex">
                <input type="text" name="search" class="form-control me-2" placeholder="Cari siswa..." value="<?php echo $search; ?>">
                <button type="submit" class="btn btn-success">Cari</button>
            </form>
            <a href="tambah_siswa.php" class="btn btn-success">Tambah Siswa</a>
        </div>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>NIS</th>
                    <th>Nama</th>
                    <th>Jenis Kelamin</th>
                    <th>Tempat Lahir</th>
                    <th>Tanggal Lahir</th>
                    <th>Kelas</th>
                    <th>Wali Murid</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <tr>
                        <td><?php echo $row['nis']; ?></td>
                        <td><?php echo $row['nama_siswa']; ?></td>
                        <td><?php echo $row['jenis_kelamin']; ?></td>
                        <td><?php echo $row['tempat_lahir']; ?></td>
                        <td><?php echo $row['tanggal_lahir']; ?></td>
                        <td><?php echo $row['nama_kelas']; ?></td>
                        <td><?php echo $row['nama_wali']; ?></td>
                        <td>
                            <a href="edit_siswa.php?id=<?php echo $row['id_siswa']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <!-- <a href="hapus_siswa.php?id=<?php echo $row['id_siswa']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?');">Hapus</a> -->
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmDelete<?php echo $row['id_siswa']; ?>">Hapus</button>

                            <!-- Modal Konfirmasi Hapus -->
                            <div class="modal fade" id="confirmDelete<?php echo $row['id_siswa']; ?>" tabindex="-1" aria-labelledby="modalLabel<?php echo $row['id_siswa']; ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalLabel<?php echo $row['id_siswa']; ?>">Konfirmasi Hapus</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah Anda yakin ingin menghapus data siswa <?php echo $row['nama_siswa']; ?>?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <a href="hapus_siswa.php?id=<?php echo $row['id_siswa']; ?>" class="btn btn-danger">Hapus</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <nav>
            <ul class="pagination">
                <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                    <li class="page-item <?php if ($page == $i) echo 'active'; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo $search; ?>"> <?php echo $i; ?> </a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>