<?php
// Get database connection details from environment variables
// These should be set in Vercel Dashboard
$host = getenv('DB_HOST') ?: 'localhost';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASSWORD') ?: '';
$db = getenv('DB_NAME') ?: 'db_perpustakaan';
$port = getenv('DB_PORT') ?: '3306';

try {
    // DSN includes port for Aiven compatibility
    $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    $pdo = new PDO($dsn, $user, $pass, $options);
}
catch (PDOException $e) {
    // In production, you might want to log this instead of showing it
    die("Koneksi gagal: " . $e->getMessage());
}
?>
