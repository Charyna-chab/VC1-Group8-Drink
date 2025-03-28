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
    {
        $this->views('/feedback/feedback_view.php');
    }

}