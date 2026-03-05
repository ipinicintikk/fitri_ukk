<?php
require_once 'models/Feedback.php';

class FeedbackController
{
    private $feedbackModel;

    public function __construct($pdo)
    {
        $this->feedbackModel = new Feedback($pdo);
    }

    public function adminIndex()
    {
        $feedbacks = $this->feedbackModel->getAll();
        include 'views/admin/feedback_list.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'id_user' => $_SESSION['user_id'],
                'isi_feedback' => $_POST['isi_feedback']
            ];

            if ($this->feedbackModel->create($data)) {
                $_SESSION['success'] = "Feedback berhasil dikirim!";
            }
            else {
                $_SESSION['error'] = "Gagal mengirim feedback!";
            }
            header("Location: index.php?page=user_dashboard");
            exit;
        }
    }

    public function delete($id)
    {
        if ($this->feedbackModel->delete($id)) {
            $_SESSION['success'] = "Feedback berhasil dihapus!";
        }
        else {
            $_SESSION['error'] = "Gagal menghapus feedback!";
        }
        header("Location: index.php?page=admin_feedback");
        exit;
    }
}
?>
