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
                <a class="nav-link" href="index.php?page=user_buku">Daftar Buku</a>
                <a class="nav-link <?php echo $_GET['page'] === 'user_riwayat' ? 'active' : ''; ?>" href="index.php?page=user_riwayat">Riwayat Pinjam</a>
                <a class="nav-link <?php echo $_GET['page'] === 'user_feedback' ? 'active' : ''; ?>" href="index.php?page=user_feedback">Kirim Feedback</a>
                <hr class="mx-3">
                <a class="nav-link text-warning" href="index.php?action=logout">Logout</a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="col-md-10 p-4">
            <h3 class="fw-bold mb-4">Riwayat Peminjaman Saya</h3>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success"><?php echo $_SESSION['success'];
    unset($_SESSION['success']); ?></div>
            <?php
endif; ?>

            <div class="card p-4">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Buku</th>
                                <th>Tgl Pinjam</th>
                                <th>Tgl Kembali</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($history) > 0): ?>
                                <?php foreach ($history as $h): ?>
                                    <tr>
                                        <td class="fw-semibold"><?php echo $h['judul']; ?></td>
                                        <td><?php echo $h['tanggal_pinjam']; ?></td>
                                        <td><?php echo $h['tanggal_kembali'] ? $h['tanggal_kembali'] : '-'; ?></td>
                                        <td>
                                            <span class="badge <?php echo $h['status'] === 'dipinjam' ? 'bg-warning' : 'bg-success'; ?>">
                                                <?php echo ucfirst($h['status']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if ($h['status'] === 'dipinjam'): ?>
                                                <button class="btn btn-sm btn-maroon" onclick="confirmKembali(<?php echo $h['id_transaksi']; ?>)">Kembalikan</button>
                                            <?php
        else: ?>
                                                <button class="btn btn-sm btn-secondary disabled">Selesai</button>
                                            <?php
        endif; ?>
                                        </td>
                                    </tr>
                                <?php
    endforeach; ?>
                            <?php
else: ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Belum ada riwayat peminjaman.</td>
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

<script>
function confirmKembali(id) {
    Swal.fire({
        title: 'Kembalikan Buku?',
        text: "Anda akan mengembalikan buku ini hari ini.",
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#800000',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Kembalikan',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "index.php?action=kembali_buku&id=" + id;
        }
    })
}
</script>

<?php include BASE_PATH . '/views/layouts/footer.php'; ?>
