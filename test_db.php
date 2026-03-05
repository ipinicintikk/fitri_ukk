<?php
require_once 'config/koneksi.php';
echo "Koneksi Berhasil!\n";

$tables = ['users', 'buku', 'transaksi'];
foreach ($tables as $table) {
    try {
        $stmt = $pdo->query("SELECT 1 FROM $table LIMIT 1");
        echo "Tabel '$table' ditemukan.\n";
    }
    catch (Exception $e) {
        echo "Error: Tabel '$table' TIDAK ditemukan. (" . $e->getMessage() . ")\n";
    }
}
?>
