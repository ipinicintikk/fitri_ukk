<?php
require_once 'models/Buku.php';

class BukuController
{
    private $bukuModel;

    public function __construct($pdo)
    {
        $this->bukuModel = new Buku($pdo);
    }

    public function index()
    {
        $limit = 10;
        $page = isset($_GET['p']) ? (int)$_GET['p'] : 1;
        $offset = ($page - 1) * $limit;

        $total_items = $this->bukuModel->countAll();
        $total_pages = ceil($total_items / $limit);

        $books = $this->bukuModel->getAll($limit, $offset);
        include 'views/admin/buku_list.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->bukuModel->create($_POST)) {
                $_SESSION['success'] = "Buku berhasil ditambahkan!";
            }
            else {
                $_SESSION['error'] = "Gagal menambahkan buku!";
            }
            header("Location: index.php?page=admin_buku");
            exit;
        }
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id_buku'];
            if ($this->bukuModel->update($id, $_POST)) {
                $_SESSION['success'] = "Data buku berhasil diupdate!";
            }
            else {
                $_SESSION['error'] = "Gagal mengupdate buku!";
            }
            header("Location: index.php?page=admin_buku");
            exit;
        }
    }

    public function delete($id)
    {
        if ($this->bukuModel->delete($id)) {
            $_SESSION['success'] = "Buku berhasil dihapus!";
        }
        else {
            $_SESSION['error'] = "Gagal menghapus buku!";
        }
        header("Location: index.php?page=admin_buku");
        exit;
    }
}
