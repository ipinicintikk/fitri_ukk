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
                <h3 class="fw-bold">Dashboard Admin</h3>
                <div>
                     <span class="text-muted">Selamat Datang, </span>
                     <span class="fw-bold text-maroon"><?php echo $_SESSION['nama']; ?></span>
                </div>
            </div>

            <!-- Stats -->
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="card p-3 border-start border-4 border-maroon">
                        <small class="text-muted text-uppercase fw-semibold">Total Buku</small>
                        <h2 class="fw-bold mt-2"><?php echo (int)$total_buku; ?></h2>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card p-3 border-start border-4 border-info">
                        <small class="text-muted text-uppercase fw-semibold">Total Anggota</small>
                        <h2 class="fw-bold mt-2"><?php echo (int)$total_anggota; ?></h2>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card p-3 border-start border-4 border-success">
                        <small class="text-muted text-uppercase fw-semibold">Buku Dipinjam</small>
                        <h2 class="fw-bold mt-2"><?php echo (int)$total_pinjam; ?></h2>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card p-3 border-start border-4 border-warning">
                        <small class="text-muted text-uppercase fw-semibold">Total Transaksi</small>
                        <h2 class="fw-bold mt-2"><?php echo (int)$total_transaksi; ?></h2>
                    </div>
                </div>
            </div>

            <!-- Welcome Card -->
            <div class="card gradient-maroon p-4 border-0 mb-4">
                <h4 class="fw-bold">Halo, <?php echo $_SESSION['nama']; ?>!</h4>
                <p class="mb-0">Akses cepat ke manajemen data dan laporan perpustakaan Anda ada di sini. Pilih menu di sidebar untuk mulai bekerja.</p>
            </div>

            <!-- Recent Transactions -->
            <div class="card p-4">
                <h5 class="fw-bold mb-3">Aktivitas Terbaru</h5>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Siswa</th>
                                <th>Buku</th>
                                <th>Tanggal Pinjam</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
$recent = $pdo->query("SELECT t.*, u.nama, b.judul FROM transaksi t 
                                JOIN users u ON t.id_user = u.id_user 
                                JOIN buku b ON t.id_buku = b.id_buku 
                                ORDER BY t.tanggal_pinjam DESC LIMIT 5")->fetchAll();
if (count($recent) > 0):
    foreach ($recent as $r):
?>
                                <tr>
                                    <td><?php echo htmlspecialchars($r['nama']); ?></td>
                                    <td><?php echo htmlspecialchars($r['judul']); ?></td>
                                    <td><?php echo htmlspecialchars($r['tanggal_pinjam']); ?></td>
                                    <td>
                                        <span class="badge <?php echo $r['status'] === 'dipinjam' ? 'bg-warning' : 'bg-success'; ?>">
                                            <?php echo ucfirst($r['status']); ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php
    endforeach;
else: ?>
                                <tr><td colspan="4" class="text-center text-muted">Belum ada transaksi.</td></tr>
                            <?php
endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>
