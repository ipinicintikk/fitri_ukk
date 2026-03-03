<?php include 'views/layouts/header.php'; ?>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card p-4 shadow-lg" style="width: 500px; border-top: 5px solid var(--maroon-dark);">
        <h2 class="mb-3 fw-bold text-center" style="color: var(--maroon-dark);">REGISTER</h2>
        <p class="text-muted text-center mb-4">Daftar sebagai anggota perpustakaan</p>

        <form action="index.php?action=register" method="POST">
            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Buat username" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Buat password" required>
            </div>
            <div class="mb-4">
                <label class="form-label">Kelas</label>
                <input type="text" name="kelas" class="form-control" placeholder="Contoh: XII RPL 1" required>
            </div>
            <button type="submit" class="btn btn-maroon w-100 py-2 fw-semibold">DAFTAR</button>
        </form>
        
        <div class="mt-4 text-center">
            <p class="mb-0 text-muted small">Sudah punya akun? <a href="index.php?page=login" class="text-maroon fw-semibold" style="color: var(--maroon-dark); text-decoration: none;">Login</a></p>
        </div>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>
