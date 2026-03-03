<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Perpustakaan Digital</title>
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --maroon-dark: #800000;
            --maroon-medium: #990000;
            --maroon-light: #B22222;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #4b0000 0%, #800000 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
        }

        .login-container {
            display: flex;
            width: 100%;
            max-width: 1000px;
            min-height: 600px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .login-image {
            flex: 1.2;
            background: linear-gradient(135deg, #4b0000 0%, #800000 50%, #B22222 100%);
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 40px;
            color: white;
        }

        .login-image::after {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(to top, rgba(128, 0, 0, 0.8), transparent);
        }

        .login-image-content {
            position: relative;
            z-index: 10;
        }

        .login-form-side {
            flex: 1;
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-header h2 {
            font-weight: 800;
            color: var(--maroon-dark);
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        .form-control {
            padding: 12px 16px;
            border-radius: 12px;
            border: 1px solid #ddd;
            background-color: #fcfcfc;
        }

        .form-control:focus {
            background-color: white;
            border-color: var(--maroon-light);
            box-shadow: 0 0 0 0.25rem rgba(128, 0, 0, 0.25);
        }

        .btn-maroon {
            padding: 14px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1.1rem;
            background: linear-gradient(to right, var(--maroon-dark), var(--maroon-medium));
            border: none;
            color: white;
        }

        .btn-maroon:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(128, 0, 0, 0.3);
            color: white;
        }

        @media (max-width: 992px) {
            .login-image { display: none; }
            .login-container { 
                width: 100%;
                max-width: 450px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-image">
            <div class="login-image-content text-start">
                <h1 class="fw-bold display-4">Pustaka Digital</h1>
                <p class="lead">Eksplorasi ilmu tanpa batas. Mudahnya akses literasi sekolah dalam genggaman Anda.</p>
            </div>
        </div>
        <div class="login-form-side">
            <div class="login-header mb-4">
                <h2>Masuk</h2>
                <p class="text-muted">Selamat datang kembali! Silakan masuk ke akun Anda.</p>
            </div>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger border-0 shadow-sm mb-4">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <?php echo htmlspecialchars($_SESSION['error']);
    unset($_SESSION['error']); ?>
                </div>
            <?php
endif; ?>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success border-0 shadow-sm mb-4">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <?php echo htmlspecialchars($_SESSION['success']);
    unset($_SESSION['success']); ?>
                </div>
            <?php
endif; ?>

            <form action="index.php?action=login" method="POST">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Masukkan username" required autocomplete="username">
                </div>
                <div class="mb-4">
                    <div class="d-flex justify-content-between">
                        <label class="form-label fw-semibold">Password</label>
                    </div>
                    <input type="password" name="password" class="form-control" placeholder="Masukkan password" required autocomplete="current-password">
                </div>
                <button type="submit" class="btn btn-maroon text-white w-100 mb-4">Log In</button>
            </form>

            <div class="text-center mt-auto">
                <p class="text-muted m-0">Belum punya akun? <a href="index.php?page=register" class="fw-bold text-decoration-none" style="color: var(--maroon-dark);">Daftar Sebagai Anggota</a></p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
