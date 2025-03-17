<?php
class SettingsController extends BaseController {
    public function index() {
        $this->view('settings', [
            'title' => 'Settings'
        ]);
    }
}