<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Digital</title>
    <!-- Google Fonts: Inter/Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --maroon-dark: #800000;
            --maroon-medium: #990000;
            --maroon-light: #B22222;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }

        .bg-maroon {
            background-color: var(--maroon-dark);
        }

        .btn-maroon {
            background-color: var(--maroon-dark);
            color: white;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-maroon:hover {
            background-color: var(--maroon-medium);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .sidebar {
            min-height: 100vh;
            background-color: var(--maroon-dark);
            color: white;
        }

        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            border-radius: 8px;
            margin: 5px 15px;
            padding: 10px 15px;
            transition: all 0.2s;
        }

        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            color: white;
            background-color: rgba(255,255,255,0.1);
        }

        .form-control:focus {
            border-color: var(--maroon-light);
            box-shadow: 0 0 0 0.25rem rgba(128, 0, 0, 0.25);
        }

        .gradient-maroon {
            background: linear-gradient(135deg, var(--maroon-dark), var(--maroon-light));
            color: white;
        }
    </style>
</head>
<body>
