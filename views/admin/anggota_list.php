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
                <h3 class="fw-bold">Manajemen Data Anggota</h3>
            </div>

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
                                <th>#</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Kelas</th>
                                <th>Role</th>
                                <th>Tgl Terdaftar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
$stmt = $pdo->query("SELECT * FROM users ORDER BY created_at DESC");
$users = $stmt->fetchAll();
$no = 1;
foreach ($users as $u):
?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td class="fw-semibold"><?php echo $u['nama']; ?></td>
                                    <td><?php echo $u['username']; ?></td>
                                    <td><?php echo $u['kelas'] ? $u['kelas'] : '-'; ?></td>
                                    <td>
                                        <span class="badge <?php echo $u['role'] === 'admin' ? 'bg-danger' : 'bg-primary'; ?>">
                                            <?php echo ucfirst($u['role']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo date('d/m/Y', strtotime($u['created_at'])); ?></td>
                                    <td>
                                        <?php if ($u['role'] !== 'admin'): ?>
                                            <button class="btn btn-sm btn-warning" onclick="confirmReset(<?php echo $u['id_user']; ?>)">Reset Pass</button>
                                            <button class="btn btn-sm btn-danger" onclick="confirmDeleteUser(<?php echo $u['id_user']; ?>)">Hapus</button>
                                        <?php
    endif; ?>
                                    </td>
                                </tr>
                            <?php
endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function confirmReset(id) {
    Swal.fire({
        title: 'Reset Password?',
        text: "Password akan direset menjadi 'password123'",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#800000',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Reset',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "index.php?action=reset_user&id=" + id;
        }
    })
}

function confirmDeleteUser(id) {
    Swal.fire({
        title: 'Hapus Anggota?',
        text: "Semua data transaksi anggota ini juga akan dihapus!",
        icon: 'error',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "index.php?action=delete_user&id=" + id;
        }
    })
}
</script>

<?php include BASE_PATH . '/views/layouts/footer.php'; ?>
