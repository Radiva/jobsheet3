<?php
include 'koneksi.php';

// Pagination
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Pencarian
$search = isset($_GET['search']) ? $_GET['search'] : '';
$search_query = $search ? "WHERE nama_kelas LIKE '%$search%'" : '';

// Ambil data kelas
$query = "SELECT * FROM kelas $search_query LIMIT $start, $limit";
$result = mysqli_query($koneksi, $query);

// Hitung total data untuk pagination
$total_query = "SELECT COUNT(*) AS total FROM kelas $search_query";
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
    <title>Data Kelas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <h2 class="mb-3">Data Kelas</h2>
        <div class="d-flex justify-content-between mb-3">
            <a href="index.php" class="btn btn-primary">Kembali ke Data Siswa</a>
            <form method="GET" class="d-flex">
                <input type="text" name="search" class="form-control me-2" placeholder="Cari kelas..." value="<?php echo $search; ?>">
                <button type="submit" class="btn btn-success">Cari</button>
            </form>
            <a href="tambah_kelas.php" class="btn btn-success">Tambah Kelas</a>
        </div>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID Kelas</th>
                    <th>Nama Kelas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <tr>
                        <td><?php echo $row['id_kelas']; ?></td>
                        <td><?php echo $row['nama_kelas']; ?></td>
                        <td>
                            <a href="edit_kelas.php?id=<?php echo $row['id_kelas']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmDelete<?php echo $row['id_kelas']; ?>">Hapus</button>

                            <!-- Modal Konfirmasi Hapus -->
                            <div class="modal fade" id="confirmDelete<?php echo $row['id_kelas']; ?>" tabindex="-1" aria-labelledby="modalLabel<?php echo $row['id_kelas']; ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalLabel<?php echo $row['id_kelas']; ?>">Konfirmasi Hapus</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah Anda yakin ingin menghapus kelas <?php echo $row['nama_kelas']; ?>?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <a href="hapus_kelas.php?id=<?php echo $row['id_kelas']; ?>" class="btn btn-danger">Hapus</a>
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