<?php
require_once 'BaseController.php';
class DashboardController extends BaseController {

    public function index() {
        // Example data to pass to the view
        $data = [
            'title' => 'Dashboard',
            'items' => ['Item 1', 'Item 2', 'Item 3']
        ];

        // Load the view
        $this->views('dashboard/list', $data);
    }
}