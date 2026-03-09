<?php
// Get database connection details from environment variables
// Comprehensive environment variable lookup
function get_db_config($key, $default = '')
{
    return getenv($key) ?: ($_ENV[$key] ?: ($_SERVER[$key] ?? $default));
}

$raw_host = trim(get_db_config('DB_HOST', 'localhost'));
$user = trim(get_db_config('DB_USER', 'root'));
$pass = get_db_config('DB_PASSWORD', get_db_config('DB_PASS', '')); // Check for both DB_PASSWORD and DB_PASS
$db = trim(get_db_config('DB_NAME', 'db_perpustakaan'));
$port = trim(get_db_config('DB_PORT', '3306'));

// Aggressive cleaning for Host, User, Port (but NOT Password)
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

// CHECK HOST RESOLUTION: If host is not resolvable and we are local, fallback to localhost
if ($host !== 'localhost' && $host !== '127.0.0.1') {
    $ip = gethostbyname($host);
    if ($ip === $host) {
        // DNS failed to resolve
        $host = 'localhost';
        $port = '3306';
    }
}

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    // Aiven requires SSL, but don't use it for localhost
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
