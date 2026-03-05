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
                <a class="nav-link" href="index.php?page=user_dashboard">Dashboard</a>
                <a class="nav-link active" href="index.php?page=user_buku">Daftar Buku</a>
                <a class="nav-link <?php echo $_GET['page'] === 'user_riwayat' ? 'active' : ''; ?>" href="index.php?page=user_riwayat">Riwayat Pinjam</a>
                <a class="nav-link <?php echo $_GET['page'] === 'user_feedback' ? 'active' : ''; ?>" href="index.php?page=user_feedback">Kirim Feedback</a>
                <hr class="mx-3">
                <a class="nav-link text-warning" href="index.php?action=logout">Logout</a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="col-md-10 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold">Daftar Koleksi Buku</h3>
                <form action="index.php" method="GET" class="d-flex" style="width: 300px;">
                    <input type="hidden" name="page" value="user_buku">
                    <input type="text" name="search" class="form-control me-2" placeholder="Cari judul/pengarang..." value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                    <button type="submit" class="btn btn-maroon">Cari</button>
                </form>
            </div>

            <div class="row g-4">
                <?php if (count($books) > 0): ?>
                    <?php foreach ($books as $b): ?>
                        <div class="col-md-3">
                            <div class="card h-100 p-3">
                                <div class="badge bg-maroon mb-2" style="width: fit-content;"><?php echo $b['kategori']; ?></div>
                                <h5 class="fw-bold mb-1"><?php echo $b['judul']; ?></h5>
                                <p class="text-muted small mb-3">Oleh: <?php echo $b['pengarang']; ?></p>
                                <div class="mt-auto d-flex justify-content-between align-items-center">
                                    <span class="text-muted small">Stok: <strong><?php echo $b['stok']; ?></strong></span>
                                    <?php if ($b['stok'] > 0): ?>
                                        <button class="btn btn-sm btn-outline-maroon" 
                                                style="border-color: var(--maroon-dark); color: var(--maroon-dark);"
                                                onclick="confirmPinjam(<?php echo $b['id_buku']; ?>, '<?php echo addslashes($b['judul']); ?>')">
                                            Pinjam
                                        </button>
                                    <?php
        else: ?>
                                        <button class="btn btn-sm btn-secondary disabled">Habis</button>
                                    <?php
        endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php
    endforeach; ?>
                <?php
else: ?>
                    <div class="col-12 text-center py-5">
                        <p class="text-muted">Buku tidak ditemukan.</p>
                    </div>
                <?php
endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
function confirmPinjam(id, judul) {
    Swal.fire({
        title: 'Pinjam Buku?',
        text: "Apakah Anda ingin meminjam '" + judul + "'?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#800000',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Pinjam',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "index.php?action=pinjam_buku&id=" + id;
        }
    })
}
</script>

<?php include BASE_PATH . '/views/layouts/footer.php'; ?>
