<?php
// Get database connection details from environment variables
$raw_host = trim(getenv('DB_HOST') ?: ($_ENV['DB_HOST'] ?? 'localhost'));
$user = trim(getenv('DB_USER') ?: ($_ENV['DB_USER'] ?? 'root'));
$pass = trim(getenv('DB_PASSWORD') ?: ($_ENV['DB_PASSWORD'] ?? ''));
$db = trim(getenv('DB_NAME') ?: ($_ENV['DB_NAME'] ?? 'db_perpustakaan'));
$port = trim(getenv('DB_PORT') ?: ($_ENV['DB_PORT'] ?? '3306'));

// Aggressive cleaning to remove hidden characters or URI schemes
$raw_host = preg_replace('/^mysql:\/\/|[^a-zA-Z0-9.:-]/', '', $raw_host);
$user = preg_replace('/[^a-zA-Z0-9._-]/', '', $user);
$port = preg_replace('/[^0-9]/', '', $port);

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

    // Aiven requires SSL
    if ($host !== 'localhost' && $host !== '127.0.0.1') {
        $options[PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = false;
    }

    $pdo = new PDO($dsn, $user, $pass, $options);
}
catch (PDOException $e) {
    // Debugging info (be careful with passwords in production)
    $error_msg = $e->getMessage();
    die("<h3>Koneksi Database Gagal</h3>
         <p>Error: $error_msg</p>
         <p><b>Tips Perbaikan:</b></p>
         <ul>
            <li>Cek apakah Hostname di Vercel sudah benar (tanpa spasi).</li>
            <li>Cek apakah Aiven Service Status sudah 'Running'.</li>
            <li>Pastikan IP <code>0.0.0.0/0</code> sudah di-whitelist di Aiven Console.</li>
         </ul>
         <hr>
         Target: <code>$host:$port</code>");
}
?>
