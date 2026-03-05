<?php
// Get database connection details from environment variables
// Use trim() to prevent "getaddrinfo failed" errors caused by accidental spaces
$host = trim(getenv('DB_HOST') ?: ($_ENV['DB_HOST'] ?? 'localhost'));
$user = trim(getenv('DB_USER') ?: ($_ENV['DB_USER'] ?? 'root'));
$pass = trim(getenv('DB_PASSWORD') ?: ($_ENV['DB_PASSWORD'] ?? ''));
$db = trim(getenv('DB_NAME') ?: ($_ENV['DB_NAME'] ?? 'db_perpustakaan'));
$port = trim(getenv('DB_PORT') ?: ($_ENV['DB_PORT'] ?? '3306'));

try {
    // DSN includes port for Aiven compatibility
    $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
        // If Aiven requires SSL, you might need to uncomment the line below:
        // PDO::MYSQL_ATTR_SSL_CA => true, 
    ];
    $pdo = new PDO($dsn, $user, $pass, $options);
}
catch (PDOException $e) {
    // Error message for debugging
    die("Koneksi gagal: " . $e->getMessage() . " (Host: $host)");
}
?>
