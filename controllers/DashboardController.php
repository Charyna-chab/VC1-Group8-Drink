<?php
class DashboardController extends BaseController {
    public function index() {
        // Add any dashboard data you need here
        $this->view('dashboard', [
            'title' => 'Dashboard'
        ]);
    }
}