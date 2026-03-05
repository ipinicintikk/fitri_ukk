<?php include BASE_PATH . '/views/layouts/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-2 sidebar p-0 d-none d-md-block">
            <div class="p-4 text-center">
                <h5 class="fw-bold">SISWA PANEL</h5>
                <hr>
            </div>
            <nav class="nav flex-column">
                <a class="nav-link active" href="index.php?page=user_dashboard">Dashboard</a>
                <a class="nav-link" href="index.php?page=user_buku">Daftar Buku</a>
                <a class="nav-link <?php echo $_GET['page'] === 'user_riwayat' ? 'active' : ''; ?>" href="index.php?page=user_riwayat">Riwayat Pinjam</a>
                <a class="nav-link <?php echo $_GET['page'] === 'user_feedback' ? 'active' : ''; ?>" href="index.php?page=user_feedback">Kirim Feedback</a>
                <hr class="mx-3">
                <a class="nav-link text-warning" href="index.php?action=logout">Logout</a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="col-md-10 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold">Dashboard Siswa</h3>
                <div>
                     <span class="text-muted">Halo, </span>
                     <span class="fw-bold text-maroon"><?php echo $_SESSION['nama']; ?></span>
                </div>
            </div>

            <!-- Intro -->
            <div class="card p-4 gradient-maroon mb-4 border-0">
                <h4 class="fw-bold">Selamat Datang di Perpustakaan Digital!</h4>
                <p class="mb-0">Temukan ribuan buku menarik dan kembangkan wawasanmu. Klik "Daftar Buku" untuk mulai mencari buku yang ingin kamu pinjam.</p>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card p-4 text-center">
                        <h1 class="fw-bold text-maroon"><?php echo (int)$buku_dipinjam; ?></h1>
                        <p class="text-muted mb-0">Buku Sedang Dipinjam</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-4 text-center">
                        <h1 class="fw-bold text-success"><?php echo (int)$buku_kembali; ?></h1>
                        <p class="text-muted mb-0">Buku Sudah Dikembalikan</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-4 text-center">
                        <h1 class="fw-bold text-info">+</h1>
                        <p class="text-muted mb-0"><a href="index.php?page=user_buku" style="text-decoration:none; color:inherit;">Cari Buku Baru</a></p>
                    </div>
                </div>
            </div>

            <!-- New Books Section -->
            <div class="card p-4 mt-4">
                <h5 class="fw-bold mb-3">Buku Terbaru</h5>
                <div class="row g-3">
                    <?php
$new_books = $pdo->query("SELECT * FROM buku ORDER BY created_at DESC LIMIT 6")->fetchAll();
if (count($new_books) > 0):
    foreach ($new_books as $book):
?>
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body">
                                    <h6 class="fw-bold text-maroon"><?php echo htmlspecialchars($book['judul']); ?></h6>
                                    <p class="text-muted small mb-1">Pengarang: <?php echo htmlspecialchars($book['pengarang']); ?></p>
                                    <p class="text-muted small mb-2">Stok: <?php echo (int)$book['stok']; ?></p>
                                    <a href="index.php?page=user_buku" class="btn btn-sm btn-maroon text-white">Lihat Detail</a>
                                </div>
                            </div>
                        </div>
                    <?php
    endforeach;
else: ?>
                        <div class="col-12 text-center text-muted">Belum ada buku.</div>
                    <?php
endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>
