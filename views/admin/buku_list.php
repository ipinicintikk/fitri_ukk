<?php include BASE_PATH . '/views/layouts/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-2 sidebar p-0 d-none d-md-block">
            <div class="p-4 text-center">
                <h5 class="fw-bold">PERPUS DIGITAL</h5>
                <hr>
            </div>
            <nav class="nav flex-column">
                <a class="nav-link <?php echo $_GET['page'] === 'admin_dashboard' ? 'active' : ''; ?>" href="index.php?page=admin_dashboard">Dashboard</a>
                <a class="nav-link <?php echo $_GET['page'] === 'admin_buku' ? 'active' : ''; ?>" href="index.php?page=admin_buku">Data Buku</a>
                <a class="nav-link <?php echo $_GET['page'] === 'admin_anggota' ? 'active' : ''; ?>" href="index.php?page=admin_anggota">Data Anggota</a>
                <a class="nav-link <?php echo $_GET['page'] === 'admin_transaksi' ? 'active' : ''; ?>" href="index.php?page=admin_transaksi">Transaksi</a>
                <a class="nav-link <?php echo $_GET['page'] === 'admin_laporan' ? 'active' : ''; ?>" href="index.php?page=admin_laporan">Laporan</a>
                <a class="nav-link <?php echo $_GET['page'] === 'admin_feedback' ? 'active' : ''; ?>" href="index.php?page=admin_feedback">Feedback</a>
                <hr class="mx-3">
                <a class="nav-link text-warning" href="index.php?action=logout">Logout</a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="col-md-10 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold">Manajemen Data Buku</h3>
                <button class="btn btn-maroon" data-bs-toggle="modal" data-bs-target="#addBukuModal">
                    + Tambah Buku
                </button>
            </div>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo $_SESSION['success'];
    unset($_SESSION['success']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php
endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo $_SESSION['error'];
    unset($_SESSION['error']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php
endif; ?>

            <div class="card p-4">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Judul</th>
                                <th>Pengarang</th>
                                <th>Kategori</th>
                                <th>Stok</th>
                                <th>Tahun</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($books) > 0): ?>
                                <?php $no = $offset + 1;
    foreach ($books as $b): ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td class="fw-semibold"><?php echo $b['judul']; ?></td>
                                        <td><?php echo $b['pengarang']; ?></td>
                                        <td><span class="badge bg-light text-dark"><?php echo $b['kategori']; ?></span></td>
                                        <td><?php echo $b['stok']; ?></td>
                                        <td><?php echo $b['tahun_terbit']; ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-info text-white" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editBukuModal<?php echo $b['id_buku']; ?>">
                                                Edit
                                            </button>
                                            <button class="btn btn-sm btn-danger" 
                                                    onclick="confirmDelete(<?php echo $b['id_buku']; ?>)">
                                                Hapus
                                            </button>
                                        </td>
                                    </tr>

                                <?php
    endforeach; ?>
                            <?php
else: ?>
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Data buku kosong.</td>
                                </tr>
                            <?php
endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <?php if (isset($total_pages) && $total_pages > 1): ?>
                <nav class="mt-4">
                    <ul class="pagination justify-content-center">
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                <a class="page-link <?php echo $i == $page ? 'bg-maroon border-maroon text-white' : 'text-maroon'; ?>" 
                                   href="index.php?page=admin_buku&p=<?php echo $i; ?>">
                                    <?php echo $i; ?>
                                </a>
                            </li>
                        <?php
    endfor; ?>
                    </ul>
                </nav>
                <?php
endif; ?>
            </div>

            <!-- Edit Modals (Moved outside table loop to fix flickering) -->
            <?php foreach ($books as $b): ?>
                <div class="modal fade" id="editBukuModal<?php echo $b['id_buku']; ?>" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Buku</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="index.php?action=update_buku" method="POST">
                                <div class="modal-body">
                                    <input type="hidden" name="id_buku" value="<?php echo $b['id_buku']; ?>">
                                    <div class="mb-3">
                                        <label class="form-label">Judul</label>
                                        <input type="text" name="judul" class="form-control" value="<?php echo htmlspecialchars($b['judul']); ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Pengarang</label>
                                        <input type="text" name="pengarang" class="form-control" value="<?php echo htmlspecialchars($b['pengarang']); ?>" required>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Penerbit</label>
                                            <input type="text" name="penerbit" class="form-control" value="<?php echo htmlspecialchars($b['penerbit']); ?>" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Tahun</label>
                                            <input type="number" name="tahun_terbit" class="form-control" value="<?php echo htmlspecialchars($b['tahun_terbit']); ?>" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Kategori</label>
                                            <input type="text" name="kategori" class="form-control" value="<?php echo htmlspecialchars($b['kategori']); ?>" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Stok</label>
                                            <input type="number" name="stok" class="form-control" value="<?php echo htmlspecialchars($b['stok']); ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-maroon">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php
endforeach; ?>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addBukuModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Buku Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="index.php?action=store_buku" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Judul</label>
                        <input type="text" name="judul" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pengarang</label>
                        <input type="text" name="pengarang" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Penerbit</label>
                            <input type="text" name="penerbit" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tahun</label>
                            <input type="number" name="tahun_terbit" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kategori</label>
                            <input type="text" name="kategori" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Stok</label>
                            <input type="number" name="stok" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-maroon">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data buku akan dihapus secara permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#800000',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "index.php?action=delete_buku&id=" + id;
        }
    })
}
</script>

<?php include BASE_PATH . '/views/layouts/footer.php'; ?>
