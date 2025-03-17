<?php
class SettingsController extends BaseController {
    public function index() {
        $this->views('settings', [
            'title' => 'Settings'
        ]);
    }
}