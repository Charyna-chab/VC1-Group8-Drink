<?php
namespace YourNamespace\Controllers;

use YourNamespace\BaseController;
class SettingsController extends BaseController {
    public function index() {
        $this->views('settings', [
            'title' => 'Settings'
        ]);
    }
}