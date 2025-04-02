<?php
require_once 'Models/FeedbackModel.php';
require_once './Controllers/BaseController.php';

class FeedbackController extends BaseController {
    private $model;
    
    function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $this->model = new FeedbackModel();
    }

    function index()
    {
        $feedbacks = $this->model->getFeedbacks();
        $this->views('/feedback/feedback_view.php', ['feedback' => $feedbacks]);
    }

    function create()
    {   $users = $this->model->getUser();
        $this->views('/feedback/admin/feedback_view.php',['users' => $users]);
    }

    function store()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'user_name' => $_POST['user_name'],
                'comment' => $_POST['comment'],
                'data' => $_POST['data'],
                'user_id' => $_POST['user_id'],
            ];
            $this->model->createFeedback($data);
            $this->readdir('/feedback');
        }
    }

}