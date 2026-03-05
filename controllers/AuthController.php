<?php
require_once __DIR__ . '/../models/User.php';

class AuthController
{
    private $userModel;

    public function __construct($pdo)
    {
        $this->userModel = new User($pdo);
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = $this->userModel->login($username, $password);
            if ($user) {
                $_SESSION['user_id'] = $user['id_user'];
                $_SESSION['nama'] = $user['nama'];
                $_SESSION['role'] = $user['role'];

                if ($user['role'] === 'admin') {
                    header("Location: index.php?page=admin_dashboard");
                }
                else {
                    header("Location: index.php?page=user_dashboard");
                }
                exit;
            }
            else {
                $_SESSION['error'] = "Username atau password salah!";
                header("Location: index.php?page=login");
                exit;
            }
        }
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nama = $_POST['nama'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $kelas = $_POST['kelas'];

            // Check if username exists
            if ($this->userModel->findByUsername($username)) {
                $_SESSION['error'] = "Username sudah digunakan!";
                header("Location: index.php?page=register");
                exit;
            }

            if ($this->userModel->register($nama, $username, $password, $kelas)) {
                $_SESSION['success'] = "Registrasi berhasil, silakan login.";
                header("Location: index.php?page=login");
                exit;
            }
            else {
                $_SESSION['error'] = "Registrasi gagal!";
                header("Location: index.php?page=register");
                exit;
            }
        }
    }

    public function logout()
    {
        session_destroy();
        header("Location: index.php?page=login");
        exit;
    }
}
?>
