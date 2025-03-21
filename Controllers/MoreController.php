<?php
namespace MoreController\Controllers;

class MoreController extends BaseController {
    public function index() {
        // Render the more menu page
        $this->render('more');
    }
}