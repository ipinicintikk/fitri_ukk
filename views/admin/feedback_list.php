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
                <a class="nav-link" href="index.php?page=admin_dashboard">Dashboard</a>
                <a class="nav-link" href="index.php?page=admin_buku">Data Buku</a>
                <a class="nav-link" href="index.php?page=admin_anggota">Data Anggota</a>
                <a class="nav-link" href="index.php?page=admin_transaksi">Transaksi</a>
                <a class="nav-link" href="index.php?page=admin_laporan">Laporan</a>
                <a class="nav-link active" href="index.php?page=admin_feedback">Feedback</a>
                <hr class="mx-3">
                <a class="nav-link text-warning" href="index.php?action=logout">Logout</a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="col-md-10 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold">Daftar Feedback</h3>
                <div>
                     <span class="text-muted">Selamat Datang, </span>
                     <span class="fw-bold text-maroon"><?php echo $_SESSION['nama']; ?></span>
                </div>
            </div>

            <div class="card p-4">
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo $_SESSION['success'];
    unset($_SESSION['success']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php
endif; ?>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th width="20%">Nama Siswa</th>
                                <th width="45%">Feedback</th>
                                <th width="15%">Tanggal</th>
                                <th width="15%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($feedbacks) > 0): ?>
                                <?php foreach ($feedbacks as $index => $f): ?>
                                    <tr>
                                        <td><?php echo $index + 1; ?></td>
                                        <td class="fw-bold text-maroon"><?php echo htmlspecialchars($f['nama']); ?></td>
                                        <td><?php echo nl2br(htmlspecialchars($f['isi_feedback'])); ?></td>
                                        <td><small class="text-muted"><?php echo date('d/m/Y H:i', strtotime($f['created_at'])); ?></small></td>
                                        <td class="text-center">
                                            <a href="index.php?action=delete_feedback&id=<?php echo $f['id_feedback']; ?>" 
                                               class="btn btn-sm btn-outline-danger" 
                                               onclick="return confirm('Apakah Anda yakin ingin menghapus feedback ini?')">
                                                <i class="bi bi-trash"></i> Hapus
                                            </a>
                                        </td>
                                    </tr>
                                <?php
    endforeach; ?>
                            <?php
else: ?>
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">Belum ada feedback yang masuk.</td>
                                </tr>
                            <?php
endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include BASE_PATH . '/views/layouts/footer.php'; ?>
