<?php
// Get database connection details from environment variables
$raw_host = trim(getenv('DB_HOST') ?: ($_ENV['DB_HOST'] ?? 'localhost'));
$user = trim(getenv('DB_USER') ?: ($_ENV['DB_USER'] ?? 'root'));
$pass = trim(getenv('DB_PASSWORD') ?: ($_ENV['DB_PASSWORD'] ?? ''));
$db = trim(getenv('DB_NAME') ?: ($_ENV['DB_NAME'] ?? 'db_perpustakaan'));
$port = trim(getenv('DB_PORT') ?: ($_ENV['DB_PORT'] ?? '3306'));

// Parsing logic: if host contains mysql:// or includes :port
if (strpos($raw_host, 'mysql://') === 0) {
    $raw_host = substr($raw_host, 8);
}

// Separate host and port if host contains a colon (e.g. host:port)
if (strpos($raw_host, ':') !== false) {
    list($host, $host_port) = explode(':', $raw_host);
    $port = $host_port;
}
else {
    $host = $raw_host;
}

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    // Aiven requires SSL. This enables basic SSL for the connection.
    if ($host !== 'localhost' && $host !== '127.0.0.1') {
        $options[PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = false; // Set to true if you provide a CA cert
    }

    $pdo = new PDO($dsn, $user, $pass, $options);
}
catch (PDOException $e) {
    // Detailed error for debugging
    $masked_host = $host;
    die("Koneksi gagal: " . $e->getMessage() . " (Target: $masked_host:$port)");
}
?>
