<?php
class User
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function login($username, $password)
    {
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && md5($password) === $user['password']) {
            return $user;
        }
        return false;
    }

    public function register($nama, $username, $password, $kelas)
    {
        $hashedPassword = md5($password);
        $sql = "INSERT INTO users (nama, username, password, role, kelas) VALUES (?, ?, ?, 'user', ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$nama, $username, $hashedPassword, $kelas]);
    }

    public function findByUsername($username)
    {
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$username]);
        return $stmt->fetch();
    }
}
?>
