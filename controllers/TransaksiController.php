<?php
require_once __DIR__ . '/../models/Transaksi.php';

class TransaksiController
{
    private $transaksiModel;

    public function __construct($pdo)
    {
        $this->transaksiModel = new Transaksi($pdo);
    }

    public function pinjam($id_buku)
    {
        $id_user = $_SESSION['user_id'];
        if ($this->transaksiModel->pinjam($id_user, $id_buku)) {
            $_SESSION['success'] = "Buku berhasil dipinjam!";
        }
        else {
            $_SESSION['error'] = "Gagal meminjam buku! Stok mungkin habis.";
        }
        header("Location: index.php?page=user_buku");
        exit;
    }

    public function kembalikan($id_transaksi)
    {
        if ($this->transaksiModel->kembalikan($id_transaksi)) {
            $_SESSION['success'] = "Buku berhasil dikembalikan!";
        }
        else {
            $_SESSION['error'] = "Gagal mengembalikan buku!";
        }

        $redirect = ($_SESSION['role'] === 'admin') ? "admin_transaksi" : "user_riwayat";
        header("Location: index.php?page=$redirect");
        exit;
    }

    public function userHistory()
    {
        $history = $this->transaksiModel->getUserHistory($_SESSION['user_id']);
        include __DIR__ . '/../views/user/riwayat.php';
    }

    public function allTransactions()
    {
        $limit = 10;
        $page = isset($_GET['p']) ? (int)$_GET['p'] : 1;
        $offset = ($page - 1) * $limit;

        $total_items = $this->transaksiModel->countAll();
        $total_pages = ceil($total_items / $limit);

        $transactions = $this->transaksiModel->getAllTransactions($limit, $offset);
        include __DIR__ . '/../views/admin/transaksi_list.php';
    }
}
?>
