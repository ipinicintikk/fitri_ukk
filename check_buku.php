<?php
require_once __DIR__ . '/config/koneksi.php';
try {
    $stmt = $pdo->query("DESCRIBE buku");
    echo "<pre>";
    print_r($stmt->fetchAll());
    echo "</pre>";
}
catch (Exception $e) {
    echo $e->getMessage();
}
?>
