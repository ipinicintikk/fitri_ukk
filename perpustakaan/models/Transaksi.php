<?php
class Transaksi
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function pinjam($id_user, $id_buku)
    {
        // Start transaction
        $this->pdo->beginTransaction();

        try {
            // Check stock
            $stmt = $this->pdo->prepare("SELECT stok FROM buku WHERE id_buku = ? FOR UPDATE");
            $stmt->execute([$id_buku]);
            $buku = $stmt->fetch();

            if (!$buku || $buku['stok'] <= 0) {
                $this->pdo->rollBack();
                return false;
            }

            // Create transaction record
            $sql = "INSERT INTO transaksi (id_user, id_buku, tanggal_pinjam, status) VALUES (?, ?, CURDATE(), 'dipinjam')";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id_user, $id_buku]);

            // Update stock
            $stmt = $this->pdo->prepare("UPDATE buku SET stok = stok - 1 WHERE id_buku = ?");
            $stmt->execute([$id_buku]);

            $this->pdo->commit();
            return true;
        }
        catch (Exception $e) {
            $this->pdo->rollBack();
            return false;
        }
    }

    public function kembalikan($id_transaksi)
    {
        $this->pdo->beginTransaction();

        try {
            // Get book id
            $stmt = $this->pdo->prepare("SELECT id_buku FROM transaksi WHERE id_transaksi = ?");
            $stmt->execute([$id_transaksi]);
            $trans = $stmt->fetch();

            // Update transaction status
            $stmt = $this->pdo->prepare("UPDATE transaksi SET tanggal_kembali = CURDATE(), status = 'dikembalikan' WHERE id_transaksi = ?");
            $stmt->execute([$id_transaksi]);

            // Update stock
            $stmt = $this->pdo->prepare("UPDATE buku SET stok = stok + 1 WHERE id_buku = ?");
            $stmt->execute([$trans['id_buku']]);

            $this->pdo->commit();
            return true;
        }
        catch (Exception $e) {
            $this->pdo->rollBack();
            return false;
        }
    }

    public function getUserHistory($id_user)
    {
        $sql = "SELECT t.*, b.judul FROM transaksi t 
                JOIN buku b ON t.id_buku = b.id_buku 
                WHERE t.id_user = ? ORDER BY t.tanggal_pinjam DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id_user]);
        return $stmt->fetchAll();
    }

    public function getAllTransactions($limit = null, $offset = 0)
    {
        $sql = "SELECT t.*, b.judul, u.nama FROM transaksi t 
                JOIN buku b ON t.id_buku = b.id_buku 
                JOIN users u ON t.id_user = u.id_user 
                ORDER BY t.tanggal_pinjam DESC";
        if ($limit !== null) {
            $sql .= " LIMIT $limit OFFSET $offset";
        }
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    public function countAll()
    {
        return $this->pdo->query("SELECT COUNT(*) FROM transaksi")->fetchColumn();
    }
}
?>
