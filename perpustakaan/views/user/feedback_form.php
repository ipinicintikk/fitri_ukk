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
                <a class="nav-link" href="index.php?page=user_dashboard">Dashboard</a>
                <a class="nav-link" href="index.php?page=user_buku">Daftar Buku</a>
                <a class="nav-link" href="index.php?page=user_riwayat">Riwayat Pinjam</a>
                <a class="nav-link active" href="index.php?page=user_feedback">Kirim Feedback</a>
                <hr class="mx-3">
                <a class="nav-link text-warning" href="index.php?action=logout">Logout</a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="col-md-10 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold">Kirim Feedback</h3>
                <div>
                     <span class="text-muted">Halo, </span>
                     <span class="fw-bold text-maroon"><?php echo $_SESSION['nama']; ?></span>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card p-4">
                        <h5 class="fw-bold mb-3">Saran & Masukan</h5>
                        <p class="text-muted small">Feedback Anda sangat berharga bagi kami untuk meningkatkan layanan perpustakaan.</p>
                        
                        <form action="index.php?action=store_feedback" method="POST">
                            <div class="mb-3">
                                <label for="isi_feedback" class="form-label fw-semibold">Isi Feedback</label>
                                <textarea name="isi_feedback" id="isi_feedback" rows="5" class="form-control" placeholder="Tuliskan saran atau masukan Anda di sini..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-maroon w-100">Kirim Feedback</button>
                        </form>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card p-4 bg-light border-0">
                        <h6 class="fw-bold mb-3"><i class="bi bi-info-circle me-2"></i>Informasi</h6>
                        <ul class="small text-muted ps-3">
                            <li class="mb-2">Feedback yang Anda kirimkan akan dibaca oleh administrator.</li>
                            <li class="mb-2">Kami akan berusaha menindaklanjuti setiap saran membangun.</li>
                            <li class="mb-2">Terima kasih telah berkontribusi bagi kemajuan perpustakaan kami.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>
