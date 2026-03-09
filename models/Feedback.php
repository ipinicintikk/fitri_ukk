<?php
class Feedback
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
        $this->ensureTableExists();
    }

    private function ensureTableExists()
    {
        $sql = "CREATE TABLE IF NOT EXISTS feedback (
            id_feedback INT AUTO_INCREMENT PRIMARY KEY,
            id_user INT NOT NULL,
            isi_feedback TEXT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE,
            INDEX (id_user)
        ) ENGINE=InnoDB";
        $this->pdo->exec($sql);
    }

    public function getAll()
    {
        $sql = "SELECT f.*, u.nama FROM feedback f 
                JOIN users u ON f.id_user = u.id_user 
                ORDER BY f.created_at DESC";
        return $this->pdo->query($sql)->fetchAll();
    }

    public function create($data)
    {
        $sql = "INSERT INTO feedback (id_user, isi_feedback) VALUES (?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$data['id_user'], $data['isi_feedback']]);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM feedback WHERE id_feedback = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}
?>
