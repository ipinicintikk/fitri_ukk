<?php
require_once __DIR__ . '/config/koneksi.php';

try {
    $sql = "CREATE TABLE IF NOT EXISTS feedback (
        id_feedback INT AUTO_INCREMENT PRIMARY KEY,
        id_user INT NOT NULL,
        isi_feedback TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE,
        INDEX (id_user)
    ) ENGINE=InnoDB";

    $pdo->exec($sql);
    echo "<h3>Success!</h3>";
    echo "<p>Table 'feedback' has been created successfully.</p>";
    echo "<a href='index.php'>Back to Home</a>";
}
catch (PDOException $e) {
    echo "<h3>Error</h3>";
    echo "<p>Error creating table: " . $e->getMessage() . "</p>";
}
?>
