<?php
class Buku
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll($limit = null, $offset = 0)
    {
        $sql = "SELECT * FROM buku ORDER BY created_at DESC";
        if ($limit !== null) {
            $sql .= " LIMIT $limit OFFSET $offset";
        }
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    public function countAll()
    {
        return $this->pdo->query("SELECT COUNT(*) FROM buku")->fetchColumn();
    }

    public function getById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM buku WHERE id_buku = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data)
    {
        $sql = "INSERT INTO buku (judul, pengarang, penerbit, tahun_terbit, kategori, stok) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['judul'], $data['pengarang'], $data['penerbit'],
            $data['tahun_terbit'], $data['kategori'], $data['stok']
        ]);
    }

    public function update($id, $data)
    {
        $sql = "UPDATE buku SET judul=?, pengarang=?, penerbit=?, tahun_terbit=?, kategori=?, stok=? 
                WHERE id_buku=?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['judul'], $data['pengarang'], $data['penerbit'],
            $data['tahun_terbit'], $data['kategori'], $data['stok'], $id
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM buku WHERE id_buku = ?");
        return $stmt->execute([$id]);
    }

    public function search($keyword)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM buku WHERE judul LIKE ? OR pengarang LIKE ?");
        $stmt->execute(["%$keyword%", "%$keyword%"]);
        return $stmt->fetchAll();
    }
}
