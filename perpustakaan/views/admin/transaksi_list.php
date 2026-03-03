<?php include 'views/layouts/header.php'; ?>

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
                <h3 class="fw-bold"><?php echo $_GET['page'] === 'admin_laporan' ? 'Laporan Transaksi' : 'Daftar Semua Transaksi'; ?></h3>
                <a href="index.php?page=admin_laporan_print" target="_blank" class="btn btn-maroon shadow-sm">
                    <i class="bi bi-printer me-2"></i> Cetak Laporan
                </a>
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

            <div class="card p-0 overflow-hidden shadow-sm">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">#</th>
                                <th>Nama Anggota</th>
                                <th>Judul Buku</th>
                                <th>Tgl Pinjam</th>
                                <th>Tgl Kembali</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
$offset = isset($offset) ? $offset : 0;
if (isset($transactions) && count($transactions) > 0): ?>
                                <?php $no = $offset + 1;
    foreach ($transactions as $t): ?>
                                    <tr>
                                        <td class="ps-4 text-muted"><?php echo $no++; ?></td>
                                        <td class="fw-semibold text-maroon"><?php echo htmlspecialchars($t['nama']); ?></td>
                                        <td><?php echo htmlspecialchars($t['judul']); ?></td>
                                        <td><span class="text-secondary"><?php echo date('d/m/Y', strtotime($t['tanggal_pinjam'])); ?></span></td>
                                        <td>
                                            <?php if ($t['tanggal_kembali']): ?>
                                                <span class="text-secondary"><?php echo date('d/m/Y', strtotime($t['tanggal_kembali'])); ?></span>
                                            <?php
        else: ?>
                                                <span class="badge bg-light text-muted fw-normal">Belum Kembali</span>
                                            <?php
        endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($t['status'] === 'dipinjam'): ?>
                                                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">Dipinjam</span>
                                            <?php
        else: ?>
                                                <span class="badge bg-success px-3 py-2 rounded-pill">Dikembalikan</span>
                                            <?php
        endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if ($t['status'] === 'dipinjam'): ?>
                                                <button class="btn btn-sm btn-maroon px-3 rounded-pill" onclick="confirmReturn(<?php echo $t['id_transaksi']; ?>)">
                                                    Kembalikan
                                                </button>
                                            <?php
        else: ?>
                                                <span class="text-muted small italic">Selesai</span>
                                            <?php
        endif; ?>
                                        </td>
                                    </tr>
                                <?php
    endforeach; ?>
                            <?php
else: ?>
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <div class="py-4">
                                            <i class="bi bi-inbox fs-1 d-block mb-3 opacity-25"></i>
                                            Belum ada transaksi ditemukan.
                                        </div>
                                    </td>
                                </tr>
                            <?php
endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <?php if (isset($total_pages) && $total_pages > 1): ?>
                <div class="card-footer bg-white py-3">
                    <nav>
                        <ul class="pagination justify-content-center mb-0">
                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                    <a class="page-link <?php echo $i == $page ? 'bg-maroon border-maroon' : 'text-maroon'; ?>" 
                                       href="index.php?page=admin_transaksi&p=<?php echo $i; ?>">
                                        <?php echo $i; ?>
                                    </a>
                                </li>
                            <?php
    endfor; ?>
                        </ul>
                    </nav>
                </div>
                <?php
endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
function confirmReturn(id) {
    Swal.fire({
        title: 'Kembalikan Buku?',
        text: "Pastikan buku sudah diterima dalam kondisi baik.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#800000',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Kembalikan',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'index.php?action=kembali_buku&id=' + id;
        }
    })
}
</script>

<?php include 'views/layouts/footer.php'; ?>
