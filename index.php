<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
define('BASE_PATH', __DIR__);
require_once __DIR__ . '/config/koneksi.php';
require_once __DIR__ . '/controllers/AuthController.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'login';
$action = isset($_GET['action']) ? $_GET['action'] : '';

$authController = new AuthController($pdo);
require_once __DIR__ . '/controllers/BukuController.php';
$bukuController = new BukuController($pdo);
require_once __DIR__ . '/controllers/TransaksiController.php';
$transaksiController = new TransaksiController($pdo);
require_once __DIR__ . '/controllers/FeedbackController.php';
$feedbackController = new FeedbackController($pdo);

// Action Handler
if ($action === 'login') {
    $authController->login();
}
elseif ($action === 'register') {
    $authController->register();
}
elseif ($action === 'logout') {
    $authController->logout();
}
elseif ($action === 'store_buku') {
    checkAccess('admin');
    $bukuController->store();
}
elseif ($action === 'update_buku') {
    checkAccess('admin');
    $bukuController->update();
}
elseif ($action === 'delete_buku') {
    checkAccess('admin');
    $bukuController->delete($_GET['id']);
}
elseif ($action === 'pinjam_buku') {
    checkAccess('user');
    $transaksiController->pinjam($_GET['id']);
}
elseif ($action === 'kembali_buku') {
    $transaksiController->kembalikan($_GET['id']);
}
elseif ($action === 'reset_user') {
    checkAccess('admin');
    $id = $_GET['id'];
    $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id_user = ?");
    $stmt->execute([md5('password123'), $id]);
    $_SESSION['success'] = "Password user berhasil direset!";
    header("Location: index.php?page=admin_anggota");
    exit;
}
elseif ($action === 'delete_user') {
    checkAccess('admin');
    $id = $_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM users WHERE id_user = ?");
    $stmt->execute([$id]);
    $_SESSION['success'] = "Anggota berhasil dihapus!";
    header("Location: index.php?page=admin_anggota");
    exit;
}
elseif ($action === 'store_feedback') {
    checkAccess('user');
    $feedbackController->store();
}
elseif ($action === 'delete_feedback') {
    checkAccess('admin');
    $feedbackController->delete($_GET['id']);
}

// Page Router
switch ($page) {
    case 'login':
        if (isset($_SESSION['user_id'])) {
            header("Location: index.php?page=" . ($_SESSION['role'] === 'admin' ? 'admin_dashboard' : 'user_dashboard'));
            exit;
        }
        include __DIR__ . '/views/auth/login.php';
        break;
    case 'register':
        include __DIR__ . '/views/auth/register.php';
        break;
    case 'admin_dashboard':
        checkAccess('admin');
        $total_buku = $pdo->query("SELECT COUNT(*) FROM buku")->fetchColumn();
        $total_anggota = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'user'")->fetchColumn();
        $total_pinjam = $pdo->query("SELECT COUNT(*) FROM transaksi WHERE status = 'dipinjam'")->fetchColumn();
        $total_transaksi = $pdo->query("SELECT COUNT(*) FROM transaksi")->fetchColumn();
        include __DIR__ . '/views/admin/dashboard.php';
        break;
    case 'admin_buku':
        checkAccess('admin');
        $bukuController->index();
        break;
    case 'admin_anggota':
        checkAccess('admin');
        include __DIR__ . '/views/admin/anggota_list.php';
        break;
    case 'admin_transaksi':
        checkAccess('admin');
        $transaksiController->allTransactions();
        break;
    case 'admin_laporan':
    case 'admin_laporan_print':
        checkAccess('admin');
        ob_start();
        $transactions = (new Transaksi($pdo))->getAllTransactions();
        if ($page === 'admin_laporan_print') {
            include __DIR__ . '/views/admin/laporan_print.php';
        }
        else {
            include __DIR__ . '/views/admin/transaksi_list.php';
        }
        break;
    case 'user_dashboard':
        checkAccess('user');
        $id_user = $_SESSION['user_id'];
        $buku_dipinjam = $pdo->query("SELECT COUNT(*) FROM transaksi WHERE id_user = $id_user AND status = 'dipinjam'")->fetchColumn();
        $buku_kembali = $pdo->query("SELECT COUNT(*) FROM transaksi WHERE id_user = $id_user AND status = 'dikembalikan'")->fetchColumn();
        include __DIR__ . '/views/user/dashboard.php';
        break;
    case 'user_buku':
        checkAccess('user');
        $books = isset($_GET['search']) ? (new Buku($pdo))->search($_GET['search']) : (new Buku($pdo))->getAll();
        include __DIR__ . '/views/user/buku_list.php';
        break;
    case 'user_riwayat':
        checkAccess('user');
        $transaksiController->userHistory();
        break;
    case 'admin_feedback':
        checkAccess('admin');
        $feedbackController->adminIndex();
        break;
    case 'user_feedback':
        checkAccess('user');
        include __DIR__ . '/views/user/feedback_form.php';
        break;
    default:
        include __DIR__ . '/views/auth/login.php';
        break;
}

function checkAccess($role)
{
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== $role) {
        header("Location: index.php?page=login");
        exit;
    }
}
?>
